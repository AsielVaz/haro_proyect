<?php

include_once('conectorBD.php');
class Usuario
{
  public $nombre;
  public $id;
  public $apellidoPaterno;
  public $apellidoMaterno;
  public $email;
  public $constrasena;
  public $telefono;
  public $calle;
  public $ciudad;
  public $pais;
  public $direccion;
  public $tipoUsuario;
  public $imagen;
  public $permiso_banca;

  public function __construct()
  {
    $this->id = 0;
  }
}

class Recuperacion
{
  public $id;
  public $idUsuario;
  public $token;
  public $fecha;
  public function __construct()
  {
    $this->id = 0;
  }
}

class administradorUsuarios extends conector
{
  public function insertaUsuario($nombre, $apellidoPaterno, $apellidoMaterno, $email, $constrasena, $telefono, $calle, $ciudad, $pais, $direccion, $permiso_banca)
  {
    $sql = 'INSERT INTO usuario (nombre,apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, permiso_banca) 
    values ("' . $nombre . '","' . $apellidoPaterno . '","' . $apellidoMaterno . '","' . $email . '","' . sha1($constrasena) . '","' . $telefono . '","' . $calle . '","' . $ciudad . '","' . $pais . '","' . $direccion . '" , 100, "'.$permiso_banca.'");';
    $this->ejecutar($sql);
  }
  public function insertaRecuperacion($idUsuario, $token, $fecha)
  {
    $sql = 'INSERT INTO recuperacion (id_usuario,token,fecha) VALUES (' . $idUsuario . ',' . $token . ',"' . $fecha . '");';
    $this->ejecutar($sql);
  }

