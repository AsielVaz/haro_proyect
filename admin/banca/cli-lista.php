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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/dt-global_style.css">



<style>
    :root {
        --haro-bg: #f5f1ec;
        --haro-surface: #ffffff;
        --haro-surface-2: #fbf8f4;
        --haro-dark: #15100d;
        --haro-dark-2: #211915;
        --haro-text: #2b2521;
        --haro-muted: #8d8178;
        --haro-border: rgba(90, 45, 31, .12);
        --haro-red: #b5231f;
        --haro-red-2: #7e1714;
        --haro-gold: #c79a43;
        --haro-gold-soft: rgba(199, 154, 67, .14);
        --haro-red-soft: rgba(181, 35, 31, .09);
        --haro-shadow: 0 18px 45px rgba(33, 25, 21, .08);
        --haro-shadow-soft: 0 8px 24px rgba(33, 25, 21, .06);
        --haro-radius: 22px;
        --haro-radius-sm: 14px;
        --haro-transition: 220ms ease;
    }

    body.layout-boxed {
        background:
            radial-gradient(circle at top left, rgba(199,154,67,.16), transparent 32%),
            linear-gradient(180deg, #fffaf3 0%, var(--haro-bg) 48%, #f7f3ee 100%) !important;
        font-family: 'DM Sans', sans-serif !important;
        color: var(--haro-text) !important;
    }

    #load_screen { background: var(--haro-bg) !important; }
    #load_screen .spinner-grow { color: var(--haro-red) !important; }

    .layout-px-spacing { padding: 28px 24px 40px !important; }

    .secondary-nav {
        background: transparent !important;
        margin-bottom: 22px !important;
    }

    .breadcrumbs-container {
        background: linear-gradient(135deg, var(--haro-dark) 0%, #2a1a15 58%, #3b2018 100%) !important;
        border: 1px solid rgba(199,154,67,.22) !important;
        border-radius: 24px !important;
        box-shadow: var(--haro-shadow) !important;
        padding: 8px 14px !important;
        position: relative;
        overflow: hidden;
    }

    .breadcrumbs-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 82% 18%, rgba(199,154,67,.24), transparent 30%);
        pointer-events: none;
    }

    .breadcrumbs-container .header {
        position: relative;
        z-index: 1;
        min-height: 86px !important;
        background: transparent !important;
    }

    .btn-toggle.sidebarCollapse {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(255,255,255,.08) !important;
        border: 1px solid rgba(255,255,255,.12);
        color: #fff !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform var(--haro-transition), background var(--haro-transition);
    }

    .btn-toggle.sidebarCollapse:hover {
        background: rgba(199,154,67,.22) !important;
        transform: translateY(-1px);
    }

    .page-title h3 {
        margin: 0 !important;
        font-family: 'Bebas Neue', sans-serif !important;
        font-size: clamp(1.15rem, 2vw, 1.65rem) !important;
        line-height: 1.08 !important;
        color: #fff !important;
        font-weight: 400 !important;
        letter-spacing: -.03em;
    }

    .breadcrumb-style-one .breadcrumb { margin-top: 7px !important; }
    .breadcrumb-style-one .breadcrumb .breadcrumb-item,
    .breadcrumb-style-one .breadcrumb .breadcrumb-item a {
        color: rgba(255,255,255,.62) !important;
        font-size: .78rem !important;
        font-weight: 600;
        text-decoration: none !important;
    }
    .breadcrumb-style-one .breadcrumb .breadcrumb-item.active { color: var(--haro-gold) !important; }

    .breadcrumb-action-dropdown .custom-dropdown-icon > a {
        width: auto !important;
        height: 44px !important;
        padding: 0 18px !important;
        border-radius: 999px !important;
        background: linear-gradient(135deg, var(--haro-red), var(--haro-red-2)) !important;
        border: 1px solid rgba(255,255,255,.14) !important;
        box-shadow: 0 12px 26px rgba(181,35,31,.28) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        color: #fff !important;
        text-decoration: none !important;
        transition: transform var(--haro-transition), box-shadow var(--haro-transition) !important;
    }

    .breadcrumb-action-dropdown .custom-dropdown-icon > a::after {
        content: 'Nuevo cliente';
        font-family: 'Bebas Neue', sans-serif;
        font-size: .82rem;
        font-weight: 400;
        letter-spacing: .01em;
        white-space: nowrap;
    }

    .breadcrumb-action-dropdown .custom-dropdown-icon > a:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px rgba(181,35,31,.36) !important;
    }

    .breadcrumb-action-dropdown svg {
        width: 22px !important;
        height: 22px !important;
    }
    .breadcrumb-action-dropdown svg path:first-child { fill: rgba(255,255,255,.16) !important; }
    .breadcrumb-action-dropdown svg path:not(:first-child) { fill: #fff !important; }

    .widget-content.widget-content-area {
        background: var(--haro-surface) !important;
        border: 1px solid var(--haro-border) !important;
        border-radius: var(--haro-radius) !important;
        box-shadow: var(--haro-shadow) !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .dt--top-section {
        padding: 20px 22px 16px !important;
        background: linear-gradient(180deg, #fff, var(--haro-surface-2)) !important;
        border-bottom: 1px solid var(--haro-border) !important;
    }

    .dataTables_length label,
    .dataTables_info {
        color: var(--haro-muted) !important;
        font-size: .82rem !important;
        font-weight: 600 !important;
    }

    .dataTables_length select,
    .dataTables_filter input {
        border: 1px solid var(--haro-border) !important;
        background: #fff !important;
        color: var(--haro-text) !important;
        border-radius: 999px !important;
        padding: 8px 14px !important;
        min-height: 40px !important;
        box-shadow: none !important;
        outline: none !important;
        transition: border-color var(--haro-transition), box-shadow var(--haro-transition) !important;
    }

    .dataTables_filter input:focus,
    .dataTables_length select:focus {
        border-color: rgba(181,35,31,.42) !important;
        box-shadow: 0 0 0 4px rgba(181,35,31,.08) !important;
    }

    .dataTables_filter label svg { color: var(--haro-red) !important; }

    table.dataTable,
    #zero-config {
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
    }

    table.dataTable thead th,
    #zero-config thead th {
        background: #fff !important;
        color: var(--haro-muted) !important;
        font-family: 'Bebas Neue', sans-serif !important;
        font-size: .72rem !important;
        font-weight: 400 !important;
        letter-spacing: .08em !important;
        text-transform: uppercase !important;
        border-bottom: 1px solid var(--haro-border) !important;
        padding: 16px 18px !important;
        white-space: nowrap;
    }

    table.dataTable tbody td,
    #zero-config tbody td {
        padding: 15px 18px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid rgba(90,45,31,.08) !important;
        color: var(--haro-text) !important;
        font-size: .9rem !important;
    }

    table.dataTable tbody tr,
    #zero-config tbody tr {
        transition: background var(--haro-transition), transform var(--haro-transition);
    }

    table.dataTable tbody tr:hover,
    #zero-config tbody tr:hover {
        background: linear-gradient(90deg, rgba(199,154,67,.08), rgba(181,35,31,.035)) !important;
    }

    .usr-img-frame {
        width: 42px !important;
        height: 42px !important;
        border-radius: 14px !important;
        overflow: hidden !important;
        border: 2px solid rgba(199,154,67,.38) !important;
        background: var(--haro-gold-soft) !important;
        box-shadow: var(--haro-shadow-soft);
    }

    .usr-img-frame img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    .admin-name {
        font-family: 'Bebas Neue', sans-serif !important;
        font-weight: 400 !important;
        color: var(--haro-dark) !important;
    }

    #zero-config tbody td:nth-child(2) {
        font-family: 'Bebas Neue', sans-serif !important;
        font-weight: 400 !important;
        color: var(--haro-dark) !important;
    }

    #zero-config tbody td:nth-child(3),
    #zero-config tbody td:nth-child(4) {
        color: var(--haro-muted) !important;
        font-weight: 600 !important;
    }

    #zero-config tbody td:last-child {
        min-width: 290px;
    }

    .btn {
        border-radius: 999px !important;
        font-family: 'Bebas Neue', sans-serif !important;
        font-size: .76rem !important;
        font-weight: 400 !important;
        letter-spacing: .01em !important;
        padding: 8px 14px !important;
        border: 1px solid transparent !important;
        box-shadow: none !important;
        transition: transform var(--haro-transition), box-shadow var(--haro-transition), background var(--haro-transition) !important;
    }

    .btn:hover { transform: translateY(-1px); }

    .btn-danger {
        background: var(--haro-red-soft) !important;
        color: var(--haro-red) !important;
        border-color: rgba(181,35,31,.18) !important;
    }
    .btn-danger:hover {
        background: var(--haro-red) !important;
        color: #fff !important;
        box-shadow: 0 10px 22px rgba(181,35,31,.24) !important;
    }
    .btn-danger:disabled {
        opacity: .45 !important;
        transform: none !important;
        cursor: not-allowed !important;
    }

    .btn-warning {
        background: var(--haro-gold-soft) !important;
        color: #8a5e12 !important;
        border-color: rgba(199,154,67,.26) !important;
    }
    .btn-warning:hover {
        background: var(--haro-gold) !important;
        color: #fff !important;
        box-shadow: 0 10px 22px rgba(199,154,67,.26) !important;
    }

    .btn-susses,
    .btn-succes,
    .btn-success {
        background: rgba(33,25,21,.07) !important;
        color: var(--haro-dark) !important;
        border-color: rgba(33,25,21,.12) !important;
    }
    .btn-susses:hover,
    .btn-succes:hover,
    .btn-success:hover {
        background: var(--haro-dark) !important;
        color: #fff !important;
        box-shadow: 0 10px 24px rgba(33,25,21,.18) !important;
    }

    .dt--bottom-section {
        padding: 16px 22px !important;
        border-top: 1px solid var(--haro-border) !important;
        background: var(--haro-surface-2) !important;
    }

    .dt--pagination .paginate_button,
    .dataTables_paginate .paginate_button {
        border-radius: 12px !important;
        color: var(--haro-muted) !important;
        border: 1px solid transparent !important;
        margin: 0 2px !important;
        font-weight: 400 !important;
    }

    .dt--pagination .paginate_button.current,
    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--haro-red), var(--haro-red-2)) !important;
        color: #fff !important;
        border-color: transparent !important;
        box-shadow: 0 8px 18px rgba(181,35,31,.22) !important;
    }

    .footer-wrapper {
        background: #fff !important;
        border-top: 1px solid var(--haro-border) !important;
        color: var(--haro-muted) !important;
        padding: 18px 28px !important;
        font-family: 'DM Sans', sans-serif !important;
    }

    .footer-wrapper a { color: var(--haro-red) !important; }
    .footer-wrapper svg { color: var(--haro-red) !important; }

    @media (max-width: 992px) {
        .breadcrumbs-container .header { gap: 12px; }
        .breadcrumb-action-dropdown { width: 100%; justify-content: flex-start; margin-top: 10px; }
        #zero-config tbody td:last-child { min-width: 240px; }
    }

    @media (max-width: 576px) {
        .layout-px-spacing { padding: 18px 12px 34px !important; }
        .breadcrumbs-container { border-radius: 18px !important; }
        .page-title h3 { font-size: 1.08rem !important; }
        .breadcrumb-action-dropdown .custom-dropdown-icon > a { width: 100% !important; justify-content: center !important; }
        .dt--top-section .row > div { justify-content: flex-start !important; }
        .dataTables_filter,
        .dataTables_filter label,
        .dataTables_filter input { width: 100% !important; }
        .footer-wrapper { flex-direction: column; gap: 8px; text-align: center; }
    }
