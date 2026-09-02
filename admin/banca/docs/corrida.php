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

  $datos = $_GET['pp'];
  //reemplasar espacios por + 
  $datos = str_replace(" ", "+", $datos);
  //desencriptar
  $datos = desencriptar($datos);
  $datos = explode(",", $datos);
  $autoId = $datos[0];
  $vendedorID = $datos[1];
  $clienteId = $datos[2];
  $monto = $datos[3];
  $acuerdo = $datos[4];
  $interes = $datos[5];
  $fecha = $datos[6];
  $fechaEmicion = $datos[7];



  $adminAutos = new AdministradorAutos();
  $adminUsuarios = new administradorUsuarios();
  $adminClientes = new AdministradorClientesBanca();
  $vendedor = $adminUsuarios->dameUsuarioId($vendedorID);
  $auto = $adminAutos->dameAuto($autoId);
  $cliente = $adminClientes->dameCliente($clienteId);

  function formatearFecha($fecha)
  {
    $fecha = explode("-", $fecha);
    $fecha = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];
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
              <p class="tm_invoice_date tm_m0">Fecha: <b class="tm_primary_color"><?php echo formatearFecha($fechaEmicion); ?></b></p>
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

            <div class="tm_invoice_right tm_text_right" >

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
        
          $lista = [];
          $subTotal = 0;
          $interesTotal = 0;
          $total = 0;
          $pagoPorEvento = $monto / $acuerdo;
          $fechaOriginal = $fechaEmicion;
          $monto_original = $monto;
          $num_pago = 1;
          for($i = 0; $i< intval($acuerdo); $i++){
              $fecha = strtotime ( '+'.$i.' month' , strtotime ( $fechaOriginal ) ) ;
              $fecha = date ( 'Y-m-d' , $fecha );
              $montoAcumulado = $pagoPorEvento * ($i + 1);
              //echo $fecha . "<br>";
              $comision = $monto_original * ($interes / 100);
              $monto_original = $monto_original - $pagoPorEvento;
              $num_pago++;
              $lista[] = array("cantidad" => $pagoPorEvento, "interes" => $comision, "total" => ($pagoPorEvento + $comision), "fecha" => $fecha);
          }
    


          ?>
          <h2>Información del auto </h2><br>
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

          <?php 
          $hoy = date("Y-m-d");
          $fechaMasUnaSemana = strtotime ( '+1 week' , strtotime ( $fechaEmicion ) ) ;
          
          if($fechaMasUnaSemana < $hoy){
            echo "<h2>Este corrido se acabo :( </h2>";
          }else{

          ?>

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
                      echo "<td class='tm_width_1'>" . formatearFecha($lista[$i]['fecha']) . "</td>";
                      echo "</tr>";
                      $subTotal += $lista[$i]['cantidad'];
                      $interesTotal += $lista[$i]['interes'];
                      $total += $lista[$i]['total'];
                    }

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
          <p>ESTA CORRIDA NO ES UN CONTRATO, ESTE AUTO ESTA SUJETO A VENTA PARA CUALQUIER OTRO CLIENTE EN CUALQUIER MOMENTO</p>
          <?php }?>
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
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jspdf.min.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function enviarCorrida(){
      //enviar con fetch 
    }
  </script>
</body>

</html>