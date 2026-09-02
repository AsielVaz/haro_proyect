<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Seminuevos haro</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="nuevo/nuevo/assets/css/master.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!--[if lt IE 9 ]>
<script src="/nuevo/assets/js/separate-js/html5shiv-3.7.2.min.js" type="text/javascript"></script><meta content="no" http-equiv="imagetoolbar">
<![endif]-->
</head>

<body class="page">

    <?php include_once 'template/head.php';
    include_once("admin/api/adminAutos.php");
    include_once("admin/api/adminEditor.php");
    $adminEditor = new AdministradorEditor();
    $adminAutos = new AdministradorAutos();
    $ultimos = $adminAutos->dameUltimosAutos();
    $marcas = $adminEditor->dameMarcas();
    $autosTodos = $adminAutos->dameAutos();

    ?>
    <!-- Loader-->
    <div id="page-preloader"><span class="spinner border-t_second_b border-t_prim_a"></span></div>
    <!-- Loader end-->


    <div class="l-theme animated-css animsition" data-header="sticky" data-header-top="200">
        <!-- ==========================-->
        <!-- MOBILE MENU-->
        <!-- ==========================-->
        <div data-off-canvas="mobile-slidebar left overlay">
            <a class="navbar-brand scroll" href="index.php"><img class="scroll-logo" src="logo.png" alt="logo"></a>


            <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a></li>
                <li class="nav-item "><a class="nav-link">Inventory</a>


                    <ul>
                        <li><a class="dropdown-item" href="inventory-list.html">Inventory list</a></li>
                        <li><a class="dropdown-item" href="inventory-grid.html">Inventory grid</a><a class="dropdown-item" href="dealers.html">Dealers list</a></li>
                        <li><a class="dropdown-item" href="dealers-info.html">Dealers info</a></li>
                    </ul>


                </li>
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>

                <li class="nav-item "><a class="nav-link" href="#">Pages</a>

                    <ul>
                        <li><a class="dropdown-item" href="typography.html">Typography</a></li>

                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">News</a>

                    <ul>
                        <li><a class="dropdown-item" href="blog-main.html">Blog main</a></li>
                        <li><a class="dropdown-item" href="blog-post.html">Blog post</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="contacts.html">Contact</a></li>
            </ul>

        </div>
        <div data-canvas="container">

            <header class="header">
                <div class="top-bar d-none d-xl-block">
                    <div class="container">
                        <div class="row">
                            <div class="col offset-2">
                                <div class="top-bar__inner row justify-content-between align-items-center">
                                    <ul class="top-bar__list list-unstyled col">
                                        <li class="top-bar__item"><a class="top-bar__link" href="contacto@seminuevosharo.mx">contacto@seminuevosharo.mx</a></li>
                                        <li class="top-bar__item">Av. Jorge Álvarez del Castillo No. 1264, Lomas del Country</li>
                                    </ul><a class="btn btn-primary btn-sm col-auto" href="#"><i class="ic icon-list"></i> Ver inventario</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-main">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-auto">
                                <a class="navbar-brand scroll"  href="index.php"><img style="width: 100px;" class="normal-logo" src="logo.png" alt="logo"></a>
                            </div>
                            <div class="col-lg-auto col">
                                <div class="header-contacts d-none d-md-block d-lg-none d-xl-block"><i class="ic text-primary icon-call-in"></i><span class="header-contacts__inner">Llamanos!<a class="header-contacts__number" href="tel:+17553028549">33 3636 8433,  33 1955 2634</a></span></div>
                                <!-- Mobile Trigger Start-->
                                <button class="menu-mobile-button js-toggle-mobile-slidebar toggle-menu-button d-lg-none"><i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i></button>
                                <!-- Mobile Trigger End-->
                            </div>
                            <div class="col-lg d-none d-lg-block">
                                <nav class="navbar navbar-expand-md justify-content-end" id="nav">
                                    <ul class="yamm main-menu navbar-nav">
                                        <li class="nav-item active"><a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a></li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" id="navbarDropdown2" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Inventory</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                                <a class="dropdown-item" href="inventory-list.html">Inventory list</a>
                                                <a class="dropdown-item" href="inventory-grid.html">Inventory grid</a>
                                                <a class="dropdown-item" href="vehicle-details.html">Vehicle details</a>
                                                <a class="dropdown-item" href="dealers.html">Dealers list</a>
                                                <a class="dropdown-item" href="dealers-info.html">Dealers info</a>
                                            </div>
                                        </li>

                                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>

                                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="navbarDropdown1" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown1"><a class="dropdown-item" href="typography.html">Typography</a></div>
                                        </li>
                                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="navbarDropdown4" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown4"><a class="dropdown-item" href="blog-main.html">Blog main</a><a class="dropdown-item" href="blog-post.html">Blog post</a></div>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="contacts.html">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
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
                                    echo '<div class="main-slider__slide sp-slide"><img class="sp-image" style="height: 700px !important; object-fit:cover !important;"  src="' . $autos->imagen . '" alt="slider" />';
                                } else {
                                    echo '<div class="main-slider__slide sp-slide"><img class="sp-image" style="height: 700px !important; object-fit:cover !important;"  src="' . $autos->imagenes[0]->url . '" alt="slider" />';
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
                            break;
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
           






            <section class="b-bnr-3 bg-dark" style="background-image: url('');">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="b-bnr-3__title ui-tilte">Encuentra las mejores marcas y modelos</h2>
                            <div class="b-bnr-3__info">Explora nuestro amplio catalogo de autos y encuentra el el vehículo que esta buscando. </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end .b-bnr-->
            <div class="b-gallery js-slider" data-slick="{&quot;slidesToShow&quot;: 8, &quot;arrows&quot;: false, &quot;autoplay&quot;: true,  &quot;slidesToScroll&quot;: 1, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 1400, &quot;settings&quot;: {&quot;slidesToShow&quot;: 6, &quot;slidesToScroll&quot;: 3}}, {&quot;breakpoint&quot;: 768, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 1}}]}">


                <?php
                foreach ($marcas as $mar) {
                    if ($mar->autos > 0) {
                ?>

                        <div class="b-gallery__item">
                            <img style="object-fit: contain; height: 200px !important;
                        
                        width: 200px !important;" class="img-fluid" src="<?php echo $mar->imagen ?>" alt="foto" />
                        </div>


                <?php
                    }
                }

                ?>


            </div>


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
                            <div class="ui-title-slogan">Nuestro catalogo</div>
                            <h2 class="ui-title">Featured<span class="text-primary"> Vehículos</span></h2>
                        </div>
                    </div>
                </div>
                <div class="section-carousel__inner bg-dark">
                    <div class="js-slider" data-slick="{&quot;slidesToShow&quot;: 5,  &quot;slidesToScroll&quot;: 5, &quot;infinite&quot;: true, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 1800, &quot;settings&quot;: {&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}}, {&quot;breakpoint&quot;: 1400, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 1040, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 1}}, {&quot;breakpoint&quot;: 767, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1}}]}">

                        <?php

                        $autosTodos = $adminAutos->dameAutosSinPausar();

                        foreach ($autosTodos as $autos) {



                        ?>


                            <div class="b-goods-f b-goods-f_mod-a">
                                <div class="b-goods-f__media">

                                    <?php
                                    if (strlen($autos->imagen)) {
                                        echo ' <a href="vehicle-details.php?auto=' . $autos->id . '"><img  style="width: 375px; height: 300px; object-fit:cover;" src="' . $autos->imagen . '" alt="foto" /></a>';
                                    } else {
                                        echo ' <a href="vehicle-details.php?auto=' . $autos->id . '"><img  style="width: 375px; height: 300px; object-fit:cover;" src="' . $autos->imagenes[0]->url . '" alt="foto" /></a>';
                                    }

                                    ?>


                                </div>
                                <div class="b-goods-f__main">
                                    <div class="b-goods-f__descrip">
                                        <div class="b-goods-f__title" style="height: 80px;"><span><?php echo strtoupper(utf8_decode($autos->marca->marca)) . " " . strtoupper(utf8_decode($autos->modelo->modelo)) ?></span></div>
                                        <div class="b-goods-f__info"></div>
                                        <ul class="b-goods-f__list list-unstyled">
                                            <li class="b-goods-f__list-item"><i class="ic flaticon-speedometer"></i> <?php echo utf8_decode($autos->transmicion->transmicion) ?></li>
                                            <li class="b-goods-f__list-item"><i class="ic flaticon-car-1"></i><?php echo $autos->anio ?></li>
                                            <li class="b-goods-f__list-item"><i class="ic flaticon-gearshift"></i> <?php echo utf8_decode($autos->combustible) ?></li>
                                        </ul>
                                    </div>
                                    <div class="b-goods-f__sidebar"><span class="b-goods-f__price-group"><span class="b-goods-f__price bg-primary"><span class="b-goods-f__price-numb">$45,800</span></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        <?php

                        }
                        ?>


                        <!-- end .b-goods-->
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12"><a class="section-carousel__btn btn btn-primary" href="#"><i class="ic icon-list"></i> View All Cars Listings</a></div>
                        </div>
                    </div>
                </div>
            </section>
      
            <div class="section-progress">
                <div class="container">
                    <ul class="b-progress-list row list-unstyled">
                        <li class="b-progress-list__item col-md-3">
                            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Vehicles Stock</span><span class="b-progress-list__percent js-chart" data-percent="3874"><span class="js-percent"></span></span>
                            </div>
                        </li>
                        <li class="b-progress-list__item col-md-3">
                            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">dealers served</span><span class="b-progress-list__percent js-chart" data-percent="299"><span class="js-percent"></span><span>+</span></span>
                            </div>
                        </li>
                        <li class="b-progress-list__item col-md-3">
                            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Happy Customers</span><span class="b-progress-list__percent js-chart" data-percent="6403"><span class="js-percent"></span></span>
                            </div>
                        </li>
                        <li class="b-progress-list__item col-md-3">
                            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">vehicles on sale</span><span class="b-progress-list__percent js-chart" data-percent="1450"><span class="js-percent"></span><span>+</span></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end .b-progress-->
            <section class="b-isotope section-default">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="ui-title-slogan">Helps you to find perfect car</div>
                            <h2 class="ui-title">Our Vehicles<span class="text-primary"> Listing</span></h2>
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
                <div class="b-goods-f__title"><span>' . strtoupper($aut->marca->marca) . " " . strtoupper($aut->modelo->modelo) . '</span>
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





            <!-- end .b-gallery-->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <div class="footer-logo">
                                    <a class="footer-logo__link" href="index.php"><img class="img-responsive" src="logo.png" alt="Logo"></a>
                                </div>
                                <ul class="footer-soc list-unstyled">
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fab fa-twitter"></i></a></li>
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fab fa-facebook"></i></a></li>
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fab fa-linkedin"></i></a></li>
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fab fa-google-plus-g"></i></a></li>
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fab fa-pinterest"></i></a></li>
                                    <li class="footer-soc__item"><a class="footer-soc__link" href="#" target="_blank"><i class="ic fas fa-play"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5">
                            <div class="footer-section footer-section_info">
                                <div class="footer-info">Ceipisicing elit sed do eiusmod tempor laboe dolore magna aliqa Ut enim ad minim veniam quis nostrud exercitation ullam co laboris nis aliquip comsecd sed ipsum.</div>
                                <div class="footer-contacts">
                                    <div class="footer-contacts__item"><i class="ic icon-location-pin"></i>Fairview Ave, El Monte, CA 91732</div>
                                    <div class="footer-contacts__item"><i class="ic icon-envelope"></i><a href="mailto:support@domain.com">support@domain.com</a></div>
                                    <div class="footer-contacts__item"><i class="ic icon-earphones-alt"></i>Phone:

                                        <a href="tel:+17553028549">+1 755 302 8549</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <section class="footer-section footer-section_link">
                                        <h3 class="footer-section__title">About Revus</h3>
                                        <ul class="footer-list list-unstyled">
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#">Services</a></li>
                                            <li><a href="#">About us</a></li>
                                            <li><a href="#">Inventory</a></li>
                                            <li><a href="#">Parts Shop</a></li>
                                            <li><a href="#">Contact</a></li>
                                        </ul>
                                    </section>
                                </div>
                                <div class="col-lg-6">
                                    <section class="footer-section footer-section_link">
                                        <h3 class="footer-section__title">Customer Links</h3>
                                        <ul class="footer-list list-unstyled">
                                            <li><a href="#">Latest Cars</a></li>
                                            <li><a href="#">Featured Cars</a></li>
                                            <li><a href="#">Sell Your Car</a></li>
                                            <li><a href="#">Buy a Car</a></li>
                                            <li><a href="#">Reviews</a></li>
                                            <li><a href="#">Latest News</a></li>
                                        </ul>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <section class="footer-section footer-section_subscribe">
                                <h3 class="footer-section__title">Subscribe Newsletter</h3>
                                <form class="footer-form">
                                    <div class="footer-form__info">Get our weekly nwsletter for latest car news exclusive offers and deals and more.</div>
                                    <div class="form-group">
                                        <input class="footer-form__input form-control" type="email" placeholder="your email">
                                    </div>
                                    <button class="btn btn-sm btn-primary">Subscribe</button>
                                </form>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="footer-copyright">
                                Copyrights (c) 2019 Revus - Auto Dealer Template. All rights reserved.
                                <a class="footer-copyright__link" href="privacy-policy.html">Privacy Policy</a>
                            </div>
                        </div>
                    </div><span class="footer__btn-up js-scroll-top"><i class="ic fas fa-angle-up"></i><img src="nuevo/assets/media/general/go_top.png" alt="go top"></span>
                </div>
            </footer>
            <!-- .footer-->
        </div>
    </div>
    <!-- end layout-theme-->


    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
</body>

</html>