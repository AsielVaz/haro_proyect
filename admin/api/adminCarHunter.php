<?php

include_once('conectorBD.php');

class CarHunter
{
    public $id;
    public $precioMin;
    public $precioMax;
    public $marca;
    public $modelo;
    public $anioMin;
    public $anioMax;
    public $nombre;
    public $email;
    public $avisado;

    public function __construct($id, $precioMin, $precioMax, $marca, $modelo, $anioMin, $anioMax, $nombre, $email, $avisado)
    {
        $this->id = $id;
        $this->precioMin = $precioMin;
        $this->precioMax = $precioMax;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anioMin = $anioMin;
        $this->anioMax = $anioMax;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->avisado = $avisado;
    }
}

class Notificacion
{
    public $id;
    public $idSuscriptor;
    public $idAuto;
    public $fecha;
    public $metodo;
    public $notificado;

    public function __construct($id, $idSuscriptor, $idAuto, $fecha, $metodo)
    {
        $this->id = $id;
        $this->idSuscriptor = $idSuscriptor;
        $this->idAuto = $idAuto;
        $this->fecha = $fecha;
        $this->metodo = $metodo;
    }
}



class AdministradorCarHunter extends conector
{

    public function nuevoCarHunter($precioMin, $precioMax, $marca, $modelo, $anioMin, $anioMax, $nombre, $email)
    {
        $query = "INSERT INTO `car_hunter`(`precio_min`, `precio_max`, `marca`, `anio_min`, `anio_max`, `modelo`, `nombre`, `email`) VALUES ('$precioMin', '$precioMax', '$marca', '$anioMin', '$anioMax', '$modelo', '$nombre', '$email')";
        $this->ejecutar($query);
    }


    public function nuevoSuscriptor($email, $nombre)
    {
        $query = "INSERT INTO `suscriptor`(`correo`, `nombre`) VALUES ('$email', '$nombre')";
        $this->ejecutar($query);
    }

    public function nuevaNotificacion($idAuto, $idSuscriptor, $metodo)
    {
        $query = "INSERT INTO `notficaiones_s`(`id_auto`, `id_suscriptor`, `metodo`) VALUES ('$idAuto', '$idSuscriptor', '$metodo')";
        $this->ejecutar($query);
    }




    public function eliminarCarHunter($id)
    {
        $query = "DELETE FROM `car_hunter` WHERE id = '$id'";
        $this->ejecutar($query);
    }

    public function dameCarHunter()
    {
        $query = "SELECT * FROM `car_hunter` where avisado = 0";
        $result = $this->ejecutar($query);
        $carHunter = array();
        while ($row = mysqli_fetch_array($result)) {
            $carHunter[] = new CarHunter($row['id'], $row['precio_min'], $row['precio_max'], $row['marca'], $row['modelo'], $row['anio_min'], $row['anio_max'], $row['nombre'], $row['email'], $row['avisado']);
        }
        return $carHunter;
    }

    public function dameCarHunterPorId($id)
    {
        $query = "SELECT * FROM `car_hunter` WHERE id = '$id'";
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        return new CarHunter($row['id'], $row['precio_min'], $row['precio_max'], $row['marca'], $row['modelo'], $row['anio_min'], $row['anio_max'], $row['nombre'], $row['email'], $row['avisado']);
    }

    public function marcarComoAvisado($id)
    {
        $query = "UPDATE `car_hunter` SET `avisado` = '1' WHERE id = '$id'";
        $this->ejecutar($query);
    }

    public function dameCarHunterPorMarcaModelo($marca, $modelo)
    {
        $query = 'SELECT `id`, `precio_min`, `precio_max`, `marca`, `anio_min`, `anio_max`, `modelo`, `nombre`, `email` , `avisado` FROM `car_hunter` WHERE marca LIKE "%' . $marca . '%" and modelo LIKE "%' . $modelo . '%";';
        $result = $this->ejecutar($query);
        $carHunter = array();
        while ($row = mysqli_fetch_array($result)) {
            if (!$row['avisado']) {
                $carHunter[] = new CarHunter($row['id'], $row['precio_min'], $row['precio_max'], $row['marca'], $row['modelo'], $row['anio_min'], $row['anio_max'], $row['nombre'], $row['email'], $row['avisado']);
            }
        }
        return $carHunter;
    }

