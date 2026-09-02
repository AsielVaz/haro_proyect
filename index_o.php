<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Seminuevos haro</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="nuevo/assets/css/master.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!--[if lt IE 9 ]>
<script src="/nuevo/assets/js/separate-js/html5shiv-3.7.2.min.js" type="text/javascript"></script><meta content="no" http-equiv="imagetoolbar">
<![endif]-->
</head>


<?php
header('Content-Type: text/html; charset=UTF-8');

include_once 'template/head.php';
include_once("admin/api/adminAutos.php");
include_once("admin/api/adminEditor.php");
$adminEditor = new AdministradorEditor();
$adminAutos = new AdministradorAutos();
$ultimos = $adminAutos->dameUltimosAutos();
$marcas = $adminEditor->dameMarcas();
$autosTodos = $adminAutos->dameAutos();

?>

<body class="page">

    <?php include_once 'template/header.php'; ?>
    <!-- end .header-->
    <div class="main-slider slider-pro" id="main-slider" data-slider-width="100%" data-slider-height="700px" data-slider-arrows="false" data-slider-buttons="false">
        <div class="sp-slides">
            <!-- Slide 1-->


            <?php

            if (count($ultimos) > 0) {
                echo '
                        <div class="main-slider slider-pro" id="main-slider" data-slider-width="100%" data-slider-height="700px" data-slider-arrows="true" data-slider-buttons="false">
                        <div class="sp-slides">
                        ';


                foreach ($ultimos as $autos) {
                    if (!$auto->pausado) {
                        if (strlen($autos->imagen)) {
                            echo '<div class="main-slider__slide sp-slide"><img class="sp-image" style="height: 700px !important; width: 1900px !important; object-fit:cover !important;"  src="' . $autos->imagen . '" alt="slider" />';
                        } else {
                            echo '<div class="main-slider__slide sp-slide"><img class="sp-image" style="height: 700px !important; width: 1900px !important;  object-fit:cover !important;"  src="' . $autos->imagenes[0]->url . '" alt="slider" />';
                        }
                        echo '
                        
                            <div class="sp-layer" data-width="100%" data-show-transition="left" data-hide-transition="left" data-show-duration="800" data-show-delay="400" data-hide-delay="400">
                                <div class="main-slider__wrap">
                                    <div class="main-slider__slogan">Aprovecha</div>
                                    <div class="main-slider__title">' . strtoupper($autos->marca->marca) . '<span class="main-slider__title_lg text-right">' . $autos->modelo->modelo . '<span class="main-slider__title"></span></span>
                                    </div>
                                    <div class="text-center">
                                        <div class="main-slider__price"><span class="main-slider__price_up">$</span>' . number_format($autos->precio) . '<span class="main-slider__price_down">.00</span><span class="main-slider__price_info">
                                        </span></div>
                                    </div>
                                    <div class="text-right"><a class="main-slider__link" href="vehicle-details.php?auto=' . $autos->id . '">Ver Más</a></div>
                                </div>
                            </div>
                        </div>';
                    }
                    
                }

                echo '
                            </div>
                            </div>
                            ';
            } else {

                echo '
                            <div class="main-slider slider-pro" id="main-slider" data-slider-width="100%" data-slider-height="700px" data-slider-arrows="false" data-slider-buttons="false">
                            <div class="sp-slides">
                                <!-- Slide 1-->
                                <div class="main-slider__slide sp-slide"><img class="sp-image" src="nuevo/assets/media/content/b-main-slider/bg-1.jpg" alt="slider" />
                                    <div class="sp-layer" data-width="100%" data-show-transition="left" data-hide-transition="left" data-show-duration="800" data-show-delay="400" data-hide-delay="400">
                                        <div class="main-slider__wrap">
                                            <div class="main-slider__slogan">Expertos en Ventas de autos</div>
                                            <div class="main-slider__title">HARO<span class="main-slider__title_lg text-right">SEMI NUEVOS<span class="main-slider__title"></span></span>
                                            </div>
                                            <div class="text-center">
                                            </div>
                                            <div class="text-right"><a class="main-slider__link" href="inventory-list.php">Ver nuestro catalogo</a></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Slide 2-->
                                <div class="main-slider__slide-2 sp-slide"><img class="sp-image" src="nuevo/assets/media/content/b-main-slider/bg-2.jpg" alt="slider" />
                                    <div class="sp-layer" data-width="100%" data-show-transition="left" data-hide-transition="left" data-show-duration="800" data-show-delay="400" data-hide-delay="400">
                                        <div class="main-slider__wrap">
                                            <div class="main-slider__slogan">Vende Con nosotros</div>
                                            <div class="main-slider__title">Haro
                                                <br>Semi Nuevos</div>
                                            <div class="text-right"><a class="main-slider__link" href="contacts.php">Contactanos</a></div>
                                        </div>
                                    </div>
                                    <div class="sp-layer" data-width="100%" data-show-transition="left" data-hide-transition="left" data-show-duration="1500" data-show-delay="800" data-hide-delay="400"><img class="main-slider__figure-1 img-fluid" src="nuevo/assets/media/content/b-main-slider/bg-2_item-1.png" alt="foto" /></div>
                                    <div class="sp-layer" data-width="100%" data-show-transition="right" data-hide-transition="right" data-show-duration="2000" data-show-delay="1200" data-hide-delay="400"><img class="main-slider__figure-2 img-fluid" src="nuevo/assets/media/content/b-main-slider/bg-2_item-2.png" alt="foto" /></div>
                                </div>
                            </div>
                        </div>
                    
                    ';
            }

            ?>

        </div>
    </div>

    <!-- end .main-slider-->


    <section class="carousel-marcas">
        <div class="section-carousel__inner">
            <div class="js-slider"
                data-slick="{&quot;slidesToShow&quot;: 5,  &quot;slidesToScroll&quot;: 5, &quot;infinite&quot;: true, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 1800, &quot;settings&quot;: {&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}}, {&quot;breakpoint&quot;: 1400, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 1040, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 767, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1}}]}">
                <?php
                foreach ($marcas as $mar) {
                    if ($mar->autos > 0) {
                        echo '
                        <div  style="width: 189px; height: 131px; object-fit:cover;">
                            <div class="b-goods-f__media margin-marca" >
                                <a href="inventory-list.php?marca=' . $mar->id . '"><img style="width: 189px; height: 131px; object-fit:contain;" src="' . $mar->imagen . '" alt="foto" /></a>
                            </div>
                        </div>';
                    }
                }

                ?>
            </div>
        </div>
    </section>
    <!-- <div class="range-slider">
        <div class="range-group">
            <input class="range-input" id="location-range-slider" value="1" min="1" max="4" type="range" />
        </div>
    </div> -->

    <!-- With number fields -->
    <section>
        <div class="container-fluid range-slider-wrapp">
            <?php
            $adminAutosBuscarPrecio = new AdministradorAutos();
            $signoPeso = '$';
            $min = $adminAutosBuscarPrecio->dameMenorPrecio();
            $max = $adminAutosBuscarPrecio->dameMaximoPrecio();

            ?>
            <div class="bg-light">
                <h3 class="widget-title bg-dark"><i class="ic flaticon-car-4"></i>Buscar Un vehiculo por precio</h3>
                <div class="mb-3"></div>
                <form method="get" action="inventory-list.php">
                    <div id="rangeSlider" class="range-slider">
                        <div class="number-group">
                            $
                            <input class="number-input d-none" type="number" value="<?php echo $min ?>"
                                min="<?php echo $min ?>" max="<?php echo $max ?>" />
                            <input class="number-input" id="inner-min" type="text" readonly
                                value="<?php echo number_format($min) ?>" />
                            $
                            <input class="number-input d-none" type="number" value="<?php echo $max ?>"
                                min="<?php echo $min ?>" max="<?php echo $max ?>" />
                            <input class="number-input" id="inner-max" type="text" readonly
                                value="<?php echo number_format($max) ?>" />

                        </div>
                        <div class="range-group">
                            <input class="range-input" name="min" value="<?php echo $min ?>" min="<?php echo $min ?>"
                                max="<?php echo $max ?>" step="1" type="range" />
                            <input class="range-input" name="max" value="<?php echo $max ?>" min="<?php echo $min ?>"
                                max="<?php echo $max ?>" step="1" type="range" />
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-center mb-2">
                        <button type="submit" class="btn btn-primary">Ver Resultado</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- end .b-find-->
    <section class="b-welcome section-default">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="ui-title-slogan">TE AYUDA A ENCONTRAR TU PRÓXIMO COCHE FÁCILMENTE</div>
                    <h2 class="ui-title">Bienvenido A<span class="text-primary"> Haro Seminuevos</span></h2>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed eiusmod tempor incididu et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ull laboris aliquip ex ea commodo consequat. Duis aute irure dolorin reprehenderits volupta velit dolore fugiat nulla pariatur excepteur sint occaecat cupidatat.</p>
                    <p>Non proident sunt ind culpa qudesa officia deserunt mollit anim est laborum. Sed per unde omnis iste natus error sit voluptatem accusantium doloremque laudantium tom eaque ipsa quae ab illo inventore veritatis architecto.</p> -->
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <ul class="b-welcome-list list-unstyled d-sm-flex justify-content-around">
                        <li class="b-welcome-list__item flex-fill"><i class="ic flaticon-car"></i>
                            Autos de primera calidad

                        </li>
                        <li class="b-welcome-list__item flex-fill"><i class="ic flaticon-gearbox"></i>Seguridad y comodidad garantizadas

                        </li>
                        <li class="b-welcome-list__item flex-fill"><i class="ic flaticon-wrench"></i>Autos de lujo y modelos exclusivos

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end .b-welcome-->
    <section class="section-carousel">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ui-title-slogan">Encuentra tu auto ideal</div>
                    <h2 class="ui-title">Nuestros<span class="text-primary"> Vehículos</span></h2>
                </div>
            </div>
        </div>
        <div class="section-carousel__inner bg-dark">
            <div class="js-slider"
                data-slick="{&quot;slidesToShow&quot;: 5,  &quot;slidesToScroll&quot;: 5, &quot;infinite&quot;: true, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 1800, &quot;settings&quot;: {&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}}, {&quot;breakpoint&quot;: 1400, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 1040, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 767, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1}}]}">
                <?php
                $autosTodos = $adminAutos->dameAutosSinPausar();
                foreach ($autosTodos as $autos) {

                    if (!$auto->pausado) {
                        echo '
                <div class="b-goods-f b-goods-f_mod-a">
                    <div class="b-goods-f__media">
                    ';

                        if (strlen($autos->imagen)) {
                            echo ' <a href="vehicle-details.php?auto=' . $autos->id . '"><img  style="width: 375px; height: 300px; object-fit:cover;" src="' . $autos->imagen . '" alt="foto" /></a>';
                        } else {
                            echo ' <a href="vehicle-details.php?auto=' . $autos->id . '"><img  style="width: 375px; height: 300px; object-fit:cover;" src="' . $autos->imagenes[0]->url . '" alt="foto" /></a>';
                        }


                        echo '
                    </div>
                    <div class="b-goods-f__main">
                        <div class="b-goods-f__descrip">
                            <div class="b-goods-f__title"><span>' . strtoupper($autos->marca->marca) . " " . strtoupper($autos->modelo->modelo) . '</span></div>
                            <ul class="b-goods-f__list list-unstyled">
                                <li class="b-goods-f__list-item"><i class="ic flaticon-fuel"></i>' . $autos->combustible . '</li>
                                <li class="b-goods-f__list-item"><i class="ic flaticon-car-1"></i>Año: ' . $autos->anio . '</li>
                                <li class="b-goods-f__list-item"><i class="ic flaticon-gearshift"></i>' . $autos->transmicion->transmicion . '</li>
                            </ul>
                        </div>
                        <div class="b-goods-f__sidebar"><span class="b-goods-f__price-group"><span class="b-goods-f__price bg-primary"><span class="b-goods-f__price-numb">$45,800</span></span>
                            </span>
                        </div>
                    </div>
                </div>';
                    }
                }

                ?>


                <!-- end .b-goods-->

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12"><a class="section-carousel__btn btn btn-primary" href="inventory-list.php"><i
                                class="ic icon-list"></i> Ver Todos Los Vehículos</a></div>
                </div>
            </div>
        </div>
    </section>

    <!-- end .b-services-->
    <section class="b-bnr bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="b-bnr__main">
                        <h2 class="b-bnr__title">¿Quieres vender tu auto?</h2>
                        <div class="b-bnr__info">Te ofrecemos el mejor precio para tu auto. Házlo con nosotros!!</div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="b-bnr__second"><a class="btn btn-primary" href="contacts.php">Contactanos</a>
                        <div class="b-bnr-contacts">
                            <div class="b-bnr-contacts__info">
                                Contáctanos</div><a class="b-bnr-contacts__phone"
                                href="https://api.whatsapp.com/send?phone=523336368433"><i
                                    class="ic icon-call-end text-primary"></i>33 38 08 29 13</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end .b-bnr-->
    <div class="section-progress">
        <div class="container">
            <ul class="b-progress-list row list-unstyled">
                <li class="b-progress-list__item col-md-3">

                </li>
                <li class="b-progress-list__item col-md-3">
                    <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Vehículos en
                            línea</span><span class="b-progress-list__percent js-chart"
                            data-percent="<?php echo $adminAutos->cuentaAutos() ?>"><span
                                class="js-percent"></span></span>
                    </div>
                </li>

                <li class="b-progress-list__item col-md-3">
                    <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Clientes
                            Satisfechos</span><span class="b-progress-list__percent js-chart"
                            data-percent="<?php echo $adminAutos->cuentaAutosHistorico() + 2400 ?>"><span
                                class="js-percent"></span></span>
                    </div>
                </li>
                <li class="b-progress-list__item col-md-3">

                </li>
            </ul>
        </div>
    </div>
    <!-- end .b-progress-->
    <section class="b-isotope section-default">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="ui-title-slogan">Te Ayudamos a encontrar tu auto perfecto</div>
                    <h2 class="ui-title">Nuestros Vehículos<span class="text-primary"> Haro Seminuevos</span></h2>
                    <ul class="b-isotope-filter list-unstyled">

                        <?php

                        foreach ($marcas as $marcas) {
                            if ($marcas->autos > 0) {
                                echo '<li><a href="" data-filter=".' . $marcas->id . '">' . strtoupper($marcas->marca) . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <ul class="b-isotope-grid grid list-unstyled row">
                <li class="grid-sizer col-lg-4 col-md-6"></li>
                <?php

                foreach ($autosTodos as $aut) {
                    if (!$aut->pausado) {
                        echo '
                <li class="b-isotope-grid__item grid-item col-lg-4 col-md-6 web ' . $aut->marca->id . '">
                    <div class="b-goods-f b-goods-f_dark">
                        <div class="b-goods-f__media">
                        ';

                        if (strlen($aut->imagen)) {
                            echo '                            <a href="vehicle-details.php?auto=' . $aut->id . '"><img class="mediaQ" style="width: 360px; height: 260px; object-fit:cover;"  src="' . $aut->imagen . '" alt="foto" /></a>
                            ';
                        } else {
                            echo '                            <a href="vehicle-details.php?auto=' . $aut->id . '"><img class="mediaQ" style="width: 360px; height: 260px; object-fit:cover;"  src="' . $aut->imagenes[0]->url . '" alt="foto" /></a>
                            ';
                        }


                        echo '
                        </div>
                        <div class="b-goods-f__main">
                            <div class="b-goods-f__descrip">
                                <div class="b-goods-f__title" style="height: 80px !important;"><span>' . strtoupper($aut->marca->marca) . " " . strtoupper($aut->modelo->modelo) . '</span>
                                </div>
                                <div class="b-goods-f__info">Magna aliqua enim aduas veniam quis nostrud exercitation ullam laboris aliquip.</div>
                                <ul class="b-goods-f__list list-unstyled">
                                    <li class="b-goods-f__list-item"><span class="b-goods-f__list-info">' . $aut->anio . '</span></li>
                                    <li class="b-goods-f__list-item"><span class="b-goods-f__list-info">' . $aut->transmicion->transmicion . '</span></li>
                                    <li class="b-goods-f__list-item"><span class="b-goods-f__list-info">' . $aut->combustible . '</span></li>
                                  
                                </ul>
                            </div>
                            ';
                        if ($aut->precio) {
                            echo '<div class="b-goods-f__sidebar"><span class="b-goods-f__price-group"><span class="b-goods-f__price"><span class="b-goods-f__price-numb">$' . number_format($aut->precio) . '</span></span>
                            </span>
                        </div>';
                        } else {
                            echo '<div class="b-goods-f__sidebar"><span class="b-goods-f__price-group"><span class="b-goods-f__price"><span class="b-goods-f__price-numb"><a href="vehicle-details.php?auto=' . $aut->id . '">Ver Ahora</a></span></span>
                            </span>
                        </div>';
                        }


                        echo '
                        </div>
                    </div>
                    <!-- end .b-goods-->
                </li>';
                    }
                }

                ?>

            </ul>
        </div>
    </section>

    <!-- .footer end-->
    <?php include 'template/footer.php'; ?>
    </div>
    </div>
    <!-- end layout-theme-->


    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <!-- MEDIA QUERY -->
    <script>
        var mq = window.matchMedia("(max-width: 512px)");
        mq.addListener(WidthChange);
        const dNone = document.getElementsByClassName('d-none-mobile');
        WidthChange(mq);

        function WidthChange(mq) {
            if (mq.matches) {
                // display none
                for (let i = 0; i < dNone.length; i++) {
                    dNone[i].style.display = 'none';
                }
            } else {
                // display 
                for (let i = 0; i < dNone.length; i++) {
                    dNone[i].style.display = 'block';
                }
            }
        }
    </script>
    <script>
        const element = document.getElementsByClassName('mediaQ');

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
    <!-- Range Slider -->
    <script>
        (function() {

            var parent = document.querySelector("#rangeSlider");
            if (!parent) return;

            var
                rangeS = parent.querySelectorAll("input[type=range]"),
                numberS = parent.querySelectorAll("input[type=number]"),
                innerMin = document.getElementById("inner-min"),
                innerMax = document.getElementById("inner-max");

            rangeS.forEach(function(el) {
                el.oninput = function() {
                    var slide1 = parseFloat(rangeS[0].value),
                        slide2 = parseFloat(rangeS[1].value);
                    slide1 = slide1.toLocaleString('en-US');
                    slide2 = slide2.toLocaleString('en-US');
                    innerMin.value = slide1;
                    innerMax.value = slide2;
                    if (slide1 > slide2) {
                        [slide1, slide2] = [slide2, slide1];
                        // var tmp = slide2;
                        // slide2 = slide1;
                        // slide1 = tmp;
                    }

                    numberS[0].value = slide1;
                    numberS[1].value = slide2;
                }
            });

            numberS.forEach(function(el) {
                el.oninput = function() {
                    var number1 = parseFloat(numberS[0].value),
                        number2 = parseFloat(numberS[1].value);

                    if (number1 > number2) {
                        var tmp = number1;
                        numberS[0].value = number2;
                        numberS[1].value = tmp;
                    }

                    rangeS[0].value = number1;
                    rangeS[1].value = number2;

                }
            });

        })();
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <!-- Color scheme-->
    <script src="nuevo/assets/plugins/switcher/js/dmss.js"></script>
    <!-- Select customization & Color scheme-->
    <script src="nuevo/assets/libs/bootstrap-select.min.js"></script>
    <!-- Pop-up window-->
    <script src="nuevo/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Headers scripts-->
    <script src="nuevo/assets/plugins/headers/slidebar.js"></script>
    <script src="nuevo/assets/plugins/headers/header.js"></script>
    <!-- Mail scripts-->
    <script src="nuevo/assets/plugins/jqBootstrapValidation.js"></script>
    <script src="nuevo/assets/plugins/contact_me.js"></script>
    <!-- Video player-->
    <script src="nuevo/assets/plugins/flowplayer/flowplayer.min.js"></script>
    <!-- Filter and sorting images-->
    <script src="nuevo/assets/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="nuevo/assets/plugins/isotope/imagesLoaded.js"></script>
    <!-- Progress numbers-->
    <script src="nuevo/assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="nuevo/assets/plugins/rendro-easy-pie-chart/jquery.waypoints.min.js"></script>
    <!-- Animations-->
    <script src="nuevo/assets/plugins/scrollreveal/scrollreveal.min.js"></script>
    <!-- Scale images-->
    <script src="nuevo/assets/plugins/ofi.min.js"></script>
    <!-- Main slider-->
    <script src="nuevo/assets/plugins/slider-pro/jquery.sliderPro.min.js"></script>
    <!--Sliders-->
    <script src="nuevo/assets/plugins/slick/slick.js"></script>
    <!-- User customization-->
    <script src="nuevo/assets/js/custom.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            // Selecciona todos los elementos que tienen la clase "sp-image"
            var elementos = document.querySelectorAll('.sp-image');

            // Recorre los elementos y establece el width a 1900px
            elementos.forEach(function(elemento) {
                elemento.style.width = '1900px';
            });
        }, 100); // Espera 2 segundos (2000 milisegundos)
    });
</script>
</body>


</html>