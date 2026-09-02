<?php

include_once("adminCarHunter.php");
include_once("adminEditor.php");
include_once("adminAutos.php");

include_once('captcha.php');

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
    for ($i = 0; $i < count($mail_destino); $i++) {
      $mail->addAddress($mail_destino[$i], $nombre_destino[$i]);
    }
  } else {
    $mail->addAddress($mail_destino, $nombre_destino);
  }
  //Set CCO
  if (is_array($mail_oculto)) {
    for ($i = 0; $i < count($mail_oculto); $i++) {
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
  for ($i = 0; $i < count($attachment); $i++) {
        $mail->AddAttachment($attachment[$i], $attachment_name[$i]);
    }

    */
  if (!$mail->send()) {
    return "Mailer Error: " . $mail->ErrorInfo;
  } else {
    return "Message sent!";
  }
}

$accion = (string) ($_POST['accion'] ?? '');
$casoAgregar = "agregar";
$casoModificar = "modificar";
$casoEliminar = "eliminar";
$casoEliminarPorCorreo = "eliminarCorreo";
$casoNotificar = "notificarManual";
$casoSuscribirse = "suscribirse";



$casoObtener = "obtener";
$casoObtenerTodos = "obtenerTodos";
$casoObtenerTodosPorMarca = "obtenerTodosPorMarca";
$casoObtenerTodosPorModelo = "obtenerTodosPorModelo";

function verificarCaptcha()
{
  // Google reCaptcha
  $recaptchaResponse = $_POST['g-recaptcha-response'];
  $userIP = $_SERVER['REMOTE_ADDR'];
  $secretkey = "6LcgrLcgAAAAAH7UwjOT7Jo9gRj5ERO7euqpJnyy";

  $request = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkey . '&response=' . $recaptchaResponse . '&remoteip=' . $userIP;
  $content = file_get_contents($request);
  $json = json_decode($content, true);
  if ($json['success'] == true) {
    return true;
  } else {
    return false;
  }
}

function nuevoSuscriptor()
{
  $correo = $_POST['subscripcion_correo'];
  if (isset($_POST['subscripcion_nombre'])) {
    $nombre = $_POST['subscripcion_nombre'];
  } else {
    $nombre = "Sin nombre";
  }
  $admin = new AdministradorCarHunter();
  if (!$admin->existeSuscriptor($correo)) {
    $admin->nuevoSuscriptor($correo, $nombre);
    $mensaje = '<html><body>';
    $mensaje .= '
    <div style="text-align: center;">
    <img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid" style="text-align: var(--mdb-body-text-align); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); background-color: rgba(255,255,255,var(--mdb-bg-opacity));">
    <br></div>
    <div style="text-align: center;"><br></div>
    <h1 style="text-align: center;">Haro Seminuevos</h1>
    <div style="text-align: center;">Gracias por suscribirse a nuestro boletín informativo, pronto recibirás noticias nuestras!!</div>';
    $mensaje .= '</body></html>';

    mailer($correo, $correo, "Suscripción de boletín informativo", $mensaje, "", "", "");

    echo "1";
  } else {
    echo "3";
  }
}


