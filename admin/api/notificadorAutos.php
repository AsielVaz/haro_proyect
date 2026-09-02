<?php
include_once("adminAutos.php");
include_once("adminCarHunter.php");
include_once("adminEditor.php");
include_once 'marcaOferta.php';
include_once('contactoMailer.php');
$adminAutos = new AdministradorAutos();
$adminCarHunter = new AdministradorCarHunter();
$autosSinNotificar = $adminAutos->dameAutosSinNotificar();
$suscriptores = $adminCarHunter->dameSuscriptores();

foreach ($autosSinNotificar as $auto) {

	$cantidadImagenes = count($auto->imagenes);
	if ($cantidadImagenes > 0 || $auto->imagen != ''){
		$adminAutos->marcaNotificados($auto->id);
		foreach ($suscriptores as $suscriptor) {
			$marca = $auto->marca->marca;
			$modelo = $auto->modelo->modelo;
			$anio = $auto->anio;
			$utlimaId = $auto->id;
			$precio = $auto->precio;
			//echo $mensaje = crearMensaje($marca, $modelo, $anio, $utlimaId, $precio, $auto->imagenes[0]->url, $suscriptor->id);
			//mailer($suscriptor->email, $suscriptor->email, "Boletín de auto", $mensaje, "", "", "");
			$adminCarHunter->nuevaNotificacion($utlimaId, $suscriptor->id, "Suscripcion");
			echo json_encode("Se ha enviado un correo a " . $suscriptor->email);
		}
	}
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
