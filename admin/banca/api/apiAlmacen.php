<?php
//json
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

header('Content-Type: application/json');
session_start();
include_once("adminAlmacenes.php");

$accion = (string) ($_POST['accion'] ?? '');

$casoAlta = "alta";
$casoBaja = "baja";
$casoConsulta = "consulta";
$casoConsultaId = "consultaId";
$casoModificacion = "modificacion";
$casoCambiarAlmacen = "cambiarAlmacen";

function altaAlmacen() {
    $admin = new AdministradorAlmacenes();
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $des_gen = $_POST['des_gen'];
        $lon = $_POST['lon'];
        $lat = $_POST['lat'];
    
    $admin->insertaAlmacen($direccion, $cp, $des_gen, $lon, $lat);
    $mensaje["mensaje"] = "Almacén creado correctamente";
    $mensaje["error"] = false;
    echo json_encode($mensaje);
}


function modificarAlmacen() {
    $admin = new AdministradorAlmacenes();
    $id = $_POST['id'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $des_gen = $_POST['des_gen'];
    $lon = $_POST['lon'];
    $lat = $_POST['lat'];
    $admin->modificarAlmacen($id, $direccion, $cp, $des_gen, $lon, $lat);
    $mensaje["mensaje"] = "Almacén modificado correctamente";
    $mensaje["error"] = false;
    echo json_encode($mensaje);
}

 function eliminarAlmacen() {
    $admin = new AdministradorAlmacenes();
    $id = $_POST['id'];
    $admin->eliminarAlmacen($id);
    $mensaje["mensaje"] = "Almacén eliminado correctamente";
    $mensaje["error"] = false;
    echo json_encode($mensaje);
}

function dameAlmacenes() {
    $admin = new AdministradorAlmacenes();
    $almacenes = $admin->dameAlmacnes();
    echo json_encode($almacenes);
}

function dameAlmacenId() {
    $admin = new AdministradorAlmacenes();
    $id = $_POST['id'];
    $almacen = $admin->dameAlmacen($id);
    echo json_encode($almacen);
}


function cambiarAlmacen() {
    $admin = new AdministradorAlmacenes();
    $idAuto = $_POST['idAuto'];
    $idAlmacen = $_POST['idAlmacen'];
    $disp = $_POST['disp'];
    $id_usuario = $_POST['id_usuario'];
    $admin->cambiarAlmacenAuto($idAuto, $idAlmacen, $disp, $id_usuario);
    $mensaje["mensaje"] = "Almacén cambiado correctamente"; 
    $mensaje["error"] = false;
    echo json_encode($mensaje);
}


switch ($accion) {
    case $casoAlta:
        altaAlmacen();
        break;
    case $casoBaja:
        eliminarAlmacen();
        break;
    case $casoConsulta:
        dameAlmacenes();
        break;
    case $casoConsultaId:
        dameAlmacenId();
        break;
    case $casoModificacion:
        modificarAlmacen();
        break;
    case $casoCambiarAlmacen:
        cambiarAlmacen();
        break;
    default:
        $mensaje["mensaje"] = "Acción no reconocida";
        $mensaje["error"] = true;
        echo json_encode($mensaje);
}
