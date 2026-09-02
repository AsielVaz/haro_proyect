<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Documento de corrida de financiera </title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <?php
  session_start();
  include("../../api/adminUsuarios.php");
  include("../../api/adminAutos.php");
  include("../api/adminClientes.php");
  include_once "encriptador.php";


  $adminAutos = new AdministradorAutos();
  $adminUsuarios = new administradorUsuarios();
  $adminClientes = new AdministradorClientesBanca();
  $vendedor = $adminUsuarios->dameUsuarioId($_SESSION['sesionUsuario']['id']);
  $auto = $adminAutos->dameAuto($_POST['auto']);
  $cliente = $adminClientes->dameCliente($_POST['cliente']);


  function formatearFechaSql($fecha)
  {
    $fecha = explode("/", $fecha);
    $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
    return $fecha;
  }
  ?>

  <style>
    img {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
      width: 150px;
    }

    .centro-x {
      margin-left: auto;
      margin-right: auto;
      width: 20%;
      /* Puedes ajustar el ancho según tus necesidades */
      display: flex;
      justify-content: end;
    }
  </style>

  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style1" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_align_center tm_mb20">
            <div class="tm_invoice_left">
              <img style="object-fit: contain;" src="assets/img/haro-logo.png" alt="Logo">
            </div>
            <div class="tm_invoice_right tm_text_right">
              <div class="tm_primary_color tm_f50 tm_text_uppercase">Corrida</div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb20">
            <div class="tm_invoice_seperator tm_gray_bg"></div>
            <div class="tm_invoice_info_list">
              <p class="tm_invoice_number tm_m0">Corrida No: <b class="tm_primary_color">#LL93784</b></p>
              <p class="tm_invoice_date tm_m0">Fecha: <b class="tm_primary_color"><?php echo date("Y-m-d") ?></b></p>
            </div>
          </div>
          <div class="tm_invoice_head tm_mb10">
            <div class="tm_invoice_left">
              <p class="tm_mb2"><b class="tm_primary_color">Datos de cliente:</b></p>
              <p>
                <?php echo $cliente->nombre ?> <br>
                <?php echo $cliente->telefono ?><br>
                <?php echo $cliente->email ?><br>
              </p>
            </div>

            <div class="tm_invoice_right tm_text_right">

              <p class="tm_mb2"><b class="tm_primary_color">Datos del vendedor :</b></p>
              <p>
                <?php echo $vendedor->nombre ?> <br>
                <?php echo $vendedor->telefono ?><br>
                <?php echo $vendedor->email ?><br>

              </p>
            </div>

            <br><br>
            <img style="height: 5rem; width: 5rem;" src="<?php echo $vendedor->imagen ?>" alt="">
          </div>
          <?php
          $lista = json_decode($_POST['lista'], true);
          //echo var_dump($lista);
          ?>
          h2Información del auto <br>
          Marca: <?php echo $auto->marca->marca ?><br>
          Modelo: <?php echo $auto->modelo->modelo ?><br>
          Año: <?php echo $auto->anio ?><br>
          <br>
          <div style="display: flex; justify-content: center;">


            <img src="<?php echo $auto->imagenes[0]->url ?>" alt="">
            <img src="<?php echo $auto->imagenes[2]->url ?>" alt="">
            <img src="<?php echo $auto->imagenes[3]->url ?>" alt="">
            <img src="<?php echo $auto->imagenes[4]->url ?>" alt="">
          </div>
          <br>
          <div class="tm_table tm_style1 tm_mb30">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Monto del pago</th>
                      <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Interés generado </th>
                      <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Total</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Fecha pago</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    for ($i = 0; $i < count($lista); $i++) {
                      echo "<tr>";
                      echo "<td class='tm_width_3'>$ " . number_format($lista[$i]['cantidad'], 2) . "</td>";
                      echo "<td class='tm_width_4'>$ " . number_format($lista[$i]['interes'], 2) . "</td>";
                      echo "<td class='tm_width_2'>$ " . number_format($lista[$i]['total'], 2) . "</td>";
                      echo "<td class='tm_width_1'>" . ($lista[$i]['fecha']) . "</td>";
                      echo "</tr>";
                      $subTotal += $lista[$i]['cantidad'];
                      $interesTotal += $lista[$i]['interes'];
                      $total += $lista[$i]['total'];
                    }
                    $emision = date("Y-m-d");
                    $emision = '2023-01-01';
                    $cadenaEnvio = $_POST['auto'] . "," . $_SESSION['sesionUsuario']['id'] . "," . $_POST['cliente'] . "," . $subTotal . "," . count($lista) . "," . $_POST['interes'] . "," . formatearFechaSql($lista[0]['fecha']) . "," . $emision;
                    $cadenaEnvio = encriptar($cadenaEnvio);
                    ?>





                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer">
              <div class="tm_left_footer">

              </div>
              <div class="tm_right_footer">
                <table>
                  <tbody>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">$ <?php echo number_format($subTotal, 2) ?></td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Intereses <span class="tm_ternary_color">(%)</span></td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+$ <?php echo number_format($interesTotal, 2) ?></td>
                    </tr>
                    <tr class="tm_border_top tm_border_bottom">
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color">TOTAL </td>
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right">$ <?php echo number_format($total, 2) ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <circle cx="392" cy="184" r="24" fill='currentColor' />
            </svg>
          </span>
          <span class="tm_btn_text">Imprimir</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            </svg>
          </span>
          <span class="tm_btn_text">Descargar</span>
        </button>
        <a onclick="enviarCorrida()" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px" height="50px">
              <path d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 29.079097 3.1186875 32.88588 4.984375 36.208984 L 2.0371094 46.730469 A 1.0001 1.0001 0 0 0 3.2402344 47.970703 L 14.210938 45.251953 C 17.434629 46.972929 21.092591 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 21.278025 46 17.792121 45.029635 14.761719 43.333984 A 1.0001 1.0001 0 0 0 14.033203 43.236328 L 4.4257812 45.617188 L 7.0019531 36.425781 A 1.0001 1.0001 0 0 0 6.9023438 35.646484 C 5.0606869 32.523592 4 28.890107 4 25 C 4 13.390466 13.390466 4 25 4 z M 16.642578 13 C 16.001539 13 15.086045 13.23849 14.333984 14.048828 C 13.882268 14.535548 12 16.369511 12 19.59375 C 12 22.955271 14.331391 25.855848 14.613281 26.228516 L 14.615234 26.228516 L 14.615234 26.230469 C 14.588494 26.195329 14.973031 26.752191 15.486328 27.419922 C 15.999626 28.087653 16.717405 28.96464 17.619141 29.914062 C 19.422612 31.812909 21.958282 34.007419 25.105469 35.349609 C 26.554789 35.966779 27.698179 36.339417 28.564453 36.611328 C 30.169845 37.115426 31.632073 37.038799 32.730469 36.876953 C 33.55263 36.755876 34.456878 36.361114 35.351562 35.794922 C 36.246248 35.22873 37.12309 34.524722 37.509766 33.455078 C 37.786772 32.688244 37.927591 31.979598 37.978516 31.396484 C 38.003976 31.104927 38.007211 30.847602 37.988281 30.609375 C 37.969311 30.371148 37.989581 30.188664 37.767578 29.824219 C 37.302009 29.059804 36.774753 29.039853 36.224609 28.767578 C 35.918939 28.616297 35.048661 28.191329 34.175781 27.775391 C 33.303883 27.35992 32.54892 26.991953 32.083984 26.826172 C 31.790239 26.720488 31.431556 26.568352 30.914062 26.626953 C 30.396569 26.685553 29.88546 27.058933 29.587891 27.5 C 29.305837 27.918069 28.170387 29.258349 27.824219 29.652344 C 27.819619 29.649544 27.849659 29.663383 27.712891 29.595703 C 27.284761 29.383815 26.761157 29.203652 25.986328 28.794922 C 25.2115 28.386192 24.242255 27.782635 23.181641 26.847656 L 23.181641 26.845703 C 21.603029 25.455949 20.497272 23.711106 20.148438 23.125 C 20.171937 23.09704 20.145643 23.130901 20.195312 23.082031 L 20.197266 23.080078 C 20.553781 22.728924 20.869739 22.309521 21.136719 22.001953 C 21.515257 21.565866 21.68231 21.181437 21.863281 20.822266 C 22.223954 20.10644 22.02313 19.318742 21.814453 18.904297 L 21.814453 18.902344 C 21.828863 18.931014 21.701572 18.650157 21.564453 18.326172 C 21.426943 18.001263 21.251663 17.580039 21.064453 17.130859 C 20.690033 16.232501 20.272027 15.224912 20.023438 14.634766 L 20.023438 14.632812 C 19.730591 13.937684 19.334395 13.436908 18.816406 13.195312 C 18.298417 12.953717 17.840778 13.022402 17.822266 13.021484 L 17.820312 13.021484 C 17.450668 13.004432 17.045038 13 16.642578 13 z M 16.642578 15 C 17.028118 15 17.408214 15.004701 17.726562 15.019531 C 18.054056 15.035851 18.033687 15.037192 17.970703 15.007812 C 17.906713 14.977972 17.993533 14.968282 18.179688 15.410156 C 18.423098 15.98801 18.84317 16.999249 19.21875 17.900391 C 19.40654 18.350961 19.582292 18.773816 19.722656 19.105469 C 19.863021 19.437122 19.939077 19.622295 20.027344 19.798828 L 20.027344 19.800781 L 20.029297 19.802734 C 20.115837 19.973483 20.108185 19.864164 20.078125 19.923828 C 19.867096 20.342656 19.838461 20.445493 19.625 20.691406 C 19.29998 21.065838 18.968453 21.483404 18.792969 21.65625 C 18.639439 21.80707 18.36242 22.042032 18.189453 22.501953 C 18.016221 22.962578 18.097073 23.59457 18.375 24.066406 C 18.745032 24.6946 19.964406 26.679307 21.859375 28.347656 C 23.05276 29.399678 24.164563 30.095933 25.052734 30.564453 C 25.940906 31.032973 26.664301 31.306607 26.826172 31.386719 C 27.210549 31.576953 27.630655 31.72467 28.119141 31.666016 C 28.607627 31.607366 29.02878 31.310979 29.296875 31.007812 L 29.298828 31.005859 C 29.655629 30.601347 30.715848 29.390728 31.224609 28.644531 C 31.246169 28.652131 31.239109 28.646231 31.408203 28.707031 L 31.408203 28.708984 L 31.410156 28.708984 C 31.487356 28.736474 32.454286 29.169267 33.316406 29.580078 C 34.178526 29.990889 35.053561 30.417875 35.337891 30.558594 C 35.748225 30.761674 35.942113 30.893881 35.992188 30.894531 C 35.995572 30.982516 35.998992 31.07786 35.986328 31.222656 C 35.951258 31.624292 35.8439 32.180225 35.628906 32.775391 C 35.523582 33.066746 34.975018 33.667661 34.283203 34.105469 C 33.591388 34.543277 32.749338 34.852514 32.4375 34.898438 C 31.499896 35.036591 30.386672 35.087027 29.164062 34.703125 C 28.316336 34.437036 27.259305 34.092596 25.890625 33.509766 C 23.114812 32.325956 20.755591 30.311513 19.070312 28.537109 C 18.227674 27.649908 17.552562 26.824019 17.072266 26.199219 C 16.592866 25.575584 16.383528 25.251054 16.208984 25.021484 L 16.207031 25.019531 C 15.897202 24.609805 14 21.970851 14 19.59375 C 14 17.077989 15.168497 16.091436 15.800781 15.410156 C 16.132721 15.052495 16.495617 15 16.642578 15 z" />
            </svg>
          </span>
          <span class="tm_btn_text">Whatsaap</span>
        </a>
        <a href="https://www.seminuevosharo.mx/admin/banca" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">

          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 26.676 26.676" xml:space="preserve">
<g>
	<path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59   c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815   C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029   c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562   C26.18,21.891,26.141,21.891,26.105,21.891z"/>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
	<g>
	</g>
</g>
</svg>
          </span>
          <span class="tm_btn_text">Atras</span>
        </a>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jspdf.min.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function enviarCorrida() {
      var enviaDatos = new FormData();
      enviaDatos.append("telefono", "<?php echo $cliente->telefono?>");
      enviaDatos.append("url", "<?php echo $cadenaEnvio?>");
      fetch("../api/envioCorrida.php", {
          method: "POST",
          body: enviaDatos,
        })
        .then((respuesta) => respuesta.json())
        .then((data) => {
          console.log(data);
          Swal.fire(
            'Enviado!',
            'Se ha enviado la corrida al cliente',
            'success'
          ).then((result) => {
          
          });

        });
    }
  </script>
</body>

</html>