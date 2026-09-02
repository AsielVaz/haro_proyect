<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Pagos atrasados - Haro</title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />
    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/dt-global_style.css">


    <style>
        :root {
            --haro-black: #0b0b0d;
            --haro-900: #131316;
            --haro-red: #b0141b;
            --haro-gold: #c9a24a;
            --haro-gold-soft: rgba(201, 162, 74, .14);
            --haro-red-soft: rgba(176, 20, 27, .12);
            --page: #f4f1ea;
            --line-2: rgba(19, 19, 22, .06);
            --text: #161616;
            --muted: #77736b;
            --radius-lg: 26px;
            --shadow-sm: 0 10px 28px rgba(15, 15, 18, .08);
            --transition: 220ms cubic-bezier(.4,0,.2,1);
        }

        body.layout-boxed {
            background:
                radial-gradient(circle at top right, rgba(201,162,74,.14), transparent 32%),
                linear-gradient(180deg, #fbf8f1 0%, var(--page) 44%, #eee8dc 100%) !important;
            font-family: 'DM Sans', 'Nunito', sans-serif !important;
            color: var(--text) !important;
            -webkit-font-smoothing: antialiased;
        }

        #load_screen { background: var(--page) !important; }
        #load_screen .spinner-grow { background-color: var(--haro-red) !important; color: var(--haro-red) !important; }

        .layout-px-spacing { padding: 30px 26px !important; }
        .layout-spacing { margin-bottom: 24px !important; }
        .secondary-nav { background: transparent !important; box-shadow: none !important; margin-bottom: 18px; }

        .breadcrumbs-container .header,
        .secondary-nav .header {
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(201,162,74,.20) !important;
            border-radius: var(--radius-lg) !important;
            padding: 18px 22px !important;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(14px);
        }

        .btn-toggle.sidebarCollapse {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--haro-900);
            color: #fff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            box-shadow: 0 10px 22px rgba(19,19,22,.16);
            transition: transform var(--transition), background var(--transition);
        }

        .btn-toggle.sidebarCollapse:hover {
            background: var(--haro-red);
            transform: translateY(-2px);
        }

        .page-title h3,
        .haro-page-title .haro-eyebrow,
        .haro-data-table thead th,
        .haro-data-table tbody td:first-child,
        .money-pill,
        .status-pill,
        .dt--pagination .paginate_button,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-family: 'Bebas Neue', sans-serif !important;
            font-weight: 400 !important;
            letter-spacing: .05em !important;
        }

        .page-title h3 {
            font-size: clamp(1.8rem, 2.8vw, 2.8rem) !important;
            line-height: .96 !important;
            color: var(--haro-900) !important;
            margin: 0 !important;
        }

        .haro-page-title .haro-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--haro-red) !important;
            font-size: 1rem !important;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .haro-page-title .haro-eyebrow::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 99px;
            background: var(--haro-gold);
        }

        .breadcrumb-style-one .breadcrumb { margin-top: 8px !important; }
        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            color: var(--muted) !important;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none !important;
        }
        .breadcrumb-style-one .breadcrumb-item.active { color: var(--haro-red) !important; }

        .haro-table-card {
            background: rgba(255,255,255,.88) !important;
            border: 1px solid rgba(201,162,74,.18) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm) !important;
            backdrop-filter: blur(12px);
            overflow: hidden;
            padding: 0 !important;
        }

        .haro-table-card::before {
            content: "";
            display: block;
            height: 4px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
        }

        .dt--top-section {
            padding: 22px 24px 18px !important;
            border-bottom: 1px solid var(--line-2);
            background: linear-gradient(135deg, rgba(176,20,27,.04), rgba(201,162,74,.08)) !important;
        }

        .dataTables_length label,
        .dataTables_info {
            color: var(--muted) !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background: #fff !important;
            border: 1px solid rgba(201,162,74,.22) !important;
            border-radius: 14px !important;
            color: var(--text) !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 13px !important;
            min-height: 40px;
            outline: none !important;
        }

        .dataTables_filter input { padding: 8px 14px 8px 38px !important; }

        .haro-data-table {
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .haro-data-table thead th {
            background: #181411 !important;
            color: #f9efe0 !important;
            border: none !important;
            font-size: 1rem !important;
            padding: 16px 18px !important;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .haro-data-table tbody td {
            color: var(--text) !important;
            border-color: rgba(19,19,22,.07) !important;
            padding: 16px 18px !important;
            vertical-align: middle !important;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif !important;
            font-weight: 600;
            background: transparent !important;
        }

        .haro-data-table tbody td:first-child {
            font-family: 'Bebas Neue', sans-serif !important;
            color: var(--haro-red) !important;
            font-size: 1.1rem;
        }

        .haro-data-table tbody tr:hover {
            background: linear-gradient(90deg, rgba(176,20,27,.055), rgba(201,162,74,.055)) !important;
        }

        .money-pill {
            display: inline-flex;
            min-width: 115px;
            justify-content: center;
            padding: 7px 12px;
            border-radius: 999px;
            background: var(--haro-red-soft) !important;
            color: var(--haro-red) !important;
            font-size: 1.05rem !important;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--haro-gold-soft);
            color: #8a661c;
            font-size: .98rem;
        }

        .status-pill.overdue {
            background: var(--haro-red-soft);
            color: var(--haro-red);
        }

        .status-pill::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .dt--bottom-section {
            padding: 18px 24px !important;
            border-top: 1px solid var(--line-2);
            background: rgba(250,248,243,.88) !important;
        }

        .footer-wrapper {
            background: rgba(255,255,255,.70) !important;
            border-top: 1px solid rgba(201,162,74,.16) !important;
            color: var(--muted) !important;
            padding: 22px 28px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 13px;
            backdrop-filter: blur(10px);
        }

        .footer-wrapper a { color: var(--haro-red) !important; font-weight: 700; }

        @media (max-width:768px) {
            .layout-px-spacing { padding: 20px 14px !important; }
            .breadcrumbs-container .header,
            .secondary-nav .header { padding: 16px !important; align-items: flex-start !important; }
            .page-title h3 { font-size: 2rem !important; }
            .dt--top-section .row { gap: 12px; }
            .haro-data-table tbody td { padding: 14px 12px !important; }
            .money-pill { min-width: auto; }
        }
    </style>

</head>

<body class="layout-boxed enable-secondaryNav">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->


    <?php include_once("template/barra_nav.php") ?>
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include("template/barra.php") ?>

        <?php 
        include_once("api/adminPagos.php");
        $adminPagos = new AdministradorPagos();
        $pagos = $adminPagos->damePagosAprobados();
        ?>
        <?php 
        
        include_once("api/adminVentas.php");
        $adminVentas = new AdministradorVentas();
        $ventasConcluidas = $adminVentas->dameVentasConcluidas();
        $ventasPendinetes = $adminVentas->dameVentasSinCompletar();
        $porCobrar = 0;
        $atrasado = 0;
        $pagosR = array();
        foreach($ventasPendinetes as $ven){
            $porCobrar += $ven->restante; 
            foreach($ven->pagos_acumulados as $pago){
                if($pago->fecha_prospecto < date("Y-m-d") && $pago->monto_acumulado > ($ven->precio_pactado  - $ven->restante ) ){
                    $atrasado += $pago->monto_pagar;
                    $pagosR[] = $pago;
                }
            }
        }
        $porcentajeAtrazado = (100 / $porCobrar) * $atrasado;

        
        function fromatearfecha($fecha){
            $fecha = explode("-", $fecha);
            $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];
            return $fecha;
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

                                        <div class="page-title haro-page-title">
                                            <span class="haro-eyebrow">Pagos atrasados</span>
                                            <h3>Panel de administración de pagos atrasados</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Pagos</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                           
                            </header>
                        </div>
                    </div>
                    <!--  END BREADCRUMBS  -->



                    <div class="row layout-top-spacing">

                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8 haro-table-card">
                                <table id="zero-config" class="table table-striped dt-table-hover haro-data-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Monto</th>
                                            <th>Estatus</th>
                                            <th>Fecha de Pago</th>
                                            <th>Venta</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                        
                                        foreach($pagosR as $pago){
                                            echo "<tr>";
                                            echo "<td>".$pago->id."</td>";
                                            echo "<td><span class='money-pill'>$ ". number_format($pago->monto_pagar, 2) ."</span></td>";
                                            echo "<td><span class='status-pill overdue'>Atrasado</span></td>";
                                            echo "<td>". fromatearfecha($pago->fecha_prospecto)  ."</td>";
                                            echo "<td>".$pago->identificador."</td>";
                                            echo "</tr>";
                                        }
                                        
                                        ?>



                                        <!-- <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="usr-img-frame me-2 rounded-circle">
                                                        <img alt="avatar" class="img-fluid rounded-circle" src="../src/assets/img/boy.png">
                                                    </div>
                                                    <p class="align-self-center mb-0 admin-name"> Tiger </p>
                                                </div>
                                            </td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr> -->
                                      
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!--  BEGIN FOOTER  -->
             <?php include_once("template/footer_haro.php"); ?>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <script src="../src/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/plugins/src/table/datatable/datatables.js"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar pago...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>