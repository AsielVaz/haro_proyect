<?php

include_once("adminEstadisticas.php");

$accion = (string) ($_POST['accion'] ?? '');

$casoVerAnio = "verAnio";
$casoVerAutos = "verAutosDia";

function procesarVerAnio()
{
  $admin = new AdministradorEstadisticas();
  $anio = $admin->generaAnio();
  echo json_encode($anio);
}

function ordenarAutosBurbuja($autos)
{
  $autosOrdenados = array();
  $autosOrdenados = $autos;
  $cantidad = count($autosOrdenados);
  for ($i = 0; $i < $cantidad; $i++) {
    for ($j = 0; $j < $cantidad - 1; $j++) {
      if ($autosOrdenados[$j]->visitas < $autosOrdenados[$j + 1]->visitas) {
        $aux = $autosOrdenados[$j];
        $autosOrdenados[$j] = $autosOrdenados[$j + 1];
        $autosOrdenados[$j + 1] = $aux;
      }
    }
  }
  return $autosOrdenados;
}

function procesarVerAutos()
{
  $dia = $_POST['dia'];
  $admin = new AdministradorEstadisticas();
  $autos = $admin->dameVisitasPorAuto($dia);
  echo json_encode(ordenarAutosBurbuja($autos));
}


switch ($accion) {
  case $casoVerAnio:
    procesarVerAnio();
    break;
  case $casoVerAutos:
    procesarVerAutos();
    break;
  default:
    echo "Error: Acción no reconocida";
    break;
}
