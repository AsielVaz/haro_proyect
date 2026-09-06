<?php
//json 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
include_once("adminAutos.php");
include_once("adminCarHunter.php");
include_once("adminEditor.php");
include_once 'marcaOferta.php';


$accion = (string) ($_POST['accion'] ?? '');
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
$casoEliminarImagen = "eliminarImagen";
$casoRenovar = "renovar";
$casoDameAutos = "dameAutos";
$casoLogsAuto = "logsAuto";
$casoVerificarAlmacen = "verificarAlmacen";
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
	$consig = $_POST['consig'];	
	$idAlmacen = $_POST['id_almacen'];
	$admin = new AdministradorAutos();
	$adminEditor = new AdministradorEditor();
	$admin->agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido, $consig, $idAlmacen);
	//$admin->agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido);
	echo "1";
}

function notificarAuto($modelo, $marca, $auto)
{
	$admin = new AdministradorAutos();
	$adminEditor = new AdministradorEditor();
	$adminCarHunter = new AdministradorCarHunter();
	$autoEditor = $admin->dameAuto($auto);
	$modeloLite    = substr($adminEditor->dameModelo($modelo)->modelo, 0, 2);
	$hunters = $adminCarHunter->dameCarHunterPorMarcaModelo($adminEditor->dameMarca($marca)->marca, $modeloLite);
	if (count($hunters) == 0) {
		$hunter = $adminCarHunter->dameCarHunterPorMarca($adminEditor->dameMarca($marca)->marca);
	}
	$utlimaId = $auto;

	$mensaje = '<html><body>';
	$mensaje .= '<div style="text-align: center;"><img src="https://seminuevosharo.mx/assets/media/general/haro-logo.jpg" target="_blank" class="img-fluid" style="text-align: var(--mdb-body-text-align); font-family: var(--mdb-font-roboto); font-size: var(--mdb-body-font-size); font-weight: var(--mdb-body-font-weight); background-color: rgba(255,255,255,var(--mdb-bg-opacity));"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;">Car Hunter:</div>
  <div style="text-align: center;">Hemos encontrado un auto a tu medida, que no te lo ganen.</div><div style="text-align: center;">Entra en este enlace para ver los de talles: https://seminuevosharo.mx/vehicle-details.php?auto=' . $utlimaId . '&nbsp;</div>
  <div style="text-align: center;"><br></div>
  <div style="text-align: center;"><img class="img-fluid" src="https://seminuevosharo.mx' . $autoEditor->imagenes[0]->url . '" alt=""></div>

  <div style="text-align: center;">Gracias por usar el servicio de car Hunter de Seminuevos Haro.</div>';
	$mensaje .= '</body></html>';

	foreach ($hunters as $hunter) {

		mailer($hunter->email, $hunter->email, "Car Hunter", $mensaje, "", "", "");
		$adminCarHunter->marcarComoAvisado($hunter->id);
		$adminCarHunter->nuevaNotificacion($utlimaId, $hunter->id, "Car Hunter");
		//echo json_encode("Se ha enviado un correo a " . $hunter->email);
	}

	$suscriptores = $adminCarHunter->dameSuscriptores();

	foreach ($suscriptores as $suscriptor) {
		//if (count($adminCarHunter->dameNotificacion($suscriptor->id, $utlimaId, "Suscripcion")) == 0) {
			$marca = $autoEditor->marca->marca;
			$modelo = $autoEditor->modelo->modelo;
			$anio = $autoEditor->anio;
			$utlimaId = $autoEditor->id;
			$precio = $autoEditor->precio;
			$mensaje = crearMensaje($marca, $modelo, $anio, $utlimaId, $precio, $autoEditor->imagenes[0]->url, $suscriptor->id);
			//mailer($suscriptor->email, $suscriptor->email, "Boletín de auto", $mensaje, "", "", "");
			$adminCarHunter->nuevaNotificacion($utlimaId, $suscriptor->id, "Suscripcion");

			//echo json_encode("Se ha enviado un correo a " . $suscriptor->email);

		//}
	}
}


function notificarOferta($auto, $precioNuevo)
{


	// Ejemplo de uso
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	$imagen = $raiz . '/agua_oferta.png';

	$rutaSalita = $raiz . '/admin/api/Imagenes/auto' . $auto . '.png';


	$admin = new AdministradorAutos();
	$adminEditor = new AdministradorEditor();
	$adminCarHunter = new AdministradorCarHunter();
	$suscriptores = $adminCarHunter->dameSuscriptores();
	$autoEditor = $admin->dameAuto($auto);
	$superpuesta = $raiz .  $autoEditor->imagenes[0]->url;
	$utlimaId = $auto;
	//superponerImagen($superpuesta, $imagen ,$rutaSalita);
	//$imagen = 'admin/api/Imagenes/auto'.$auto.'.png';
	//echo var_dump($suscriptores);
	foreach ($suscriptores as $suscriptor) {
		// if (count($adminCarHunter->dameNotificacion($suscriptor->id, $utlimaId, "Suscripcion")) == 0) {
		if ($suscriptor->nombre == "Sin nombre") {
			$nombre = "Querido Suscriptor";
		} else {
			$nombre = $suscriptor->nombre;
		}
		$marca = $autoEditor->marca->marca;
		$modelo = $autoEditor->modelo->modelo;
		$anio = $autoEditor->anio;
		$utlimaId = $autoEditor->id;
		$precio = $autoEditor->precio;

		$mensaje = crearMensajeOferta($marca, $modelo, $anio, $utlimaId, $precio, $autoEditor->imagenes[0]->url, $suscriptor->id, $precioNuevo);
		// echo $mensaje;
		//echo "HOLA";
		//mailer($suscriptor->email, $suscriptor->email, "Boletín de auto", $mensaje, "", "", "");
		$adminCarHunter->nuevaNotificacion($utlimaId, $suscriptor->id, "Oferta Por modificación con precio nuevo $precio");
		//echo json_encode("Se ha enviado un correo a " . $suscriptor->email);

		// }
	}
}

