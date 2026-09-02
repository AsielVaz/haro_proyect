<?php
require_once("adminAutos.php");
$adminAutos = new AdministradorAutos();

$autos = $adminAutos->obtenerAutosParaAsignarPortada();


$umbralSegundos = 7200; 
$ahora = new DateTime(); 

foreach ($autos as $auto) {
    $fechaCap = new DateTime($auto->fecha_cap);
    $diferencia = $ahora->getTimestamp() - $fechaCap->getTimestamp();
    if ($diferencia >= $umbralSegundos && $auto->primera_imagen) {
        $adminAutos->asignarPortadaAuto($auto->id, $auto->primera_imagen);
        echo "Auto ID {$auto->id} actualizado correctamente.\n";
    }
}
?>
