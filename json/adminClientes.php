<?php

include_once('conectorBD.php');

class Cliente
{

  public $id;
  public $appat;
  public $apmat;
  public $correo;
  public $nombre;
  public $telefono;

  public function __construct()
  {
    $this->id = 0;
  }
}

class AdministradorClientes extends conector
{
  function setCliente($nombre, $appat, $apmat, $correo, $telefono)
  {
    $sql = 'INSERT INTO `cliente` (`nombre`, `appat`, `apmat`, `correo`, `telefono`, `contrasena`) VALUES ("' . $nombre . '", "' . $appat . '", "' . $apmat . '", "' . $correo . '", "' . $telefono . '", "0");';
    $this->ejecutar($sql);
  }

  function getCliente($id)
  {
    $sql = 'SELECT * FROM `cliente` WHERE id = ' . $id . ';';
    $cliente = new Cliente();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $cliente->id = $row['id'];
      $cliente->nombre = $row['nombre'];
      $cliente->appat = $row['appat'];
      $cliente->apmat = $row['apmat'];
      $cliente->correo = $row['correo'];
      $cliente->telefono = $row['telefono'];
    }
    return $cliente;
  }

  function getClientes()
  {
    $clientes = array();
    $sql = 'SELECT * FROM `cliente`;';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $cliente = new Cliente();
      $cliente->id = $row['id'];
      $cliente->nombre = $row['nombre'];
      $cliente->appat = $row['appat'];
      $cliente->apmat = $row['apmat'];
      $cliente->correo = $row['correo'];
      $cliente->telefono = $row['telefono'];
      $clientes[] = $cliente;
    }
    return $clientes;
  }

  function deleteCliente($id)
  {
    $sql = 'DELETE FROM `cliente` WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
}
