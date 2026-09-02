<?php

header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods:*');

header('Access-Control-Allow-Headers:*');

header('Content-Type: application/json;charset=utf-8');
include_once("adminAutos.php");
include_once("adminCarHunter.php");
include_once("adminEditor.php");



$precio_minimo = $_GET["p_min"];

$precio_maximo = $_GET["p_max"];

$buscar = $_GET["buscar"];

$accion  = $_POST['accion'];
$casoAlta = "agregar";
$casoBaja = "eliminar";
$casoModificar = "modificar";
$casoPausar = "pausar";
$casoDesPausar = "despausar";
$casoImagen = "imagen";
$casoBajaImagen = "bimagen";
$casoPonerBanner = "banner";
$casoQuitarBanner = "ebanner";
$casoMaximos = "rangos";
$casoAsignar  = "asignar";
$casoAsignarPortada = "asignarportada";
$casoVerAuto = "verAuto";
$casoVerRedSocial = "verRedSocial";
$casoRecuperar  = "recuperar";

use PHPMailer\PHPMailer\PHPMailer;

function mailer($mail_destino, $nombre_destino, $asunto, $mensaje, $attachment, $attachment_name, $mail_oculto)
{
    $mail_host = 'seminuevosharo.mx';
    $smtp_secure = 'ssl';
    $mail_port = 465;
    $mail_email = 'administracion@pruebas.seminuevosharo.mx';
    $mail_password = 'rQ-cXFBPYsSN';
    $mail_username = 'Haro Seminuevos';
    //Import PHPMailer classes into the global namespace
    require_once 'Pendiente/mailer/src/PHPMailer.php';
    require_once 'Pendiente/mailer/src/SMTP.php';
    require_once 'Pendiente/mailer/src/Exception.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Whether to use SMTP authentication
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Set the hostname of the mail server
    $mail->Host = $mail_host;
    $mail->Port = $mail_port;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = $smtp_secure;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $mail_email;
    //Password to use for SMTP authentication
    $mail->Password = $mail_password;
    //Set who the message is to be sent from
    $mail->setFrom($mail_email, $mail_username);
    //Set who the message is to be sent to
    if (is_array($mail_destino)) {
        for ($i = 0; $i <= count($mail_destino); $i++) {
            $mail->addAddress($mail_destino[$i], $nombre_destino[$i]);
        }
    } else {
        $mail->addAddress($mail_destino, $nombre_destino);
    }
    //Set CCO
    if (is_array($mail_oculto)) {
        for ($i = 0; $i <= count($mail_oculto); $i++) {
            $mail->addBCC($mail_oculto[$i]);
        }
    } else {
        $mail->addBCC($mail_oculto);
    }

    //Set the subject line
    $mail->Subject = $asunto;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Body    = $mensaje;


    /*
    for ($i = 0; $i <= count($attachment); $i++) {
        $mail->AddAttachment($attachment[$i], $attachment_name[$i]);
    }

    */
    if (!$mail->send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "Message sent!";
    }
}


function procesarImagen()
{

    $carpetaDestino = '/Imagenes/Autos/';
    $pesoMaxicoImagen = 2000000;
    $nombreCompuestoImagen = "default.txt";
    $nombre_imagen = $_FILES['archivo']['name'];
    $tipo_Imgaen = $_FILES['archivo']['type'];
    $tamanio_imagen = $_FILES['archivo']['size'];

    $casoPng = ".png";
    $casoJpeg = ".jpg";
    //comprovadores de peso y tipo de imagen

    if ($tamanio_imagen < $pesoMaxicoImagen) {
        if ($tipo_Imgaen == "image/jpeg" || $tipo_Imgaen == "image/png") {
            //mueve la imagen a la carpeta seleccionada 
            move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);
            chmod($carpetaDestino . $nombre_imagen, 0777);
            switch ($tipo_Imgaen) {
                case "image/jpeg":
                    $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) . $casoJpeg;
                    break;
                case "image/png":
                    $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) .  $casoPng;
                    break;
            }
            rename($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen, $_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen);
            chmod($_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen, 0777);
            unlink($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);

            return $nombreCompuestoImagen;
        } else {
            echo json_encode("El formato de la imagen no esta permitido");
        }
    } else {
        echo json_encode("La imagen supera el tamaño establecido");
    }
}