    function dameCarHunterPorMarca($marca)
    {
        $query = 'SELECT `id`, `precio_min`, `precio_max`, `marca`, `anio_min`, `anio_max`, `modelo`, `nombre`, `email` , `avisado` FROM `car_hunter` WHERE marca LIKE "%' . $marca . '%";';
        $result = $this->ejecutar($query);
        $carHunter = array();
        while ($row = mysqli_fetch_array($result)) {
            if (!$row['avisado']) {
                $carHunter[] = new CarHunter($row['id'], $row['precio_min'], $row['precio_max'], $row['marca'], $row['modelo'], $row['anio_min'], $row['anio_max'], $row['nombre'], $row['email'], $row['avisado']);
            }
        }
        return $carHunter;
    }

    public function eliminarCarHunterPorEmail($email)
    {
        $query = "DELETE FROM `car_hunter` WHERE email = '$email'";
        $this->ejecutar($query);
    }

    function dameSuscriptores()
    {
        $query = "SELECT * FROM `suscriptor`";
        $result = $this->ejecutar($query);
        $suscriptores = array();
        while ($row = mysqli_fetch_array($result)) {
            $suscriptores[] = new CarHunter($row['id'], 0, 0, 0, 0, 0, 0, $row['nombre'], $row['correo'], 0);
        }
        return $suscriptores;
    }

    public function dameSuscriptor($id){
        $query = "SELECT * FROM `suscriptor` WHERE id = '$id'";
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        return new CarHunter($row['id'], 0, 0, 0, 0, 0, 0, $row['nombre'], $row['correo'], 0);
    }

    function dameNotificacion($usuario, $auto, $metodo)
    {
        $usuario = (int) $usuario;
        $auto = (int) $auto;
        $metodo = $this->escapar((string) $metodo);
        $query = "SELECT `id`, `id_suscriptor`, `id_auto`, `fecha`, `metodo` FROM `notficaiones_s` WHERE id_suscriptor = $usuario and id_auto = $auto and metodo = '$metodo';";
        $result = $this->ejecutar($query);
        $notificaciones = array();
        while ($row = mysqli_fetch_array($result)) {
            $notificaciones[] = new Notificacion($row['id'], $row['id_suscriptor'], $row['id_auto'], $row['fecha'], $row['metodo']);
        }
        return $notificaciones;
    }

    function dameNotificacionesSinNotificar(){
        $query = "SELECT n.`id`, n.`id_suscriptor`, n.`id_auto`, n.`fecha`, n.`metodo`, n.`notificado`
            FROM `notficaiones_s` n
            INNER JOIN (
                SELECT `id_suscriptor`, `id_auto`, MAX(`id`) AS ultimo_id, MIN(`id`) AS primer_id
                FROM `notficaiones_s`
                WHERE `notificado` = 0
                GROUP BY `id_suscriptor`, `id_auto`
                ORDER BY primer_id DESC
                LIMIT 1
            ) pendiente ON pendiente.ultimo_id = n.id";
        $result = $this->ejecutar($query);
        $row = $result->fetch_assoc();
        return $row
            ? new Notificacion($row['id'], $row['id_suscriptor'], $row['id_auto'], $row['fecha'], $row['metodo'])
            : null;
    }

    function marcarNotificacion($id){
        $query = "UPDATE `notficaiones_s` SET `notificado` = '1' WHERE id = '$id'";
        $this->ejecutar($query);
    }
    function marcarNotificacionAlter($idAuto, $idSus){
        $query = "UPDATE `notficaiones_s` SET `notificado` = '1' WHERE id_auto = '$idAuto' and id_suscriptor = '$idSus'";
        $this->ejecutar($query);
    }

    function existeNotificado($idAuto, $idSus){
        $query = "SELECT 1 FROM `notficaiones_s` WHERE id_auto = " . (int) $idAuto . " and id_suscriptor = " . (int) $idSus . " and notificado = 1 LIMIT 1";
        return $this->ejecutar($query)->num_rows > 0;
    }

    function existeNotificacion($usuario, $auto, $metodo)
    {
        $metodo = $this->escapar((string) $metodo);
        $query = "SELECT 1 FROM `notficaiones_s` WHERE id_suscriptor = " . (int) $usuario . " and id_auto = " . (int) $auto . " and metodo = '$metodo' LIMIT 1";
        return $this->ejecutar($query)->num_rows > 0;
    }

    function eliminarSuscriptorPorId($id)
    {
        $query = "DELETE FROM `suscriptor` WHERE id = '$id'";
        $this->ejecutar($query);
    }
    function existeSuscriptor($correo)
    {
        $correo = $this->escapar((string) $correo);
        $query = "SELECT 1 FROM `suscriptor` WHERE correo = '$correo' LIMIT 1";
        return $this->ejecutar($query)->num_rows > 0;
    }
}



// $admin = new AdministradorCarHunter();
// echo json_encode($carHunter = $admin->dameCarHunterPorMarcaModelo("bmw", "x5"));
