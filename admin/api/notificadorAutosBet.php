<?php
include_once("adminAutos.php");
include_once("adminCarHunter.php");
include_once("adminEditor.php");
include_once 'marcaOferta.php';
include_once('contactoMailer.php');
include_once('conectorBD.php');

$adminAutos = new AdministradorAutos();
$adminCarHunter = new AdministradorCarHunter();
$notificacion = $adminCarHunter->dameNotificacionesSinNotificar();

//echo json_encode($notificacion);
$auto = $adminAutos->dameAutoConImagenes($notificacion->idAuto);
//echo json_encode($auto);
$suscriptor = $adminCarHunter->dameSuscriptor($notificacion->idSuscriptor);
//echo json_encode($suscriptor);
$cantidadImagenes = count($auto->imagenes);

echo 'Enviando auto con id ' . $auto->id . ' a suscriptor con id ' . $suscriptor->id . ' y correo ' . $suscriptor->email . ' y cantidad de imagenes ' . $cantidadImagenes;


if ((($auto->imagen != '' && $auto->imagen != null) || $cantidadImagenes > 0 ) && $suscriptor->email != '' && $suscriptor->email != null) {
	if (!$adminCarHunter->existeNotificado($auto->id, $suscriptor->id)) {
		$adminCarHunter->marcarNotificacionAlter($auto->id, $suscriptor->id);
		//$adminCarHunter->marcarNotificacion($notificacion->id);
		$marca = $auto->marca->marca;
		$modelo = $auto->modelo->modelo;
		$anio = $auto->anio;
		$utlimaId = $auto->id;
		$precio = $auto->precio;
		echo $mensaje = crearMensaje($marca, $modelo, $anio, $utlimaId, $precio, $auto->imagenes[0]->url, $suscriptor->id);
		//mailer($suscriptor->email, "SEMINUEVOS HARO", "Boletín de auto", $mensaje, "", "", "");
		enviarMailChimp($suscriptor->email, $suscriptor->nombre, $auto->marca->marca . " " . $auto->modelo->modelo, $mensaje, $attachment = [], $attachment_name = [], $mail_oculto = [], 'no-reply@seminuevosharo.mx', $auto->id, $suscriptor->id);
		//function enviarMailChimp($email, $nombre, $asunto, $mensaje, $attachment = [], $attachment_name = [], $mail_oculto = [], $correo_origen = '')
		//$adminCarHunter->nuevaNotificacion($utlimaId, $suscriptor->id, "Suscripcion");
		echo json_encode("Se ha enviado un correo a " . $suscriptor->email);
	} else {
		echo json_encode("Ya se ha notificado a " . $suscriptor->email);
		$adminCarHunter->marcarNotificacionAlter($auto->id, $suscriptor->id);
	}
} else {
	echo json_encode("No se ha enviado un correo a " . $suscriptor->email . " porque no tiene imagen auto con id " . $auto->id . " y cantidad de imagenes " . $cantidadImagenes. " o el correo del suscriptor es nulo o vacio con id " . $suscriptor->id);
}










function crearMensaje($marca, $modelo, $anio, $id, $precio, $imagen, $suscriptor)
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




function enviarMailChimp($email, $nombre, $asunto, $mensaje, $attachment = [], $attachment_name = [], $mail_oculto = [], $correo_origen = '', $id_auto = null, $id_suscriptor = null)
{
	$apiKey = 'md-lU26gXaU5HtZ5wUa2GdOjA';

	// Adjuntos (PDFs)
	$adjuntos = [];
	foreach ($attachment as $key => $value) {
		if (!isset($attachment_name[$key])) continue; // seguridad por índices
		$adjuntos[] = [
			'type'    => 'application/pdf',
			'name'    => $attachment_name[$key],
			'content' => base64_encode(@file_get_contents($value))
		];
	}

	// Armamos destinatarios
	$to = [
		['email' => $email, 'name' => $nombre, 'type' => 'to']
	];

	// Si mandas correos ocultos adicionales en el parámetro $mail_oculto
	if (is_array($mail_oculto)) {
		foreach ($mail_oculto as $bcc) {
			if (!empty($bcc)) {
				$to[] = ['email' => $bcc, 'type' => 'bcc'];
			}
		}
	}

	// Regla: si el asunto o el HTML del mensaje contienen "fapa", agregar BCC a log@fapa.mx
	if (stripos($asunto . ' ' . $mensaje, 'fapa') !== false) {
		$to[] = ['email' => 'log@fapa.mx', 'type' => 'bcc'];
	}

	$postData = [
		'key'     => $apiKey,
		'message' => [
			'from_email'  => $correo_origen,
			'to'          => $to,
			'subject'     => $asunto,
			'html'        => $mensaje,
			'attachments' => $adjuntos
		]
	];

	$ch = curl_init('https://mandrillapp.com/api/1.0/messages/send.json');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);

	if ($response === false) {
		$err = curl_error($ch);
		curl_close($ch);
		echo json_encode(['status' => 'error', 'message' => $err], JSON_UNESCAPED_UNICODE);
		return;
	}

	curl_close($ch);
	echo $response;

	$responseData = json_decode($response, true);
	$status = $responseData[0]['status'];
	$id_mandrill = $responseData[0]['_id'];
	$reject_reason = $responseData[0]['reject_reason'];
	$queued_reason = $responseData[0]['queued_reason'];
	
	$conector = new Conector();
	echo $query = "INSERT INTO log_envio_correo (email, id_auto, id_suscriptor, status, id_mandrill, reject_reason, queued_reason) VALUES ('$email', $id_auto, $id_suscriptor, '$status', '$id_mandrill', '$reject_reason', '$queued_reason')";
	$conector->ejecutar($query);
}
