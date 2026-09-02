<!DOCTYPE html>
<html lang="es">

<?php include 'template/head.php'; ?>

<body class="page">


    <?php include 'template/header.php'; ?>
    <!-- end .header-->
    <div class="section-title-page area-bg area-bg_dark area-bg_op_60">
        <div class="area-bg__inner">
            <div class="container">
                <div class="row">
                    <div class="col offset-lg-3">
                        <div class="b-title-page__wrap">
                            <h1 class="b-title-page">¿Quiénes Somos?</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">¿Quiénes Somos?</li>
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
    <main>
        <div class="section-default bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="b-advantages"><i class="b-advantages__ic flaticon-car-repair-check-list"></i>
                            <div class="b-advantages__title">Nuestra Misión</div>
                            <div class="b-advantages__info">Ser una de las agencias líderes, mas confiable y respetable
                                del mercado, obteniendo el mayor grado de satisfacción de nuestros clientes.</div>
                        </div>
                        <!-- end .b-advantages-->
                    </div>
                    <!-- <div class="col-lg-4">
            <div class="b-advantages active"><i class="b-advantages__ic flaticon-speedometer"></i>
              <div class="b-advantages__title">Todas Las Marcas Coches</div>
              <div class="b-advantages__info"></div>
            </div>
          </div> -->
                    <div class="col-lg-4">
                        <div class="b-advantages"><i class="b-advantages__ic flaticon-car-repair"></i>
                            <div class="b-advantages__title">Nuestra Visión</div>
                            <div class="b-advantages__info">La prosperidad y el desarrollo de una empresa se fundamentan
                                sobre todo en la confianza que ésta otorgue a su entorno social y,
                                en concreto, en la confianza que inspire a sus empleados, clientes, accionistas,
                                colaboradores y proveedores.</div>
                        </div>
                        <!-- end .b-advantages-->
                    </div>
                </div>
            </div>
        </div>
        <section class="section-about section-default">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="ui-title-slogan">TE AYUDA A ENCONTRAR TU PRÓXIMO COCHE FÁCILMENTE</div>
                        <h2 class="ui-title"><span class="text-primary">Bienvenido A</span> Haro Seminuevos</h2>
                        <p>Somos una agencia de autos seminuevos de gran prestigio, ya con más de 20 años de experiencia
                            en el ramo.
                            <br>
                            Razón que nos llevó a posicionarnos rápidamente en el mercado local, estatal y hasta
                            nacional. Con ideas creativas y una nueva forma de hacer negocios, siempre buscando ser
                            fieles a nuestros principios, <span style="color: red;"><strong>HARO
                                    SEMINUEVOS</strong></span> nació con la
                            idea de convertirse
                            en lo que es
                            ahora, una empresa reconocida tanto local y nacionalmente, por nuestro catálogo tan variado
                            de vehículos, puedes encontrar tanto un auto sedan a vehículos comerciales de equipo pesado.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end .b-about-->
        <div class="section-progress">
            <div class="container">
                <?php
        include_once('admin/api/adminAutos.php');
        $autos = new administradorAutos();
        $cuenta = $autos->cuentaAutos();
        ?>
                <ul class="b-progress-list b-progress-list_mod-a row list-unstyled">
                    <li class="b-progress-list__item col-md-3">
                        <!-- <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">vehículos en línea</span><span class="b-progress-list__percent js-chart" data-percent="3874"><span class="js-percent"></span></span></div> -->
                    </li>
                    <li class="b-progress-list__item col-md-3">
                        <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Vehículos En
                                Línea</span><span class="b-progress-list__percent js-chart"
                                data-percent="<?php echo $cuenta ?>"><span
                                    class="js-percent"></span><span></span></span></div>
                    </li>
                    <li class="b-progress-list__item col-md-3">
                        <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Clientes
                                Satisfechos</span><span class="b-progress-list__percent js-chart"
                                data-percent="<?php echo $autos->cuentaAutosHistorico() + 2400 ?>"><span
                                    class="js-percent"></span></span></div>
                    </li>
                    <li class="b-progress-list__item col-md-3">
                        <!-- <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">vehicles on sale</span><span class="b-progress-list__percent js-chart" data-percent="1450"><span class="js-percent"></span><span>+</span></span></div> -->
                    </li>
                </ul>
            </div>
        </div>

        <!-- end .b-progress-->
        <section class="b-bnr bg-dark b-bnr_mod-a">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="b-bnr__main">
                            <h2 class="b-bnr__title">¿Quieres vender tu auto?</h2>
                            <div class="b-bnr__info">Te ofrecemos el mejor precio para tu auto. Hazlo con nosotros!!
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="b-bnr__second"><a class="btn btn-primary" href="#">Contactanos</a>
                            <div class="b-bnr-contacts">
                                <div class="b-bnr-contacts__info">Llámenos para reservar un vehículo</div><a
                                    class="b-bnr-contacts__phone" href="tel:tel:3319552634"><i
                                        class="ic icon-call-end text-primary"></i>33 195 52634</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end .b-bnr-->
        <!-- <section class="b-steps section-default parallax">
      <div class="b-steps__inner">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="ui-title-slogan">Helps you to find perfect car</div>
              <h2 class="ui-title">How Revus<span class="text-primary"> Works</span></h2>
              <ul class="b-steps-list list-unstyled row">
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">01</span>
                  <div class="b-steps-list__title">Search Our Inventory</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">02</span>
                  <div class="b-steps-list__title">Choose The Car You Like</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">03</span>
                  <div class="b-steps-list__title">Apply For Auto Finance</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">04</span>
                  <div class="b-steps-list__title">Get Approved & Drive</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    </main>

    <?php include 'template/footer.php'; ?>
    <!-- .footer-->
    </div>
    </div>
    <!-- end layout-theme-->


    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
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
    <script src="assets/plugins/switcher/js/dmss.js"></script>
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
    <!--Sliders-->
    <script src="assets/plugins/slick/slick.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>
</body>

</html>