function crearMensajeOferta($marca, $modelo, $anio, $id, $precio, $imagen, $suscriptor, $precioNuevo)
{
	$mensaje = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
	  <head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <meta  name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0," /> 
		  <title>blaack</title>
		  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet" type=text/css />
  
		  <style type="text/css">
		  



		  .wrapper {
			margin: 50px auto;
			width: 280px;
			height: 370px;
			background: white;
			border-radius: 10px;
			-webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
			-moz-box-shadow:    0px 0px 8px rgba(0,0,0,0.3);
			box-shadow:         0px 0px 8px rgba(0,0,0,0.3);
			position: relative;
			z-index: 90;
		  }
		  
		  .ribbon-wrapper-green {
			width: 85px;
			height: 88px;
			overflow: hidden;
			position: absolute;
			top: 10px;
			right: -3px;
		  }
		  
		  .ribbon-green {
			font: bold 15px Sans-Serif;
			color: #333;
			text-align: center;
			text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
			-webkit-transform: rotate(45deg);
			-moz-transform:    rotate(45deg);
			-ms-transform:     rotate(45deg);
			-o-transform:      rotate(45deg);
			position: relative;
			padding: 7px 0;
			left: -5px;
			top: 15px;
			width: 120px;
			background-color: #BFDC7A;
			background-image: -webkit-gradient(linear, left top, left bottom, from(#BFDC7A), to(#8EBF45)); 
			background-image: -webkit-linear-gradient(top, #BFDC7A, #8EBF45); 
			background-image:    -moz-linear-gradient(top, #BFDC7A, #8EBF45); 
			background-image:     -ms-linear-gradient(top, #BFDC7A, #8EBF45); 
			background-image:      -o-linear-gradient(top, #BFDC7A, #8EBF45); 
			color: #6a6340;
			-webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
			-moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
			box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
		  }
		  
		  .ribbon-green:before, .ribbon-green:after {
			content: "";
			border-top:   3px solid #6e8900;   
			border-left:  3px solid transparent;
			border-right: 3px solid transparent;
			position:absolute;
			bottom: -3px;
		  }
		  
		  .ribbon-green:before {
			left: 0;
		  }
		  .ribbon-green:after {
			right: 0;
		  }

			  html { width: 100%; }
			  body {margin:0; padding:0; width:100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
			  img {display:block !important; border:0; -ms-interpolation-mode:bicubic;}
  
			  .ReadMsgBody { width: 100%;}
			  .ExternalClass {width: 100%;}
			  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
			  
			  .MsoNormal {font-family: Open Sans, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  p {margin:0 !important; padding:0 !important;}
			  
			  .images {display:block !important; width:100% !important;}
			  .display-button td, .display-button a  {font-family: Open Sans, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
  
			  .display-button a:hover {text-decoration:none !important;}
			  
			  /* MEDIA QUIRES */
			  @media only screen and (min-width:799px)
			  {
				  .main-width {
					  width:600px;
				  }
				  .width800 {
					  width:800px !important;
					  max-width:800px !important;
				  }
				  .saf-table {
					  display:table !important;
				  }
			  }
			  @media only screen and (max-width:799px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}	
				  .display-width-inner {width:600px !important;}	
				  .padding { padding:0 20px !important; }	
				  .width800 {
					  width:100% !important;
					  max-width:100% !important;
				  }
			  }
			  
			  @media only screen and (max-width:639px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}
				  .display-width-inner,  
				  .display-width-child {width:100% !important;}
				  .display-width-child .button-width .display-button {width:auto !important;}
				  .padding { padding:0 20px !important; }	
				  .width282 {
					  width:282px !important;  
				  }
				  span.unsub-width {width:100% !important;
				  display:block !important;}
				  span.txt-copyright{ padding-bottom:10px !important;}
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
					  width:100% !important;
				  }
				  .res-center { 
					  display:table !important;
					  margin:0 auto !important;
				  }
				  .height10 {height:10px !important; line-height:10px !important;}
				  .height20 {height:20px !important; line-height:20px !important;}
				  .height30 {height:30px !important; line-height:30px !important;}
				  .hide-height, .hide-bar {display:none !important;}
				  .txt-center {text-align:center !important;}
			  }
			  
			  @media only screen and (max-width:480px) {
				  
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width .width282 {
					  width:282px !important;  
				  }
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
				  width:100% !important;
				  max-width: 100% !important;
				  }
			  }
			  
			  @media only screen and (max-width:380px)
			  {
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width-child .width282 { width:100% !important;}
			  }
		  </style>
		  
	  </head>
	  <body style="width:100%;margin: 0; mso-line-height-rule: exactly;">
		  <!--[if mso]>
		  <style>
			  .heading {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .MsoNormal {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .display-button td, .display-button a, a {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .width-auto {
			  width:auto !important;
			  }
		  </style>
		  <![endif]-->
		  
		  <!-- VIEW IN BROWSER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
							  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
								  <tr>
									  <td align="center" valign="top" width="100%" style="max-width:800px;">
										  <![endif]-->
											  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
												  <!-- ID:BG VIEW BROWSER -->
												  <table align="center" bgcolor="#111111" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
													  <tbody>	
														  <tr>
															  <td align="center" class="padding">
																  <!--[if mso]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
																	  <tr>
																		  <td align="center">
																				  <![endif]-->
																				  
																				  <!--[if mso]>
																			  </td>
																		  </tr>
																	  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </tbody>	
												  </table>
											  </div>
										  <!--[if mso]>
									  </td>
								  </tr>
							  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- VIEW IN BROWSER ENDS -->
		 
   
	
		  <!-- MENU STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
							  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
								  <tr>
									  <td align="center" valign="top" width="100%" style="max-width:800px;">
										  <![endif]-->
											  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
												  <!-- ID:BG MENU -->
												  <table align="center" bgcolor="#1b1b1b" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
													  <tbody>	
														  <tr>
															  <td align="center" class="padding" style="height: 100px;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;"> 
																					  <tr>
																						  <td height="15" class="height30" style="mso-line-height-rule:exactly; line-height:15px; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td align="center"  style="width:100%; max-width:100%; font-size:0;">
																							  <!--[if (gte mso 9)|(IE)]>
																							  <table  aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="width:100%;">
																								  <tr>
																									  <td align="center" valign="top" width="150">
																										  <![endif]-->
																										  <div style="display:inline-block; max-width:150px; width:100%; vertical-align:top;" class="div-width">
																											  <!--TABLE LEFT-->
																											  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="100%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%; max-width:100%;">
																												  <tr>
																													  <td align="center">
																														  <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:auto !important;">
																															  <tr>
																																  <!-- ID:TXT MENU -->
																																  <td align="center" style="color:#333333;">
																																	  <a href="#" style="color:#333333; text-decoration:none;">
																																		  <img src="https://seminuevosharo.mx/img-mail/logo.png"  width="139" height="75" style=" position: relative;
																																		  top: 35; margin:0; border:0; padding:0; display:block;"/>
																																	  </a>
																																  </td>
																															  </tr>
																														  </table>
																													  </td>
																												  </tr>
																											  </table>
																										  </div>
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																									  <td align="center" valign="top" width="440">
																									  <![endif]-->
																										  
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																								  </tr>
																							  </table>
																							  <![endif]-->
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="15" class="height30" style="mso-line-height-rule:exactly; line-height:15px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </tbody>	
												  </table>
											  </div>
										  <!--[if (gte mso 9)|(IE)]>
									  </td>
								  </tr>
							  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- MENU ENDS -->
		  
		  <!-- HEADER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if mso]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG HEADER OPTIONAL -->
									  <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="left" width="800">
						<a href="https://www.seminuevosharo.mx/vehicle-details.php?auto=' . $id . '">
												  <img src="https://www.seminuevosharo.mx/' . $imagen . '"  width="800" height="500" style="margin:0; border:0; width:100%; max-width:100%; display:block; height:auto;"/>
						  </a>
						  </td>	
										  </tr>
									  </table>
								  </div>
								  <!--[if mso]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- HEADER ENDS -->
		  
		  <!-- CTA STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if (gte mso 9)|(IE)]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG CTA OPTIONAL -->
									  <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="center">
												  <!--[if gte mso 9]>
												  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px; height:434px; margin:auto;">
												  <v:fill type="frame"  color="#f6f8f7" />
												  <v:textbox inset="0,0,0,0">
												  <![endif]-->
												  <div style="margin:auto;">
													  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-position:center; background-repeat:no-repeat;">
														  <tr>
															  <td align="center" class="padding" style="font-size:0;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width: 600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block;width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  
																					  <tr>
																						  <td align="center">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:90%; max-width:90%;">
																								  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:22px; line-height:38px; letter-spacing:1px;">
																										   ' . $marca . ' ' . $modelo . ' ' . $anio . '
																									  </td>
													
												   
																								  </tr>
												  													

																								  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									 
																										
																										<td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:22px; line-height:38px; letter-spacing:1px;">
																										<p > $' . number_format($precioNuevo, 2) . '</p>																							  
																										</td>
													
												   
																								  </tr>
  
												 
																								  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									  <td align="Left" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:15px; line-height:38px; letter-spacing:1px;">
																										  Car Hunter:
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="10" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  
																								  <tr>
																									  <!-- ID:TXT CTA CONTENT -->
																									  <td align="Left" class="MsoNormal" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; color:#cccccc; line-height:24px; font-weight:400; letter-spacing:1px;">
																										  Hola querido suscriptor, hemos añadido un auto a nuestro inventario. ¡Que no te lo ganen! Haz clic en la imagen para ver los detalles.
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="20" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  <tr>
																									  <!-- ID:TXT CTA CONTENT -->
																									  <td align="Left" class="MsoNormal" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; color:#cccccc; line-height:24px; font-weight:400; letter-spacing:1px;">
																										  Gracias por suscribirse a HARO SEMINUEVOS. Si desea darse de baja de nuestro boletín, haga clic en el siguiente botón:
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="20" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  <tr>
																									  <td align="center" class="button-width">	
																										  <!-- ID:BR CTA BUTTON -->
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-button" style="border:1px solid #ffffff;">
																											  <tr>
																												  <!-- ID:TXT CTA BUTTON TEXT -->
																												  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; padding:8px 12px; font-size:11px; letter-spacing:1px;">
																													  <a href="https://seminuevosharo.mx/suscripciones.php?suscriptor=' . $suscriptor . '" style="color:#ffffff; text-decoration:none;">Cancelar la suscripción</a>
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																							  </table>
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="130" style="mso-line-height-rule: exactly; line-height:130px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </table>
												  </div>
												  <!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->	
											  </td>
										  </tr>
									  </table>
								  </div>
								  <!--[if (gte mso 9)|(IE)]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- CTA ENDS -->
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  <!-- FOOTER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
						  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
							  <tr>
								  <td align="center" valign="top" width="100%" style="max-width:800px;">
									  <![endif]-->
									  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
										  <!-- ID:BG FOOTER -->
										  <table align="center" bgcolor="#111111" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
											  <tbody>	
												  <tr>
													  <td align="center" class="padding">
														  <!--[if mso]>
														  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
															  <tr>
																  <td align="center">
																		  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  <tr>
																						  <td height="60" style="mso-line-height-rule:exactly; line-height:60px; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER ADDRESS -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; padding:0 5px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  Av. Jorge Álvarez del Castillo No. 1264, Lomas del Country Guadalajara, Jal.
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="10" style="line-height:10px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER MAIL -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  <a href="#" style="color:#ffffff;text-decoration:none;">contacto@seminuevosharo.mx</a>
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="10" style="line-height:10px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER PHONE -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  +52 33 3636 8433
																						  </td>
																					  </tr
																					  <tr>
																						  <!-- ID:TXT FOOTER PHONE -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  +52 33 1955 2634
																						  </td>
																					  </tr>
																					  
																				  
																					  <tr>
																						  <!-- ID:BR FOOTER BORDER -->
																						  <td height="60" style="border-bottom:1px solid #666666; line-height: 60px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td height="40" style="line-height: 40px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:12px; font-weight:400; line-height:22px; letter-spacing:1px;">
																							  <span class="txt-copyright unsub-width">&copy; Todos los derechos reservados por Edworld - ALA </span>  
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="60" style="mso-line-height-rule:exactly; line-height:60px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																		  <!--[if mso]>
																	  </td>
																  </tr>
															  </table>
														  <![endif]-->
													  </td>
												  </tr>
											  </tbody>	
										  </table>
									  </div>
									  <!--[if mso]>
								  </td>
							  </tr>
						  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- FOOTER ENDS -->
	  </body>
  </html>
	';
	return $mensaje;
}

function crearMensaje($marca, $modelo, $anio, $id, $precio, $imagen, $suscriptor)
{
	$mensaje = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
	  <head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0," /> 
		  <title>Haro Seminuevos - Nuevo Vehículo</title>
		  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" type=text/css />
  
		  <style type="text/css">
		  
			  html { width: 100%; }
			  body {margin:0; padding:0; width:100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color: #f5f5f5;}
			  img {display:block !important; border:0; -ms-interpolation-mode:bicubic;}
  
			  .ReadMsgBody { width: 100%;}
			  .ExternalClass {width: 100%;}
			  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
			  
			  .MsoNormal {font-family: Inter, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  p {margin:0 !important; padding:0 !important;}
			  
			  .images {display:block !important; width:100% !important;}
			  .display-button td, .display-button a  {font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
  
			  .display-button a:hover {text-decoration:none !important;}
			  
			  /* MEDIA QUIRES */
			  @media only screen and (min-width:799px)
			  {
				  .main-width {
					  width:600px;
				  }
				  .width800 {
					  width:800px !important;
					  max-width:800px !important;
				  }
				  .saf-table {
					  display:table !important;
				  }
			  }
			  @media only screen and (max-width:799px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}	
				  .display-width-inner {width:600px !important;}	
				  .padding { padding:0 20px !important; }	
				  .width800 {
					  width:100% !important;
					  max-width:100% !important;
				  }
			  }
			  
			  @media only screen and (max-width:639px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}
				  .display-width-inner,  
				  .display-width-child {width:100% !important;}
				  .display-width-child .button-width .display-button {width:auto !important;}
				  .padding { padding:0 20px !important; }	
				  .width282 {
					  width:282px !important;  
				  }
				  span.unsub-width {width:100% !important;
				  display:block !important;}
				  span.txt-copyright{ padding-bottom:10px !important;}
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
					  width:100% !important;
				  }
				  .res-center { 
					  display:table !important;
					  margin:0 auto !important;
				  }
				  .height10 {height:10px !important; line-height:10px !important;}
				  .height20 {height:20px !important; line-height:20px !important;}
				  .height30 {height:30px !important; line-height:30px !important;}
				  .hide-height, .hide-bar {display:none !important;}
				  .txt-center {text-align:center !important;}
				  .price-text {font-size: 28px !important;}
				  .title-text {font-size: 24px !important;}
			  }
			  
			  @media only screen and (max-width:480px) {
				  
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width .width282 {
					  width:282px !important;  
				  }
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
				  width:100% !important;
				  max-width: 100% !important;
				  }
				  .price-text {font-size: 24px !important;}
				  .title-text {font-size: 20px !important;}
			  }
			  
			  @media only screen and (max-width:380px)
			  {
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width-child .width282 { width:100% !important;}
				  .price-text {font-size: 22px !important;}
				  .title-text {font-size: 18px !important;}
			  }
		  </style>
		  
	  </head>
	  <body style="width:100%;margin: 0; mso-line-height-rule: exactly; background-color: #f5f5f5;">
		  <!--[if mso]>
		  <style>
			  .heading {font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .MsoNormal {font-family: Inter, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .display-button td, .display-button a, a {font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .width-auto {
			  width:auto !important;
			  }
		  </style>
		  <![endif]-->
		  
		  <!-- MENU STARTS -->
		  <table align="center" bgcolor="#f5f5f5" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
							  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
								  <tr>
									  <td align="center" valign="top" width="100%" style="max-width:800px;">
										  <![endif]-->
											  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
												  <!-- ID:BG MENU -->
												  <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px; border-bottom: 3px solid #d4af37;">
													  <tbody>	
														  <tr>
															  <td align="center" class="padding" style="height: 80px;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;"> 
																					  <tr>
																						  <td height="20" class="height30" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td align="center" style="width:100%; max-width:100%; font-size:0;">
																							  <!--[if (gte mso 9)|(IE)]>
																							  <table  aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="width:100%;">
																								  <tr>
																									  <td align="center" valign="top" width="150">
																										  <![endif]-->
																										  <div style="display:inline-block; max-width:200px; width:100%; vertical-align:top;" class="div-width">
																											  <!--TABLE LEFT-->
																											  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="100%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%; max-width:100%;">
																												  <tr>
																													  <td align="center">
																														  <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:auto !important;">
																															  <tr>
																																  <!-- ID:TXT MENU -->
																																  <td align="center" style="color:#333333;">
																																	  <a href="https://www.seminuevosharo.mx" style="color:#333333; text-decoration:none;">
																																		  <img src="https://seminuevosharo.mx/img-mail/logo.png" width="160" height="auto" style="margin:0; border:0; padding:0; display:block; max-height: 60px;"/>
																																	  </a>
																																  </td>
																															  </tr>
																														  </table>
																													  </td>
																												  </tr>
																											  </table>
																										  </div>
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																									  <td align="center" valign="top" width="440">
																									  <![endif]-->
																										  
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																								  </tr>
																							  </table>
																							  <![endif]-->
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="20" class="height30" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </tbody>	
												  </table>
											  </div>
										  <!--[if (gte mso 9)|(IE)]>
									  </td>
								  </tr>
							  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- MENU ENDS -->
		  
		  <!-- HEADER STARTS -->
		  <table align="center" bgcolor="#f5f5f5" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if mso]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG HEADER OPTIONAL -->
									  <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="center" style="padding: 0; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
												<a href="https://www.seminuevosharo.mx/vehicle-details.php?auto=' . $id . '">
													<img src="https://www.seminuevosharo.mx/' . $imagen . '" width="800" style="margin:0; border:0; width:100%; max-width:100%; display:block; height:auto;"/>
												</a>
											  </td>	
										  </tr>
									  </table>
								  </div>
								  <!--[if mso]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- HEADER ENDS -->
		  
		  <!-- CTA STARTS -->
		  <table align="center" bgcolor="#f5f5f5" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if (gte mso 9)|(IE)]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG CTA OPTIONAL -->
									  <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="center" style="padding: 40px 0;">
												  <div style="margin:auto;">
													  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
														  <tr>
															  <td align="center" class="padding" style="font-size:0;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width: 600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block;width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  <tr>
																						  <td align="center">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:90%; max-width:90%;">
																								  
																								  <!-- Badge de notificación -->
																								  <tr>
																									  <td align="center" style="padding-bottom: 20px;">
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #d4af37; border-radius: 20px;">
																											  <tr>
																												  <td align="center" style="padding: 8px 20px; font-family: Montserrat, Arial, sans-serif; font-size: 11px; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 2px;">
																													  🚗 Nuevo en Inventario
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																								  
																								  <!-- Título del vehículo -->
																								  <tr>
																									  <td align="center" class="title-text" style="color:#1a1a1a; font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:800; font-size:32px; line-height:42px; letter-spacing:-0.5px; padding-bottom: 5px;">
																										  ' . $marca . ' ' . $modelo . '
																									  </td>
																								  </tr>
																								  
																								  <!-- Año -->
																								  <tr>
																									  <td align="center" style="color:#666666; font-family: Inter, Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:500; font-size:18px; line-height:28px; letter-spacing:1px; padding-bottom: 15px;">
																										  ' . $anio . '
																									  </td>
																								  </tr>
																								  
																								  <!-- Precio destacado -->
																								  <tr>
																									  <td align="center" style="padding-bottom: 30px;">
																										  <table align="center" border="0" cellpadding="0" cellspacing="0">
																											  <tr>
																												  <td align="center" class="price-text" style="color:#d4af37; font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:800; font-size:36px; line-height:46px; letter-spacing:-1px;">
																													  $' . number_format($precio, 2) . '
																												  </td>
																											  </tr>
																											  <tr>
																												  <td align="center" style="color:#999999; font-family: Inter, Arial, sans-serif; font-size:12px; font-weight:400; padding-top: 5px;">
																													  Precio especial suscriptores
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																								  
																								  <!-- Separador -->
																								  <tr>
																									  <td align="center" style="padding-bottom: 30px;">
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" width="60" style="border-top: 3px solid #d4af37;">
																											  <tr><td height="0" style="font-size:0; line-height:0;">&nbsp;</td></tr>
																										  </table>
																									  </td>
																								  </tr>
																								  
																								  <!-- Saludo -->
																								  <tr>
																									  <td align="left" style="color:#1a1a1a; font-family: Montserrat, Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:16px; line-height:26px; padding-bottom: 15px;">
																										  Hola, Car Hunter:
																									  </td>
																								  </tr>
																								  
																								  <!-- Mensaje principal -->
																								  <tr>
																									  <td align="left" style="font-family: Inter, Arial, Helvetica Neue, Helvetica, sans-serif; font-size:15px; color:#555555; line-height:26px; font-weight:400; padding-bottom: 25px;">
																										  Tenemos excelentes noticias. Hemos añadido un nuevo vehículo a nuestro inventario que creemos que te interesará. No dejes pasar esta oportunidad única.
																									  </td>
																								  </tr>
																								  
																								  <!-- Botón CTA Principal -->
																								  <tr>
																									  <td align="center" style="padding-bottom: 40px;">
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-button" style="background: linear-gradient(135deg, #d4af37 0%, #c19b26 100%); border-radius: 30px; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
																											  <tr>
																												  <td align="center" style="padding: 16px 40px; font-family: Montserrat, Arial, sans-serif; font-size:14px; font-weight:700; color: #ffffff; text-transform: uppercase; letter-spacing: 1px;">
																													  <a href="https://www.seminuevosharo.mx/vehicle-details.php?auto=' . $id . '" style="color:#ffffff; text-decoration:none; display: inline-block;">Ver Detalles del Auto</a>
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																								  
																								  <!-- Mensaje secundario -->
																								  <tr>
																									  <td align="center" style="padding-top: 20px; border-top: 1px solid #eeeeee;">
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
																											  <tr>
																												  <td height="20" style="font-size:0; line-height:0;">&nbsp;</td>
																											  </tr>
																											  <tr>
																												  <td align="center" style="font-family: Inter, Arial, sans-serif; font-size:13px; color:#888888; line-height:22px; font-weight:400;">
																													  Gracias por suscribirte a <strong style="color:#1a1a1a;">HARO SEMINUEVOS</strong>
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																								  
																							  </table>
																						  </td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </table>
												  </div>
											  </td>
										  </tr>
									  </table>
								  </div>
								  <!--[if (gte mso 9)|(IE)]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- CTA ENDS -->
		  
		  <!-- FOOTER STARTS -->
		  <table align="center" bgcolor="#f5f5f5" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
						  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
							  <tr>
								  <td align="center" valign="top" width="100%" style="max-width:800px;">
									  <![endif]-->
									  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
										  <!-- ID:BG FOOTER -->
										  <table align="center" bgcolor="#1a1a1a" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
											  <tbody>	
												  <tr>
													  <td align="center" class="padding" style="padding: 50px 20px;">
														  <!--[if mso]>
														  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
															  <tr>
																  <td align="center">
																		  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  
																					  <!-- Logo footer -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 30px;">
																							  <img src="https://seminuevosharo.mx/img-mail/logo.png" width="120" height="auto" style="margin:0; border:0; padding:0; display:block; opacity: 0.8;"/>
																						  </td>
																					  </tr>
																					  
																					  <!-- Dirección -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 20px;">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0">
																								  <tr>
																									  <td align="center" style="font-family: Inter, Arial, sans-serif; font-size:14px; color:#d4af37; font-weight:600; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">
																										  Visítanos
																									  </td>
																								  </tr>
																								  <tr>
																									  <td align="center" style="font-family: Inter, Arial, sans-serif; font-size:13px; color:#aaaaaa; line-height:22px; font-weight:400;">
																										  Av. Jorge Álvarez del Castillo No. 1264<br/>
																										  Lomas del Country, Guadalajara, Jal.
																									  </td>
																								  </tr>
																							  </table>
																						  </td>
																					  </tr>
																					  
																					  <!-- Contacto -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 30px;">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0">
																								  <tr>
																									  <td align="center" style="padding: 0 15px;">
																										  <a href="mailto:contacto@seminuevosharo.mx" style="color:#ffffff; text-decoration:none; font-family: Inter, Arial, sans-serif; font-size:13px; font-weight:500;">contacto@seminuevosharo.mx</a>
																									  </td>
																								  </tr>
																							  </table>
																						  </td>
																					  </tr>
																					  
																					  <!-- Teléfonos -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 30px;">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0">
																								  <tr>
																									  <td align="center" style="padding: 0 10px;">
																										  <table border="0" cellpadding="0" cellspacing="0" style="background-color: #2d2d2d; border-radius: 20px;">
																											  <tr>
																												  <td align="center" style="padding: 10px 20px; font-family: Montserrat, Arial, sans-serif; font-size:13px; color:#ffffff; font-weight:600;">
																													  📞 33 3636 8433
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																									  <td align="center" style="padding: 0 10px;">
																										  <table border="0" cellpadding="0" cellspacing="0" style="background-color: #2d2d2d; border-radius: 20px;">
																											  <tr>
																												  <td align="center" style="padding: 10px 20px; font-family: Montserrat, Arial, sans-serif; font-size:13px; color:#ffffff; font-weight:600;">
																													  📱 33 1955 2634
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																							  </table>
																						  </td>
																					  </tr>
																					  
																					  <!-- Separador -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 30px;">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0" width="40" style="border-top: 2px solid #d4af37;">
																								  <tr><td height="0" style="font-size:0; line-height:0;">&nbsp;</td></tr>
																							  </table>
																						  </td>
																					  </tr>
																					  
																					  <!-- Copyright -->
																					  <tr>
																						  <td align="center" style="padding-bottom: 20px;">
																							  <span style="font-family: Inter, Arial, sans-serif; font-size:12px; color:#666666; font-weight:400;">
																								  &copy; 2024 Haro Seminuevos. Todos los derechos reservados.
																							  </span>
																						  </td>
																					  </tr>
																					  
																					  <!-- Cancelar suscripción sutil -->
																					  <tr>
																						  <td align="center">
																							  <a href="https://seminuevosharo.mx/suscripciones.php?suscriptor=' . $suscriptor . '" style="color:#555555; text-decoration:underline; font-family: Inter, Arial, sans-serif; font-size:11px; font-weight:400;">
																								  Cancelar suscripción
																							  </a>
																						  </td>
																					  </tr>
																					  
																				  </table>
																			  </div>
																		  <!--[if mso]>
																	  </td>
																  </tr>
															  </table>
														  <![endif]-->
													  </td>
												  </tr>
											  </tbody>	
										  </table>
									  </div>
									  <!--[if mso]>
								  </td>
							  </tr>
						  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- FOOTER ENDS -->
	  </body>
  </html>
	';
	return $mensaje;
}
function crearMensajeOLD($marca, $modelo, $anio, $id, $precio, $imagen, $suscriptor)
{
	$mensaje = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
	  <head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <meta  name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0," /> 
		  <title>blaack</title>
		  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet" type=text/css />
  
		  <style type="text/css">
		  
			  html { width: 100%; }
			  body {margin:0; padding:0; width:100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
			  img {display:block !important; border:0; -ms-interpolation-mode:bicubic;}
  
			  .ReadMsgBody { width: 100%;}
			  .ExternalClass {width: 100%;}
			  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
			  
			  .MsoNormal {font-family: Open Sans, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  p {margin:0 !important; padding:0 !important;}
			  
			  .images {display:block !important; width:100% !important;}
			  .display-button td, .display-button a  {font-family: Open Sans, Arial, Helvetica Neue, Helvetica, sans-serif !important;}
  
			  .display-button a:hover {text-decoration:none !important;}
			  
			  /* MEDIA QUIRES */
			  @media only screen and (min-width:799px)
			  {
				  .main-width {
					  width:600px;
				  }
				  .width800 {
					  width:800px !important;
					  max-width:800px !important;
				  }
				  .saf-table {
					  display:table !important;
				  }
			  }
			  @media only screen and (max-width:799px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}	
				  .display-width-inner {width:600px !important;}	
				  .padding { padding:0 20px !important; }	
				  .width800 {
					  width:100% !important;
					  max-width:100% !important;
				  }
			  }
			  
			  @media only screen and (max-width:639px)
			  {
				  body {width:auto !important;}
				  .display-width {width:100% !important;}
				  .display-width-inner,  
				  .display-width-child {width:100% !important;}
				  .display-width-child .button-width .display-button {width:auto !important;}
				  .padding { padding:0 20px !important; }	
				  .width282 {
					  width:282px !important;  
				  }
				  span.unsub-width {width:100% !important;
				  display:block !important;}
				  span.txt-copyright{ padding-bottom:10px !important;}
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
					  width:100% !important;
				  }
				  .res-center { 
					  display:table !important;
					  margin:0 auto !important;
				  }
				  .height10 {height:10px !important; line-height:10px !important;}
				  .height20 {height:20px !important; line-height:20px !important;}
				  .height30 {height:30px !important; line-height:30px !important;}
				  .hide-height, .hide-bar {display:none !important;}
				  .txt-center {text-align:center !important;}
			  }
			  
			  @media only screen and (max-width:480px) {
				  
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width .width282 {
					  width:282px !important;  
				  }
				  .div-width {				
				  display: block !important;
				  width: 100% !important;
				  max-width: 100% !important;
				  }
				  .width-auto {
				  width:100% !important;
				  max-width: 100% !important;
				  }
			  }
			  
			  @media only screen and (max-width:380px)
			  {
				  .display-width table {width:100% !important;}
				  .display-width .button-width .display-button {width:auto !important;}
				  .display-width-child .width282 { width:100% !important;}
			  }
		  </style>
		  
	  </head>
	  <body style="width:100%;margin: 0; mso-line-height-rule: exactly;">
		  <!--[if mso]>
		  <style>
			  .heading {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .MsoNormal {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .display-button td, .display-button a, a {font-family: Arial, Helvetica Neue, Helvetica, sans-serif !important;}
			  .width-auto {
			  width:auto !important;
			  }
		  </style>
		  <![endif]-->
		  
		  <!-- VIEW IN BROWSER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
							  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
								  <tr>
									  <td align="center" valign="top" width="100%" style="max-width:800px;">
										  <![endif]-->
											  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
												  <!-- ID:BG VIEW BROWSER -->
												  <table align="center" bgcolor="#111111" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
													  <tbody>	
														  <tr>
															  <td align="center" class="padding">
																  <!--[if mso]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
																	  <tr>
																		  <td align="center">
																				  <![endif]-->
																				  
																				  <!--[if mso]>
																			  </td>
																		  </tr>
																	  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </tbody>	
												  </table>
											  </div>
										  <!--[if mso]>
									  </td>
								  </tr>
							  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- VIEW IN BROWSER ENDS -->
		  
		  <!-- MENU STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
							  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
								  <tr>
									  <td align="center" valign="top" width="100%" style="max-width:800px;">
										  <![endif]-->
											  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
												  <!-- ID:BG MENU -->
												  <table align="center" bgcolor="#1b1b1b" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
													  <tbody>	
														  <tr>
															  <td align="center" class="padding" style="height: 100px;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;"> 
																					  <tr>
																						  <td height="15" class="height30" style="mso-line-height-rule:exactly; line-height:15px; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td align="center"  style="width:100%; max-width:100%; font-size:0;">
																							  <!--[if (gte mso 9)|(IE)]>
																							  <table  aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="width:100%;">
																								  <tr>
																									  <td align="center" valign="top" width="150">
																										  <![endif]-->
																										  <div style="display:inline-block; max-width:150px; width:100%; vertical-align:top;" class="div-width">
																											  <!--TABLE LEFT-->
																											  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="100%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%; max-width:100%;">
																												  <tr>
																													  <td align="center">
																														  <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:auto !important;">
																															  <tr>
																																  <!-- ID:TXT MENU -->
																																  <td align="center" style="color:#333333;">
																																	  <a href="#" style="color:#333333; text-decoration:none;">
																																		  <img src="https://seminuevosharo.mx/img-mail/logo.png"  width="139" height="75" style="margin:0; border:0; padding:0; display:block;"/>
																																	  </a>
																																  </td>
																															  </tr>
																														  </table>
																													  </td>
																												  </tr>
																											  </table>
																										  </div>
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																									  <td align="center" valign="top" width="440">
																									  <![endif]-->
																										  
																										  <!--[if (gte mso 9)|(IE)]>
																									  </td>
																								  </tr>
																							  </table>
																							  <![endif]-->
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="15" class="height30" style="mso-line-height-rule:exactly; line-height:15px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </tbody>	
												  </table>
											  </div>
										  <!--[if (gte mso 9)|(IE)]>
									  </td>
								  </tr>
							  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- MENU ENDS -->
		  
		  <!-- HEADER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if mso]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG HEADER OPTIONAL -->
									  <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="left" width="800">
						<a href="https://www.seminuevosharo.mx/vehicle-details.php?auto=' . $id . '">
												  <img src="https://www.seminuevosharo.mx/' . $imagen . '"  width="800" height="500" style="margin:0; border:0; width:100%; max-width:100%; display:block; height:auto;"/>
						  </a>
						  </td>	
										  </tr>
									  </table>
								  </div>
								  <!--[if mso]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- HEADER ENDS -->
		  
		  <!-- CTA STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tr>
				  <td align="center">
					  <!--[if (gte mso 9)|(IE)]>
					  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
						  <tr>
							  <td align="center" valign="top" width="800">
								  <![endif]-->
								  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
									  <!-- ID:BG CTA OPTIONAL -->
									  <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
										  <tr>
											  <td align="center">
												  <!--[if gte mso 9]>
												  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px; height:434px; margin:auto;">
												  <v:fill type="frame"  color="#f6f8f7" />
												  <v:textbox inset="0,0,0,0">
												  <![endif]-->
												  <div style="margin:auto;">
													  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-position:center; background-repeat:no-repeat;">
														  <tr>
															  <td align="center" class="padding" style="font-size:0;">
																  <!--[if (gte mso 9)|(IE)]>
																  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width: 600px;">
																	  <tr>
																		  <td align="center" valign="top" width="600">
																			  <![endif]-->
																			  <div style="display:inline-block;width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  
																					  <tr>
																						  <td align="center">
																							  <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:90%; max-width:90%;">
																								  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:22px; line-height:38px; letter-spacing:1px;">
																										   ' . $marca . ' ' . $modelo . ' ' . $anio . '
																									  </td>
													
												   
																								  </tr>
												  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:22px; line-height:38px; letter-spacing:1px;">
													$' . number_format($precio, 2) . '
																									  </td>
													
												   
																								  </tr>
  
												 
																								  <tr>
																									  <!-- ID:TXT CTA HEADING -->
																									  <td align="Left" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; font-size:15px; line-height:38px; letter-spacing:1px;">
																										  Car Hunter:
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="10" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  
																								  <tr>
																									  <!-- ID:TXT CTA CONTENT -->
																									  <td align="Left" class="MsoNormal" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; color:#cccccc; line-height:24px; font-weight:400; letter-spacing:1px;">
																										  Hola querido suscriptor, hemos añadido un auto a nuestro inventario. ¡Que no te lo ganen! Haz clic en la imagen para ver los detalles.
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="20" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  <tr>
																									  <!-- ID:TXT CTA CONTENT -->
																									  <td align="Left" class="MsoNormal" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; color:#cccccc; line-height:24px; font-weight:400; letter-spacing:1px;">
																										  Gracias por suscribirse a HARO SEMINUEVOS. Si desea darse de baja de nuestro boletín, haga clic en el siguiente botón:
																									  </td>
																								  </tr>
																								  <tr>
																									  <td height="20" style="mso-line-height-rule:exactly; line-height:20px; font-size:0;">&nbsp;</td>
																								  </tr>
																								  <tr>
																									  <td align="center" class="button-width">	
																										  <!-- ID:BR CTA BUTTON -->
																										  <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-button" style="border:1px solid #ffffff;">
																											  <tr>
																												  <!-- ID:TXT CTA BUTTON TEXT -->
																												  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-weight:700; padding:8px 12px; font-size:11px; letter-spacing:1px;">
																													  <a href="https://seminuevosharo.mx/suscripciones.php?suscriptor=' . $suscriptor . '" style="color:#ffffff; text-decoration:none;">Cancelar la suscripción</a>
																												  </td>
																											  </tr>
																										  </table>
																									  </td>
																								  </tr>
																							  </table>
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="130" style="mso-line-height-rule: exactly; line-height:130px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																			  <!--[if (gte mso 9)|(IE)]>
																		  </td>
																	  </tr>
																  </table>
																  <![endif]-->
															  </td>
														  </tr>
													  </table>
												  </div>
												  <!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->	
											  </td>
										  </tr>
									  </table>
								  </div>
								  <!--[if (gte mso 9)|(IE)]>
							  </td>
						  </tr>
					  </table>
					  <![endif]-->
				  </td>
			  </tr>
		  </table>	
		  <!-- CTA ENDS -->
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  <!-- FOOTER STARTS -->
		  <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
				  <tr>
					  <td align="center">
						  <!--[if mso]>
						  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="800" style="width: 800px;">
							  <tr>
								  <td align="center" valign="top" width="100%" style="max-width:800px;">
									  <![endif]-->
									  <div style="display:inline-block; width:100%; max-width:800px; vertical-align:top;" class="width800">
										  <!-- ID:BG FOOTER -->
										  <table align="center" bgcolor="#111111" border="0" cellpadding="0" cellspacing="0" class="display-width" width="100%" style="max-width:800px;">
											  <tbody>	
												  <tr>
													  <td align="center" class="padding">
														  <!--[if mso]>
														  <table aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="width:600px;">
															  <tr>
																  <td align="center">
																		  <![endif]-->
																			  <div style="display:inline-block; width:100%; max-width:600px; vertical-align:top;" class="main-width">
																				  <table align="center" border="0" class="display-width-inner" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
																					  <tr>
																						  <td height="60" style="mso-line-height-rule:exactly; line-height:60px; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER ADDRESS -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; padding:0 5px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  Av. Jorge Álvarez del Castillo No. 1264, Lomas del Country Guadalajara, Jal.
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="10" style="line-height:10px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER MAIL -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  <a href="#" style="color:#ffffff;text-decoration:none;">contacto@seminuevosharo.mx</a>
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="10" style="line-height:10px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <!-- ID:TXT FOOTER PHONE -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  +52 33 3636 8433
																						  </td>
																					  </tr
																					  <tr>
																						  <!-- ID:TXT FOOTER PHONE -->
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:14px; font-weight:400; line-height:24px; letter-spacing:1px;">
																							  +52 33 1955 2634
																						  </td>
																					  </tr>
																					  
																				  
																					  <tr>
																						  <!-- ID:BR FOOTER BORDER -->
																						  <td height="60" style="border-bottom:1px solid #666666; line-height: 60px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td height="40" style="line-height: 40px; mso-line-height-rule: exactly; font-size:0;">&nbsp;</td>
																					  </tr>
																					  <tr>
																						  <td align="center" class="MsoNormal" style="color:#ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size:12px; font-weight:400; line-height:22px; letter-spacing:1px;">
																							  <span class="txt-copyright unsub-width">&copy; Todos los derechos reservados por Edworld - ALA </span>  
																						  </td>
																					  </tr>
																					  <tr>
																						  <td height="60" style="mso-line-height-rule:exactly; line-height:60px; font-size:0;">&nbsp;</td>
																					  </tr>
																				  </table>
																			  </div>
																		  <!--[if mso]>
																	  </td>
																  </tr>
															  </table>
														  <![endif]-->
													  </td>
												  </tr>
											  </tbody>	
										  </table>
									  </div>
									  <!--[if mso]>
								  </td>
							  </tr>
						  </table>
						  <![endif]-->
					  </td>
				  </tr>					
			  </tbody>	
		  </table>
		  <!-- FOOTER ENDS -->
	  </body>
  </html>
	';
	return $mensaje;
}

function procesarModificacion()
{
	$idUsuario = (int) ($_SESSION['sesionUsuario']['id'] ?? 0);
	if ($idUsuario <= 0) {
		http_response_code(401);
		echo json_encode(['error' => 'La sesión expiró. Inicia sesión nuevamente.']);
		return;
	}

	$adminAuto = new AdministradorAutos();
	$id = (int) ($_POST['id'] ?? 0);
	$autoModificado = $adminAuto->dameAuto($id);
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
	$consig = $_POST['consig'] ?? '';
	$idAlmacen = $_POST['id_almacen'];
	if ($consig == "on") {
		$consig = 1;
	} else {
		$consig = 0;
	}

	$admin = new AdministradorAutos();
	$admin->actualizarAuto($id, $cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $consig, $idAlmacen, $idUsuario);

	if ($autoModificado->precio != $precio) {
		try {
			notificarOferta($id, $precio);
		} catch (Throwable $exception) {
			error_log('El auto se modificó, pero falló la notificación de oferta: ' . $exception->getMessage());
		}
	}

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
	$X = $admin->dameAuto($auto);
	$admin->asignarAuto($id, $auto);

	if (intval($admin->cuentaImagenesAuto($auto)) <= 1) {
		notificarAuto($X->modelo->id, $X->marca->id, $X->id);
	}

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
	echo
	 json_encode($admin->dameAutosNoSubidos($red));
}

function renovarAuto(){
	$id = $_POST['id'];
	$admin = new AdministradorAutos();
	$admin->renovarAuto($id);
	echo "1";
}

function dameAutos(){
	$admin = new AdministradorAutos();
	echo json_encode($admin->dameAutosApp());

}

function dameLogsAuto(){
	$id = $_POST['id'];
	$admin = new AdministradorAutos();
	echo json_encode($admin->dameLogsAuto($id));
}

function verificarAlmacen(){
	$id = $_POST['id'];
	$id_usuario = $_POST['id_usuario'];
	$admin = new AdministradorAutos();
	$admin->verificarAlmacen($id, $id_usuario);
	$mensaje = array(
		"Mensaje" => "almacen verificado",
		"estatus" => "1"
	);
	echo json_encode($mensaje);
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
	case $casoRenovar:
		renovarAuto();
		break;
	case $casoDameAutos:
		dameAutos();
		break;
	case $casoLogsAuto:
		dameLogsAuto();
		break;
	case $casoVerificarAlmacen:
		verificarAlmacen();
		break;
	default:
		echo "0";
		break;
}





//notificarOferta(1689,);
