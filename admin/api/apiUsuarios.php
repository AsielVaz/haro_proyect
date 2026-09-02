<?php
//json header
header('Content-Type: application/json');

include_once('adminUsuarios.php');
include_once('captcha.php');
include_once('validarCaracteres.php');
include_once('encriptador.php');

$accion = (string) ($_POST['accion'] ?? '');
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoInicio = "inicio";
$casoVerUnRegistro  = "verUno";
$casoActualizar = "actualizar";
$casoDireccion = "direccion";
$casoSubirImagen = "imagen";
$casoRecuperar = "recuperar-contrasena";
$casoAcender = "acender";
$casoDecender = "desender";
$casoInicioToken = "inicioToken";




function procesarImagen($id)
{

  $carpetaDestino = '/Imagenes/Usuarios/';
  $pesoMaxicoImagen = 2000000;
  $nombreCompuestoImagen = "default.txt";
  $nombre_imagen = $_FILES['archivo']['name'];
  $tipo_Imgaen = $_FILES['archivo']['type'];
  $tamanio_imagen = $_FILES['archivo']['size'];

  $casoPng = ".png";
  $casoJpeg = ".jpg";
  //comprovadores de peso y tipo de imagen

  if ($tamanio_imagen < $pesoMaxicoImagen) {
    if ($tipo_Imgaen == "image/jpeg" || $tipo_Imgaen == "image/png") {
      //mueve la imagen a la carpeta seleccionada 
      move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);
      chmod($carpetaDestino . $nombre_imagen, 0777);
      switch ($tipo_Imgaen) {
        case "image/jpeg":
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . $id . $casoJpeg;
          break;
        case "image/png":
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . $id .  $casoPng;
          break;
      }
      rename($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen, $_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen);
      chmod($_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen, 0777);
      unlink($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);

      return $nombreCompuestoImagen;
    } else {
      echo json_encode("El formato de la imagen no esta permitido");
    }
  } else {
    echo json_encode("La imagen supera el tamaño establecido");
  }
}

