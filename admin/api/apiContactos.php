
<?php

include_once('adminContactos.php');

use PHPMailer\PHPMailer\PHPMailer;


$accion = (string) ($_POST['accion'] ?? '');
$casoAlta = "agregar";
$casoBaja = "eliminar";

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

function procesarAlta()
{
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];
    $admin = new AdministradorContactos();
    $admin->setContacto($nombre, $correo, $mensaje);

    $mensajeMailer = '<html><body>';
    $mensajeMailer .= '
    <p style="text-align: center"><br></p>
    <h1 style="text-align: center">Haro Seminuevos</h1>
    <p style="text-align: center">
    <img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" class="img-fluid">
    </p>
    <p style="text-align: center">Hemos recibido tu mensaje exitosamente, nos pondremos en contacto contigo lo antes posible</p>
    <p style="text-align: center">
    <a href="https://seminuevosharo.mx/" target="_blank" contenteditable="false" style="font-size: 1rem; text-align: left">seminuevosharo.mx</a>&nbsp;© 2022</p>
    <p style="text-align: left"><b>Direccion:</b></p><p style="text-align: left"><span style="background-color: rgba(255,255,255,var(--mdb-bg-opacity)); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); text-align: var(--mdb-body-text-align);">Av. Cvln. División del Nte. 1264, Jardines del Country Guadalajara, Jal.</span></p>
    <p><b>Telefono:</b></p>
    <ul>
    <li>33 3636 8433</li>
    <li>33 1955 2634</li>
    </ul>
    <p><span style="font-weight: bolder;">Correo:</span></p><ul><li>seminuevosharo@hotmail.com</li></ul>';
    $mensajeMailer .= '</body></html>';

    mailer($correo, $correo, "Contacto Haro Seminuevos", $mensajeMailer, "", "", "");
    echo "1";
}

function procesarBaja()
{
    $id = $_POST['id'];
    $admin = new AdministradorContactos();
    $admin->eliminarContacto($id);
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
