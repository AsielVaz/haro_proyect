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
  private ?array $clientesCache = null;

  private function cargarClientes(): void
  {
    if ($this->clientesCache !== null) {
      return;
    }

    $this->clientesCache = [];
    $result = $this->ejecutar('SELECT `id`, `nombre`, `appat`, `apmat`, `correo`, `telefono` FROM `cliente`');
    while ($row = $result->fetch_assoc()) {
      $cliente = new Cliente();
      $cliente->id = $row['id'];
      $cliente->nombre = $row['nombre'];
      $cliente->appat = $row['appat'];
      $cliente->apmat = $row['apmat'];
      $cliente->correo = $row['correo'];
      $cliente->telefono = $row['telefono'];
      $this->clientesCache[(int) $row['id']] = $cliente;
    }
  }

  function setCliente($nombre, $appat, $apmat, $correo, $telefono)
  {
    $sql = 'INSERT INTO `cliente` (`nombre`, `appat`, `apmat`, `correo`, `telefono`, `contrasena`) VALUES ("' . $nombre . '", "' . $appat . '", "' . $apmat . '", "' . $correo . '", "' . $telefono . '", "0");';
    $this->ejecutar($sql);
    $this->clientesCache = null;
  }

  function getCliente($id)
  {
    $this->cargarClientes();
    return $this->clientesCache[(int) $id] ?? new Cliente();
  }

  function getClientes()
  {
    $this->cargarClientes();
    return array_values($this->clientesCache);
  }

  function deleteCliente($id)
  {
    $sql = 'DELETE FROM `cliente` WHERE id = ' . (int) $id . ';';
    $this->ejecutar($sql);
    $this->clientesCache = null;
  }
}