  public function dameRecuperacion($token)
  {
    $rec = new Recuperacion();
    $sql = 'SELECT * FROM recuperacion WHERE token = ' . $token . ' ORDER BY fecha;';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $rec->id = $row['id'];
        $rec->idUsuario = $row['id_usuario'];
        $rec->token = $row['token'];
        $rec->fecha = $row['fecha'];
      }
    } else {
    }

    //print_r(json_encode($arregloProductos));
    return $rec;
  }

  public function dameUsuario($email, $pass)
  {
    $usuario = new Usuario();
    $email = $this->escapar((string) $email);
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen, permiso_banca
    FROM usuario 
    WHERE email = "' . $email . '" and contrasena ="' . sha1($pass) . '";';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $usuario->id = $row['id'];
        $usuario->imagen = $row['imagen'];
        $usuario->nombre = $row['nombre'];
        $usuario->apellidoPaterno = $row['apellido_paterno'];
        $usuario->apellidoMaterno = $row['apellido_materno'];
        $usuario->email = $row['email'];
        $usuario->constrasena = $row['contrasena'];
        $usuario->telefono = $row['telefono'];
        $usuario->calle = $row['calle'];
        $usuario->ciudad = $row['ciudad'];
        $usuario->pais = $row['pais'];
        $usuario->direccion = $row['direccion'];
        $usuario->tipoUsuario = $row['tipo_usuario'];
        $usuario->permiso_banca = $row['permiso_banca'];
      }
      return $usuario;
    } else {
      return $usuario;
    }

    //print_r(json_encode($arregloProductos));
    return $usuario;
  }
  public function existeUsuario($email)
  {
    $email = $this->escapar((string) $email);
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen
    FROM usuario 
    WHERE email = "' . $email . '";';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        return intval($row['id']);
      }
    } else {
      return false;
    }
    //print_r(json_encode($arregloProductos));
    return $usuario;
  }
  public function mataToken($token)
  {
    $sql = 'DELETE FROM recuperacion WHERE token = ' . $token . ';';
    $this->ejecutar($sql);
  }
  public function dameUsuarioId($id)
  {
    $usuario = new Usuario();
    $id = (int) $id;
    if ($id > 0) {
      $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen, permiso_banca
      FROM usuario 
      WHERE id = '.$id.';';
      $result = $this->ejecutar($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $usuario->id = $row['id'];
          $usuario->nombre = $row['nombre'];
          $usuario->imagen = $row['imagen'];
          $usuario->apellidoPaterno = $row['apellido_paterno'];
          $usuario->apellidoMaterno = $row['apellido_materno'];
          $usuario->email = $row['email'];
          $usuario->constrasena = $row['contrasena'];
          $usuario->telefono = $row['telefono'];
          $usuario->calle = $row['calle'];
          $usuario->ciudad = $row['ciudad'];
          $usuario->pais = $row['pais'];
          $usuario->direccion = $row['direccion'];
          $usuario->tipoUsuario = $row['tipo_usuario'];
          $usuario->permiso_banca = $row['permiso_banca'];
        }
        return $usuario;
      } else {
        return $usuario;
      }
    }else{
      return $usuario;
    }

    //print_r(json_encode($arregloProductos));
    return $usuario;
  }
  public function eliminaUsuario($id)
  {
    $sql = 'DELETE FROM usuario WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  function buscaUsuario($buscar)
  {
    $arregloUsuarios = array();
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen
    FROM usuario WHERE nombre like "%' . $buscar . '%" or apellido_materno like "%' . $buscar . '%" or apellido_paterno like "%' . $buscar . '%" or telefono like "%' . $buscar . '%" or email like "%' . $buscar . '%";';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $usuario = new Usuario();
        $usuario->id = $row['id'];
        $usuario->nombre = $row['nombre'];
        $usuario->imagen = $row['imagen'];
        $usuario->apellidoPaterno = $row['apellido_paterno'];
        $usuario->apellidoMaterno = $row['apellido_materno'];
        $usuario->email = $row['email'];
        $usuario->constrasena = $row['contrasena'];
        $usuario->telefono = $row['telefono'];
        $usuario->calle = $row['calle'];
        $usuario->ciudad = $row['ciudad'];
        $usuario->pais = $row['pais'];
        $usuario->direccion = $row['direccion'];
        $usuario->tipoUsuario = $row['tipo_usuario'];
        $arregloUsuarios[] = $usuario;
      }
      return $arregloUsuarios;
    } else {
      return $arregloUsuarios;
    }

    //print_r(json_encode($arregloProductos));
    return $arregloUsuarios;
  }
  function dameUsuarios()
  {
    $arregloUsuarios = array();
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen, permiso_banca
    FROM usuario;';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $usuario = new Usuario();
        $usuario->id = $row['id'];
        $usuario->nombre = $row['nombre'];
        $usuario->imagen = $row['imagen'];
        $usuario->apellidoPaterno = $row['apellido_paterno'];
        $usuario->apellidoMaterno = $row['apellido_materno'];
        $usuario->email = $row['email'];
        $usuario->constrasena = $row['contrasena'];
        $usuario->telefono = $row['telefono'];
        $usuario->calle = $row['calle'];
        $usuario->ciudad = $row['ciudad'];
        $usuario->pais = $row['pais'];
        $usuario->direccion = $row['direccion'];
        $usuario->tipoUsuario = $row['tipo_usuario'];
        $usuario->permiso_banca = $row['permiso_banca'];
        $arregloUsuarios[] = $usuario;
      }
      return $arregloUsuarios;
    } else {
      return $arregloUsuarios;
    }

    //print_r(json_encode($arregloProductos));
    return $arregloUsuarios;
  }

  function actualizarUsuario($id, $nombre, $apellidoPaterno, $apellidoMaterno, $email, $contrasena, $telefono, $calle, $ciudad, $pais, $direccion)
  {

    $sql = 'UPDATE usuario SET nombre = "' . $nombre . '", apellido_paterno = "' . $apellidoPaterno . '", apellido_materno = "' . $apellidoMaterno . '", email = "' . $email . '", contrasena = "' . sha1($contrasena) . '"  WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function actualizarContrasena($id, $contrasena)
  {
    $sql = 'UPDATE usuario SET contrasena = "' . sha1($contrasena) . '"  WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function actualizarDireccion($id, $email, $calle, $ciudad, $pais, $direccion)
  {
    $sql = 'UPDATE usuario SET calle = "' . $calle . '",  email = "' . $email . '" ,  ciudad = "' . $ciudad . '", pais = "' . $pais . '", direccion = "' . $direccion . '" WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function asignarImagen($id, $imagen)
  {
    $sql = 'UPDATE usuario SET imagen = "' . $imagen . '" WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  function acenderUsuario($id)
  {
    $sql = 'UPDATE usuario SET tipo_usuario = 100 WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function desenderUsuario($id)
  {
    $sql = 'UPDATE usuario SET tipo_usuario = 0 WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  public function modificaProducto()
  {
  }
}
