<?php
include_once("adminClientes.php");

$accion = (string) ($_POST['accion'] ?? '');


$casoAgregar = "agregar";
$casoModificar = "modificar";
$casoEliminar = "eliminar";

function procesarImagen()
{

  $carpetaDestino = '/admin/banca/imagenes/clientes/';
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
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) . $casoJpeg;
          break;
        case "image/png":
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) .  $casoPng;
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

function agregarCliente(){
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['app'];
    $email = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $imagen = procesarImagen();
    $adminClientes = new AdministradorClientes();
    $adminClientes->insertaCliente($nombre, $apellidos, $email, $telefono, $imagen);
    $mensaje = array("mensaje"=>"Cliente agregado", "status"=>"ok");
    echo json_encode($mensaje);
}

function eliminarCliente(){
    $id = $_POST['id'];
    $adminClientes = new AdministradorClientes();
    $adminClientes->eliminaCliente($id);
    $mensaje = array("mensaje"=>"Cliente eliminado", "status"=>"ok");
    echo json_encode($mensaje);
}




switch($accion){
    case $casoAgregar:
        agregarCliente();
        break;
    case $casoModificar:
        break;
    case $casoEliminar:
        eliminarCliente();
        break;
}
