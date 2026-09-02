<?php
header('Content-Type: text/html; charset=utf-8');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Banca - Haro </title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />
    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">

    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/light/apex/custom-apexcharts.css" rel="stylesheet" type="text/css">

    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/dark/apex/custom-apexcharts.css" rel="stylesheet" type="text/css">

</head>

<body class="layout-boxed enable-secondaryNav">
    <?php
    $usuarioPermiso = $_SESSION['sesionUsuario']['permiso_banca'] ?? '';
    if ($usuarioPermiso === 'Banca') {
    } else if ($usuarioPermiso === 'Cashier') {
        echo '<script> window.location.href = "autos-inventario.php"; </script>';

    } else {
        echo '<script> window.location.href = "../index.php"; </script>';
    }

    ?>
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <script>
        var montosEstadisticaInventario = [];
        var mesesEstadisticaInventario = [];
        var cantidadEstadoInventario = [];
        var montosEstadisticaVenta = [];
        var mesesEstadisticaVenta = [];
        var intereses = [];
        var mesSinVender = [];
        var cantidadSinVender = [];
    </script>

    <?php include_once("template/barra_nav.php") ?>
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include("template/barra.php") ?>

        <?php
        include_once("api/adminVentas.php");
        include_once("api/adminUtil.php");
        include_once("../api/adminAutos.php");
        $adminAutos = new AdministradorAutos();
        $adminVentas = new AdministradorVentas();
        $adminUtil = new AdminUtil();
        $estadisticasVentas = $adminUtil->dameEstadisticasVenta();
        $esatisticas = $adminUtil->dameEstadisticaInventarioA();
        $ventasConcluidas = $adminVentas->dameVentasConcluidas();
        $ventasPendinetes = $adminVentas->dameVentasSinCompletar();
        $sinVender = $adminUtil->estadisticasInvSinVender();

        $porCobrar = 0;
        $atrasado = 0;
        foreach ($ventasPendinetes as $ven) {
            $porCobrar += $ven->restante;
            foreach ($ven->pagos_acumulados as $pago) {
                if ($pago->fecha_prospecto < date("Y-m-d") && $pago->monto_acumulado > ($ven->precio_pactado  - $ven->restante)) {
                    $atrasado += $pago->monto_pagar;
                    $ven->color = "#FF0000";
                }
            }
        }
        $porcentajeAtrazado = (100 / $porCobrar) * $atrasado;

        foreach ($esatisticas as $estad) {
            echo "<script>montosEstadisticaInventario.push(" . $estad->monto_cantidad . ")</script>";
            echo "<script>cantidadEstadoInventario.push(" . $estad->autos_cantidad . ")</script>";
            echo "<script>mesesEstadisticaInventario.push('" . $estad->mes . "/" . $estad->anio . "')</script>";
        }
        foreach ($estadisticasVentas as $estats) {
            echo "<script>montosEstadisticaVenta.push(" . $estats->monto_cantidad . ")</script>";
            echo "<script>mesesEstadisticaVenta.push('" . $estats->mes . "/" . $estats->anio . "')</script>";
            echo "<script>intereses.push(" . $estats->intereses . ")</script>";
        }

        foreach ($sinVender as $sin) {
            echo "<script>mesSinVender.push('" . $sin->mes . "/" . $sin->anio . "')</script>";
            echo "<script>cantidadSinVender.push(" . $sin->autos_cantidad . ")</script>";
        }

        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Analytics">
                            <header class="header navbar navbar-expand-sm">
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                    </svg>
                                </a>
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">

                                        <div class="page-title">
                                            <h3>Panel de administracion de cobros</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                                
                            </header>
                        </div>
                    </div>
                    <!--  END BREADCRUMBS  -->

                    <div class="row layout-top-spacing">

                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-six" style="height: 220px;">
                                <div class="widget-heading">
                                    <h6 class="">Estado del a banca</h6>
                                    <div class="task-action">
                                        <div class="dropdown">



                                        </div>
                                    </div>
                                </div>
                                <div class="w-chart">
                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Autos en crédito</p>
                                            <p class="w-stats"><?php echo count($ventasPendinetes) ?></p>
                                        </div>
                                        <div class="w-chart-render-one">
                                        </div>
                                    </div>

                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Crédito por cobrar</p>
                                            <p class="w-stats">$ <?php echo number_format($porCobrar, 2) ?></p>
                                        </div>
                                        <div class="w-chart-render-one">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-six" style="height: 220px;">
                                <div class="widget-heading">
                                    <h6 class="">Valor total de inventario</h6>
                                    <div class="task-action">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="statistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </a>

                                            <div class="dropdown-menu left" aria-labelledby="statistics" style="will-change: transform;">
                                                <a class="dropdown-item" href="javascript:void(0);">View</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-chart">
                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Valor total del inventario </p>
                                            <p class="w-stats">$ <?php echo number_format($adminAutos->sumaMontosAutos(), 2) ?></p>
                                        </div>

                                    </div>

                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Autos en inventario </p>
                                            <p class="w-stats"><?php echo ($adminAutos->cuentaAutosValidos()) ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-six" style="height: 220px;">
                                <div class="widget-heading">
                                    <h6 class="">Autos en consignación</h6>
                                    <div class="task-action">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="statistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </a>

                                            <div class="dropdown-menu left" aria-labelledby="statistics" style="will-change: transform;">
                                                <a class="dropdown-item" href="javascript:void(0);">View</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-chart">
                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Autos en consignación </p>
                                            <p class="w-stats">$ <?php echo number_format($adminUtil->dameSumaConsig(), 2) ?></p>
                                        </div>

                                    </div>

                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Autos </p>
                                            <p class="w-stats"><?php echo number_format($adminUtil->dameConteoConsig()) ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-six" style="height: 220px;">
                                <div class="widget-heading">
                                    <h6 class="">Ventas </h6>
                                    <div class="task-action">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="statistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </a>

                                            <div class="dropdown-menu left" aria-labelledby="statistics" style="will-change: transform;">
                                                <a class="dropdown-item" href="javascript:void(0);">View</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-chart">
                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Inventario vendido</p>
                                            <p class="w-stats">$ <?php echo number_format($adminVentas->sumaVentas(), 2) ?></p>
                                        </div>

                                    </div>

                                    <div class="w-chart-section">
                                        <div class="w-detail">
                                            <p class="w-title">Autos vendidos</p>
                                            <p class="w-stats"><?php echo $adminVentas->cuentaVentas() ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>





                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value">Intereses generados </h6>
                                        </div>
                                        <div class="task-action">
                                            <div class="dropdown">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-content">

                                        <div class="w-info">
                                            <p class="value">$ <?php echo number_format($adminVentas->sumaIntereses(), 2) ?> <span>En intereses </span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up">
                                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                    <polyline points="17 6 23 6 23 12"></polyline>
                                                </svg></p>
                                        </div>

                                    </div>

                                    <!-- <div class="w-progress-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $porcentajeAtrazado ?>%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="">
                                            <div class="w-icon">
                                                <p><?php echo round($porcentajeAtrazado, 2) ?>% </p>
                                            </div>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value">Total crédito atrasado</h6>
                                        </div>
                                        <div class="task-action">
                                            <div class="dropdown">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-content">

                                        <div class="w-info">
                                            <p class="value">$ <?php echo number_format($atrasado, 2) ?> <span>En crédito pendiente</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up">
                                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                    <polyline points="17 6 23 6 23 12"></polyline>
                                                </svg></p>
                                        </div>

                                    </div>

                                    <!-- <div class="w-progress-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $porcentajeAtrazado ?>%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="">
                                            <div class="w-icon">
                                                <p><?php echo round($porcentajeAtrazado, 2) ?>% </p>
                                            </div>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>




                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                            <div class="widget-four">
                                <div class="widget-heading">
                                    <h5 class="">Autos por liquidar</h5>
                                </div>
                                <div class="widget-content">
                                    <div class="vistorsBrowser">


                                        <?php
                                        foreach ($ventasPendinetes as $venta) {
                                            $porcentaje =  (100 / $venta->precio_pactado) * ($venta->precio_pactado - $venta->restante);

                                            $porcentaje = round($porcentaje, 2);
                                            echo '
                                                <a href="venta-detalle.php?id=' . $venta->id . '">
                                                <div class="browser-list">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                                                    </div>
                                                    <div class="w-browser-details">
                                                        
                                                        <div class="w-browser-info">
                                                            <h6 style="color: ' . $venta->color . ';">' . $venta->identificador . $venta->resetante . '</h6>
                                                            <p class="browser-count">' . $porcentaje . '%</p>
                                                        </div>

                                                        <div class="w-browser-stats">
                                                            <div class="progress">
                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: ' . $porcentaje . '%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                </a>
                                            
                                            ';
                                        }

                                        ?>




                                    </div>

                                </div>
                            </div>
                        </div>




                        <div id="chartMixed" class="col-xl-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Inventario</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div id="valorInventario" class="" style="min-height: 365px;">

                                    </div>


                                </div>
                            </div>
                        </div>


                        <div id="chartMixed" class="col-xl-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Inventario sin vender </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div id="sinVenta" class="" style="min-height: 365px;">

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div id="chartMixed" class="col-xl-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Inventario Vendido</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div id="ventas" class="" style="min-height: 365px;">

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div id="chartMixed" class="col-xl-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Inventario</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div id="inventario" class="" style="min-height: 365px;">

                                    </div>


                                </div>
                            </div>
                        </div>




                    </div>

                </div>

            </div>
            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/assets/js/scrollspyNav.js"></script>
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/plugins/src/apex/custom-apexcharts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        //esperar a que la pagina cargue con jquery

        $(document).ready(function() {

            var optionsV = {
                series: [{
                    name: "Valor del inventario",
                    data: montosEstadisticaInventario
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Valor del inventario',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: mesesEstadisticaInventario,
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toLocaleString('es-ES', {
                                style: 'currency',
                                currency: 'MXN'
                            }); // Cambia 'EUR' según la moneda que necesites
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#valorInventario"), optionsV);
            chart.render();



            var optionsVentas = {
                series: [{
                    name: 'Monto Ventas',
                    data: montosEstadisticaVenta
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toLocaleString('es-ES', {
                            style: 'currency',
                            currency: 'MXN'
                        });
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: mesesEstadisticaVenta,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                   
                    formatter: function(val) {
                            return val.toLocaleString('es-ES', {
                                style: 'currency',
                                currency: 'MXN'
                            }); // Cambia 'EUR' según la moneda que necesites
                        },
                    
                },
                title: {
                    text: 'Ventas por mes',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#ventas"), optionsVentas);
            chart.render();



            var optionsInv = {
                series: [{
                    name: 'Promedio: ',
                    data: cantidadEstadoInventario
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val + " AUTOS";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: mesesEstadisticaInventario,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function(val) {
                            return val + " Autos";
                        }
                    }

                },
                title: {
                    text: 'Numero de autos',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#inventario"), optionsInv);
            chart.render();




            var optionsSinv = {
                series: [{
                    name: 'Promedio: ',
                    data: cantidadSinVender
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val + " AUTOS";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: mesSinVender,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function(val) {
                            return val + " Autos";
                        }
                    }

                },
                title: {
                    text: 'Cantidad de inventario por mes',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#sinVenta"), optionsSinv);
            chart.render();




        });
    </script>

</body>

</html>
