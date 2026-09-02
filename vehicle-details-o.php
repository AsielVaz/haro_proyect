<!DOCTYPE html>
<html lang="es">


<?php include 'template/head.php'; ?>

<body class="page">
    <?php
    $id = $_GET['auto'];
    include_once("admin/api/adminEstadisticas.php");
    include_once("admin/api/adminAutos.php");
    $admin = new AdministradorAutos();
    $adminEstats = new AdministradorEstadisticas();
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'));
    $adminEstats->insertaVisita($ip, $id);
    $auto = $admin->dameAuto($id);


    ?>
    <!-- Header-->
    <?php include 'template/header.php'; ?>

    <!-- end .header-->

    <div class="section-title-page area-bg area-bg_dark area-bg_op_60">
        <div class="area-bg__inner">
            <div class="container">
                <div class="row">
                    <div class="col offset-lg-3">
                        <div class="b-title-page__wrap">
                            <h1 class="b-title-page">Detalles del Veh&iacute;culo</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detalles</li>
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
            <section class="b-goods-f">


                <div class="row">
                    <div class="col-lg-8">
                        <div class="ui-subtitle">La mejor eleccion</div>
                        <a class="spotlight" data-src="<?php echo $auto->imagenes[0]->url ?>">

                            <h1 class="ui-title text-uppercase"><?php
                                                                echo $auto->marca->marca . " " . $auto->modelo->modelo;

                                                                ?></h1>
                        </a>

                    </div>
                    <div class="col-lg-4">
                        <div class="b-goods-f-price">
                            <div class="b-goods-f-price__inner">
                                <?php

                                if ($auto->precio) {
                                    echo ' 
                                <div class="b-goods-f-price__main bg-primary">
                                    $ ' . number_format($auto->precio)  . '
                                </div>';
                                }

                                ?>

                            </div>
                            <div class="b-goods-f-price__note">Incluye Impuestos</div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-8">
                        <div class="b-goods-f__links"><a class="b-goods-f__links-item" href="#"><i class="ic fas fa-map-marker-alt text-primary"></i><?php echo $auto->nacionalidad ?></a>
                        </div>
                        <div class="b-goods-f__slider">
                            <a class="spotlight" data-src="<?php echo $auto->imagenes[0]->url ?>" data-description="<?php echo $auto->marca->marca . " " . $auto->modelo->modelo; ?>">

                                <div class="ui-slider-main js-slider-for">
                                    <?php
                                    if (count($auto->imagenes) > 0) {
                                        foreach ($auto->imagenes as $image) {

                                            echo '<img class="img-details" src="' . $image->url . '" alt="foto" />';
                                        }
                                    } else {
                                        echo '<img class="img-scale" src="assets/media/content/b-goods/main-slider/main/1.jpg" alt="foto" />';
                                    }
                                    ?>

                                </div>
                            </a>
                            <div class="ui-slider-nav js-slider-nav">
                                <?php

                                if (count($auto->imagenes) > 0) {
                                    foreach ($auto->imagenes as $image) {
                                        echo '<a class="spotlight" data-src="' . $image->url . '"  data-description="' . $auto->marca->marca . " " . $auto->modelo->modelo . '">';
                                        echo ' <img class="img-details_mini" src="' . $image->url . '" alt="foto" />';
                                        echo '</a>';
                                    }
                                } else {
                                    echo '<img class="img-scale" src="assets/media/content/b-goods/main-slider/thumb/1.jpg" alt="foto" />';
                                }

                                ?>


                            </div>
                        </div>
                        <h2 class="b-goods-f__title">Especificaciones del Veh&iacute;culo</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="b-goods-f__descr row">
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Año</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->anio ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Modelo</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12">
                                        <?php echo $auto->modelo->modelo . " " . $auto->marca->marca ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Cuerpo</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->cuerpo ?>
                                    </dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Color</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->color ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Combustible</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12">
                                        <?php echo $auto->combustible ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Poder</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->poder ?></dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="b-goods-f__descr row">
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Condicion</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->estatus ?>
                                    </dd>
                                    <?php

                                    if ($auto->kilometragePermitido) {
                                        echo ' <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Kilometraje</dt>
                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12">' . $auto->kilometrage . ' KM</dd>';
                                    }

                                    ?>


                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Transmision</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12">
                                        <?php echo $auto->transmicion->transmicion ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Cilindraje</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->cilindrage ?>
                                        Cilindros</dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Interiores</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12">
                                        <?php echo $auto->interiores->interiores ?></dd>
                                    <dt class="b-goods-f__descr-title col-lg-5 col-md-12">Asientos</dt>
                                    <dd class="b-goods-f__descr-info col-lg-7 col-md-12"><?php echo $auto->asientos ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-vehicle-detail-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Descripcion</a></li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <p><?php echo $auto->descripcion ?></p>
                                <h3 class="b-goods-f__title-inner">Informacion General</h3>
                                <ul class="list list-mark-2">
                                    <li>Poderosos <strong><?php echo $auto->cilindrage ?></strong> cilindros para que
                                        nunca te falte poder</li>
                                    <li>Interiores de <strong><?php echo $auto->interiores->interiores ?></strong> para
                                        la experiencia de manejo mas comoda</li>
                                    <li>Con su transmicion
                                        <strong><?php echo $auto->transmicion->transmicion ?></strong> siente la
                                        verdadera experiencia de manejo
                                    </li>
                                    <li><strong><?php echo $auto->asientos ?> asientos</strong> para que lleves a quien
                                        tu quieras</li>
                                    <li><?php echo $auto->estatus ?></li>
                                </ul>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-4">
                        <aside class="l-sidebar">


                            <div class="b-seller">
                                <div class="b-seller__header">
                                    <div class="b-seller__img"><img class="img-scale" src="assets/media/general/haro-logo.jpg" alt="foto" style="height: 100%; width: 100%;" /></div>
                                    <div class="b-seller__title">
                                        <div class="b-seller__name">
                                            <?php echo $auto->duenio->nombre . " " . $auto->duenio->appat ?></div>
                                        <div class="b-seller__category"><?php echo $auto->duenio->correo ?></div>
                                    </div>
                                </div>
                                <div class="b-seller__main"><i class="b-seller__ic fas fa-phone text-primary"></i>
                                    <div class="b-seller__contact"><span class="d-block">Contacta al vendedor</span><a class="b-seller__phone" href="https://api.whatsapp.com/send?phone=<?php echo $auto->duenio->telefono ?>"><?php echo $auto->duenio->telefono ?></a>
                                    </div>
                                    <ul class="b-seller-soc list-unstyled">
                                    </ul>
                                </div>
                            </div>
                            <!-- end .b-seller-->

                            <div class="widget section-sidebar bg-gray widget-selecr-contact">
                                <h3 class="widget-title bg-dark"><i class="ic icon_mail_alt"></i>Manda un mensaje al
                                    vendedor</h3>
                                <div class="widget-content">
                                    <div class="widget-inner">
                                        <form>
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Nombre *" />
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" placeholder="Tu Mensaje *" rows="4"></textarea>
                                            </div>
                                            <button class="btn btn-red btn-lg w-100">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </aside>
                    </div>
                </div>
            </section>
            <!-- end .b-goods-f-->

        </div>
    </div>


    <!-- .footer-->
    <?php include 'template/footer.php'; ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <!-- Select customization & Color scheme-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js"></script>
    <!-- Pop-up window-->
    <script src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Headers scripts-->
    <script src="assets/plugins/headers/slidebar.js"></script>
    <script src="assets/plugins/headers/header.js"></script>
    <!-- Mail scripts-->
    <script src="assets/plugins/jqBootstrapValidation.js"></script>
    <script src="assets/plugins/contact_me.js"></script>
    <!-- Video player-->
    <script src="assets/plugins/flowplayer/flowplayer.min.js"></script>
    <!-- Filter and sorting images-->
    <script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/plugins/isotope/imagesLoaded.js"></script>
    <!-- Progress numbers-->
    <script src="assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/plugins/rendro-easy-pie-chart/jquery.waypoints.min.js"></script>
    <!-- Animations-->
    <script src="assets/plugins/scrollreveal/scrollreveal.min.js"></script>
    <!-- Scale images-->
    <script src="assets/plugins/ofi.min.js"></script>
    <!-- Video player-->
    <script src="assets/plugins/flowplayer/flowplayer.min.js"></script>
    <!--Sliders-->
    <script src="assets/plugins/slick/slick.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>

    <script>
        var titulo = "<?php echo $auto->marca->marca . " " . $auto->modelo->modelo ?>";

        //Aplicamos el valor de la variable titulo
        document.getElementById('titulo').innerHTML = titulo;
    </script>
</body>

</html>
