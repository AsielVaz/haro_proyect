<?php
include_once("adminPublicaciones.php");
$accion = (string) ($_POST['accion'] ?? '');
$casoAgregar = 'agregar';
$casoEliminar = 'eliminar';
$casoVerPublicado = 'verPublicado';
$casoVerId = 'verId';




function agregar()
{
    $publicacion = $_POST['publicacion'];
    $redSocial = $_POST['redSocial'];
    $auto = $_POST['auto'];
    $admin = new AdministradorPublicaciones();
    $admin->nuevaPublicacion($publicacion, $redSocial, date("Y-m-d"), 1, $auto);
    echo "1";
}

function eliminar()
{
    $id = $_POST['id'];
    $admin = new AdministradorPublicaciones();
    $admin->eliminarPublicacion($id);
    echo "1";
}

function verificarExistencia()
{
    $redSocial = $_POST['redSocial'];
    $auto = $_POST['auto'];
    $admin = new AdministradorPublicaciones();
    echo json_encode($admin->existepublicacionPorRedSocialYa($redSocial, $auto));
}

function verId()
{
    $redSocial = $_POST['redSocial'];
    $auto = $_POST['id_auto'];
    $admin = new AdministradorPublicaciones();
    echo json_encode($admin->damePublicacionesPorAutoYRedSocial($auto, $redSocial));
}


switch ($accion) {
    case $casoAgregar:
        agregar();
        break;
    case $casoEliminar:
        eliminar();
        break;
    case $casoVerPublicado:
        verificarExistencia();
        break;
    case $casoVerId:
        verId();
        break;
}
