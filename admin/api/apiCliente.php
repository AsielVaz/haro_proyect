
<?php

include_once('adminClientes.php');


$accion = (string) ($_POST['accion'] ?? '');
$casoAlta = "agregar";
$casoBaja = "eliminar";


function procesarAlta()
{
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $admin = new AdministradorClientes();
    $admin->setCliente($nombre, $appat, $apmat, $correo, $telefono);
    echo "1";
}

function procesarBaja()
{
    $id = $_POST['id'];
    $admin = new AdministradorClientes();
    $admin->deleteCliente($id);
    echo "1";
}



switch ($accion) {
    case $casoAlta:
        procesarAlta();
        break;
    case $casoBaja:
        procesarBaja();
        break;
    default:
        echo "El caso no existe";
        break;
}
