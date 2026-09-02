<?php session_start(); ?>
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
            --haro-black: #111111;
            --haro-ink: #1f1b18;
            --haro-muted: #756f67;
            --haro-red: #9f1d1d;
            --haro-gold: #c49a4a;
            --haro-bg: #f4f0ea;
            --haro-card: #fffaf3;
            --haro-border: rgba(31, 27, 24, .10);
            --haro-shadow: 0 20px 55px rgba(22, 18, 14, .10);
            --haro-radius: 22px;
            --haro-transition: 220ms ease;
        }

        body.layout-boxed {
            background: radial-gradient(circle at top left, rgba(196,154,74,.18), transparent 34%),
                        linear-gradient(180deg, #fbf7f1 0%, var(--haro-bg) 100%) !important;
            font-family: 'DM Sans', 'Nunito', sans-serif !important;
            color: var(--haro-ink) !important;
        }

        #load_screen { background: var(--haro-bg) !important; }
        #load_screen .spinner-grow { background-color: var(--haro-red) !important; color: var(--haro-red) !important; }
        .layout-px-spacing { padding: 30px 24px 24px !important; }

        .secondary-nav .header {
            background: rgba(255, 250, 243, .86) !important;
            border: 1px solid var(--haro-border) !important;
            border-radius: var(--haro-radius) !important;
            padding: 18px 20px !important;
            box-shadow: 0 12px 32px rgba(22,18,14,.06);
            backdrop-filter: blur(14px);
        }

        .btn-toggle.sidebarCollapse {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--haro-black);
            color: #fff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            transition: transform var(--haro-transition), background var(--haro-transition);
        }

        .btn-toggle.sidebarCollapse:hover {
            background: var(--haro-red);
            transform: translateY(-2px);
        }

        .haro-page-title .haro-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--haro-red);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 11px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: .14em;
            margin-bottom: 4px;
        }

        .haro-page-title .haro-eyebrow::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 99px;
            background: var(--haro-gold);
        }

        .page-title h3 {
            color: var(--haro-ink) !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: clamp(22px, 2.4vw, 32px) !important;
            line-height: 1.05 !important;
            font-weight: 400 !important;
            letter-spacing: -.04em;
            margin: 0 !important;
        }

        .breadcrumb-style-one .breadcrumb { margin-top: 8px !important; }
        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            color: var(--haro-muted) !important;
            font-size: 12px;
            font-weight: 600;
        }
        .breadcrumb-style-one .breadcrumb-item.active { color: var(--haro-red) !important; }

        .haro-table-card {
            background: var(--haro-card) !important;
            border: 1px solid var(--haro-border) !important;
            border-radius: var(--haro-radius) !important;
            box-shadow: var(--haro-shadow) !important;
            overflow: hidden;
            padding: 0 !important;
        }

        .dt--top-section {
            padding: 22px 24px 18px !important;
            border-bottom: 1px solid var(--haro-border);
            background: linear-gradient(135deg, rgba(17,17,17,.035), rgba(196,154,74,.08));
        }

        .dataTables_length label,
        .dataTables_info {
            color: var(--haro-muted) !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background: #fff !important;
            border: 1px solid var(--haro-border) !important;
            border-radius: 12px !important;
            color: var(--haro-ink) !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 13px !important;
            min-height: 40px;
            outline: none !important;
            transition: border-color var(--haro-transition), box-shadow var(--haro-transition);
        }

        .dataTables_filter input { padding: 8px 14px 8px 38px !important; }

        .dataTables_length select:focus,
        .dataTables_filter input:focus {
            border-color: var(--haro-red) !important;
            box-shadow: 0 0 0 4px rgba(159, 29, 29, .10) !important;
        }

        .haro-data-table {
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .haro-data-table thead th {
            background: #181411 !important;
            color: #f9efe0 !important;
            border: none !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 16px 18px !important;
            white-space: nowrap;
        }

        .haro-data-table tbody td {
            color: var(--haro-ink) !important;
            border-color: rgba(31,27,24,.07) !important;
            padding: 16px 18px !important;
            vertical-align: middle !important;
            font-size: 14px;
            font-weight: 600;
            background: transparent !important;
        }

        .haro-data-table tbody tr { transition: background var(--haro-transition); }
        .haro-data-table tbody tr:hover { background: rgba(196,154,74,.10) !important; }

        .haro-data-table tbody td:first-child {
            font-family: 'Bebas Neue', sans-serif;
            color: var(--haro-red) !important;
            font-weight: 400;
        }

        .money-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 115px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(159, 29, 29, .10);
            color: var(--haro-red);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 13px;
            font-weight: 400;
            letter-spacing: -.01em;
        }

        .money-pill.pending {
            background: rgba(196, 154, 74, .18);
            color: #8a6422;
            border: 1px solid rgba(196, 154, 74, .22);
        }

        .btn-haro-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 8px 16px;
            border-radius: 12px;
            background: var(--haro-black);
            color: #fff !important;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 12px;
            font-weight: 400;
            text-decoration: none !important;
            transition: transform var(--haro-transition), background var(--haro-transition), box-shadow var(--haro-transition);
            box-shadow: 0 8px 18px rgba(17,17,17,.14);
            white-space: nowrap;
        }

        .btn-haro-view:hover {
            background: var(--haro-red);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(159,29,29,.22);
        }

        .dt--bottom-section {
            padding: 18px 24px !important;
            border-top: 1px solid var(--haro-border);
            background: #fffaf3;
        }

        .dt--pagination .paginate_button,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 12px !important;
            border: 1px solid transparent !important;
            color: var(--haro-muted) !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-weight: 400 !important;
            transition: all var(--haro-transition);
        }

        .dt--pagination .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--haro-red) !important;
            border-color: var(--haro-red) !important;
            color: #fff !important;
        }

        .footer-wrapper {
            background: transparent !important;
            border-top: 1px solid var(--haro-border) !important;
            color: var(--haro-muted) !important;
            padding: 22px 28px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 13px;
        }

        .footer-wrapper a {
            color: var(--haro-red) !important;
            font-weight: 400;
        }

        html[data-theme="dark"] body.layout-boxed,
        body.dark.layout-boxed,
        .dark body.layout-boxed {
            background: #111111 !important;
            color: #f5ead9 !important;
        }

        html[data-theme="dark"] .secondary-nav .header,
        html[data-theme="dark"] .haro-table-card,
        body.dark .secondary-nav .header,
        body.dark .haro-table-card {
            background: #191512 !important;
            border-color: rgba(196,154,74,.18) !important;
        }

        html[data-theme="dark"] .page-title h3,
        body.dark .page-title h3 {
            color: #fff5e8 !important;
        }

        html[data-theme="dark"] .haro-data-table tbody td,
        body.dark .haro-data-table tbody td {
            color: #f5ead9 !important;
            border-color: rgba(255,255,255,.07) !important;
        }

        html[data-theme="dark"] .dt--top-section,
        html[data-theme="dark"] .dt--bottom-section,
        body.dark .dt--top-section,
        body.dark .dt--bottom-section {
            background: #161210 !important;
            border-color: rgba(196,154,74,.16) !important;
        }

        @media (max-width: 768px) {
            .layout-px-spacing { padding: 18px 14px !important; }
            .secondary-nav .header {
                align-items: flex-start !important;
                padding: 16px !important;
            }
            .page-title h3 { font-size: 22px !important; }
            .dt--top-section .row { gap: 12px; }
            .haro-data-table tbody td { padding: 14px 12px !important; }
            .money-pill { min-width: auto; }
        }
    </style>


    <style>
        :root {
            --haro-black: #0b0b0d;
            --haro-900: #131316;
            --haro-red: #b0141b;
            --haro-gold: #c9a24a;
            --haro-gold-soft: rgba(201, 162, 74, .14);
            --haro-red-soft: rgba(176, 20, 27, .12);
            --page: #f4f1ea;
            --paper: #ffffff;
            --paper-2: #faf8f3;
            --line: rgba(19, 19, 22, .09);
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

        .page-title h3,
        .haro-page-title .haro-eyebrow,
        .haro-data-table thead th,
        .haro-data-table tbody td:first-child,
        .money-pill,
        .btn-haro-view,
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
        }

        .haro-page-title .haro-eyebrow {
            font-size: 1rem !important;
            color: var(--haro-red) !important;
        }

        .breadcrumbs-container .header {
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(201,162,74,.20) !important;
            border-radius: var(--radius-lg) !important;
            padding: 18px 22px !important;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(14px);
        }

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

        .haro-data-table thead th {
            background: #181411 !important;
            color: #f9efe0 !important;
            font-size: 1rem !important;
            padding: 16px 18px !important;
        }

        .haro-data-table tbody td {
            color: var(--text) !important;
            border-color: rgba(19,19,22,.07) !important;
            padding: 16px 18px !important;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif !important;
            font-weight: 600;
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
            min-width: 115px;
            padding: 7px 12px;
            border-radius: 999px;
            background: var(--haro-red-soft) !important;
            color: var(--haro-red) !important;
            font-size: 1.05rem !important;
        }

        .money-pill.pending {
            background: var(--haro-gold-soft) !important;
            color: #8a661c !important;
            border: 1px solid rgba(201,162,74,.22) !important;
        }

        .btn-haro-view {
            background: var(--haro-900) !important;
            border-radius: 12px;
            color: #fff !important;
            font-size: 1rem !important;
            padding: 8px 16px;
        }

        .btn-haro-view:hover {
            background: var(--haro-red) !important;
            transform: translateY(-2px);
        }

        .dt--top-section {
            background: linear-gradient(135deg, rgba(176,20,27,.04), rgba(201,162,74,.08)) !important;
        }

        .dt--bottom-section {
            background: rgba(250,248,243,.88) !important;
        }

        .footer-wrapper {
            background: rgba(255,255,255,.70) !important;
            border-top: 1px solid rgba(201,162,74,.16) !important;
            color: var(--muted) !important;
            backdrop-filter: blur(10px);
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

        <?php include("template/barra.php");
        include_once("api/adminVentas.php");
        $adminVentas= new AdministradorVentas();
        $ventasConcluidas = $adminVentas->dameVentasSinCompletar();
        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Ventas">
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
                                            <span class="haro-eyebrow">Ventas pendientes</span>
                                            <h3>Panel de administración de ventas pendientes</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Ventas</li>
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
                                            <th>Auto</th>
                                            <th>Precio Final</th>
                                            <th>Restante</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($ventasConcluidas as $venta){
                                                echo '<tr>';
                                                echo '<td>'.$venta->id.'</td>';
                                                echo '<td>'.$venta->identificador.'</td>';
                                                echo '<td><span class="money-pill">$'.number_format($venta->precio_pactado, 2).'</span></td>';
                                                echo '<td><span class="money-pill pending">$'.number_format($venta->restante, 2).'</span></td>';
                                                echo '<td><a class="btn-haro-view" href="venta-detalle.php?id='.$venta->id.'">Ver detalle</a></td>';
                                                echo '</tr>';
                                            }
                                        
                                        
                                        ?>
                                      
                                        
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
                "sSearchPlaceholder": "Buscar venta...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>