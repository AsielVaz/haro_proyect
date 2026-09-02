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

    public function __construct($id, $nombre, $apellidos, $email, $telefono, $imagen){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->imagen = $imagen;
    }
}




class AdministradorClientes extends conector{
    public function insertaCliente($nombre, $apellidos, $email, $telefono, $imagen){
        $query = "INSERT INTO `clientes_banca`(`nombre`, `apellidos`, `email`, `telefono`, `imagen`) VALUES ('$nombre','$apellidos','$email','$telefono','$imagen')";
        $this->ejecutar($query);
    }
    public function modificaCliente($id, $nombre, $apellidos, $email, $telefono, $imagen){
        $query = "UPDATE `clientes_banca` SET `nombre`='$nombre',`apellidos`='$apellidos',`email`='$email',`telefono`='$telefono',`imagen`='$imagen' WHERE `id`=$id";
        $this->ejecutar($query);
    }
    public function eliminaCliente($id){
        $query = "DELETE FROM `clientes_banca` WHERE `id`=$id";
        $this->ejecutar($query);
    }
    public function dameCliente($id){
        $query = "SELECT `id`, `nombre`, `apellidos`, `email`, `telefono`, `imagen` FROM `clientes_banca` WHERE `id`=$id";
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        $cliente = new ClienteBanca($row['id'], $row['nombre'], $row['apellidos'], $row['email'], $row['telefono'], $row['imagen']);
        return $cliente;
    }
    public function dameClientes(){
        $query = "SELECT `id`, `nombre`, `apellidos`, `email`, `telefono`, `imagen` FROM `clientes_banca` WHERE 1";
        $result = $this->ejecutar($query);
        $clientes = array();
        while($row = mysqli_fetch_array($result)){
            $cliente = new ClienteBanca($row['id'], $row['nombre'], $row['apellidos'], $row['email'], $row['telefono'], $row['imagen']);
            array_push($clientes, $cliente);
        }
        return $clientes;
    }
}

?>