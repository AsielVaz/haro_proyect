<?php
include_once("conectorBD.php");
///SELECT `id`, `direccion`, `cp`, `des_gen` FROM `almacenes` WHERE 1

class Almacen {
    public  $id;
    public $direccion;
    public $cp;
    public $des_gen;
    public $lon;
    public $lat;

    public function __construct($id, $direccion, $cp, $des_gen, $lon, $lat)
    {
        $this->id = $id;
        $this->direccion = $direccion;
        $this->cp = $cp;
        $this->des_gen = $des_gen;
        $this->lon = $lon;
        $this->lat = $lat;
    }


}



class AdministradorAlmacenes extends conectorB {

    public function insertaAlmacen ($direccion, $cp, $des_gen, $lon, $lat) {
        $sql = "INSERT INTO `almacenes`(`direccion`, `cp`, `des_gen`, `lon`, `lat`) VALUES ('$direccion', '$cp', '$des_gen', '$lon', '$lat')";
        return $this->ejecutar($sql);
    }

    public function dameAlmacnes () {
        $sql = "SELECT `id`, `direccion`, `cp`, `des_gen`, `lon`, `lat` FROM `almacenes`";
        $resultado = $this->ejecutar($sql);
        $almacenes = array();
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $almacen = new Almacen($fila['id'], $fila['direccion'], $fila['cp'], $fila['des_gen'], $fila['lon'], $fila['lat']);
            array_push($almacenes, $almacen);
        }
        return $almacenes;
    }

    public function eliminarAlmacen ($id) {
        $sql = "DELETE FROM `almacenes` WHERE id = $id";
        return $this->ejecutar($sql);
    }

    public function dameAlmacen($id) {
        $sql = "SELECT `id`, `direccion`, `cp`, `des_gen`, `lon`, `lat` FROM `almacenes` WHERE id = $id";
        $resultado = $this->ejecutar($sql);
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new Almacen($fila['id'], $fila['direccion'], $fila['cp'], $fila['des_gen'], $fila['lon'], $fila['lat']);
        }
        return null;
    }

    public function modificarAlmacen ($id, $direccion, $cp, $des_gen, $lon, $lat) {
        $sql = "UPDATE `almacenes` SET `direccion`='$direccion',`cp`='$cp',`des_gen`='$des_gen',`lon`='$lon',`lat`='$lat' WHERE id = $id";
        return $this->ejecutar($sql);
    }

    public function cambiarAlmacenAuto($idAuto, $idAlmacen, $disp, $id_usuario) {
        $sql = "UPDATE `auto` SET `id_almacen`='$idAlmacen' WHERE id = $idAuto";
        $this->ejecutar($sql); 
        $ip = $_SERVER['REMOTE_ADDR'];
        $mensaje = "Auto con id $idAuto cambiado al almacen con id $idAlmacen. Dispositivo: $disp";
        $ultima_act = date("Y-m-d H:i:s");
        //SELECT `id`, `ip`, `mensaje`, `ultima_act`, `id_auto`, `disp` FROM `log_cambio_auto` WHERE 1
        $sql = "INSERT INTO `log_cambio_auto`(`ip`, `mensaje`, `ultima_act`, `id_auto`, `disp`, `id_usuario`) VALUES ('$ip', '$mensaje', '$ultima_act', '$idAuto', '$disp', $id_usuario)";
        $this->ejecutar($sql);
    }




}