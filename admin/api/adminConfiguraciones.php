<?php

include_once('conectorBD.php');

class Configuracion
{
  public $id;
  public $nombre;
  public $valor;

  public function __construct($id, $nombre, $valor)
  {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->valor = $valor;
  }
}


class AdministradorConfiguraciones extends conector
{

  public function cambiarConfiguracion($id, $valor)
  {


    $sql = "UPDATE configuraciones SET valor = '$valor' WHERE id = '$id'";
    $this->ejecutar($sql);
  }

  public function dameConfiguraciones()
  {

    $sql = "SELECT `id`, `nombre`, `valor` FROM configuraciones";
    $resultado = $this->ejecutar($sql);
    $configuraciones = array();
    while ($fila = $resultado->fetch_assoc()) {
      $configuraciones[] = new Configuracion($fila['id'], $fila['nombre'], $fila['valor']);
    }
    return $configuraciones;
  }

  public function dameConfiguracion($id)
  {

    $sql = "SELECT `id`, `nombre`, `valor` FROM configuraciones WHERE id = " . (int) $id;
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return new Configuracion($fila['id'], $fila['nombre'], $fila['valor']);
  }

  public function dameConfiguracionPorNombre($nombre)
  {

    $nombre = $this->escapar((string) $nombre);
    $sql = "SELECT `id`, `nombre`, `valor` FROM configuraciones WHERE nombre = '$nombre'";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return new Configuracion($fila['id'], $fila['nombre'], $fila['valor']);
  }
}
