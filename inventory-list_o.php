<!DOCTYPE html>
<html lang="es">

<?php
header('Content-Type: text/html; charset=UTF-8');

include 'template/head.php';
?>
<script src="https://cdn.tailwindcss.com"></script>

<body class="page">

  <?php include 'template/header.php'; ?>

  <?php
  include_once('admin/api/adminAutos.php');
  $adminAutos = new AdministradorAutos();
  if (isset($_GET['marca'])  && isset($_GET['modelo']) &&  isset($_GET['estatus']) && isset($_GET['transmicion']) && isset($_GET['combustible'])) {
    $autos = $adminAutos->dameAutosBusqueda($_GET['marca'], $_GET['modelo'], $_GET['estatus'], $_GET['transmicion'], $_GET['combustible']);
  } elseif (isset($_GET['min']) && isset($_GET['max'])) {
    $autos = $adminAutos->dameAutosPorPrecio($_GET['min'], $_GET['max']);
  } else if (isset($_GET['marca'])) {
    $autos = $adminAutos->dameAutosMarca($_GET['marca']);
  } else if (isset($_GET['buscar'])) {
    $autos = $adminAutos->dameAutosBuscados($_GET['buscar']);
  } else if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $autos = $adminAutos->dameAutosPaginacion($_GET['pagina']);
  } else if (isset($_GET['amin']) && isset($_GET['amax'])) {
    $autos = $adminAutos->dameAutosPorAnio($_GET['amin'], $_GET['amax']);
  } else {
    $pagina = 1;
    $autos = $adminAutos->dameAutosPaginacion(1);
  }
  ?>
  <!-- end .header-->
  <style>
    .range_container {
      display: flex;
      flex-direction: column;
      width: 80%;
      margin: 35% auto;
    }

    .sliders_control {
      position: relative;
      min-height: 50px;
    }

    .form_control {
      position: relative;
      display: flex;
      justify-content: space-between;
      font-size: 24px;
      color: #635a5a;
    }

    input[type=range]::-webkit-slider-thumb {
      -webkit-appearance: none;
      pointer-events: all;
      width: 24px;
      height: 24px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 0 0 1px red;
      cursor: pointer;
    }

    input[type=range]::-moz-range-thumb {
      -webkit-appearance: none;
      pointer-events: all;
      width: 24px;
      height: 24px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 0 0 1px red;
      cursor: pointer;
    }

    input[type=range]::-webkit-slider-thumb:hover {
      background: #f7f7f7;
    }

    input[type=range]::-webkit-slider-thumb:active {
      box-shadow: inset 0 0 3px red, 0 0 9px red;
      -webkit-box-shadow: inset 0 0 3px red, 0 0 9px red;
    }

    input[type="number"] {
      color: #8a8383;
      width: 50px;
      height: 30px;
      font-size: 20px;
      border: none;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      opacity: 1;
    }

    input[type="range"] {
      -webkit-appearance: none;
      appearance: none;
      height: 2px;
      width: 100%;
      position: absolute;
      background-color: red;
      pointer-events: none;
    }

    #fromSlider {
      height: 0;
      z-index: 1;
    }
  </style>
  <div class="section-title-page area-bg area-bg_dark area-bg_op_60">
    <div class="area-bg__inner">
      <div class="container">
        <div class="row">
          <div class="col offset-lg-3">
            <div class="b-title-page__wrap">
              <h1 class="b-title-page">Lista De vehículos</h1>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Inventario</li>
                </ol>
                <!-- end breadcrumb-->
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end .b-title-page-->
  <div class="l-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <aside class="l-sidebar">
            <div class="widget section-sidebar bg-light">
              <h3 class="widget-title bg-dark"><i class="ic flaticon-car-4"></i>Buscar Un Coche</h3>
              <div class="mt-3"></div>
              <form action="" method="GET">
                <div class="form-group">
                  <div class="b-filter-slider__title">¿Que auto buscas?</div>
                  <input type="text" name="buscar" class="form-control" placeholder="Auto, Modelo, transmisión etc...">
                </div>
                <div class="form-group d-flex justify-content-center mb-2">
                  <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
              </form>

              <form method="GET">
                <?php
                $adminAutosBuscarPrecio = new AdministradorAutos();
                $min = $adminAutosBuscarPrecio->dameMenorPrecio();
                $max = $adminAutosBuscarPrecio->dameMaximoPrecio();
                $minAnio = $adminAutosBuscarPrecio->dameAnioMasBajo();
                $maxAnio = $adminAutosBuscarPrecio->dameAnioMasAlto();
                //limpiar comas 
                $min = str_replace(',', '', $min);
                $max = str_replace(',', '', $max);
                $minAnio = str_replace(',', '', $minAnio);
                $maxAnio = str_replace(',', '', $maxAnio);
                ?>
                <div class="b-filter-slider ui-filter-slider">
                  <div class="b-filter-slider__title">Buscar Por Precio</div>
                  <div class="b-filter-slider__main">
                    <div id="filterPrice"></div>
                    <div class="b-filter__row row">
                      <div class="b-filter__item col-md-6 col-lg-12 col-xl-6" style="display: flex; align-items: center; font-weight: bold; font-size: 20px;">
                        $
                        <input class="ui-select d-none" name="min" id="input-with-keypress-0" />
                        <input class="ui-select" type="text" id="inner-min-inventory" readonly value="<?php echo number_format($min) ?>" />
                      </div>
                      <div class="b-filter__item col-md-6 col-lg-12 col-xl-6" style="display: flex; align-items: center; font-weight: bold; font-size: 20px;">
                        $
                        <input class="ui-select d-none" name="max" id="input-with-keypress-1" />
                        <input class="ui-select" type="text" id="inner-max-inventory" readonly value="<?php echo number_format($max) ?>" />
                      </div>
                    </div>
                    <div class="form-group d-flex justify-content-center mb-2">
                      <button type="submit" class="btn btn-primary">Ver Resultado</button>
                    </div>
                  </div>
                </div>
              </form>


              <div class="b-filter-slider ui-filter-slider">
                <div class="b-filter-slider__title">Buscar Por año</div>
                <div class="b-filter-slider__main">
                  <div id="filterPrice"></div>


                  <div class="range_container" style="height: 60px;">
                    <div class="sliders_control">
                      <input id="fromSlider" type="range" value="<?php echo ($minAnio) ?>" min="<?php echo ($minAnio) ?>" max="<?php echo ($maxAnio) ?>" />
                      <input id="toSlider" type="range" value="<?php echo ($maxAnio) ?>" min="<?php echo ($minAnio) ?>" max="<?php echo ($maxAnio) ?>" />
                    </div>
                    <div class="form_control">
                      <div class="form_control_container">
                        <div class="form_control_container__time">Del año</div>
                        <input class="form_control_container__time__input" style="width: 100px;" type="number" id="fromInput" value="<?php echo ($minAnio) ?>" min="0" max="<?php echo ($maxAnio) ?>" />
                      </div>
                      <div class="form_control_container">
                        <div class="form_control_container__time">Al año</div>
                        <input class="form_control_container__time__input" style="width: 100px;" type="number" id="toInput" value="<?php echo ($maxAnio) ?>" min="0" max="<?php echo ($maxAnio) ?>" />
                      </div>
                    </div>
                  </div>


                  <div class="form-group d-flex justify-content-center mb-2">
                    <button type="button" onclick="buscarAnios()" class="btn btn-primary">Ver Resultado</button>
                  </div>
                </div>
              </div>








              <div class="mb-4"></div>
            </div>
            <!-- Car Hunter -->
            <!-- <form>
              <div class="form-group">
                <div class="b-filter-slider__title">Car Hunter</div>
                <img src="Imagenes/carHunter/carhunter.jpg" class="img-fluid" alt="" style="width: auto; height:auto">
              </div>
              <div class="form-group d-flex justify-content-center mb-2">
                <a href="car-hunter.php" class="btn btn-primary">Buscar</a>
              </div>
            </form> -->
          </aside>

          <aside class="l-sidebar">
            <div class="widget section-sidebar bg-light">
              <h3 class="widget-title bg-dark"><i class="ic flaticon-car-4"></i>CAR HUNTER</h3>
              <div class="mt-3"></div>

              <!-- Car Hunter -->
              <div class="b-filter-slider__title">Encuentra el vehiculo que estas buscando</div>
              <div class="d-flex justify-content-center">
                <img class="img-fluid" src="Imagenes/carHunter/carhunter-logo1.png" alt="car hunter" width="200" height="290">
              </div>
              <form>
                <div class="form-group">
                </div>
                <div class="form-group d-flex justify-content-center mb-2">
                  <a href="car-hunter.php" class="btn btn-primary">Buscar</a>
                </div>
              </form>
          </aside>
        </div>
        <div class="col-lg-9">
          <div class="b-filter-goods">
            <div class="row justify-content-between align-items-center">
              <div class="b-filter-goods__info col-auto">
                <?php
                if (count($autos) <= 1) {
                  echo 'Se Encontraro<strong> ' . count($autos) . '</strong> Resultado En Total<strong></strong>';
                } else {
                  echo 'Se Encontraron<strong> ' . count($autos) . '</strong> Resultados En Total<strong></strong>';
                };
                ?>
              </div>
              <div class="btns-switch col-auto"><i class="btns-switch__item js-view-list active ic fa fa-th-list"></i><i class="btns-switch__item js-view-th ic fa fa-th"></i></div>
            </div>
          </div>
          <!-- end .b-filter-goods-->
          <main class="b-goods-group row">
            <?php

            function limpiaCaracteresEspeciales($cadena)
            {
              $cadena = str_replace('á', 'a', $cadena);
              $cadena = str_replace('é', 'e', $cadena);
              $cadena = str_replace('í', 'i', $cadena);
              $cadena = str_replace('ó', 'o', $cadena);
              $cadena = str_replace('ú', 'u', $cadena);
              $cadena = str_replace('Á', 'A', $cadena);
              $cadena = str_replace('É', 'E', $cadena);
              $cadena = str_replace('Í', 'I', $cadena);
              $cadena = str_replace('Ó', 'O', $cadena);
              $cadena = str_replace('Ú', 'U', $cadena);
              $cadena = str_replace('ñ', 'n', $cadena);
              $cadena = str_replace('Ñ', 'N', $cadena);
              $cadena = str_replace('´', '', $cadena);
              $cadena = str_replace('¨', '', $cadena);
              $cadena = str_replace('º', '', $cadena);
              $cadena = str_replace('ª', '', $cadena);
              $cadena = str_replace('·', '', $cadena);
              $cadena = str_replace(' ', '-', $cadena);
              $cadena = str_replace('', '', $cadena);
              $cadena = str_replace('Â', '', $cadena);
              
              
              return $cadena;
            }


            foreach ($autos as $auto) {
              if (strlen($auto->descripcion) > 64) {
                $descripcionLimitada = substr($auto->descripcion, 0, 65);
              } else {
                $descripcionLimitada = $auto->descripcion;
              }
              if (!$auto->pausado) {
                echo '
                <div class="b-goods-f col-12 b-goods-f_row">
                ';
                if (strlen($auto->imagen)) {
                  echo '<div class="b-goods-f__media"><a href="vehicle-details.php?auto=' . $auto->id . '"><img class="b-goods-f__img img-scale img-fluid" src="' . $auto->imagen . '" alt="foto" /><span class="b-goods-f__media-inner"><span class="b-goods-f__favorite"><i class="ic far fa-eye"></i></span></span></a></div>
                  ';
                } else {
                  echo '<div class="b-goods-f__media"><a href="vehicle-details.php?auto=' . $auto->id . '"><img class="b-goods-f__img img-scale img-fluid" src="' . $auto->imagenes[0]->url . '" alt="foto" /><span class="b-goods-f__media-inner"><span class="b-goods-f__favorite"><i class="ic far fa-eye"></i></span></span></a></div>
                  ';
                }
                echo '
                <div class="b-goods-f__main">
                  <div class="b-goods-f__descrip">
                    <div class="b-goods-f__title"><a href="vehicle-details.php?auto=' . $auto->id . '">' . strtoupper($auto->marca->marca) . ' ' . $auto->modelo->modelo . '</a></div>
                    <div class="b-goods-f__info">
                    ' . limpiaCaracteresEspeciales($descripcionLimitada) . '
                    ...<a href="vehicle-details.php?auto=' . $auto->id . '"> Ver Mas</a></div>
                    <ul class="b-goods-f__list list-unstyled">
                    ';

                if ($auto->kilometragePermitido) {
                  echo '<li class="b-goods-f__list-item"><span class="b-goods-f__list-title">Kilometraje :</span><span class="b-goods-f__list-info">' . $auto->kilometrage . 'km</span></li>';
                }



                echo '
                      <li class="b-goods-f__list-item"><span class="b-goods-f__list-title">Modelo :</span><span class="b-goods-f__list-info">' . $auto->anio . '</span></li>
                      <li class="b-goods-f__list-item"><span class="b-goods-f__list-title">Transmisión :</span><span class="b-goods-f__list-info">' . $auto->transmicion->transmicion . '</span></li>
                      <li class="b-goods-f__list-item"><span class="b-goods-f__list-title">Combustible :</span><span class="b-goods-f__list-info">' . $auto->combustible . '</span></li>
                      <li class="b-goods-f__list-item b-goods-f__list-item_row"><span class="b-goods-f__list-title">Color :</span><span class="b-goods-f__list-info">' . $auto->color . '</span></li>
                    </ul>
                  </div>
                  ';
                if ($auto->precio) {

                  echo ' <div class="b-goods-f__sidebar"><span class="b-goods-f__price-group"><span class="b-goods-f__price"><span class="b-goods-f__price_col">msrp:&nbsp;</span><span class="b-goods-f__price-numb">$' . number_format($auto->precio) . '</span></span></span></div>';
                }

                echo '
                </div>
              </div>
                ';
              }
            } ?>

            <!-- end .b-goods-->
          </main>

          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <?php
              if (!isset($_GET['marca'])) {
                $total_paginas = ceil($adminAutos->cuentaAutos() / 6) - 2;
                $maximo_botones = 5;
                if ($total_paginas > 0) {
                  if ($pagina > 1) {
                    echo '<li class="page-item"><a class="page-link" href="inventory-list.php?pagina=1"><<</a></li>' . "\n";
                    echo '<li class="page-item"><a class="page-link" href="inventory-list.php?pagina=' . ($pagina - 1) . '"><</a></li>';
                  }

                  $inicio = max(1, min($pagina - floor($maximo_botones / 2), $total_paginas - $maximo_botones + 1));
                  $fin = min($inicio + $maximo_botones - 1, $total_paginas);
                  // Mostrar solo cinco botones de números
                  for ($i = $inicio; $i <= $fin; $i++) {
                    if ($i == $pagina) {
                      echo '<li class="page-item active"><a class="page-link" href="inventory-list.php?pagina=' . $i . '">' . $i . '</a></li>';
                    } else {
                      echo '<li class="page-item"><a class="page-link" href="inventory-list.php?pagina=' . $i . '">' . $i . '</a></li>';
                    }
                  }

                  if ($pagina < $total_paginas - 2) {
                    echo '<li class="page-item"><a class="page-link" href="inventory-list.php?pagina=' . ($pagina + 1) . '">></a></li>' . "\n";
                    //echo '<li class="page-item"><a class="page-link" href="inventory-list.php?pagina=' . $total_paginas . '">>></a></li>';
                  }
                }
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- .footer start-->
  <?php include 'template/footer.php'; ?>
  <!-- .footer end-->
  </div>
  </div>
  <!-- end layout-theme-->


  <!-- ++++++++++++-->
  <!-- MAIN SCRIPTS-->
  <!-- ++++++++++++-->
  <?php include 'template/js-import.php'; ?>
  <!-- Media Query JS-->
  <script>
    const element = document.getElementsByClassName('mediaQInventory');

    function mediaQuery(x) {
      if (x.matches) { // If media query matches
        // add class to the elements 
        for (let i = 0; i < element.length; i++) {
          element[i].classList.add('img-fluid');
          // remove width and height attributes
          element[i].style.width = '';
          element[i].style.height = '';
        }
      } else {
        // remove class from the elements 
        for (let i = 0; i < element.length; i++) {
          element[i].classList.remove('img-fluid');
          // set width and height attributes
          element[i].style.width = '360px';
          element[i].style.height = '260px';
        }
      }
    }

    var x = window.matchMedia("(max-width: 1200px)")
    mediaQuery(x) // Call listener function at run time
    x.addListener(mediaQuery) // Attach listener function on state changes
  </script>
  <script>
    // Selector de marcas para obtener los modelos
    function changeMarca() {
      let id = document.getElementById("select-marca").value;
      let datosDeInicio = new FormData();
      datosDeInicio.append("accion", "verModelos");
      datosDeInicio.append("id", id);
      fetch("admin/api/apiEditor.php", {
          method: "POST",
          body: datosDeInicio,
        })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          if (data.length > 0) {
            let selectModelo = document.getElementById("select-modelo");
            selectModelo.innerHTML = "";
            data.forEach(element => {
              selectModelo.innerHTML += '<option value="' + element.id + '">' + element.modelo +
                '</option>';
            });
          } else {
            let selectModelo = document.getElementById("select-modelo");
            selectModelo.innerHTML = '<option>No hay modelos</option>';
          }
        })
        .catch((error) => console.error(error));
    }
  </script>


  <script>
    function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
      const [from, to] = getParsed(fromInput, toInput);
      fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
      if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
      } else {
        fromSlider.value = from;
      }
    }

    function controlToInput(toSlider, fromInput, toInput, controlSlider) {
      const [from, to] = getParsed(fromInput, toInput);
      fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
      setToggleAccessible(toInput);
      if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
      } else {
        toInput.value = from;
      }
    }

    function controlFromSlider(fromSlider, toSlider, fromInput) {
      const [from, to] = getParsed(fromSlider, toSlider);
      fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
      if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
      } else {
        fromInput.value = from;
      }
    }

    function controlToSlider(fromSlider, toSlider, toInput) {
      const [from, to] = getParsed(fromSlider, toSlider);
      fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
      setToggleAccessible(toSlider);
      if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
      } else {
        toInput.value = from;
        toSlider.value = from;
      }
    }

    function getParsed(currentFrom, currentTo) {
      const from = parseInt(currentFrom.value, 10);
      const to = parseInt(currentTo.value, 10);
      return [from, to];
    }

    function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
      const rangeDistance = to.max - to.min;
      const fromPosition = from.value - to.min;
      const toPosition = to.value - to.min;
      controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} 100%)`;
    }

    function setToggleAccessible(currentTarget) {
      const toSlider = document.querySelector('#toSlider');
      if (Number(currentTarget.value) <= 0) {
        toSlider.style.zIndex = 2;
      } else {
        toSlider.style.zIndex = 0;
      }
    }

    const fromSlider = document.querySelector('#fromSlider');
    const toSlider = document.querySelector('#toSlider');
    const fromInput = document.querySelector('#fromInput');
    const toInput = document.querySelector('#toInput');
    fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
    setToggleAccessible(toSlider);

    fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
    toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
    fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
    toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);
  </script>

  <script>
    function buscarAnios() {
      let min = document.getElementById("fromInput").value;
      let max = document.getElementById("toInput").value;
      window.location.href = "inventory-list.php?amin=" + min + "&amax=" + max;
    }
  </script>
</body>

</html>