<?php

include_once('conectorBD.php');

class Contacto
{

    public $id;
    public $nombre;
    public $correo;
    public $mensaje;

    public function __construct()
    {
        $this->id = 0;
    }
}

class AdministradorContactos extends conector
{
    function setContacto($nombre, $correo, $mensaje)
    {
        $sql = 'INSERT INTO `contactos` (`nombre`, `correo`, `mensaje`) VALUES ("' . $nombre . '", "' . $correo . '", "' . $mensaje . '");';
        $this->ejecutar($sql);
    }


    function getContacto($id)
    {
        $sql = 'SELECT `id`, `nombre`, `correo`, `mensaje` FROM `contactos` WHERE id = ' . (int) $id . ';';
        $contacto = new Contacto();
        $result = $this->ejecutar($sql);
        while ($row = $result->fetch_assoc()) {
            $contacto->id = $row['id'];
            $contacto->nombre = $row['nombre'];
            $contacto->correo = $row['correo'];
            $contacto->mensaje = $row['mensaje'];
        }
        return $contacto;
    }

    function getContactos()
    {
        $contactos = array();
        $sql = 'SELECT `id`, `nombre`, `correo`, `mensaje` FROM `contactos`;';
        $result = $this->ejecutar($sql);
        while ($row = $result->fetch_assoc()) {
            $contacto = new Contacto();
            $contacto->id = $row['id'];
            $contacto->nombre = $row['nombre'];
            $contacto->correo = $row['correo'];
            $contacto->mensaje = $row['mensaje'];
            $contactos[] = $contacto;
        }
        return $contactos;
    }


    function eliminarContacto($id)
    {
        $sql = 'DELETE FROM `contactos` WHERE id = ' . (int) $id . ';';
        $this->ejecutar($sql);
    }
}