function agregarCarHunter()
{
  $marcaIdParaProceso = 0;
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $precioMaximo = $_POST['precioMaximo'];
  $precioMinimo = $_POST['precioMinimo'];
  $marca = $_POST['marca'];
  $modelo = $_POST['modelo'];

  $anioMaximo = $_POST['anioMaximo'];
  $anioMinimo = $_POST['anioMinimo'];


  $admin = new AdministradorCarHunter();
  $adminEditor = new AdministradorEditor();
  $adminAutos = new AdministradorAutos();
  $admin->nuevoCarHunter($precioMinimo, $precioMaximo, $adminEditor->dameMarcaGeneral($marca)->marca, $adminEditor->dameModeloGeneral($modelo)->modelo, $anioMinimo, $anioMaximo, $nombre, $correo);

  if (isset($_POST['suscribirse'])) {
    $admin->nuevoSuscriptor($correo, $nombre);
  }
  $marcaModelo = array();
  $modelos = $adminEditor->dameMarcaYModelo($adminEditor->dameMarcaGeneral($marca)->marca, $adminEditor->dameModeloGeneral($modelo)->modelo);
  $idA = 1;

  foreach ($modelos as $modeloFH) {
    $marcaModelo = explode(" - ", $modeloFH);
    $idAuto = $adminAutos->dameAutoMarcaYModelo($marcaModelo[0], $marcaModelo[1])->id;
    $marcaIdParaProceso = $marcaModelo[0];
    if ($idAuto != 0) {
      $idA = $idAuto;
    }
  }

  if ($idA != 1) {
    $autoMail = $adminAutos->dameAuto(intval($idA));
    if ($autoMail->imagen) {
      $imagenA = $autoMail->imagen;
    } else {
      $imagenA = $autoMail->imagenes[0]->url;
    }
    $mensaje = '<html><body>';
    $mensaje .= '
    <div style="text-align: center;">
    
    <br>
    <h1 style="text-align: center"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid">&nbsp;Powered by&nbsp;<img src="https://seminuevosharo.mx/Imagenes/carHunter/carhunter-logo1.png" target="_blank" class="img-fluid" style="background-color: rgba(255,255,255,var(--mdb-bg-opacity)); height: 100px; font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); text-align: var(--mdb-body-text-align);"></h1><ul>
    </ul>
    <br></div>
    <div style="text-align: center;"><br></div>
    <div style="text-align: center;">Car Hunter:</div>
    <div style="text-align: center;">Gracias por registrarte en el servicio de car hunter, recibirás un correo electrónico en cuanto</div>
    <div style="text-align: center;">entre a nuestro inventario un auto con las características que buscas.</div>
    <div style="text-align: center;">Auto: ' . $adminEditor->dameMarcaGeneral($marca)->marca  . ' ' . $adminEditor->dameModeloGeneral($modelo)->modelo . '</div>
    <br>
    <br> 
    <div style="text-align: center;">De hecho es posible que ya este en nuestro inventario, checa el siguiente link: <br> https://seminuevosharo.mx/vehicle-details.php?auto=' . $idA . '  </div>
    <div style="text-align: center;"><img src="https://seminuevosharo.mx' . $imagenA . '" alt=""></div>';
    $mensaje .= '</body></html>';
  } else {
    $marcaActual = $adminEditor->transformaMarca($marca);
    $marcaImg = $marcaActual->imagen;

    $mensaje = '<html><body>';
    $mensaje .= '
    <div style="text-align: center;">
    <br>
    <h1 style="text-align: center"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid">&nbsp;Powered by&nbsp;<img src="https://seminuevosharo.mx/Imagenes/carHunter/carhunter-logo1.png" target="_blank" class="img-fluid" style="background-color: rgba(255,255,255,var(--mdb-bg-opacity)); height: 100px; font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); text-align: var(--mdb-body-text-align);"></h1><ul>
    </ul>
    <br></div>
    <div style="text-align: center;"><br></div>
    <div style="text-align: center;">Car Hunter:</div>
    <div style="text-align: center;">Gracias por registrarte en el servicio de car hunter, recibirás un correo electrónico en cuanto</div>
    <div style="text-align: center;">entre a nuestro inventario un auto con las características que buscas.</div>
    <div style="text-align: center;"><img src="https://seminuevosharo.mx' . $marcaImg . '" alt=""></div>
    
    <div style="text-align: center;"></div>
    <div style="text-align: center;">Auto: ' . $adminEditor->dameMarcaGeneral($marca)->marca  . ' ' . $adminEditor->dameModeloGeneral($modelo)->modelo . '</div>
    
   ';

    $mensaje .= '</body></html>';
  }

  mailer($correo, $correo, "Car Hunter", $mensaje, "", "", "");


  echo $idA;
}




function notificar()
{
  $carHunter = $_POST['carHunter'];
  $auto = $_POST['auto'];
  $mensajeX = $_POST['mensaje'];


  $admin = new AdministradorCarHunter();
  $adminAuto = new AdministradorAutos();
  $autoCH = $adminAuto->dameAuto($auto);
  $carHunterCH = $admin->dameCarHunterPorId($carHunter);
  $utlimaId = $auto;
  $aut = $adminAuto->dameAuto($utlimaId);
  $mensaje = '<html><body>';
  $mensaje .=
    '
  <br>
  <h1 style="text-align: center"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid">&nbsp;Powered by&nbsp;<img src="https://seminuevosharo.mx/Imagenes/carHunter/carhunter-logo1.png" target="_blank" class="img-fluid" style="background-color: rgba(255,255,255,var(--mdb-bg-opacity)); height: 100px; font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); text-align: var(--mdb-body-text-align);"></h1><ul>
  </ul>  <div style="text-align: center;">Car Hunter:</div>
  <div style="text-align: center;">Hemos encontrado un auto a tu medida, que no te lo ganen. ' . $mensajeX . ' </div>
  <div style="text-align: center;">Entra en este enlace para ver los de talles: https://seminuevosharo.mx/vehicle-details.php?auto=' . $utlimaId . '&nbsp;</div><div style="text-align: center;"><br></div>
  <div style="text-align: center;"> <img src="https://seminuevosharo.mx' . $aut->imagenes[0]->url . '" target="_blank" class="img-fluid"> <br> Gracias por usar el servicio de car Hunter de Seminuevos Haro.</div>';
  $mensaje .= '</body></html>';
  mailer($carHunterCH->email, $carHunterCH->email, "Car Hunter", $mensaje, "", "", "");
  $admin->marcarComoAvisado($carHunter);
  echo "1";
}

function eliminarCarHunter()
{
  $id = $_POST['id'];
  $admin = new AdministradorCarHunter();
  $admin->eliminarCarHunter($id);
  echo "1";
}

function eliminarPorCorreo()
{
  $correo = $_POST['correo'];
  $admin = new AdministradorCarHunter();
  $admin->eliminarCarHunterPorEmail($correo);
  echo "1";
}


switch ($accion) {
  case $casoAgregar:
    if (verificarCaptcha()) {
      agregarCarHunter();
    } else {
      echo "0";
    }
    break;
  case $casoEliminar:
    eliminarCarHunter();
    break;
  case $casoEliminarPorCorreo:
    eliminarPorCorreo();
    break;
  case $casoNotificar:
    notificar();
  case $casoSuscribirse:
    nuevoSuscriptor();
    break;
}
