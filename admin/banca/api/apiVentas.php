<?php
session_start();
include_once("../../api/conectorBD.php");
include_once("adminVentas.php");
include_once("adminPagos.php");
include_once("../../api/adminAutos.php");
include_once("encriptador.php");
include_once("adminClientes.php");
include_once("adminUsuarios.php");



$accion = (string) ($_POST['accion'] ?? '');
$casoInserta = "inserta";
$casoElimina = "elimina";
$casoModifica = "modifica";
function formatearFechaSql($fecha)
{
  $fecha = explode("/", $fecha);
  $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
  return $fecha;
}

function generaPagosEventos($acuerdo, $fecha, $monto, $periodo_venta, $id_venta, $por_com)
{
  $adminClientes = new AdministradorClientesBanca();
  $cleinte = $adminClientes->dameCliente($_POST['cliente']);
  $pagoPorEvento = $monto / $acuerdo;
  $fechaOriginal = $fecha;
  $monto_original = $monto;
  $num_pago = 1;
  $adminPagos = new AdministradorPagos();

  for ($i = 0; $i < intval($acuerdo); $i++) {
    $fecha = strtotime('+' . $i . ' month', strtotime($fechaOriginal));
    $fecha = date('Y-m-d', $fecha);
    $montoAcumulado = $pagoPorEvento * ($i + 1);
    //echo $fecha . "<br>";
    $comision = $monto_original * ($por_com / 100);
    $monto_original = $monto_original - $pagoPorEvento;
    $adminPagos->insertaPagoEvento($id_venta, $fecha, $montoAcumulado, ($pagoPorEvento + $comision), $comision, $num_pago);
    $num_pago++;
  }
  $emision = date("Y-m-d");
  $precio_inicial = $_POST['precio_inicial'];
  $precio_pactado = $_POST['precio_pactado'];
  $precio_inicial = str_replace(",", "", $precio_inicial);
  $precio_pactado = str_replace(",", "", $precio_pactado);
  $pago_inicial = $_POST['enganche'];
  $pago_inicial = str_replace(",", "", $pago_inicial);
  $cadenaEnvio = $_POST['auto'] . "," . $_SESSION['sesionUsuario']['id'] . "," . $_POST['cliente'] . "," . $precio_pactado . "," . $acuerdo . "," . $_POST['por_com'] . "," . formatearFechaSql($fecha) . "," . $emision;
  $cadenaEnvio = encriptar($cadenaEnvio);
  $cadenaRecivo = $_POST['auto'] . "," . $_SESSION['sesionUsuario']['id'] . "," . $_POST['cliente'] . "," . $precio_pactado . "," . $acuerdo . "," . $_POST['por_com'] . "," . formatearFechaSql($fecha) . "," . $emision . "," . $precio_inicial . "," . $pago_inicial;
  $cadenaRecivo = encriptar($cadenaRecivo);
  envioRecivoVenta($cleinte->telefono, $cadenaRecivo);
  envioCorridaVenta($cleinte->telefono, $cadenaEnvio);
}

function generarPagosEventosDias($acuerdo, $fecha, $monto, $periodo_venta, $id_venta, $por_com)
{
  $adminClientes = new AdministradorClientesBanca();
  $cleinte = $adminClientes->dameCliente($_POST['cliente']);
  $pagoPorEvento = $monto / $acuerdo;
  $fechaOriginal = $fecha;
  $monto_original = $monto;
  $num_pago = 1;
  $adminPagos = new AdministradorPagos();

  for ($i = 0; $i < intval($acuerdo); $i++) {
    $fecha = strtotime('+' . ($i * $periodo_venta) . ' day', strtotime($fechaOriginal));
    $fecha = date('Y-m-d', $fecha);
    $montoAcumulado = $pagoPorEvento * ($i + 1);
    //echo $fecha . "<br>";
    $comision = $monto_original * ($por_com / 100);
    $monto_original = $monto_original - $pagoPorEvento;
    $adminPagos->insertaPagoEvento($id_venta, $fecha, $montoAcumulado, ($pagoPorEvento + $comision), $comision, $num_pago);
    $num_pago++;
  }
  $emision = date("Y-m-d");
  $precio_inicial = $_POST['precio_inicial'];
  $precio_pactado = $_POST['precio_pactado'];
  $precio_inicial = str_replace(",", "", $precio_inicial);
  $precio_pactado = str_replace(",", "", $precio_pactado);
  $pago_inicial = $_POST['enganche'];
  $pago_inicial = str_replace(",", "", $pago_inicial);
  $cadenaEnvio = $_POST['auto'] . "," . $_SESSION['sesionUsuario']['id'] . "," . $_POST['cliente'] . "," . $precio_pactado . "," . $acuerdo . "," . $_POST['por_com'] . "," . formatearFechaSql($fecha) . "," . $emision;
  $cadenaEnvio = encriptar($cadenaEnvio);
  $cadenaRecivo = $_POST['auto'] . "," . $_SESSION['sesionUsuario']['id'] . "," . $_POST['cliente'] . "," . $precio_pactado . "," . $acuerdo . "," . $_POST['por_com'] . "," . formatearFechaSql($fecha) . "," . $emision . "," . $precio_inicial . "," . $pago_inicial;
}


