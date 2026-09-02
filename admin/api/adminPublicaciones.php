<?php

include_once('conectorBD.php');

class Publicacion
{
  public $id;
  public $publicacion;
  public $redSocial;
  public $fecha;
  public $activo;
  public $auto;

  public function __construct($id, $publicacion, $redSocial, $fecha, $activo, $auto)
  {
    $this->id = $id;
    $this->publicacion = $publicacion;
    $this->redSocial = $redSocial;
    $this->fecha = $fecha;
    $this->activo = $activo;
    $this->auto = $auto;
  }
}


class AdministradorPublicaciones extends conector
{
  public function nuevaPublicacion($publicacion, $redSocial, $fecha, $activo, $auto)
  {
    $query = "INSERT INTO publicaciones (id_publicacion, red_social, activo, auto) VALUES ('$publicacion', '$redSocial', '$activo', '$auto')";
    $this->ejecutar($query);
  }

  public function eliminarPublicacion($id)
  {
    $query = "DELETE FROM publicaciones WHERE id = '$id'";
    $this->ejecutar($query);
  }

  public function damePublicaciones()
  {
    $query = "SELECT `id`, `id_publicacion` AS publicacion, `red_social` AS redSocial, `fecha_hora` AS fecha, `activo`, `auto` FROM publicaciones";
    $result = $this->ejecutar($query);
    $publicaciones = array();
    while ($row = mysqli_fetch_array($result)) {
      $publicaciones[] = new Publicacion($row['id'], $row['publicacion'], $row['redSocial'], $row['fecha'], $row['activo'], $row['auto']);
    }
    return $publicaciones;
  }

  public function damePublicacion($id)
  {
    $query = "SELECT `id`, `id_publicacion` AS publicacion, `red_social` AS redSocial, `fecha_hora` AS fecha, `activo`, `auto` FROM publicaciones WHERE id = " . (int) $id;
    $result = $this->ejecutar($query);
    $row = mysqli_fetch_array($result);
    return $row ? new Publicacion($row['id'], $row['publicacion'], $row['redSocial'], $row['fecha'], $row['activo'], $row['auto']) : null;
  }

  public function damePublicacionesActivas()
  {
    $query = "SELECT `id`, `id_publicacion` AS publicacion, `red_social` AS redSocial, `fecha_hora` AS fecha, `activo`, `auto` FROM publicaciones WHERE activo = 1";
    $result = $this->ejecutar($query);
    $publicaciones = array();
    while ($row = mysqli_fetch_array($result)) {
      $publicaciones[] = new Publicacion($row['id'], $row['publicacion'], $row['redSocial'], $row['fecha'], $row['activo'], $row['auto']);
    }
    return $publicaciones;
  }

  public function damePublicacionesInactivas()
  {
    $query = "SELECT `id`, `id_publicacion` AS publicacion, `red_social` AS redSocial, `fecha_hora` AS fecha, `activo`, `auto` FROM publicaciones WHERE activo = 0";
    $result = $this->ejecutar($query);
    $publicaciones = array();
    while ($row = mysqli_fetch_array($result)) {
      $publicaciones[] = new Publicacion($row['id'], $row['publicacion'], $row['redSocial'], $row['fecha'], $row['activo'], $row['auto']);
    }
    return $publicaciones;
  }

  public function existepublicacionPorRedSocialYa($redSocial, $auto)
  {
    $redSocial = $this->escapar((string) $redSocial);
    $query = "SELECT 1 FROM publicaciones WHERE red_social = '$redSocial' AND auto = " . (int) $auto . " LIMIT 1";
    $result = $this->ejecutar($query);
    return mysqli_num_rows($result) > 0;
  }

  public function dameIdPorAutoYRedSocial($auto, $redSocial)
  {
    $query = "SELECT id_publicacion FROM publicaciones WHERE auto = '$auto' AND red_social = '$redSocial';";
    $result = $this->ejecutar($query);
    $row = mysqli_fetch_array($result);
    return $row['id_publicacion'];
  }


  public function damePublicacionesPorAutoYRedSocial($auto, $redSocial)
  {
    $query = "SELECT * FROM publicaciones WHERE auto = '$auto' AND red_social = '$redSocial'";
    $result = $this->ejecutar($query);
    $publicaciones = array();
    while ($row = mysqli_fetch_array($result)) {
      $publicaciones[] = new Publicacion($row['id'], $row['id_publicacion'], $row['red_social'], $row['fecha_hora'], $row['activo'], $row['auto']);
    }
    return $publicaciones;
  }


  public function damePublicacionesPorAuto($auto)
  {
    $query = "SELECT * FROM publicaciones WHERE auto = '$auto'";
    $result = $this->ejecutar($query);
    $publicaciones = array();
    while ($row = mysqli_fetch_array($result)) {
      $publicaciones[] = new Publicacion($row['id'], $row['id_publicacion'], $row['red_social'], $row['fecha_hora'], $row['activo'], $row['auto']);
    }
    return $publicaciones;
  }

  public function inactivarPublicacion($id)
  {
    $query = "UPDATE publicaciones SET activo = 0 WHERE auto = '$id'";
    $this->ejecutar($query);
  }

  public function activarPublicacion($id)
  {
    $query = "UPDATE publicaciones SET activo = 1 WHERE auto = '$id'";
    $this->ejecutar($query);
  }
}