function procesarAlta()
{
  //$nombre, $apellidoPaterno, $apellidoMaterno, $email, $constrasena, $telefono, $calle, $ciudad, $pais, $direccion

  $nombre = $_POST['nombre'];
  $apellidoPaterno = $_POST['appat'];
  $apellidoMaterno = $_POST['apmat'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $contrasena = $_POST['pass'];
  $permiso_banca = $_POST['permiso_banca'];
  // $calle = $_POST['calle'];
  // $ciudad = $_POST['ciudad'];
  // $pais = $_POST['pais'];
  // $direccion = $_POST['direccion'];

  $admin = new administradorUsuarios();
  $admin->insertaUsuario($nombre, $apellidoPaterno, $apellidoMaterno, $email, $contrasena, $telefono, "No definido", "No definido", "No definido", "No definido", $permiso_banca);
  echo "1";
}

function procesarActualizacion()
{
  $validarCaracteres = new ValidarCaracteres();
  $id = $_POST['id'];
  $nombre = $validarCaracteres->validarTexto($_POST['nombre']);
  $apellidoPaterno = $validarCaracteres->validarTexto($_POST['appat']);
  $apellidoMaterno = $validarCaracteres->validarTexto($_POST['apmat']);
  $email = $_POST['email'];
  $pass = $validarCaracteres->validarContrasena($_POST['pass']);
  if ($nombre) {
    $admin = new administradorUsuarios();
    $admin->actualizarUsuario($id, $nombre, $apellidoPaterno, $apellidoMaterno, $email, $pass, "No definido", "No definido", "No definido", "No definido", "No definido");
    echo "1";
  } else {
    echo "0";
  }
}

function procesarActualizacionContrasena()
{
  $validarCaracteres = new ValidarCaracteres();
  $id = $_POST['id'];
  $token = $_POST['token'];
  $pass = $validarCaracteres->validarContrasena($_POST['pass']);
  if ($pass) {
    $admin = new administradorUsuarios();
    $admin->actualizarContrasena($id, $pass);
    $admin->mataToken($token);
    echo "1";
  } else {
    echo "0";
  }
}

function procesarActualizacionDireccion()
{

  $id = $_POST['id'];
  $direccion = $_POST['direccion'];
  $calle = $_POST['calle'];
  $ciudad = $_POST['ciudad'];
  $pais = $_POST['pais'];
  $email = $_POST['email'];
  $admin = new administradorUsuarios();
  $admin->actualizarDireccion($id, $email, $calle, $ciudad, $pais, $direccion);
  echo "1";
}
function verificarCaptcha()
{
  $captcha = $_POST['g-recaptcha-response'];
  $cap = new Captcha($captcha);
  return $cap->dameEstatus();
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorUsuarios();
  $admin->eliminaUsuario($id);
  echo "1";
}

function procesarVerRegistros() {}

function procesarVerUnRegistro() {}

function procesarAcender()
{
  $id = $_POST['id'];
  $admin = new administradorUsuarios();
  $admin->acenderUsuario($id);
  echo "1";
}

function procesarDesender()
{
  $id = $_POST['id'];
  $admin = new administradorUsuarios();
  $admin->desenderUsuario($id);
  echo "1";
}

function procesarImagenUsuario()
{
  $id = $_POST['id'];
  $imagen = procesarImagen($id);
  $admin = new administradorUsuarios();
  $admin->asignarImagen($id, $imagen);
  echo "1";
}

function inicioSesion()
{

  $email = $_POST['email'];
  $constrasena = $_POST['pass'];
  $admin = new administradorUsuarios();
  $usuario = $admin->dameUsuario($email, $constrasena);
  if ($usuario->id != 0) {
    $respuestas = array();
    $respuestas[] = $usuario->id;
    $respuestas[] = $usuario->tipoUsuario;
    $respuestas[] = $usuario->permiso_banca;
    $respuestas[] = $usuario->nombre;
    $respuestas[] = encriptar($usuario->id . "|" . $usuario->tipoUsuario . "|" . $usuario->permiso_banca . "|" . $usuario->nombre);

    echo json_encode($respuestas);
  } else {
    echo "0";
  }
}

function inicioSesionToken()
{
  $token = (string) ($_POST['token'] ?? '');
  $tokenDesencrip = desencriptar($token);
  $tokenArray = explode("|", $tokenDesencrip);
  if (count($tokenArray) !== 4) {
    http_response_code(400);
    echo json_encode(['error' => 'Token no válido']);
    return;
  }
  $id = (int) $tokenArray[0];
  $admin = new administradorUsuarios();
  $usuario = $admin->dameUsuarioId($id);
  if ($usuario->id != 0) {
    $respuestas = array();
    $respuestas[] = $usuario->id;
    $respuestas[] = $usuario->tipoUsuario;
    $respuestas[] = $usuario->permiso_banca;
    $respuestas[] = $usuario->nombre;
    $respuestas[] = encriptar($usuario->id . "|" . $usuario->tipoUsuario . "|" . $usuario->permiso_banca . "|" . $usuario->nombre);
    echo json_encode($respuestas);
  } else {
    echo "0";
  }
}

switch ($accion) {
  case $casoAgregar:

    procesarAlta();

    break;
  case $casoActualizar:
    procesarActualizacion();
    break;
  case $casoEliminar:
    procesarBaja();
    break;
  case $casoInicio:
    inicioSesion();
    break;
  case $casoInicioToken:
    inicioSesionToken();
    break;
  case $casoVerUnRegistro:
    break;
  case $casoDireccion:
    procesarActualizacionDireccion();
    break;
  case $casoSubirImagen:
    procesarImagenUsuario();
    break;
  case $casoRecuperar:
    procesarActualizacionContrasena();
    break;
  case $casoAcender:
    procesarAcender();
    break;
  case $casoDecender:
    procesarDesender();
    break;
  default:
    echo '0';
    break;
}
