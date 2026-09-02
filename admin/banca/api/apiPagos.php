<?php
session_start();

include_once("adminPagos.php");
include_once("adminUsuarios.php");
include_once("encriptador.php");
include_once("adminVentas.php");

$accion = (string) ($_POST['accion'] ?? '');
$casoInserta = "inserta";
$casoElimina = "elimina";
$casoModifica = "modifica";
$casoAprobar = "aprobar";




function insertaPago()
{
    $adminUsuarios = new administradorUsuarios();
    $adminPagos = new AdministradorPagos();
    $adminVentas = new AdministradorVentas();
    $monto_pago = $_POST['monto_pago'];
    $monto_pago = str_replace(",", "", $monto_pago);
    $venta = $_POST['venta'];
    $estatus = $_POST['estatus'];
    $fecha = $_POST['fecha'];
    $metodo = $_POST['metodo'];
    $usuario_inserta = $_SESSION['sesionUsuario']['id'];
    $usuario = $adminUsuarios->dameUsuarioId($usuario_inserta);
    $usuarios_banca = $adminUsuarios->dameUsuariosBanca();
    $ventaO = $adminVentas->dameVenta($venta);
    
    if ($_SESSION['sesionUsuario']['permiso_banca'] == "Banca") {
        $estatus = "Aprobado";
    }

    if ($metodo == "0" || $venta == "0") {
        $mensaje = array("mensaje" => "El metodo de pago o la venta no son validos", "status" => "error");
        echo json_encode($mensaje);
        return;
    } else {
        $id_pago = $adminPagos->insertaPago($monto_pago, $venta, $estatus, $fecha, $metodo, "Abono");

        if($estatus != "Aprobado"){
            foreach($usuarios_banca as $usuarioB){
                mensajeWhats($usuario->nombre, $monto_pago, $ventaO->identificador, $id_pago, $usuarioB->telefono, $metodo); 
            }
        }
        

        $mensaje = array("mensaje" => "Pago agregado", "status" => "success");
        echo json_encode($mensaje);
    }
}

function aprobarPago()
{
    $id = $_POST['id'];
    $adminPagos = new AdministradorPagos();
    $adminPagos->aprobarPago($id);
    $mensaje = array("mensaje" => "Pago aprobado", "status" => "success");
    echo json_encode($mensaje);
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
            "to": "52'.$telefono.'",
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
                            "text": "'.$nombre.'"
                        },
                        {
                            "type": "text",
                            "text": "$ '. number_format($monto).' en '.$metodo.'"
                        },
                        {
                            "type": "text",
                            "text": "'.$auto.'"
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
                        "text": "/apruebaApi.php?pago='.$pagoEncript.'"
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
                        "text": "/apruebaApi.php?pago='.$pagoEncript.'"
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
   // echo $response;
}

switch ($accion) {
    case $casoInserta:
        insertaPago();
        break;
    case $casoElimina:
        break;
    case $casoModifica:
        break;
    case $casoAprobar:
        aprobarPago();
        break;
    default:
        break;
}
