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
    <link href="../src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css">
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
        include_once("api/adminClientes.php");
        $adminClientes = new AdministradorClientesBanca();
        $clientes = $adminClientes->dameClientes();
        ?>
        <?php
        include_once("../api/adminAutos.php");
        $adminAutos = new AdministradorAutos();
        $autos = $adminAutos->dameAutos();
        if (isset($_GET['auto'])) {
            $auto = $adminAutos->dameAuto($_GET['auto']);
            $autoIdentificado = $auto->marca->marca . " " . $auto->modelo->modelo . " " . $auto->anio;
            if ($auto->imagen == "") {
                $imagen = $auto->imagenes[0]->url;
            } else {
                $imagen = $auto->imagen;
            }
        } else {
            $auto = null;
        }

        if (isset($_GET['id'])) {
            $editando = 1;
        } else {
            $editando = 0;
        }

        ?>

        <script>
            var clientes = <?php echo json_encode($clientes) ?>;
            var autos = <?php echo json_encode($autos) ?>;
            console.log(clientes);
            console.log(autos);
        </script>

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
                                    <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                        <li class="nav-item more-dropdown">
                                            <div class="dropdown  custom-dropdown-icon">
                                                <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span>Settings</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down custom-dropdown-arrow">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">

                                                    <a class="dropdown-item" data-value="Settings" data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-settings&quot;><circle cx=&quot;12&quot; cy=&quot;12&quot; r=&quot;3&quot;></circle><path d=&quot;M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z&quot;></path></svg>" href="javascript:void(0);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                        </svg> Settings
                                                    </a>

                                                    <a class="dropdown-item" data-value="Mail" data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-mail&quot;><path d=&quot;M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z&quot;></path><polyline points=&quot;22,6 12,13 2,6&quot;></polyline></svg>" href="javascript:void(0);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                            <polyline points="22,6 12,13 2,6"></polyline>
                                                        </svg> Mail
                                                    </a>

                                                    <a class="dropdown-item" data-value="Print" data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-printer&quot;><polyline points=&quot;6 9 6 2 18 2 18 9&quot;></polyline><path d=&quot;M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2&quot;></path><rect x=&quot;6&quot; y=&quot;14&quot; width=&quot;12&quot; height=&quot;8&quot;></rect></svg>" href="javascript:void(0);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                            <rect x="6" y="14" width="12" height="8"></rect>
                                                        </svg> Print
                                                    </a>

                                                    <a class="dropdown-item" data-value="Download" data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-download&quot;><path d=&quot;M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4&quot;></path><polyline points=&quot;7 10 12 15 17 10&quot;></polyline><line x1=&quot;12&quot; y1=&quot;15&quot; x2=&quot;12&quot; y2=&quot;3&quot;></line></svg>" href="javascript:void(0);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                                        </svg> Download
                                                    </a>

                                                    <a class="dropdown-item" data-value="Share" data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-share-2&quot;><circle cx=&quot;18&quot; cy=&quot;5&quot; r=&quot;3&quot;></circle><circle cx=&quot;6&quot; cy=&quot;12&quot; r=&quot;3&quot;></circle><circle cx=&quot;18&quot; cy=&quot;19&quot; r=&quot;3&quot;></circle><line x1=&quot;8.59&quot; y1=&quot;13.51&quot; x2=&quot;15.42&quot; y2=&quot;17.49&quot;></line><line x1=&quot;15.41&quot; y1=&quot;6.51&quot; x2=&quot;8.59&quot; y2=&quot;10.49&quot;></line></svg>" href="javascript:void(0);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2">
                                                            <circle cx="18" cy="5" r="3"></circle>
                                                            <circle cx="6" cy="12" r="3"></circle>
                                                            <circle cx="18" cy="19" r="3"></circle>
                                                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                                        </svg> Share
                                                    </a>

                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                            </header>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">

                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">

                            <div class="card bg-secondary" style="background-image: url('<?php echo $imagen ?>');  background-size: cover;  background-position: center;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $autoIdentificado ?></h5>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!--  END BREADCRUMBS  -->

                    <div class="row layout-top-spacing">

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Venta</h4>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="widget-content widget-content-area">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Precio inicial</label>
                                            <input type="text" class="form-control" value="<?php echo number_format($auto->precio, 2)  ?>" id="precio_inicial" name="precio_inicial" readOnly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword4" class="form-label">Precio pactado</label>
                                            <input type="text" oninput="formatearPrecio(), actualizaPrecioComision()" class="form-control" id="precio_pactado" name="precio_pactado">
                                        </div>
                                        <div class="col-12" hidden>
                                            <label for="inputAddress" class="form-label">Auto</label>
                                            <input type="text" name="auto" value="<?php echo $_GET['auto'] ?>">

                                        </div>

                                        <div class="col-md-4" hidden>
                                            <label for="inputState" class="form-label">Tipo compra</label>
                                            <select onchange="cambiarTipoCompra(this.value), actualizaPrecioComision()" id="tipoPago" name="tipoPago" class="form-select">
                                                <option value="0">Elegir...</option>
                                                <option value="1">Liquidación total</option>
                                                <option value="2" selected>Parcialidades</option>


                                            </select>
                                        </div>

                                        <div class="col-md-6" hidden>
                                            <label for="inputState" class="form-label">Método Pago</label>
                                            <select id="metodo_pago" name="metodo_pago" class="form-select">
                                                <option value="0">Seleccionar ... </option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Transferencia">Transferencia</option>

                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputCity" class="form-label" id="letreroPago">Pago inicial (enganche)</label>
                                            <input oninput="ajustarPrecio(), formatearPrecioEnganche(), actualizaPrecioComision()" type="text" class="form-control" id="enganche" name="enganche">
                                        </div>


                                        <div class="col-md-12">
                                            <label for="inputState" class="form-label">Cliente</label>
                                            <select onchange="actualizaPrecioComision(), seteaPorcentajeCliente(this.value)" id="cliente" name="cliente" class="form-select" disabled>
                                                <option value="0" selected="0">Elegir...</option>
                                                <?php
                                                foreach ($clientes as $cliente) {
                                                    if ($cliente->id == $_GET['cliente']) {
                                                        echo "<option value='" . $cliente->id . "' selected>" . $cliente->nombre . " " . $cliente->app . " " . $cliente->correo . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div id="espacioLiquidacion" class="row">


                                            <div class="col-md-4">
                                                <label for="inputZip" class="form-label">Porcentaje de comisión cliente</label>
                                                <input type="text" class="form-control"  value="<? echo $cliente->comision?>" id="comision" name="por_com" require>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="inputZip" class="form-label">Comisión </label>
                                                <input type="text" class="form-control" id="precio_com" name="precio_com" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="inputZip" class="form-label">Fecha inicial de pagos</label>
                                                <input type="date" class="form-control" value="<?php echo date("Y-m-d")?>" id="fecha_inicial" name="fecha_inicial" require>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="inputState" class="form-label">Cantidad de pagos (Meses)</label>
                                                <input oninput="actualizaPrecioComision(),calcularParcialidades(), actualizaTablaPagos()" type="number" name="acuerdo" id="acuerdo" class="form-control" require>
                                            </div>

                                            <div class="col-md-4" hidden>
                                                <label for="inputState" class="form-label">Calculo</label>
                                                <input type="text" name="calculo" id="calculo" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="inputState" class="form-label">Precio total con comisiones </label>
                                                <input type="text" name="total_com" id="total_com" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-4" hidden>
                                                <label for="inputState" class="form-label">Periodo de compra</label>
                                                <select id="periodo_venta" name="periodo_venta" class="form-select">
                                                    <option selected value="3">3 Meses</option>
                                                    <option value="6">6 Meses</option>
                                                    <option value="12">Un año</option>
                                                    <option value="24">Dos Años</option>
                                                    <option value="36">Tres Años</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button onclick="verCorrida()" class="btn btn-primary _effect--ripple waves-effect waves-light">Ver Corrida</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row layout-top-spacing">

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="table-responsive">
                                    <h2>Corrida financiera </h2>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Interés</th>
                                                <th class="text-center" scope="col">Total</th>
                                                <th class="text-center" scope="col">Fecha Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaPagos">




                                        </tbody>
                                    </table>
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
        function aumentarUnMes(fecha, meses) {
            const nuevaFecha = new Date(fecha);
            nuevaFecha.setMonth(nuevaFecha.getMonth() + meses);
            //aumentar un dia 
            nuevaFecha.setDate(nuevaFecha.getDate() + 1);
            return nuevaFecha;
        }
    </script>

    <script>
        var tablaPagosJson = [];
        class Pago {
            constructor(cantidad, interes, total, fecha) {
                this.cantidad = cantidad;
                this.interes = interes;
                this.total = total;
                this.fecha = fecha;
            }
        }

        function actualizaTablaPagos() {
            tablaPagosJson = [];
            var tablaPagos = document.getElementById("tablaPagos");
            var cantidad_pagos = document.getElementById("acuerdo").value;
            var monto = document.getElementById("precio_pactado").value;
            monto = monto.replace(/,/g, '');
            var fecha_inicial = document.getElementById("fecha_inicial").value;
            var porcetaje = document.getElementById("comision").value;
            var enganche = document.getElementById("enganche").value;
            enganche = enganche.replace(/,/g, '');
            var monto_m = monto - enganche;
            var total_por_pago = monto_m / cantidad_pagos;
            var totalCantidades = 0;
            var totalIntereses = 0;
            var totalTotales = 0;
            tablaPagos.innerHTML = "";
            for (var i = 0; i < cantidad_pagos; i++) {
                var interes = monto_m * (porcetaje / 100);
                var fila = tablaPagos.insertRow();
                var celdaCantidad = fila.insertCell(0);
                var celdaInteres = fila.insertCell(1);
                var celdaTotal = fila.insertCell(2);
                var celdaFecha = fila.insertCell(3);
                var pago = new Pago(total_por_pago, interes, total_por_pago + interes, aumentarUnMes(fecha_inicial, i).toLocaleDateString());
                tablaPagosJson.push(pago);


                var total_format = new Intl.NumberFormat('en-US', {
                    style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                    currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                    currency: 'MXN',
                    useGrouping: true
                }).format(parseFloat(total_por_pago));

                var interes_format = new Intl.NumberFormat('en-US', {
                    style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                    currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                    currency: 'MXN',
                    useGrouping: true
                }).format(parseFloat(interes));


                var calculo_format = new Intl.NumberFormat('en-US', {
                    style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                    currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                    currency: 'MXN',
                    useGrouping: true
                }).format(parseFloat(total_por_pago + interes));

                celdaCantidad.innerHTML = total_format;
                celdaInteres.innerHTML = interes_format;
                celdaTotal.innerHTML = calculo_format;
                celdaFecha.innerHTML = aumentarUnMes(fecha_inicial, i).toLocaleDateString();
                totalCantidades = totalCantidades + total_por_pago;
                totalIntereses = totalIntereses + interes;
                totalTotales = totalTotales + (total_por_pago + interes);
                monto_m = monto_m - total_por_pago;
            }
            var totalCantidades_format = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(totalCantidades));

            var totalIntereses_format = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(totalIntereses));

            var totalTotales_format = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(totalTotales));

            var fila = tablaPagos.insertRow();
            var celdaCantidad = fila.insertCell(0);
            celdaCantidad.innerHTML = "TOTALES";

            var fila = tablaPagos.insertRow();
            var celdaCantidad = fila.insertCell(0);
            var celdaInteres = fila.insertCell(1);
            var celdaTotal = fila.insertCell(2);
            var celdaFecha = fila.insertCell(3);
            celdaCantidad.innerHTML = totalCantidades_format;
            celdaInteres.innerHTML = totalIntereses_format;
            celdaTotal.innerHTML = totalTotales_format;
            celdaFecha.innerHTML = "Total";


        }
    </script>

    <script>
        function calcularParcialidades() {
            var precioPactado = document.getElementById("precio_pactado").value;
            var enganche = document.getElementById("enganche").value;
            precioPactado = precioPactado.replace(/,/g, '');
            enganche = enganche.replace(/,/g, '');
            var acuerdo = document.getElementById("acuerdo").value;
            var espacioCalculo = document.getElementById("calculo");
            var parcialidad = (precioPactado - enganche + comision_calculada) / acuerdo;
            var parcialCalculo = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(parcialidad));
            espacioCalculo.value = acuerdo + " PAGOS DE: " + parcialCalculo;
        }
    </script>

    <script>
        var tipoPago = 0;

        function cambiarTipoCompra(tipo) {
            var espacioLiquidacion = document.getElementById("espacioLiquidacion");
            var leteroPago = document.getElementById("letreroPago");
            var espacioEnganche = document.getElementById("enganche");
            if (tipo == 1) {
                espacioLiquidacion.style.display = "none";
                leteroPago.innerHTML = "Pago TOTAL";
                tipoPago = 1;
                espacioEnganche.value = document.getElementById("precio_pactado").value;
                espacioEnganche.readOnly = true;
                comision_calculada = 0;
            } else {
                espacioLiquidacion.style.display = "";
                leteroPago.innerHTML = "Pago inicial (enganche)";
                espacioEnganche.readOnly = false;
                comision_calculada = 0;
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
            precioPactado = precioPactado.replace(/,/g, '');
            enganche = enganche.replace(/,/g, '');
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
                enviaDatosContra.append("comision", comision_calculada);


            } else {
                enviaDatosContra.append("accion", "inserta");
                enviaDatosContra.append("comision", comision_calculada);

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
                        data.status
                    ).then(() => {
                        //redireccionar a la pagina de inicio
                        if (data.status == "success") {
                            window.location.href = "venta-rel.php";
                        }
                    });

                });
        });
    </script>


    <script>
        function formatearPrecio() {
            var input = document.getElementById('precio_pactado');
            var valor = input.value.replace(/[^\d.]/g, ''); // Eliminar caracteres no numéricos ni puntos
            var partes = valor.split('.');

            if (partes.length > 2) {
                partes = [partes.shift(), partes.join('.')];
            }

            if (partes.length > 0) {
                partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Agregar comas
            }

            input.value = partes.join('.');
        }
    </script>

    <script>
        function formatearPrecioEnganche() {
            var input = document.getElementById('enganche');
            var valor = input.value.replace(/[^\d.]/g, ''); // Eliminar caracteres no numéricos ni puntos
            var partes = valor.split('.');

            if (partes.length > 2) {
                partes = [partes.shift(), partes.join('.')];
            }

            if (partes.length > 0) {
                partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Agregar comas
            }

            input.value = partes.join('.');
        }
    </script>

    <script>
        var comision_calculada = 0;

        function calculaComicionPago(monto, pagos, porcentaje) {
            var saldoInsuluto = monto;
            var comision = 0;
            var pagoBase = monto / pagos;

            for (var i = 0; i < pagos; i++) {
                comision += saldoInsuluto * (porcentaje / 100);
                saldoInsuluto -= pagoBase;
            }
            return comision;
        }

        function actualizaPrecioComision() {
            var precioPactado = document.getElementById("precio_pactado").value;
            var comision = document.getElementById("comision").value;
            var enganche = document.getElementById("enganche").value;
            enganche = enganche.replace(/,/g, '');
            var precioFinal = precioPactado - enganche;
            precioPactado = precioPactado.replace(/,/g, '');
            comision = comision.replace(/,/g, '');
            var acuerdo = document.getElementById("acuerdo").value;
            var precioFinal = precioPactado - enganche;
            var precioComision = calculaComicionPago(precioFinal, acuerdo, comision);
            var espacioPrecioComision = document.getElementById("precio_com");
            var espacioTotalCom = document.getElementById("total_com");
            var precioComisionFormateado = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(precioComision));
            espacioPrecioComision.value = precioComisionFormateado;
            comision_calculada = precioComision;
            console.log(comision_calculada);
            var totalComision = parseFloat(precioFinal) + parseFloat(precioComision);
            var totalComisionFormateado = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
                currency: 'MXN',
                useGrouping: true
            }).format(parseFloat(totalComision));
            espacioTotalCom.value = totalComisionFormateado;
        }
    </script>

    <script>
        function seteaPorcentajeCliente(id) {
            var porcetaje = clientes.find(cliente => cliente.id == id).comision;
            document.getElementById("comision").value = porcetaje;
            actualizaPrecioComision();
        }
    </script>

    <script>
        function verCorrida() {
            // Crear un formulario dinámico
            const formulario = document.createElement('form');
            formulario.method = 'POST';
            formulario.action = 'docs/index.php';

            // Agregar un campo de entrada (input) para el parámetro 'id'
            const inputId = document.createElement('input');
            inputId.type = 'hidden'; // Esto hará que el campo esté oculto
            inputId.name = 'lista';
            inputId.value = JSON.stringify(tablaPagosJson);
            formulario.appendChild(inputId);
            const inputCliente = document.createElement('input');
            inputCliente.type = 'hidden'; // Esto hará que el campo esté oculto
            inputCliente.name = 'cliente';
            inputCliente.value = '<?php echo $_GET['cliente']?>';
            formulario.appendChild(inputCliente);
            const inputAuto = document.createElement('input');
            inputAuto.type = 'hidden'; // Esto hará que el campo esté oculto
            inputAuto.name = 'auto';
            inputAuto.value = '<?php echo $_GET['auto']?>';
            formulario.appendChild(inputAuto);
            // Agregar el formulario al cuerpo del documento
            const inputCom = document.createElement('input');
            inputCom.type = 'hidden'; // Esto hará que el campo esté oculto
            inputCom.name = 'interes';
            inputCom.value = document.getElementById("comision").value;
            formulario.appendChild(inputCom);
            document.body.appendChild(formulario);


            //comision

            // Enviar el formulario
            formulario.submit();
        }
    </script>

</body>

</html>