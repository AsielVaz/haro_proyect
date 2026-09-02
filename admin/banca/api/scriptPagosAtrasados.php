<?php
session_start();

include_once("adminPagos.php");
include_once("adminVentas.php");
include_once("conectorBD.php");



$adminVentas = new AdministradorVentas();
$ventas = $adminVentas->dameVentas();
$adminPagos = new AdministradorPagos();


foreach($ventas as $venta){
    $pagos = $adminPagos->damePagosEventoVencidos($venta->id, $venta->pagos_acumulados, date("Y-m-d"));
    // echo "ID: " . $venta->id . "<br>";
    echo "Pagos acumulados: " .$venta->pagos_acumulados . "<br>";
    // echo "FECHA INICIO PAGOS: " . $venta->fecha_inicio_pagos . "<br>";
    if(count($pagos)>0){
        $interesesAcumulados = $venta->interes_acumulado;
        foreach($pagos as $pago){
             echo "ID: " . $venta->id . "<br>";
            echo "ID PAGO: " . $pago->id . "<br>";
            echo "FECHA PAGO: " . $pago->fecha_prospecto . "<br>";
            echo "MONTO PAGO: " . $pago->monto_acumulado . "<br>";
            echo "MONTO PAGAR: " . $pago->monto_pagar . "<br>";
            echo "MONTO INTERES: " . $pago->monto_interes . "<br>";
            $interesesAcumulados = $interesesAcumulados + $pago->monto_interes;
            echo "<br>";
            $adminPagos->marcarPagoAtrasado($pago->id);
        }
        echo "INTERESES ACUMULADOS: " . $interesesAcumulados . "<br>";
        $adminVentas->cambiarIntereses($venta->id, $interesesAcumulados);
    }
}
echo "<br>---------------------------------------------------------------------------------------------------<br>";


foreach($ventas as $venta){
    $pagos = $adminPagos->damePagosEventoNoCubierto($venta->id, $venta->pagos_acumulados);
    // echo "ID: " . $venta->id . "<br>";
    echo "Pagos acumulados: " .$venta->pagos_acumulados . "<br>";
    $totalPrecio = $venta->precio_inicial;
    $saldoInsuoluto = $totalPrecio - $venta->pagos_acumulados;
    $saldoInsuolutoInteres = $saldoInsuoluto + $venta->interes_acumulado;
    $pagoEventoNuevo = $saldoInsuolutoInteres / count($pagos);

    
    echo "Total precio: " .$totalPrecio . "<br>";
    echo "Saldo insoluto: " .$saldoInsuoluto . "<br>";
    echo "Saldo insoluto interés: " .$saldoInsuolutoInteres . "<br>";
    echo "Pago evento nuevo: " .$pagoEventoNuevo . "<br>";
    echo "<br>";

    // echo "FECHA INICIO PAGOS: " . $venta->fecha_inicio_pagos . "<br>";
    if(count($pagos)>0){
        for($i = 0; $i< intval(count($pagos)); $i++){
            $montoNuevoPago = $pagoEventoNuevo + ($saldoInsuolutoInteres * ($venta->porcentaje_pactado / 100));
            echo "ID: " . $venta->id . "<br>";
            echo "ID PAGO: " . $pagos[$i]->id . "<br>";
            echo "FECHA PAGO: " . $pagos[$i]->fecha_prospecto . "<br>";
            echo "MONTO PAGO: " . $pagos[$i]->monto_acumulado . "<br>";
            echo "MONTO INTERES: " . $pagos[$i]->monto_interes . "<br>";
            echo "MONTO PAGAR: " . $pagos[$i]->monto_pagar . "<br>";
            echo "NUEVO PAGO  ". $montoNuevoPago . " <br>";
            echo "<br>";
            $saldoInsuolutoInteres = $saldoInsuolutoInteres - $pagoEventoNuevo;
        }
     
    }

    echo "<br>---------------------------------------------------------------------------------------------------<br>";
}




//$pagosAtrasados = $adminPagos->damePagosEventoVencidos();



function generaPagosEventosAtrasados($acuerdo, $fecha, $monto, $id_venta, $por_com){
    $pagoPorEvento = $monto / $acuerdo;
    $fechaOriginal = $fecha;
    $monto_original = $monto;
    for($i = 0; $i< intval($acuerdo); $i++){
        $fecha = strtotime ( '+'.$i.' month' , strtotime ( $fechaOriginal ) ) ;
        $fecha = date ( 'Y-m-d' , $fecha );
        $adminPagos = new AdministradorPagos();
        $montoAcumulado = $pagoPorEvento * ($i + 1);
        //echo $fecha . "<br>";
        $comision = $monto_original * ($por_com / 100);
        $monto_original = $monto_original - $pagoPorEvento;
        $adminPagos->insertaPagoEvento($id_venta, $fecha, $montoAcumulado, ($pagoPorEvento + $comision), $comision);
    }

}


$sumaAutos = $adminVentas->sumaMontosAutosV();
$conteoAutos = $adminVentas->cuentaAutosValidosV();
$sumaVentas = $adminVentas->sumaVentasDia();
$sumaIntereses = $adminVentas->sumaInteresesDia();
$ventasConteo = $adminVentas->cuentaVentasDia();

$conector = new conectorB();
$conector->ejecutar("INSERT INTO `inventario_dia`(`autos_cantidad`, `monto_cantidad`) VALUES (".$conteoAutos.", ".$sumaAutos.")");
$conector->ejecutar("INSERT INTO `ventas_dia`(`ventas_cantidad`, `montos_cantidad`, `intereses`) VALUES (".$ventasConteo.", ".$sumaVentas.", ".$sumaIntereses.")");