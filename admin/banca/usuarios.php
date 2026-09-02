<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Usuarios del sistema - Haro</title>
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
        /* HARO UI redesign - solo diseño */
        :root {
            --haro-red: #e31b23;
            --haro-red-dark: #9f1018;
            --haro-gold: #c4932f;
            --haro-ink: #090d16;
            --haro-ink-2: #111827;
            --haro-text: #283044;
            --haro-muted: #8b93a8;
            --haro-line: #e8ebf3;
            --haro-soft: #f7f8fc;
            --haro-white: #ffffff;
            --haro-shadow: 0 18px 45px rgba(9, 13, 22, .10);
            --haro-radius: 22px;
        }

        body.layout-boxed {
            font-family: 'DM Sans', 'Nunito', sans-serif !important;
            color: var(--haro-text) !important;
            background:
                radial-gradient(circle at top left, rgba(227, 27, 35, .08), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, #f4f6fb 42%, #eef1f7 100%) !important;
        }

        #load_screen .spinner-grow { color: var(--haro-red) !important; }

        .layout-px-spacing { padding: 30px 24px !important; }
        .middle-content.container-xxl { max-width: 1420px; }

        .secondary-nav {
            background: transparent !important;
            box-shadow: none !important;
            margin-bottom: 22px !important;
        }

        .breadcrumbs-container .header {
            min-height: 112px;
            padding: 18px 0 !important;
            background: transparent !important;
            align-items: center;
        }

        .btn-toggle.sidebarCollapse {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(227, 27, 35, .30);
            border-radius: 14px;
            color: var(--haro-red) !important;
            background: rgba(255,255,255,.80);
            box-shadow: 0 10px 24px rgba(9, 13, 22, .08);
            transition: all .22s ease;
        }

        .btn-toggle.sidebarCollapse:hover {
            transform: translateY(-1px);
            background: var(--haro-red);
            color: #fff !important;
            border-color: var(--haro-red);
        }

        .page-header { padding-left: 18px; }

        .page-title h3 {
            margin: 0 0 8px !important;
            font-family: 'Syne', 'Nunito', sans-serif !important;
            font-size: clamp(1.35rem, 2.2vw, 2.15rem) !important;
            line-height: 1.05 !important;
            font-weight: 400 !important;
            letter-spacing: -.04em;
            color: var(--haro-ink) !important;
            text-transform: uppercase;
        }

        .page-title h3::before {
            content: 'ADMINISTRACIÓN HARO';
            display: block;
            margin-bottom: 8px;
            font-size: .68rem;
            line-height: 1;
            letter-spacing: .32em;
            color: var(--haro-red);
            font-weight: 400;
        }

        .breadcrumb-style-one .breadcrumb { margin: 0 !important; }
        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            font-family: 'DM Sans', sans-serif !important;
            font-size: .82rem !important;
            color: var(--haro-muted) !important;
            font-weight: 600;
        }
        .breadcrumb-style-one .breadcrumb-item.active { color: var(--haro-gold) !important; }

        .breadcrumb-action-dropdown .btn,
        .breadcrumb-action-dropdown a.btn {
            min-width: 168px;
            min-height: 46px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 20px !important;
            border-radius: 14px !important;
            border: 1px solid rgba(227, 27, 35, .35) !important;
            background: linear-gradient(135deg, var(--haro-red), var(--haro-red-dark)) !important;
            color: #fff !important;
            box-shadow: 0 14px 30px rgba(227, 27, 35, .24) !important;
            text-decoration: none !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: .8rem;
            font-weight: 400;
            letter-spacing: .04em;
            text-transform: uppercase;
            transition: all .22s ease;
        }

        .breadcrumb-action-dropdown .btn::after { content: 'Nuevo usuario'; }
        .breadcrumb-action-dropdown .btn svg {
            width: 18px !important;
            height: 18px !important;
            filter: brightness(0) invert(1);
        }
        .breadcrumb-action-dropdown .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(227, 27, 35, .32) !important;
        }

        .widget-content.widget-content-area {
            position: relative;
            overflow: hidden;
            padding: 0 !important;
            background: rgba(255,255,255,.92) !important;
            border: 1px solid rgba(232,235,243,.95) !important;
            border-radius: var(--haro-radius) !important;
            box-shadow: var(--haro-shadow) !important;
        }

        .widget-content.widget-content-area::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold), var(--haro-red));
            z-index: 2;
        }

        .dt--top-section {
            padding: 26px 28px 20px !important;
            border-bottom: 1px solid var(--haro-line);
            background: linear-gradient(180deg, #fff 0%, #fbfcff 100%);
        }

        .dataTables_length label,
        .dataTables_info {
            color: var(--haro-muted) !important;
            font-size: .82rem !important;
            font-weight: 700 !important;
            letter-spacing: .08em;
        }

        .dataTables_length select,
        .dataTables_filter input {
            height: 42px !important;
            border-radius: 12px !important;
            border: 1px solid #dfe4ef !important;
            background-color: #f8f9fd !important;
            color: var(--haro-text) !important;
            font-family: 'DM Sans', sans-serif !important;
            font-weight: 600 !important;
            outline: none !important;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.6) !important;
        }

        .dataTables_length select { padding: 8px 34px 8px 12px !important; }
        .dataTables_filter input { padding: 8px 14px 8px 40px !important; min-width: 250px; }
        .dataTables_filter input:focus,
        .dataTables_length select:focus {
            border-color: rgba(227,27,35,.55) !important;
            box-shadow: 0 0 0 4px rgba(227,27,35,.10) !important;
        }
        .dataTables_filter label svg { color: var(--haro-red) !important; }

        #zero-config {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
        }

        #zero-config thead th {
            padding: 16px 18px !important;
            background: #f4f6fb !important;
            border-bottom: 1px solid var(--haro-line) !important;
            color: #9aa2b8 !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: .72rem !important;
            font-weight: 400 !important;
            letter-spacing: .12em !important;
            text-transform: uppercase !important;
            white-space: nowrap;
        }

        #zero-config tbody td {
            padding: 16px 18px !important;
            border-bottom: 1px solid #edf0f6 !important;
            color: var(--haro-text) !important;
            font-size: .9rem !important;
            font-weight: 600;
            vertical-align: middle !important;
            background: #fff !important;
        }

        #zero-config tbody tr { transition: all .22s ease; }
        #zero-config tbody tr:hover td { background: #fff7f7 !important; }
        #zero-config tbody td:first-child {
            font-family: 'Bebas Neue', sans-serif;
            color: var(--haro-red) !important;
            font-weight: 400;
        }
        #zero-config tbody td:nth-child(2) {
            font-family: 'Bebas Neue', sans-serif;
            color: var(--haro-ink) !important;
            font-weight: 400;
        }
        #zero-config tbody td:nth-child(4) { color: var(--haro-muted) !important; }
        #zero-config tbody td:nth-child(5) {
            color: var(--haro-gold) !important;
            text-transform: uppercase;
            letter-spacing: .06em;
            font-size: .78rem !important;
        }

        #zero-config tbody td .btn,
        #zero-config tbody td button {
            border: 1px solid rgba(227, 27, 35, .32) !important;
            background: #fff0f0 !important;
            color: var(--haro-red) !important;
            border-radius: 10px !important;
            padding: 8px 14px !important;
            margin: 0 !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: .75rem !important;
            font-weight: 400 !important;
            letter-spacing: .04em;
            text-transform: uppercase;
            box-shadow: none !important;
            transition: all .22s ease;
        }

        #zero-config tbody td .btn:hover,
        #zero-config tbody td button:hover {
            background: var(--haro-red) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }

        .dt--bottom-section {
            padding: 18px 28px !important;
            border-top: 1px solid var(--haro-line);
            background: #fff !important;
        }
        .dt--pagination .pagination { gap: 6px; }
        .dt--pagination .paginate_button,
        .page-item .page-link {
            border-radius: 10px !important;
            border-color: #e4e8f2 !important;
            color: var(--haro-text) !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-weight: 700 !important;
        }
        .dt--pagination .paginate_button.current,
        .page-item.active .page-link {
            background: var(--haro-red) !important;
            border-color: var(--haro-red) !important;
            color: #fff !important;
        }

        .footer-wrapper {
            margin-top: 24px;
            padding: 20px 28px !important;
            border-top: 1px solid rgba(232,235,243,.9) !important;
            background: rgba(255,255,255,.76) !important;
            color: var(--haro-muted) !important;
            font-family: 'DM Sans', sans-serif !important;
        }
        .footer-wrapper a { color: var(--haro-red) !important; font-weight: 400; }
        .footer-wrapper svg { color: var(--haro-red) !important; stroke: var(--haro-red) !important; }

        body.dark,
        .dark body,
        [data-bs-theme="dark"] body {
            background: radial-gradient(circle at top left, rgba(227,27,35,.16), transparent 35%), #090d16 !important;
            color: #d9deea !important;
        }
        body.dark .widget-content.widget-content-area,
        .dark .widget-content.widget-content-area {
            background: rgba(13,18,30,.96) !important;
            border-color: rgba(255,255,255,.08) !important;
        }
        body.dark .dt--top-section,
        body.dark .dt--bottom-section,
        .dark .dt--top-section,
        .dark .dt--bottom-section { background: #0d121e !important; border-color: rgba(255,255,255,.08) !important; }
        body.dark #zero-config thead th,
        .dark #zero-config thead th { background: #111827 !important; color: #9aa3b8 !important; border-color: rgba(255,255,255,.08) !important; }
        body.dark #zero-config tbody td,
        .dark #zero-config tbody td { background: #0d121e !important; color: #d9deea !important; border-color: rgba(255,255,255,.07) !important; }
        body.dark #zero-config tbody tr:hover td,
        .dark #zero-config tbody tr:hover td { background: rgba(227,27,35,.10) !important; }
        body.dark .page-title h3,
        .dark .page-title h3 { color: #fff !important; }
        body.dark .dataTables_length select,
        body.dark .dataTables_filter input,
        .dark .dataTables_length select,
        .dark .dataTables_filter input { background: #111827 !important; border-color: rgba(255,255,255,.12) !important; color: #e5e7eb !important; }
        body.dark .footer-wrapper,
        .dark .footer-wrapper { background: rgba(13,18,30,.92) !important; border-color: rgba(255,255,255,.08) !important; }

        @media (max-width: 991px) {
            .breadcrumbs-container .header { min-height: auto; flex-wrap: wrap; gap: 14px; }
            .page-header { padding-left: 12px; }
            .breadcrumb-action-dropdown { width: 100%; justify-content: flex-start; margin-left: 0 !important; }
            .breadcrumb-action-dropdown .btn { min-width: 100%; }
            .dataTables_filter input { min-width: 100%; width: 100%; }
        }

        @media (max-width: 575px) {
            .layout-px-spacing { padding: 22px 14px !important; }
            .page-title h3 { font-size: 1.22rem !important; }
            .dt--top-section, .dt--bottom-section { padding-left: 16px !important; padding-right: 16px !important; }
            #zero-config thead th, #zero-config tbody td { padding: 14px 12px !important; }
        }
    </style>


<style>
.page-title h3,
#zero-config thead th,
#zero-config tbody td:first-child,
#zero-config tbody td:nth-child(2),
.breadcrumb-action-dropdown .btn,
#zero-config tbody td .btn{
font-family:'Bebas Neue',sans-serif!important;
font-weight:400!important;
letter-spacing:.05em!important;
}
.page-title h3{
font-size:clamp(2rem,3vw,3rem)!important;
}
.breadcrumb-action-dropdown .btn::after{
content:'Nuevo usuario'!important;
}
#zero-config tbody td:first-child{
font-size:1.1rem!important;
color:#b0141b!important;
}
#zero-config tbody td:nth-child(2){
font-size:1.15rem!important;
color:#131316!important;
}
#zero-config tbody td .btn{
background:rgba(176,20,27,.10)!important;
border-color:rgba(176,20,27,.22)!important;
color:#b0141b!important;
}
#zero-config tbody td .btn:hover{
background:#b0141b!important;
color:#fff!important;
}
.btn-haro-edit{
    background: linear-gradient(135deg,#d4a63a,#b8871e) !important;
    border: 1px solid #e3c16d !important;
    color: #111 !important;
    border-radius: 10px !important;
    font-family:'Bebas Neue',sans-serif !important;
    letter-spacing:.05em;
    text-transform:uppercase;
    transition:.25s ease;
}

.btn-haro-edit:hover{
    background: linear-gradient(135deg,#e3b64c,#c79524) !important;
    color:#111 !important;
    transform:translateY(-1px);
    box-shadow:0 10px 20px rgba(201,162,74,.35);
}
</style>


<style id="haro-edit-button-final-fix">
#zero-config tbody td .btn-haro-edit,
#zero-config tbody td a.btn-haro-edit {
    background: #f1c40f !important;
color: #2c3e50 !important; /* Texto gris oscuro/azul para un contraste suave */
border: 1px solid #d4ac0d !important;
border-radius: 6px;
}

#zero-config tbody td .btn-haro-edit:hover,
#zero-config tbody td a.btn-haro-edit:hover {
    background: linear-gradient(135deg,#d4a63a,#b8871e) !important;
border: 1px solid #e3c16d !important;
color: #111 !important;
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

        include_once("../api/adminUsuarios.php");
        $adminUsuarios = new administradorUsuarios();
        $usuarios = $adminUsuarios->dameUsuarios();

        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Usuarios">
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
                                            <h3>Panel de administración de usuarios del sistema</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a class="btn mb-2 me-4 _effect--ripple waves-effect waves-light" href="usuario-nuevo.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                                    <path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z" />
                                                    <path fill="#fff" d="M21,14h6v20h-6V14z" />
                                                    <path fill="#fff" d="M14,21h20v6H14V21z" />
                                                </svg>

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
                                <table id="zero-config">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Nombre </th>
                                            <th> Apellidos </th>
                                            <th> Correos </th>
                                            <th> Rol </th>
                                            <th> Acciones </th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php

                                        foreach ($usuarios as $usuario) {
                                            echo "<tr>";
                                            echo "<td>" . $usuario->id . "</td>";
                                            echo "<td>" . $usuario->nombre . "</td>";
                                            echo "<td>" . $usuario->apellidoPaterno . " " . $usuario->apellidoMaterno . "</td>";
                                            echo "<td>" . $usuario->email . "</td>";
                                            echo "<td>" . $usuario->permiso_banca . "</td>";
                                            echo '<td><button onclick="baja('.$usuario->id.')" class="btn btn-warning btn-rounded mb-2 me-4 _effect--ripple waves-effect waves-light" style="background-color: #DA2D19; ">Eliminar</button>
                                                 <a href="usuario-nuevo.php?id=' . $usuario->id . '" class="btn btn-haro-edit btn-rounded mb-2 me-4 _effect--ripple waves-effect waves-light">Editar</a>
                                            </td>';
                                            echo "</tr>";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                "sSearchPlaceholder": "Buscar usuario...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->


    <script>
        function baja(id) {

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009378',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let datos = new FormData();
                    datos.append("accion", "eliminar");
                    datos.append("id", id);

                    fetch("../api/apiUsuarios.php", {
                            method: "POST",
                            body: datos,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {

                            console.log(data);

                            console.log("Registro Exitoso");
                            location.reload();
                        });
                }
            })




        }
    </script>

</body>

</html>