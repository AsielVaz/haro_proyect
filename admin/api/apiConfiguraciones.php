<?php

include_once("adminConfiguraciones.php");

$accion = (string) ($_POST['accion'] ?? '');
$casoCambiar = "cambiarConfiguracion";


function cambiarConfiguracion()
{
  $id = $_POST['id'];
  $valor = $_POST['valor'];
  $admin = new AdministradorConfiguraciones();
  $admin->cambiarConfiguracion($id, $valor);
  echo "1";
}

switch ($accion) {
  case $casoCambiar:
    cambiarConfiguracion();
    break;
}
