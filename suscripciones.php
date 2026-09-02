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
                            <h1 class="b-title-page">Boletín De Suscripciones</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Boletín De Suscripciones</li>
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
    <!-- <main class="l-main-content">
        <div class="container">
            <div class="section-area">
                <div class="row center">

                </div>
            </div>
        </div>
    </main> -->
    <section class="b-bnr-3 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    include 'admin/api/adminCarHunter.php';
                    $ID = $_GET['suscriptor'];
                    $admin = new AdministradorCarHunter();
                    // $admin->eliminarSuscriptorPorId($ID);
                    if (isset($_GET['suscriptor'])) {
                        $admin->eliminarSuscriptorPorId($ID);
                        echo '
                        <h1 class="b-bnr-3__title ui-tilte" style="color:black">Te has desuscrito de nuestro boletín informativo</h1>
                        <div class="b-bnr-3__info" style="color:black">Ya no recibirás nuestras notificaciones, Vuelve cuando gustes!!</div><a class="b-bnr-3__btn btn btn-primary" href="index.php">Inicio</a>
                        ';
                    } else {
                        echo '
                        <section class="centro">
  <article>
    <p class="error">ERROR</p>
    <h1 class="cc">404</h1>  
  </article>
   <img src="http://icons.iconarchive.com/icons/icons8/android/512/Network-Disconnected-icon.png" alt="Disconnected" width="200px">
    
    
</section>
                        ';
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <?php include 'template/footer.php'; ?>
    <!-- .footer-->
    </div>
    </div>
    <!-- end layout-theme-->


    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <script>

    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
    <!-- User map-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhTd-ZT5nzCNucY9AZUCspnXrw3votR34"></script>
    <!-- Maps customization-->
    <script src="assets/js/map-custom.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>
</body>

</html>