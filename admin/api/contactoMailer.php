<?php

use PHPMailer\PHPMailer\PHPMailer;

function mailer($mail_destino, $nombre_destino, $asunto, $mensaje, $attachment, $attachment_name, $mail_oculto)
{
    $mail_host = 'smtp.hostinger.com';
    $smtp_secure = 'ssl';
    $mail_port = 465;
    $mail_email = 'no-reply@seminuevosharo.mx';
    $mail_password = 'cDU@e/2Ab';
    $mail_username = 'Notificador Haro';
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


    $mail->SMTPDebug = 2; // Nivel de depuración: 0 = off, 1 = cliente, 2 = cliente y servidor
    $mail->Debugoutput = 'html'; // Muestra la salida en formato HTML
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

// $correo = $_GET['correo'];
// $enlace = $_GET['enlace'];
// $token = rand(1, 8000000);



// $mensaje = '<html><body>';
// $mensaje .= '<div style="text-align: center;"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid" style="text-align: var(--mdb-body-text-align); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); background-color: rgba(255,255,255,var(--mdb-bg-opacity));"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;">Car Hunter:</div><div style="text-align: center;">Hemos encontrado un auto a tu medida, que no te lo ganen.</div><div style="text-align: center;">Entra en este enlace para ver los de talles:&nbsp;</div><div style="text-align: center;"><br></div><div style="text-align: center;">Gracias por usar el servicio de car Hunter de Seminuevos Haro.</div>';
// $mensaje .= '</body></html>';

// mailer($correo, $correo, "Car Hunter", $mensaje, "", "", "");

// // echo $idUSusario;
// // echo $correo;
// // echo $token;

// echo "1";
