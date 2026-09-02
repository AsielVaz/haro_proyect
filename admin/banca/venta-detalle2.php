<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>HARO - VENTA </title>
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
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="../src/assets/css/light/elements/infobox.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/elements/infobox.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/components/tabs.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>

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
        include_once("api/adminVentas.php");
        $adminVentas = new AdministradorVentas();
        $venta = $adminVentas->dameVenta($_GET['id']);
        $totalVentaParcial = $venta->pagos_acumulados;
        include_once("../api/adminAutos.php");
        $adminAutos = new AdministradorAutos();
        $auto = $adminAutos->dameAuto($venta->id_auto);
        if ($auto->imagen == "") {
            $imagen = $auto->imagenes[0]->url;
        } else {
            $imagen = $auto->imagen;
        }


        //echo var_dump($venta);


        ?>
        <?php
        include_once("api/adminPagos.php");
        $adminPagos = new AdministradorPagos();
        $pagos = $adminPagos->damePagosVenta($venta->id);
        $pagoProximo = $adminPagos->damePagoProximo($venta->id, $totalVentaParcial);
        $pagosProspectos = $adminPagos->damePagosEventos($venta->id);
        ?>

        <?php

        function formatearFecha($fecha)
        {
            $fechaF = explode("-", $fecha);
            $fechaF = $fechaF[2] . "/" . $fechaF[1] . "/" . $fechaF[0];
            return $fechaF;
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
                                            <h3>Panel de creacion de ventas nuevas</h3>
                                            </dizv>

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


                        <div class="info-box-2">
                            <div class="info-box-2-bg" style="background: url('<?php echo $imagen ?>');"></div>
                            <div class="info-box-2-bg-blur"></div>
                            <div class="info-box-2-content-wrapper">
                                <h3 class="info-box-2-title"><?php echo $venta->identificador ?></h3>
                                <div class="info-box-2-content">Precio pactado: $<?php echo number_format($venta->precio_pactado, 2)  ?></div>
                                <div class="info-box-2-content">Comisión Venta: $<?php echo number_format($venta->comision, 2)  ?></div>
                                <div class="info-box-2-content">Total Pagado : $<?php echo number_format(($venta->precio_pactado + $venta->comision) - $venta->restante)  ?></div>
                                <div class="info-box-2-content" style="color: red;">Intereses acumulados por atrasos: $<?php echo number_format($venta->interes_acumulado, 2)  ?></div>

                                <div class="info-box-2-content">Total Restante: $<?php echo number_format(($venta->restante + $venta->interes_acumulado), 2)  ?></div>

                                <div class="info-box-2-content">Fecha Proximo Pago <?php echo formatearFecha($pagoProximo->fecha_prospecto)  ?></div>


                            </div>
                        </div>







                    </div>


                    <div id="tabsSimple" class="col-xl-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4 class="padding" style="padding: 30px;">Resumen de ventas</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <div class="simple-tab">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab-icon" data-bs-toggle="tab" data-bs-target="#home-tab-icon-pane" type="button" role="tab" aria-controls="home-tab-icon-pane" aria-selected="false" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg> Pagos previstos
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab-icon" data-bs-toggle="tab" data-bs-target="#profile-tab-icon-pane" type="button" role="tab" aria-controls="profile-tab-icon-pane" aria-selected="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                Pagos recibidos
                                            </button>
                                        </li>
                                   
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade  active show" id="home-tab-icon-pane" role="tabpanel" aria-labelledby="home-tab-icon" tabindex="0">
                                            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                                <div class="widget-content widget-content-area br-8">
                                                    <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Monto</th>
                                                                <th>Intereses</th>
                                                                <th>Total Pago</th>
                                                                <th>Acumulado</th>
                                                                <th>Estatus</th>
                                                                <th>Fecha de Pago</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            foreach ($pagosProspectos as $pago) {
                                                                echo "<tr>";
                                                                echo "<td>" . $pago->id . "</td>";
                                                                echo "<td>$ " . number_format(($pago->monto_pagar - $pago->monto_interes), 2) . "</td>";
                                                                echo "<td>$ " . number_format(($pago->monto_interes), 2) . "</td>";
                                                                echo "<td>$ " . number_format(($pago->monto_pagar), 2) . "</td>";

                                                                echo "<td>$ " . number_format($pago->monto_acumulado, 2) . "</td>";


                                                                if (intval($pago->monto_acumulado)  > intval($totalVentaParcial)) {
                                                                    echo "<td><span class='badge badge-warning'>Pendiente</span></td>";
                                                                } else {
                                                                    echo "<td><span class='badge badge-success'>Pagado</span></td>";
                                                                }

                                                                echo "<td>" . formatearFecha($pago->fecha_prospecto) . "</td>";
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
                                        <div class="tab-pane fade" id="profile-tab-icon-pane" role="tabpanel" aria-labelledby="profile-tab-icon" tabindex="0">
                                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                                <div class="widget-content widget-content-area br-8">
                                                    <table id="zero" class="table table-striped dt-table-hover" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Monto</th>
                                                                <th>Fecha de Pago</th>
                                                                <th>Recibió pago</th>
                                                                <th>Método pago</th>
                                                                <th>Tipo de pago</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            foreach ($pagos as $pago) {
                                                                echo "<tr>";
                                                                echo "<td>" . $pago->id . "</td>";
                                                                echo "<td>$ " . number_format(($pago->monto), 2) . "</td>";
                                                                echo "<td>" . formatearFecha($pago->fecha_pago) . "</td>";
                                                                echo "<td>" . ($pago->usuarioInserta) . "</td>";
                                                                echo "<td>" . ($pago->metodo) . "</td>";
                                                                echo "<td>" . ($pago->tipo_pago) . "</td>";

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



                            </div>
                        </div>
                    </div>


                    <div class="row layout-top-spacing">



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
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/assets/js/scrollspyNav.js"></script>
    <script src="../src/plugins/src/highlight/highlight.pack.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    <script src="../src/assets/js/scrollspyNav.js"></script>

    <script>
        var tipoPago = 0;

        function cambiarTipoCompra(tipo) {
            var espacioLiquidacion = document.getElementById("espacioLiquidacion");
            var leteroPago = document.getElementById("letreroPago");
            if (tipo == 1) {
                espacioLiquidacion.style.display = "none";
                leteroPago.innerHTML = "Pago TOTAL";
                tipoPago = 1;
            } else {
                espacioLiquidacion.style.display = "";
                leteroPago.innerHTML = "Pago inicial (enganche)";
                tipoPago = 2;
            }
        }
    </script>
    <script>
        function ajustarPrecio() {
            var espacioPrecioPactado = document.getElementById("precio_pactado");
            var espacioEnganche = document.getElementById("enganche");
            var precioPactado = document.getElementById("precio_pactado").value;
            var enganche = document.getElementById("enganche").value;
            if (parseFloat(enganche) > parseFloat(precioPactado)) {
                espacioEnganche.value = precioPactado;
            }
        }
    </script>
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
        const formulario = document.getElementById("formulario");


        formulario.addEventListener("submit", function(e) {
            e.preventDefault();
            var precioPactado = document.getElementById("precio_pactado").value;
            var enganche = document.getElementById("enganche").value;
            if (tipoPago == 1) {
                if (enganche != precioPactado) {
                    Swal.fire(
                        "Error",
                        "El precio pactado debe ser igual al enganche en caso de liquidacion total",
                        "error"
                    )
                    return;
                }
            }



            const enviaDatosContra = new FormData(formulario);
            if (<?php echo $editando ?> == 1) {
                enviaDatosContra.append("accion", "modifica");
                enviaDatosContra.append("id", "<?php echo $_GET['id'] ?>");

            } else {
                enviaDatosContra.append("accion", "inserta");

            }
            fetch("api/apiVentas.php", {
                    method: "POST",
                    body: enviaDatosContra,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    Swal.fire(
                        data.estatus,
                        data.mensaje,
                        data.subMensaje
                    )

                });
        });
    </script>

</body>

</html>