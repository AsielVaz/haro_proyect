<?php
include "adminPagos.php";
include "adminVentas.php";
include "adminClientes.php";
include_once "adminUsuarios.php";

$adminVentas = new AdministradorVentas();
$adminPagos = new AdministradorPagos();
$adminClientes = new AdministradorClientesBanca();
$adminUsuarios = new administradorUsuarios();
$usuariosBanca = $adminUsuarios->dameUsuariosBanca();

$hoy = date("Y-m-d");
$hoyMas5 = strtotime('+5 day', strtotime($hoy));
$hoyMas5 = date('Y-m-d', $hoyMas5);

$ventas = $adminVentas->dameVentas();
foreach ($ventas as $venta) {
    $pagosVenta = $adminPagos->damePagosEventoNoCubierto($venta->id, $venta->pagos_acumulados);
    $cantidadPagos = count($pagosVenta);
    $cliente = $adminClientes->dameCliente($venta->id_cliente);
    echo  $hoyMas5 . "<br>";

    foreach($pagosVenta as $pago){
            if($pago->fecha_prospecto == $hoy){

                foreach($usuariosBanca as $usuario){
                    mensajeHaro($cantidadPagos, $pago->num_pago, $cliente->nombre . " " . $cliente->apellidos, ($pago->monto_pagar ), $venta->identificador, $usuario->telefono);

                }

                mensajeDia( $cliente->nombre . " " . $cliente->apellidos, ($pago->monto_pagar ), $venta->identificador, $cliente->telefono);

            }
            if($hoyMas5 == $pago->fecha_prospecto){

                mensaje5Dias( $cliente->nombre . " " . $cliente->apellidos, ($pago->monto_pagar ), $venta->identificador, $cliente->telefono, $pago->fecha_prospecto);


            }
    }

    

}




function mensaje5Dias($nombreCliente, $cantidad, $auto, $telefono, $fecha)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v17.0/187052137814295/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '
    {
      "messaging_product": "whatsapp",
      "to": "52' . $telefono . '",
      "type": "template",
      "template": {
        "name": "n_recodatorio_pago",
        "language": {
          "code": "es"
        },
        "components": [
             {
            "type": "body",
            "index": 0,
            "parameters": [
                {
                    "type": "text",
                    "text": "'.$nombreCliente.'"
                },
                  {
                    "type": "text",
                    "text": "$ '. number_format($cantidad, 2) .'"
                }
                ,
                  {
                    "type": "text",
                    "text": "'.$fecha.'"
                },
                  {
                    "type": "text",
                    "text": "'.$auto.'"
                }
                
                
            ]
        }
        ]
      }
    }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer EABraG1mmqU0BOZC8i15L0OwPgtNGpagYtrx86JH5LdZC9y1SREr0VJbkj1ZAmkEZBhfwmuVXwQ7rd2jTMfpSjv0Yi7RURgWP0GZAM8LEi7nMb04ZAsBZAsoPFYQHygsvEZCoLprd598xYgRPnDXMifLpjMHm15xyz9QRUZC1jpgtIOsn6hd2vN1D1z2CHMRTEHQ0ubrKwfaffFpfEJlSZB',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    echo "<br><br><br><br><br><br>";
    //esperar 2 segundos 
    sleep(2);

}

function mensajeDia($nombreCliente, $cantidad, $auto, $telefono)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v17.0/187052137814295/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '
    {
      "messaging_product": "whatsapp",
      "to": "52' . $telefono . '",
      "type": "template",
      "template": {
        "name": "n_recordatorio_ultimo",
        "language": {
          "code": "es"
        },
        "components": [
             {
            "type": "body",
            "index": 0,
            "parameters": [
                {
                    "type": "text",
                    "text": "'.$nombreCliente.'"
                },
                  {
                    "type": "text",
                    "text": "$ '. number_format($cantidad, 2) .'"
                },
                  {
                    "type": "text",
                    "text": "'.$auto.'"
                }
                
                
            ]
        }
        ]
      }
    }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer EABraG1mmqU0BOZC8i15L0OwPgtNGpagYtrx86JH5LdZC9y1SREr0VJbkj1ZAmkEZBhfwmuVXwQ7rd2jTMfpSjv0Yi7RURgWP0GZAM8LEi7nMb04ZAsBZAsoPFYQHygsvEZCoLprd598xYgRPnDXMifLpjMHm15xyz9QRUZC1jpgtIOsn6hd2vN1D1z2CHMRTEHQ0ubrKwfaffFpfEJlSZB',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    echo "<br><br><br><br><br><br>";
    //esperar 2 segundos 
    sleep(2);

}

function mensajeInteres()
{
}

function mensajeHaro($cantidadPagos, $numeroPago, $nombreCliente, $cantidad, $auto, $telefono)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v17.0/187052137814295/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '
    {
      "messaging_product": "whatsapp",
      "to": "52' . $telefono . '",
      "type": "template",
      "template": {
        "name": "n_pagos_programados",
        "language": {
          "code": "es"
        },
        "components": [
             {
            "type": "body",
            "index": 0,
            "parameters": [
                {
                    "type": "text",
                    "text": "'.$nombreCliente.'"
                },
                  {
                    "type": "text",
                    "text": "$ '. number_format($cantidad, 2) .'"
                },
                  {
                    "type": "text",
                    "text": "'.$auto.'"
                }
                ,
                  {
                    "type": "text",
                    "text": "'.$numeroPago.'"
                }
                ,
                  {
                    "type": "text",
                    "text": "'.$cantidadPagos.'"
                }
                
            ]
        }
        ]
      }
    }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer EABraG1mmqU0BOZC8i15L0OwPgtNGpagYtrx86JH5LdZC9y1SREr0VJbkj1ZAmkEZBhfwmuVXwQ7rd2jTMfpSjv0Yi7RURgWP0GZAM8LEi7nMb04ZAsBZAsoPFYQHygsvEZCoLprd598xYgRPnDXMifLpjMHm15xyz9QRUZC1jpgtIOsn6hd2vN1D1z2CHMRTEHQ0ubrKwfaffFpfEJlSZB',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    echo "<br><br><br><br><br><br>";
    //esperar 2 segundos 
    sleep(2);
}