</style>


<style>
    /* Ajuste final para empatar con el dashboard corregido */
    :root {
        --haro-black: #0b0b0d;
        --haro-900: #131316;
        --haro-red: #b0141b;
        --haro-gold: #c9a24a;
        --page: #f4f1ea;
    }

    body.layout-boxed {
        background:
            radial-gradient(circle at top right, rgba(201,162,74,.14), transparent 32%),
            linear-gradient(180deg, #fbf8f1 0%, var(--page) 44%, #eee8dc 100%) !important;
        font-family: 'DM Sans', sans-serif !important;
    }

    .page-title h3,
    .breadcrumb-action-dropdown .custom-dropdown-icon > a::after,
    table.dataTable thead th,
    #zero-config thead th,
    .admin-name,
    #zero-config tbody td:nth-child(2),
    .btn {
        font-family: 'Bebas Neue', sans-serif !important;
        font-weight: 400 !important;
        letter-spacing: .04em !important;
    }

    .page-title h3 {
        font-size: clamp(1.6rem, 2.7vw, 2.35rem) !important;
        line-height: .96 !important;
    }

    table.dataTable thead th,
    #zero-config thead th {
        font-size: 1rem !important;
    }

    .btn {
        font-size: 1rem !important;
    }

    #zero-config tbody td:nth-child(2),
    .admin-name {
        font-size: 1.08rem !important;
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
        if (!function_exists('haroTexto')) {
            function haroTexto($texto) {
                $texto = (string) $texto;

                if (function_exists('mb_detect_encoding') && !mb_detect_encoding($texto, 'UTF-8', true)) {
                    $texto = mb_convert_encoding($texto, 'UTF-8', 'ISO-8859-1');
                }

                $map = array(
                    '�' => 'é',
                    'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãº' => 'ú',
                    'Ã�' => 'Á', 'Ã‰' => 'É', 'Ã“' => 'Ó', 'Ãš' => 'Ú',
                    'Ã±' => 'ñ', 'Ã‘' => 'Ñ',
                    'Garc�a' => 'García',
                    'Guti�rrez' => 'Gutiérrez',
                    'P�rez' => 'Pérez',
                    'Gonz�lez' => 'González',
                    'Hern�ndez' => 'Hernández',
                    'Mart�nez' => 'Martínez',
                    'L�pez' => 'López',
                    'S�nchez' => 'Sánchez',
                    'Ram�rez' => 'Ramírez',
                    'Jim�nez' => 'Jiménez',
                    'Rodr�guez' => 'Rodríguez',
                    'D�az' => 'Díaz',
                    'Mu�oz' => 'Muñoz',
                    'N��ez' => 'Núñez'
                );

                return strtr($texto, $map);
            }
        }


        include_once("api/adminClientes.php");
        $adminClientes = new AdministradorClientesBanca();
        $clientes = $adminClientes->dameClientes();
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
                                            <h3>Panel de administración de clientes</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a style="background-color: #5A9F19;" class="btn btn-succes mb-2 me-4 _effect--ripple waves-effect waves-light" href="./cli-nuevo.php" >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"/><path fill="#fff" d="M21,14h6v20h-6V14z"/><path fill="#fff" d="M14,21h20v6H14V21z"/></svg>

                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </header>
                        </div>
                    </div>
                    <!--  END BREADCRUMBS  -->



                    <div class="row layout-top-spacing">

                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        foreach ($clientes as $cliente) {
                                            echo '
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="usr-img-frame me-2 rounded-circle">
                                                            <img alt="avatar" class="img-fluid rounded-circle" src="' . $cliente->imagen . '">
                                                        </div>
                                                        <p class="align-self-center mb-0 admin-name"> ' . $cliente->id . ' </p>
                                                    </div>
                                                </td>
                                                <td>' . htmlspecialchars(haroTexto($cliente->nombre), ENT_QUOTES, 'UTF-8') . '</td>
                                                <td>' . htmlspecialchars(haroTexto($cliente->email), ENT_QUOTES, 'UTF-8') . '</td>
                                                <td>' . htmlspecialchars(haroTexto($cliente->telefono), ENT_QUOTES, 'UTF-8') . '</td>
                                                <td>

                                                ';

                                            if (intval($cliente->autos_venta) <= 0) {
                                                echo '
                                                    <button onclick="eliminarCliente('.$cliente->id.')" class="btn btn-danger mb-2 me-4 _effect--ripple waves-effect waves-light">Eliminar</button>
                                                    <a href="cli-nuevo.php?id='.$cliente->id.'" class="btn btn-warning mb-2 me-4 _effect--ripple waves-effect waves-light">Editar</a>
                                                    <a href="autos-inventario-pre.php?id='.$cliente->id.'"  class="btn btn-susses mb-2 me-4 _effect--ripple waves-effect waves-light">Crear Corrida</a>


                                                    ';
                                            } else {
                                                echo '
                                                    <button class="btn btn-danger mb-2 me-4 _effect--ripple waves-effect waves-light" disabled>Eliminar</button>
                                                    <a href="cli-nuevo.php?id='.$cliente->id.'"  class="btn btn-warning mb-2 me-4 _effect--ripple waves-effect waves-light">Editar</a>
                                                    <a href="autos-inventario-pre.php?id='.$cliente->id.'"  class="btn btn-susses mb-2 me-4 _effect--ripple waves-effect waves-light">Crear Corrida</a>


                                                    ';
                                            }

                                            echo '
                                                
                                                </td>
                                            </tr>
                                            ';
                                        }


                                        ?>





                                    </tbody>
                                    <tfoot>

                                    </tfoot>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->


    <script>
        function eliminarCliente(id) {
            //pregunta swal 

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "api/apiClientes.php",
                        type: "POST",
                        data: {
                            accion: "eliminar",
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                            location.reload();
                        }
                    })
                }
            })


        }
    </script>

</body>

</html>