function procesarAlta()
{
    if (isset($_POST['kilometragePermitido'])) {
        $kilometragePermitido = 0;
    } else {
        $kilometragePermitido = 1;
    }
    $cilindrage = $_POST['cilindrage'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];;
    $transmicion = $_POST['trans'];
    $anio = $_POST['anio'];
    $precio = $_POST['precio'];
    $nacionalidad = $_POST['nacionalidad'];
    $duenio = $_POST['duenio'];
    $estatus = $_POST['estatus'];
    $kilometrage = $_POST['kilometros'];
    $combustible = $_POST['combustible'];
    $interiores = $_POST['interior'];
    $color = $_POST['color'];
    $cuerpo = $_POST['cuerpo'];
    $poder = $_POST['poder'];
    $asientos = $_POST['asientos'];
    $admin = new AdministradorAutos();
    $adminEditor = new AdministradorEditor();
    $adminCarHunter = new AdministradorCarHunter();
    $modeloLite    = substr($adminEditor->dameModelo($modelo)->modelo, 0, 2);
    $hunters = $adminCarHunter->dameCarHunterPorMarcaModelo($adminEditor->dameMarca($marca)->marca, $modeloLite);
    if (count($hunters) == 0) {
        $hunter = $adminCarHunter->dameCarHunterPorMarca($adminEditor->dameMarca($marca)->marca);
    }
    $admin->agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido);
    $utlimaId = $admin->dameUltimoId();

    $mensaje = '<html><body>';
    $mensaje .= '<div style="text-align: center;"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid" style="text-align: var(--mdb-body-text-align); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); background-color: rgba(255,255,255,var(--mdb-bg-opacity));"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;">Car Hunter:</div><div style="text-align: center;">Hemos encontrado un auto a tu medida, que no te lo ganen.</div><div style="text-align: center;">Entra en este enlace para ver los de talles: https://seminuevosharo.mx/vehicle-details.php?auto=' . $utlimaId . '&nbsp;</div><div style="text-align: center;"><br></div><div style="text-align: center;">Gracias por usar el servicio de car Hunter de Seminuevos Haro.</div>';
    $mensaje .= '</body></html>';

    foreach ($hunters as $hunter) {

        mailer($hunter->email, $hunter->email, "Car Hunter", $mensaje, "", "", "");
        $adminCarHunter->marcarComoAvisado($hunter->id);
        //echo json_encode("Se ha enviado un correo a " . $hunter->email);
    }

    $suscriptores = $adminCarHunter->dameSuscriptores();

    foreach ($suscriptores as $suscriptor) {
        if ($suscriptor->nombre == "Sin nombre") {
            $nombre = "Querido Suscriptor";
        } else {
            $nombre = $suscriptor->nombre;
        }
        $mensaje = '<html><body>';
        $mensaje .= '
    <div style="text-align: center;">
    <img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid" style="text-align: var(--mdb-body-text-align); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); background-color: rgba(255,255,255,var(--mdb-bg-opacity));">
    <br>
    </div>
    <div style="text-align: center;"><br></div>
    <div style="text-align: center;">Car Hunter:</div>
    <div style="text-align: center;">Hola ' . $nombre . ' Hemos añadido un auto a nuestro inventario, que no te lo ganen.</div>
    <div style="text-align: center;">Entra en este enlace para ver los de talles: https://seminuevosharo.mx/vehicle-details.php?auto=' . $utlimaId . '&nbsp;</div>
    <div style="text-align: center;"><br></div><div style="text-align: center;">Gracias por suscribirte a HARO SEMINUEVOS.</div>
    <footer style="text-align: center;"><br>
    <p>Si deseas desuscribirse de nuestro boletín, entra a este enlace <a href="https://seminuevosharo.mx/suscripciones.php?suscriptor=' . $suscriptor->id . '">Desuscribirse</a>.</p>
    <p>&copy; Seminuevos Haro 2022</p>
    </footer>
    ';
        $mensaje .= '</body></html>';
        mailer($suscriptor->email, $suscriptor->email, "Car Hunter", $mensaje, "", "", "");
        //echo json_encode("Se ha enviado un correo a " . $suscriptor->email);
    }


    //$admin->agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido);
    echo "1";
}

