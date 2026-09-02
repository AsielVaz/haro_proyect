<?php
include_once("conectorBD.php");

class ClienteBanca{
    //SELECT `id`, `nombre`, `apellidos`, `email`, `telefono`, `imagen` FROM `clientes_banca` WHERE 1
    public $id;
    public $nombre;
    public $apellidos;
    public $email;
    public $telefono;
    public $imagen;
    public $autos_venta;
    public $comision;
    public function __construct($id, $nombre, $apellidos, $email, $telefono, $imagen){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->imagen = $imagen;
    }
}




class AdministradorClientesBanca extends conectorB{


    public function cuentaAutosCliente($id){
        $query = "SELECT COUNT(*) FROM `venta` WHERE `id_cliente` = $id";
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    public function insertaCliente($nombre, $apellidos, $email, $telefono, $imagen, $comision){
        $query = "INSERT INTO `clientes_banca`(`nombre`, `apellidos`, `email`, `telefono`, `imagen`, `comision`) VALUES ('$nombre','$apellidos','$email','$telefono','$imagen', '$comision')";
        $this->ejecutar($query);
    }
    public function modificaCliente($id, $nombre, $apellidos, $email, $telefono){
        $query = "UPDATE `clientes_banca` SET `nombre`='$nombre',`apellidos`='$apellidos',`email`='$email',`telefono`='$telefono' WHERE `id`=$id";
        $this->ejecutar($query);
    }
    public function eliminaCliente($id){
        $query = "DELETE FROM `clientes_banca` WHERE `id`=$id";
        $this->ejecutar($query);
    }
    public function dameCliente($id){
        $query = "SELECT `id`, `nombre`, `apellidos`, `email`, `telefono`, `imagen`, `comision` FROM `clientes_banca` WHERE `id`=$id";
       //echo $query;
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        $cliente = new ClienteBanca($row['id'], $row['nombre'], $row['apellidos'], $row['email'], $row['telefono'], $row['imagen']);
        return $cliente;
    }
    public function dameClientes(){
        $query = "SELECT c.`id`, c.`nombre`, c.`apellidos`, c.`email`, c.`telefono`, c.`imagen`, c.`comision`,
            COUNT(v.`id`) AS autos_venta
            FROM `clientes_banca` c
            LEFT JOIN `venta` v ON v.`id_cliente` = c.`id`
            GROUP BY c.`id`, c.`nombre`, c.`apellidos`, c.`email`, c.`telefono`, c.`imagen`, c.`comision`";
        $result = $this->ejecutar($query);
        $clientes = array();
        while($row = mysqli_fetch_array($result)){
            $cliente = new ClienteBanca($row['id'], $row['nombre'], $row['apellidos'], $row['email'], $row['telefono'], $row['imagen']);
            $cliente->autos_venta = (int) $row['autos_venta'];
            $cliente->comision = $row['comision'];
            array_push($clientes, $cliente);
        }
        return $clientes;
    }
}

?>
