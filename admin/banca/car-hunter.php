<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Prospectos Car Hunter - Haro</title>
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
.page-title h3,
.table thead th,
.table tbody td:nth-child(1),
.table tbody td:nth-child(2),
.table tbody td:nth-child(3),
.btn-flotante{
font-family:'Bebas Neue',sans-serif!important;
font-weight:400!important;
letter-spacing:.05em!important;
}
.page-title h3{
font-size:clamp(1.9rem,2.8vw,2.8rem)!important;
}
.table thead th{
font-size:.95rem!important;
}
.table tbody td:nth-child(1){
color:#b0141b!important;
font-size:1.05rem;
}
.btn-flotante{
font-size:1rem!important;
background:linear-gradient(135deg,#b0141b,#6f1818)!important;
}
.haro-prospect-table textarea,
.haro-prospect-table select{
font-family:'DM Sans',sans-serif!important;
}
</style>

</head>

<style>
    :root {
        --haro-bg: #f4f1ec;
        --haro-card: #ffffff;
        --haro-card-2: #fbfaf8;
        --haro-ink: #17120f;
        --haro-muted: #756c64;
        --haro-soft: #a79a90;
        --haro-border: rgba(58, 43, 35, .12);
        --haro-red: #8f1d1d;
        --haro-red-2: #651414;
        --haro-gold: #c5a267;
        --haro-gold-soft: rgba(197, 162, 103, .16);
        --haro-shadow: 0 18px 45px rgba(42, 28, 20, .10);
        --haro-shadow-sm: 0 8px 24px rgba(42, 28, 20, .08);
        --haro-radius: 22px;
        --haro-radius-sm: 14px;
    }

    body.layout-boxed {
        background:
            radial-gradient(circle at top left, rgba(197,162,103,.20), transparent 34%),
            linear-gradient(135deg, #f8f6f1 0%, var(--haro-bg) 54%, #ece6dd 100%) !important;
        color: var(--haro-ink) !important;
        font-family: 'DM Sans', 'Nunito', sans-serif !important;
    }

    .layout-px-spacing { padding: 30px 24px 100px !important; }

    .secondary-nav .breadcrumbs-container,
    .secondary-nav .header {
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
    }

    .secondary-nav .header {
        min-height: auto !important;
        padding: 22px 24px !important;
        border-radius: var(--haro-radius) !important;
        background:
            linear-gradient(135deg, rgba(23,18,15,.97), rgba(101,20,20,.94)),
            radial-gradient(circle at right top, rgba(197,162,103,.34), transparent 38%) !important;
        border: 1px solid rgba(197,162,103,.22) !important;
        box-shadow: var(--haro-shadow) !important;
        overflow: hidden;
        position: relative;
    }

    .secondary-nav .header:after {
        content: '';
        position: absolute;
        right: -70px;
        top: -80px;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: rgba(197,162,103,.17);
        pointer-events: none;
    }

    .secondary-nav .btn-toggle {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.09) !important;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,.12);
        margin-right: 16px;
        position: relative;
        z-index: 2;
    }

    .secondary-nav .btn-toggle svg { stroke: currentColor; }

    .page-title h3 {
        margin: 0 !important;
        color: #fff !important;
        font-family: 'Bebas Neue', 'DM Sans', sans-serif !important;
        font-weight: 400 !important;
        font-size: clamp(1.15rem, 2.1vw, 1.75rem) !important;
        letter-spacing: -.03em;
        line-height: 1.15;
        position: relative;
        z-index: 2;
    }

    .breadcrumb-style-one .breadcrumb { margin-top: 8px !important; margin-bottom: 0 !important; }
    .breadcrumb-style-one .breadcrumb .breadcrumb-item,
    .breadcrumb-style-one .breadcrumb .breadcrumb-item a {
        color: rgba(255,255,255,.66) !important;
        font-size: 12px !important;
        font-weight: 600;
        text-decoration: none;
    }
    .breadcrumb-style-one .breadcrumb .breadcrumb-item.active { color: var(--haro-gold) !important; }

    .breadcrumb-action-dropdown .btn {
        width: 46px;
        height: 46px;
        padding: 0 !important;
        border-radius: 15px !important;
        border: 1px solid rgba(197,162,103,.40) !important;
        background: linear-gradient(135deg, var(--haro-gold), #e0c487) !important;
        box-shadow: 0 12px 28px rgba(197,162,103,.28) !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        transition: transform .22s ease, box-shadow .22s ease;
    }

    .breadcrumb-action-dropdown .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 34px rgba(197,162,103,.36) !important;
    }

    .breadcrumb-action-dropdown .btn svg { width: 28px !important; height: 28px !important; }
    .breadcrumb-action-dropdown .btn svg path:first-child { fill: transparent !important; }
    .breadcrumb-action-dropdown .btn svg path:not(:first-child) { fill: #251915 !important; }

    .widget-content.widget-content-area {
        background: rgba(255,255,255,.86) !important;
        border: 1px solid var(--haro-border) !important;
        border-radius: var(--haro-radius) !important;
        box-shadow: var(--haro-shadow-sm) !important;
        padding: 0 !important;
        overflow: hidden;
        backdrop-filter: blur(12px);
    }

    .table {
        margin-bottom: 0 !important;
        min-width: 1040px;
        border-color: transparent !important;
    }

    .widget-content-area { overflow-x: auto !important; }
    .widget-content-area::-webkit-scrollbar { height: 8px; }
    .widget-content-area::-webkit-scrollbar-thumb { background: rgba(143,29,29,.35); border-radius: 999px; }

    .table thead th {
        background: linear-gradient(180deg, #fffaf2, #f5efe4) !important;
        color: var(--haro-red) !important;
        font-family: 'Bebas Neue', 'DM Sans', sans-serif !important;
        font-weight: 400 !important;
        font-size: 11px !important;
        text-transform: uppercase;
        letter-spacing: .08em;
        border: 0 !important;
        border-bottom: 1px solid rgba(197,162,103,.28) !important;
        padding: 17px 18px !important;
        white-space: nowrap;
    }

    .table tbody td {
        color: var(--haro-ink) !important;
        font-size: 14px !important;
        font-weight: 600;
        vertical-align: middle !important;
        border-color: rgba(58,43,35,.08) !important;
        padding: 18px !important;
        background: rgba(255,255,255,.72) !important;
    }

    .table tbody tr {
        transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
    }

    .table tbody tr:hover td {
        background: rgba(197,162,103,.09) !important;
    }

    .table tbody td:nth-child(1) {
        font-family: 'Bebas Neue', 'DM Sans', sans-serif !important;
        font-weight: 400;
        color: var(--haro-red) !important;
    }

    .table tbody td:nth-child(5) {
        color: #2f221b !important;
        font-weight: 400;
        white-space: nowrap;
    }

    .form-control.form-control-lg,
    textarea {
        width: 100% !important;
        min-width: 230px;
        border: 1px solid rgba(58,43,35,.14) !important;
        border-radius: 14px !important;
        background: var(--haro-card-2) !important;
        color: var(--haro-ink) !important;
        font-family: 'DM Sans', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        box-shadow: none !important;
        transition: border-color .22s ease, box-shadow .22s ease, background .22s ease;
    }

    .form-control.form-control-lg {
        min-height: 44px !important;
        padding: 9px 14px !important;
    }

    textarea {
        min-height: 96px;
        resize: vertical;
        padding: 12px 14px;
        line-height: 1.45;
    }

    .form-control.form-control-lg:focus,
    textarea:focus {
        outline: none !important;
        border-color: var(--haro-gold) !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(197,162,103,.18) !important;
    }

    .btn-flotante {
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 400;
        color: #ffffff !important;
        border-radius: 16px;
        letter-spacing: .08em;
        background: linear-gradient(135deg, var(--haro-red), var(--haro-red-2));
        border: 1px solid rgba(197,162,103,.28);
        padding: 15px 24px;
        position: fixed;
        bottom: 32px;
        right: 32px;
        transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
        box-shadow: 0 18px 34px rgba(101,20,20,.28);
        z-index: 99;
    }

    .btn-flotante:hover {
        background: linear-gradient(135deg, #a72525, var(--haro-red));
        box-shadow: 0 24px 44px rgba(101,20,20,.34);
        transform: translateY(-4px);
    }

    .footer-wrapper {
        background: transparent !important;
        border-top: 1px solid rgba(58,43,35,.10) !important;
        color: var(--haro-muted) !important;
        padding: 22px 28px 90px !important;
    }

    .footer-wrapper p,
    .footer-wrapper a { color: var(--haro-muted) !important; font-size: 12px !important; }
    .footer-wrapper svg { stroke: var(--haro-red) !important; }

    body.dark .layout-px-spacing,
    body.dark.layout-boxed {
        background:
            radial-gradient(circle at top left, rgba(197,162,103,.14), transparent 30%),
            linear-gradient(135deg, #120f0d 0%, #1c1512 48%, #2a1111 100%) !important;
    }

    body.dark .widget-content.widget-content-area {
        background: rgba(23,18,15,.92) !important;
        border-color: rgba(197,162,103,.16) !important;
    }

    body.dark .table thead th {
        background: linear-gradient(180deg, #241916, #1a1210) !important;
        color: var(--haro-gold) !important;
        border-bottom-color: rgba(197,162,103,.18) !important;
    }

    body.dark .table tbody td {
        background: rgba(23,18,15,.72) !important;
        color: rgba(255,255,255,.86) !important;
        border-color: rgba(197,162,103,.10) !important;
    }

    body.dark .table tbody tr:hover td { background: rgba(197,162,103,.10) !important; }
    body.dark .table tbody td:nth-child(1),
    body.dark .table tbody td:nth-child(5) { color: #f0d79e !important; }

    body.dark .form-control.form-control-lg,
    body.dark textarea {
        background: rgba(255,255,255,.06) !important;
        color: #fff !important;
        border-color: rgba(197,162,103,.16) !important;
    }

    body.dark .form-control.form-control-lg option { color: #17120f; }

    @media (max-width: 991px) {
        .secondary-nav .header { align-items: flex-start !important; flex-wrap: wrap; gap: 12px; }
        .breadcrumb-action-dropdown { margin-left: 0 !important; width: 100%; justify-content: flex-start; }
        .layout-px-spacing { padding: 22px 14px 96px !important; }
    }

    @media (max-width: 575px) {
        .secondary-nav .header { padding: 18px !important; }
        .page-title h3 { font-size: 1.05rem !important; }
        .table { min-width: 920px; }
        .table thead th,
        .table tbody td { padding: 14px !important; }
        .btn-flotante { left: 16px; right: 16px; bottom: 18px; width: calc(100% - 32px); }
        .footer-wrapper { padding-bottom: 86px !important; }
    }
</style>


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
        include_once("../api/adminCarHunter.php");
        include_once("../api/adminAutos.php");

        $adminAutos = new AdministradorAutos();
        $adminCarHunter = new AdministradorCarHunter();
        $hunters = $adminCarHunter->dameCarHunter();
        $adminUsuario = new administradorUsuarios();
        $autos = $adminAutos->dameAutosSinPausar();

        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));
        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Car Hunter">
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
                                            <h3>Prospectos por Car Hunter</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Car Hunter</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>

                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a style="background-color: #5A9F19;" class="btn btn-succes mb-2 me-4 _effect--ripple waves-effect waves-light" href="./auto-nuevo.php">
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
                            <table class="table table-bordered table-hover haro-prospect-table">
                                            <thead>
                                                <tr>
                                                    <th> Nombre </th>
                                                    <th> Busca Marca </th>
                                                    <th> Busca Modelo </th>
                                                    <th> Correo </th>
                                                    <th> Precio </th>
                                                    <th> Auto Prospecto </th>
                                                    <th> Mensaje </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                        foreach ($hunters as $hunter) {
                          echo '
                          <tr>
                            <td> ' . $hunter->nombre . ' </td>
                            <td> ' . $hunter->marca . ' </td>
                            ';

                          if ($hunter->modelo == "") {
                            echo '<td> No especificó </td>';
                          } else {
                            echo '<td> ' . $hunter->modelo . ' </td>';
                          }
                          echo ' 
                            
                            <td> ' . $hunter->email . ' </td>

                            <td> $' . number_format($hunter->precioMin)  . ' - $' . number_format($hunter->precioMax) . ' </td>
                            <td> 
                            <select onchange="asignarValores(this.value)" class="form-control form-control-lg" id="exampleFormControlSelect1">
                      

                              ';

                          if ($hunter->avisado == "0") {
                            echo '<option value="0">Seleccione Un auto</option>';

                            foreach ($autos as $auto) {

                              echo '
                                  <option value="' . $hunter->id . ',' . $auto->id . '"> ' . $auto->marca->marca . ' ' . $auto->modelo->modelo . ' $' . number_format($auto->precio) . ' </option>
                                  ';
                            }
                          } else {
                            echo '
                            <option value="0"> Ya fue avisado </option>
                            ';
                          }



                          echo ' 
                          <td> <textarea name="" id="mensaje' . $hunter->id . '" cols="20" rows="5"></textarea></td>

                            </select>
                            </td>
                          </tr>
                          ';
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
            <button onclick="notificar()" class="btn-flotante">Notificar</button>

            < <?php include_once("template/footer_haro.php"); ?>
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
                "sSearchPlaceholder": "Buscar prospecto...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
    var arreglo = [];
    var autoId = 0;
    var imagenId = 0;

    function asignarValores(valores) {
        console.log(valores);
        var ids = valores.split(",");
        console.log(ids);
        autoId = ids[0];
        imagenId = ids[1];
        var par = new Object();
        par.carHunter = autoId;
        par.auto = imagenId;
        arreglo.push(par);
        console.log(arreglo);
    }

    // Eliminar Cliente
    function deleteCliente(id) {
        let datosDeInicioAuto = new FormData();
        datosDeInicioAuto.append("accion", "eliminar");
        datosDeInicioAuto.append("id", id);
        fetch("../api/apiCliente.php", {
                method: "POST",
                body: datosDeInicioAuto,
            })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                if (data == "1") {
                    console.log("Registro Exitoso");
                    location.reload();
                } else {
                    console.log("Error");
                }
            });
    }

    // Agregar Cliente
    const formCliente = document.getElementById("formCliente");

    formCliente.addEventListener("submit", (e) => {
        e.preventDefault();
        let formData = new FormData(formCliente);
        formData.append("accion", "agregar");
        fetch("../api/apiCliente.php", {
                method: "POST",
                body: formData,
            })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                if (data == "1") {
                    console.log("Registro Exitoso");
                } else {
                    console.log("Error");
                }
            });
        formCliente.reset();
    });

    function notificar() {
        for (let i = 0; i < arreglo.length; i++) {
            let chData = new FormData();
            mensaje = document.getElementById("mensaje" + arreglo[i].carHunter).value;
            console.log(arreglo[i].carHunter);
            chData.append("accion", "notificarManual");
            chData.append("carHunter", arreglo[i].carHunter);
            chData.append("auto", arreglo[i].auto);
            chData.append("mensaje", mensaje);
            fetch("../api/apiCarHunter.php", {
                    method: "POST",
                    body: chData,
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log(data);
                    if (data == "1") {
                        console.log("Registro Exitoso");
                    } else {
                        console.log("Error");
                    }
                });

            if (i == arreglo.length - 1) {
                location.reload();
            }
        }
    }
    </script>

</body>

</html>