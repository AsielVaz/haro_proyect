<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Selección de autos - Haro</title>
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


<style id="haro-seleccion-autos-final">
:root{--haro-bg:#f4f1ea;--haro-paper:rgba(255,255,255,.90);--haro-black:#0b0b0d;--haro-ink:#161616;--haro-muted:#77736b;--haro-red:#b0141b;--haro-gold:#c9a24a;--haro-line:rgba(19,19,22,.08);--haro-line-gold:rgba(201,162,74,.20);--haro-radius:26px;--haro-shadow:0 18px 48px rgba(15,15,18,.09);--haro-transition:220ms cubic-bezier(.4,0,.2,1);}
body.layout-boxed{background:radial-gradient(circle at top right,rgba(201,162,74,.16),transparent 32%),radial-gradient(circle at 7% 24%,rgba(176,20,27,.07),transparent 28%),linear-gradient(180deg,#fbf8f1 0%,var(--haro-bg) 46%,#eee8dc 100%)!important;font-family:'DM Sans','Nunito',sans-serif!important;color:var(--haro-ink)!important;}
#load_screen{background:var(--haro-bg)!important;}#load_screen .spinner-grow{background-color:var(--haro-red)!important;color:var(--haro-red)!important;}
.layout-px-spacing{padding:30px 26px!important;}
.secondary-nav,.breadcrumbs-container{background:transparent!important;box-shadow:none!important;border:0!important;}
.secondary-nav .header{background:var(--haro-paper)!important;border:1px solid var(--haro-line-gold)!important;border-radius:var(--haro-radius)!important;padding:20px 22px!important;min-height:auto!important;box-shadow:var(--haro-shadow)!important;backdrop-filter:blur(14px);position:relative;overflow:hidden;}
.secondary-nav .header::before{content:"";position:absolute;inset:0 0 auto 0;height:4px;background:linear-gradient(90deg,var(--haro-red),var(--haro-gold),var(--haro-red));}
.btn-toggle.sidebarCollapse{width:44px!important;height:44px!important;min-width:44px!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;border-radius:15px!important;background:linear-gradient(135deg,#fff,#f7efe2)!important;border:1px solid rgba(176,20,27,.18)!important;color:var(--haro-red)!important;box-shadow:0 10px 24px rgba(16,15,12,.10)!important;transition:transform var(--haro-transition),box-shadow var(--haro-transition),border-color var(--haro-transition);}
.btn-toggle.sidebarCollapse:hover{transform:translateY(-2px);border-color:rgba(176,20,27,.38)!important;box-shadow:0 16px 32px rgba(176,20,27,.13)!important;}
.page-header{padding:0!important;}
.haro-page-title .haro-eyebrow{display:inline-flex;align-items:center;gap:9px;color:var(--haro-red);font-family:'Bebas Neue',sans-serif;font-size:1.05rem;font-weight:400;letter-spacing:.09em;text-transform:uppercase;margin-bottom:5px;}
.haro-page-title .haro-eyebrow::before{content:"";width:30px;height:2px;border-radius:999px;background:var(--haro-gold);}
.page-title h3{margin:0!important;color:var(--haro-black)!important;font-family:'Bebas Neue',sans-serif!important;font-size:clamp(2rem,3vw,3.05rem)!important;font-weight:400!important;letter-spacing:.035em!important;line-height:.94!important;text-transform:uppercase;}
.breadcrumb{margin:9px 0 0!important;}.breadcrumb-item,.breadcrumb-item a{color:var(--haro-muted)!important;font-size:.8rem!important;font-weight:700;text-decoration:none!important;}.breadcrumb-item.active{color:var(--haro-red)!important;}
.haro-table-card,.widget-content.widget-content-area{background:var(--haro-paper)!important;border:1px solid var(--haro-line-gold)!important;border-radius:var(--haro-radius)!important;box-shadow:var(--haro-shadow)!important;backdrop-filter:blur(12px);overflow:hidden;padding:0!important;}
.haro-table-card::before,.widget-content.widget-content-area::before{content:"";display:block;height:4px;background:linear-gradient(90deg,var(--haro-red),var(--haro-gold));}
.dt--top-section{padding:22px 24px 18px!important;background:linear-gradient(135deg,rgba(176,20,27,.04),rgba(201,162,74,.08))!important;border-bottom:1px solid var(--haro-line);}
.dataTables_length label,.dataTables_info{color:var(--haro-muted)!important;font-size:13px!important;font-weight:700!important;}
.dataTables_length select,.dataTables_filter input{background:#fff!important;border:1px solid rgba(201,162,74,.23)!important;border-radius:14px!important;color:var(--haro-ink)!important;font-family:'DM Sans',sans-serif!important;font-size:13px!important;min-height:40px;outline:none!important;}
.dataTables_filter input{min-width:260px;padding:8px 14px 8px 38px!important;}
.dataTables_filter input:focus,.dataTables_length select:focus{border-color:rgba(176,20,27,.42)!important;box-shadow:0 0 0 4px rgba(176,20,27,.10)!important;}
.haro-auto-table{width:100%!important;margin:0!important;border-collapse:separate!important;border-spacing:0!important;}
.haro-auto-table thead th{background:#181411!important;color:#f9efe0!important;border:none!important;padding:16px 18px!important;font-family:'Bebas Neue',sans-serif!important;font-size:1rem!important;font-weight:400!important;letter-spacing:.07em!important;text-transform:uppercase;white-space:nowrap;}
.haro-auto-table tbody td{padding:18px!important;border-color:rgba(19,19,22,.07)!important;color:var(--haro-ink)!important;font-family:'DM Sans',sans-serif!important;font-size:14px;font-weight:650;vertical-align:middle!important;background:transparent!important;}
.haro-auto-table tbody tr:nth-child(even){background:rgba(250,248,243,.72)!important;}
.haro-auto-table tbody tr:hover{background:linear-gradient(90deg,rgba(176,20,27,.055),rgba(201,162,74,.055))!important;}
.haro-auto-table tbody td:first-child{width:180px;}
.haro-auto-table tbody td:first-child img{width:150px!important;height:94px!important;object-fit:cover!important;border-radius:18px!important;border:1px solid rgba(201,162,74,.22);box-shadow:0 12px 26px rgba(15,15,18,.12);}
.haro-auto-table tbody td:nth-child(2){color:var(--haro-black)!important;font-family:'Bebas Neue',sans-serif!important;font-size:1.32rem!important;font-weight:400!important;letter-spacing:.04em!important;}
.haro-auto-table tbody td:nth-child(4){color:var(--haro-red)!important;font-family:'Bebas Neue',sans-serif!important;font-size:1.25rem!important;font-weight:400!important;letter-spacing:.04em!important;}
.btn-haro-action{min-height:44px;padding:10px 18px!important;border-radius:15px!important;border:1px solid rgba(201,162,74,.26)!important;background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;color:#fff!important;font-family:'Bebas Neue',sans-serif!important;font-size:1.05rem!important;font-weight:400!important;letter-spacing:.06em;text-transform:uppercase;box-shadow:0 12px 26px rgba(176,20,27,.22);text-decoration:none!important;transition:transform var(--haro-transition),box-shadow var(--haro-transition);}
.btn-haro-action:hover{color:#fff!important;transform:translateY(-2px);box-shadow:0 18px 36px rgba(176,20,27,.28);}
.dt--bottom-section{padding:18px 24px!important;border-top:1px solid var(--haro-line);background:rgba(250,248,243,.88)!important;}
.dt--pagination .paginate_button,.dataTables_paginate .paginate_button{border-radius:12px!important;border:1px solid transparent!important;color:var(--haro-muted)!important;font-family:'Bebas Neue',sans-serif!important;font-weight:400!important;letter-spacing:.05em;margin:0 2px!important;}
.dt--pagination .paginate_button.current,.dataTables_paginate .paginate_button.current{background:var(--haro-red)!important;border-color:var(--haro-red)!important;color:#fff!important;}
.haro-footer{margin-top:34px!important;}
@media(max-width:768px){.layout-px-spacing{padding:22px 14px!important}.secondary-nav .header{align-items:flex-start!important;padding:18px!important}.page-title h3{font-size:2rem!important}.dataTables_filter input{min-width:100%;width:100%!important}.dt--top-section .row{gap:12px}.dt--top-section .row>div{width:100%}.haro-auto-table thead th,.haro-auto-table tbody td{padding:14px 12px!important}.haro-auto-table tbody td:first-child{width:120px}.haro-auto-table tbody td:first-child img{width:96px!important;height:72px!important;border-radius:14px!important}.btn-haro-action{width:100%;margin:0!important;text-align:center}}
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
        include_once("../api/adminAutos.php");
        $adminAutos = new AdministradorAutos();
        $autos = $adminAutos->dameAutos();
        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Simulación">
                            <header class="header navbar navbar-expand-sm">
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">

                                        <div class="page-title haro-page-title">
                                            <span class="haro-eyebrow">Ventas</span>
                                            <h3>Panel de selección de autos</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Simulación</li>
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
                                <table id="zero-config" class="table table-striped dt-table-hover haro-auto-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Auto</th>
                                            <th>Precio</th>
                                            <th style="display: none;">Precio Hidden</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($autos as $auto) {

                                            if ($auto->imagen == "") {
                                                $imagen = $auto->imagenes[0]->url;
                                            } else {
                                                $imagen = $auto->imagen;
                                            }

                                            // echo var_dump($auto->imagenes);
                                            echo '
                                            <a target="_blank" href="venta-nueva.php?auto=' . $auto->id . '" >
                                            <tr class="columna" style=" background-image: url("'.$imagen.'");>
                                                <td>
                                                 
                                                 <img alt="avatar" class="img-fluid" src="' . $imagen . '" style="width: 100%;">
                                                        
                                                </td>
                                                <td>' . $auto->marca->marca . ' ' . $auto->modelo->modelo . ' ' . $auto->anio . ' </td>
                                         
                                                <td style="display: none;" >' . $auto->precio . '</td>
                                                <td>$ ' . number_format($auto->precio, 2) . '</td>
                                                <td>
                                                
                                                <a target="_blank" href="venta-nueva-pre.php?auto=' . $auto->id . '&cliente='.$_GET['id'].'"  class="btn btn-haro-action btn-rounded mb-2 me-4 _effect--ripple waves-effect waves-light">Simular compra</a>
                                               
                                            </tr>
                                            </a>
                                       
                                            
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
            <?php include_once("template/footer_haro.php"); ?>
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
                "sSearchPlaceholder": "Buscar auto...",
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