function procesarModificacion()
{
    $cilindrage = $_POST['cilindrage'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];;
    $transmicion = $_POST['trans'];
    $anio = $_POST['anio'];
    $precio = $_POST['precio'];
    $nacionalidad = $_POST['nacionalidad'];
    $duenio = $_POST['duenio'];
    $estatus = $_POST['estatus'];
    $kilometrage = $_POST['kilometros'];
    $combustible = $_POST['combustible'];
    $interiores = $_POST['interior'];
    $color = $_POST['color'];
    $cuerpo = $_POST['cuerpo'];
    $poder = $_POST['poder'];
    $asientos = $_POST['asientos'];
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->actualizarAuto($id, $cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos);
    echo "1";
}

function procesarBaja()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->eliminarAuto($id);
    echo "1";
}

function procesarRecuperacion()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->recuperarAuto($id);
    echo "1";
}

function verFiltroPrecios()
{
    $precio_minimo = $_GET["p_min"];
    $precio_maximo = $_GET["p_max"];
    $admin = new AdministradorAutos();
    $response['data'] = $admin->dameAutosApiRango($precio_minimo, $precio_maximo);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function verAutosBuscados()
{
    $admin = new AdministradorAutos();
    $response['data'] = $admin->dameAutosApiBuscados($_GET['buscar']);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function dameDetalles()
{
    $id = $_GET['id'];
    $admin = new AdministradorAutos();
    $response['data'] = $admin->dameDetallesApi($id);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function verAutos()
{
    $admin = new AdministradorAutos();
    $precioMinimo = 0;
    $precioMaximo = 200000000;
    // if (isset($_GET['p_min'])) {
    //     $precioMinimo = $_GET['p_min'];
    // }
    // if (isset($_GET['p_max'])) {
    //     $precioMaximo = $_GET['p_max'];
    // }
    $response['data'] = $admin->dameAutosApi($_GET['buscar'], $precioMinimo, $precioMaximo);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}


function procesarAltaImagen()
{
    $id = $_POST['id_auto'];
    $url = procesarImagen();
    $admin = new AdministradorAutos();
    $admin->agregarImagen($id, $url);
    echo "1";
}

function procesarBajaImagen()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->eliminarImagen($id);
    echo "1";
}

function procesarAltaBanner()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->colocarBanner($id);
    echo "1";
}

function procesarBajaBanner()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->quitarBanner($id);
    echo "1";
}

function dameMaximoYMinimo()
{
    $admin = new AdministradorAutos();
    echo json_encode($admin->dameMaximoMinimo());
}

function pausar()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->pausar($id);
    echo "1";
}
function despausar()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    $admin->despausar($id);
    echo "1";
}
function asignarImagen()
{
    $id = $_POST['id'];
    $auto = $_POST['auto'];
    $admin = new AdministradorAutos();
    $admin->asignarAuto($id, $auto);
    echo "1";
}

function asignarPortada()
{
    $url = $_POST['url'];
    $auto = $_POST['auto'];
    $admin = new AdministradorAutos();
    $admin->asignarPortada($url, $auto);
    echo "1";
}

function procesarVerAuto()
{
    $id = $_POST['id'];
    $admin = new AdministradorAutos();
    echo json_encode($admin->dameAuto($id));
}

function verRedSocial()
{
    $red = $_POST['red'];
    $admin = new AdministradorAutos();
    echo json_encode($admin->dameAutosNoSubidos($red));
}
switch ($accion) {
    case $casoAlta:
        procesarAlta();
        break;
    case $casoBaja:
        procesarBaja();
        break;
    case $casoModificar:
        procesarModificacion();
        break;
    case $casoImagen:
        procesarAltaImagen();
        break;
    case $casoBajaImagen:
        procesarBajaImagen();
        break;
    case $casoPonerBanner:
        procesarAltaBanner();
        break;
    case $casoQuitarBanner:
        procesarBajaBanner();
        break;
    case $casoMaximos:
        dameMaximoYMinimo();
        break;
    case $casoPausar:
        pausar();
        break;
    case $casoDesPausar:
        despausar();
        break;
    case $casoAsignar:
        asignarImagen();
        break;
    case $casoAsignarPortada:
        asignarPortada();
        break;
    case $casoVerAuto:
        procesarVerAuto();
        break;
    case $casoVerRedSocial:
        verRedSocial();
        break;
    case $casoRecuperar:
        procesarRecuperacion();
        break;
    default:
        break;
}



dameDetalles();
