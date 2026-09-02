<?php

include_once("adminEditor.php");

$accion = (string) ($_POST['accion'] ?? '');

$casoAgregarMarca = "marca";
$casoAgregarInterior = "interior";
$casoAgregarTransmicion = "trans";
$casoAgregarModelo = "modelo";

$casoVerModelos = "verModelos";

$casoEliminarMarca = "emarca";
$casoEliminarInterior = "einterior";
$casoEliminarTransmicion = "etrans";
$casoEliminarModelo = "emodelo";

$casoVerModelosPorMarca = "verModelosPorMarca";

function procesarImagen()
{

  $carpetaDestino = '/Imagenes/Marcas/';
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

function procesarAltaMarca()
{
  $admin = new AdministradorEditor();
  $marca = $_POST['marca'];
  if ($admin->existeMarcaPorNombre($marca)) {
    echo "3";
  } else {
    $imagen = procesarImagen();
    $admin->agregarMarca($marca, $imagen);
    echo "1";
  }
}
function procesarAltaModelo()
{
  $admin = new AdministradorEditor();
  $modelo = $_POST['modelo'];
  $marca = $_POST['marca'];
  $admin->agregarModelo($modelo, $marca);
  echo "1";
}
function procesarAltaInterior()
{
  $admin = new AdministradorEditor();
  $interior = $_POST['interior'];
  $admin->agregarInterior($interior);
  echo "1";
}
function procesarAltaTransmicion()
{
  $admin = new AdministradorEditor();
  $trans = $_POST['trans'];
  $admin->agregartransmicion($trans);
  echo "1";
}

function procesarBajaMarca()
{
  $id = $_POST['id'];
  $admin = new AdministradorEditor();
  if ($admin->eliminaMarca($id)) {
    echo "1";
  } else {
    echo "3";
  }
}

function procesarBajaModelo()
{
  $id = $_POST['id'];
  $admin = new AdministradorEditor();
  $admin->eliminarModelo($id);
  echo "1";
}


function procesarBajaInterior()
{
  $id = $_POST['id'];
  $admin = new AdministradorEditor();
  $admin->eliminaInterior($id);
  echo "1";
}


function procesarBajaTransmicion()
{
  $id = $_POST['id'];
  $admin = new AdministradorEditor();
  $admin->eliminaTransmicion($id);
  echo "1";
}

function procesarVerModelos()
{
  $id = $_POST['id'];
  $admin = new AdministradorEditor();
  echo json_encode($admin->dameModelosPorMarca($id));
}

function procesarVerModelosEspecificos()
{
  $marca = $_POST['marca'];
  $admin = new AdministradorEditor();
  echo json_encode($admin->dameModelosGeneralesPorMarca($marca));
}



switch ($accion) {
  case $casoAgregarInterior:
    procesarAltaInterior();
    break;
  case $casoAgregarMarca:
    procesarAltaMarca();
    break;
  case $casoAgregarModelo:
    procesarAltaModelo();
    break;
  case $casoAgregarTransmicion:
    procesarAltaTransmicion();
    break;
  case $casoEliminarInterior:
    procesarBajaInterior();
    break;
  case $casoEliminarMarca:
    procesarBajaMarca();
    break;
  case $casoEliminarModelo:
    procesarBajaModelo();
    break;
  case $casoEliminarTransmicion:
    procesarBajaTransmicion();
    break;
  case $casoVerModelos:
    procesarVerModelos();
    break;
  case $casoVerModelosPorMarca:
    procesarVerModelosEspecificos();
    break;

  default:
    echo '0';
    break;
}