function generarPagoInicial($id_venta, $monto, $metodo_pago)
{
  $adminUsuarios = new administradorUsuarios();
  $adminVentas = new AdministradorVentas();
  $ventaO = $adminVentas->dameVenta($id_venta);
  $usuarios_banca = $adminUsuarios->dameUsuariosBanca();
  $usuario_inserta = $_SESSION['sesionUsuario']['id'];
  $usuario = $adminUsuarios->dameUsuarioId($usuario_inserta);
  $fecha = date("Y-m-d");
  $adminPagos = new AdministradorPagos();
  $estatus = "Pendiente";
  if ($_SESSION['sesionUsuario']['permiso_banca'] == "Banca") {
    $estatus = "Aprobado";
    $adminPagos->insertaPago($monto, $id_venta, $estatus, $fecha, $metodo_pago, "Pago Inicial");
  } else {
    $estatus = "Pendiente";
    $idpago = $adminPagos->insertaPago($monto, $id_venta, $estatus, $fecha, $metodo_pago, "Pago Inicial");

    foreach ($usuarios_banca as $usuarioB) {
      mensajeWhats($usuario->nombre, $_POST['enganche'], $ventaO->identificador, $idpago, $usuarioB->telefono, $_POST['metodo_pago']);
    }
  }
}
function insertaVenta()
{
  $precio_inicial = $_POST['precio_inicial'];
  $precio_pactado = $_POST['precio_pactado'];
  $precio_inicial = str_replace(",", "", $precio_inicial);
  $precio_pactado = str_replace(",", "", $precio_pactado);
  $id_auto = $_POST['auto'];
  $pago_inicial = $_POST['enganche'];
  $pago_inicial = str_replace(",", "", $pago_inicial);
  $fecha_inicio_pagos = $_POST['fecha_inicial'];
  $acuerdo_pagos = $_POST['acuerdo'];
  $id_cliente = $_POST['cliente'];
  $periodo_venta = $_POST['periodo_venta'];
  $metodo_pago = $_POST['metodo_pago'];
  $por_com = $_POST['por_com'];
  $tipo_pago = $_POST['tipoPago'];
  $tipoPeriodo = $_POST['tipo_periodo'];
  $diasAcuerdo = $_POST['dias_periodo'];
  $adminVentas = new AdministradorVentas();
  $adminAutos = new AdministradorAutos();
  if ($tipo_pago == 2) {
    $comision = $_POST['comision'];
  } else {
    $comision = 0;
  }
  $restante_costo = $precio_pactado - $pago_inicial;

  if ($id_cliente == "0") {
    $mensaje = array("mensaje" => "El cliente no es valido", "status" => "error");
    echo json_encode($mensaje);
  } else {
    $result = $adminVentas->insertaVenta($precio_inicial, ($precio_pactado), $id_auto, $pago_inicial, $fecha_inicio_pagos, $acuerdo_pagos, $id_cliente, $periodo_venta, $comision, $por_com);
    $auto = $adminAutos->dameAutoLite($id_auto);
    if ($tipoPeriodo == "meses") {
      generaPagosEventos($acuerdo_pagos, $fecha_inicio_pagos, ($restante_costo), $periodo_venta, $result, $por_com);
    } else if ($tipoPeriodo == "dias") {
      //$mensaje = array("mensaje" => "Opcion de pago aun no valida (EN DESAROLLO) ", "status" => "error");
      generarPagosEventosDias($acuerdo_pagos, $fecha_inicio_pagos, ($restante_costo), $diasAcuerdo, $result, $por_com);
    } else {
      $mensaje = array("mensaje" => "Opcion de pago aun no valida ", "status" => "error");
    }
    if ($pago_inicial > 0) {
      generarPagoInicial($result, $pago_inicial, $metodo_pago);
    }
    //echo var_dump($auto);
    $adminAutos->agregarAutoVenta($auto);
    $mensaje = array("mensaje" => "Venta insertada correctamente", "status" => "success");
    echo json_encode($mensaje);
    //echo $result;
  }
}
function envioRecivoVenta($telefono, $url)
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
  "name": "n_recibo",
  "language": {
    "code": "es"
  },
  "components": [
      {
      "type": "button",
      "sub_type": "url",
      "index": 0,
      "parameters": [
        {
          "type": "text",
          "text": "?pp=' . $url . '"
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
  //echo $response;
  //esperar 2 segundos para enviar la corrida
  sleep(2);
}
function envioCorridaVenta($telefono, $url)
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
    "name": "n_corrida",
    "language": {
      "code": "es"
    },
    "components": [
        {
        "type": "button",
        "sub_type": "url",
        "index": 0,
        "parameters": [
          {
            "type": "text",
            "text": "?pp=' . $url . '"
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
  //echo $response;
  sleep(2);
}


function mensajeWhats($nombre, $monto, $auto, $pago, $telefono, $metodo)
{

  $pagoEncript = encriptar($pago);

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
                "name": "n_pago_nuevo",
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
                            "text": "' . $nombre . '"
                        },
                        {
                            "type": "text",
                            "text": "$ ' . ($monto) . ' en ' . $metodo . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $auto . '"
                        }
                        
                    ]
                },
                {
                    "type": "button",
                    "sub_type": "url",
                    "index": 0,
                    "parameters": [
                    {
                        "type": "text",
                        "text": "/apruebaApi.php?pago=' . $pagoEncript . '"
                    }
                    ]
                },
                {
                    "type": "button",
                    "sub_type": "url",
                    "index": 1,
                    "parameters": [
                    {
                        "type": "text",
                        "text": "/apruebaApi.php?pago=' . $pagoEncript . '"
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
  //echo $response;
  sleep(2);
}
switch ($accion) {
  case $casoInserta:
    insertaVenta();
    break;
  case $casoElimina:
    break;
  case $casoModifica:
    break;
  default:
    break;
}
