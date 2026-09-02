<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Simulación de venta - Haro</title>
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
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="../src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css">

<style id="haro-venta-simulacion-final">
/* ==========================================================
   SIMULACIÓN DE VENTA - ESTILO DASHBOARD HARO
   Solo diseño. No modifica PHP, sesiones ni funcionalidades.
========================================================== */

:root {
    --haro-bg:#f4f1ea;
    --haro-paper:rgba(255,255,255,.90);
    --haro-black:#0b0b0d;
    --haro-ink:#161616;
    --haro-muted:#77736b;
    --haro-red:#b0141b;
    --haro-gold:#c9a24a;
    --haro-line:rgba(19,19,22,.08);
    --haro-line-gold:rgba(201,162,74,.20);
    --haro-radius:26px;
    --haro-shadow:0 18px 48px rgba(15,15,18,.09);
    --haro-transition:220ms cubic-bezier(.4,0,.2,1);
}

body.layout-boxed {
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.16), transparent 32%),
        radial-gradient(circle at 7% 24%, rgba(176,20,27,.07), transparent 28%),
        linear-gradient(180deg,#fbf8f1 0%,var(--haro-bg) 46%,#eee8dc 100%) !important;
    font-family:'DM Sans','Nunito',sans-serif !important;
    color:var(--haro-ink) !important;
}

#load_screen { background:var(--haro-bg) !important; }
#load_screen .spinner-grow { background-color:var(--haro-red) !important; color:var(--haro-red) !important; }

.layout-px-spacing { padding:30px 26px !important; }

.secondary-nav,
.breadcrumbs-container {
    background:transparent !important;
    box-shadow:none !important;
    border:0 !important;
}

.secondary-nav .header {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-line-gold) !important;
    border-radius:var(--haro-radius) !important;
    padding:20px 22px !important;
    min-height:auto !important;
    box-shadow:var(--haro-shadow) !important;
    backdrop-filter:blur(14px);
    position:relative;
    overflow:hidden;
}

.secondary-nav .header::before {
    content:"";
    position:absolute;
    inset:0 0 auto 0;
    height:4px;
    background:linear-gradient(90deg,var(--haro-red),var(--haro-gold),var(--haro-red));
}

.btn-toggle.sidebarCollapse {
    width:44px !important;
    height:44px !important;
    min-width:44px !important;
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    border-radius:15px !important;
    background:linear-gradient(135deg,#ffffff,#f7efe2) !important;
    border:1px solid rgba(176,20,27,.18) !important;
    color:var(--haro-red) !important;
    box-shadow:0 10px 24px rgba(16,15,12,.10) !important;
    transition:transform var(--haro-transition), box-shadow var(--haro-transition), border-color var(--haro-transition);
}

.btn-toggle.sidebarCollapse:hover {
    transform:translateY(-2px);
    border-color:rgba(176,20,27,.38) !important;
    box-shadow:0 16px 32px rgba(176,20,27,.13) !important;
}

.page-header { padding:0 !important; }

.haro-page-title .haro-eyebrow {
    display:inline-flex;
    align-items:center;
    gap:9px;
    color:var(--haro-red);
    font-family:'Bebas Neue',sans-serif;
    font-size:1.05rem;
    font-weight:400;
    letter-spacing:.09em;
    text-transform:uppercase;
    margin-bottom:5px;
}

.haro-page-title .haro-eyebrow::before {
    content:"";
    width:30px;
    height:2px;
    border-radius:999px;
    background:var(--haro-gold);
}

.page-title h3 {
    margin:0 !important;
    color:var(--haro-black) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:clamp(2rem,3vw,3.05rem) !important;
    font-weight:400 !important;
    letter-spacing:.035em !important;
    line-height:.94 !important;
    text-transform:uppercase;
}

.breadcrumb { margin:9px 0 0 !important; }
.breadcrumb-item,
.breadcrumb-item a {
    color:var(--haro-muted) !important;
    font-size:.8rem !important;
    font-weight:700;
    text-decoration:none !important;
}
.breadcrumb-item.active { color:var(--haro-red) !important; }

.haro-sale-hero {
    min-height:220px;
    border:1px solid rgba(201,162,74,.22) !important;
    border-radius:28px !important;
    overflow:hidden;
    box-shadow:var(--haro-shadow) !important;
    position:relative;
    margin-bottom:12px;
}

.haro-sale-hero::before {
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,rgba(11,11,13,.76),rgba(11,11,13,.22),rgba(176,20,27,.18));
}

.haro-sale-hero .card-body {
    position:relative;
    z-index:1;
    min-height:220px;
    display:flex;
    align-items:flex-end;
    padding:28px !important;
}

.haro-sale-hero .card-title {
    margin:0 !important;
    color:#fff3df !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:clamp(2.1rem,5vw,4rem);
    font-weight:400;
    letter-spacing:.05em;
    text-transform:uppercase;
    text-shadow:0 14px 36px rgba(0,0,0,.35);
}

.haro-form-card,
.haro-table-card {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-line-gold) !important;
    border-radius:var(--haro-radius) !important;
    box-shadow:var(--haro-shadow) !important;
    backdrop-filter:blur(12px);
    overflow:hidden;
}

.haro-form-header {
    padding:28px 30px 22px !important;
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.25), transparent 42%),
        linear-gradient(135deg,#111111 0%,#211714 55%,#7d1118 100%) !important;
    border-bottom:1px solid rgba(201,162,74,.24) !important;
}

.haro-form-header h4 {
    color:#fff3df !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:2.15rem !important;
    font-weight:400 !important;
    letter-spacing:.06em !important;
    margin:0 !important;
    text-transform:uppercase;
}

.haro-form-subtitle {
    color:rgba(255,243,223,.72);
    font-size:13px;
    font-weight:500;
    margin:8px 0 0;
    max-width:760px;
}

.haro-form-card .widget-content {
    padding:30px !important;
    background:transparent !important;
}

.haro-form-card label {
    color:var(--haro-ink) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.05rem;
    font-weight:400 !important;
    letter-spacing:.07em;
    text-transform:uppercase;
    margin-bottom:9px;
}

.haro-form-card .form-control,
.haro-form-card .form-select {
    min-height:48px;
    background:#fff !important;
    border:1px solid rgba(201,162,74,.24) !important;
    border-radius:14px !important;
    color:var(--haro-ink) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:14px !important;
    font-weight:600;
    outline:none !important;
    transition:border-color var(--haro-transition), box-shadow var(--haro-transition);
}

.haro-form-card .form-control:focus,
.haro-form-card .form-select:focus {
    border-color:var(--haro-red) !important;
    box-shadow:0 0 0 4px rgba(176,20,27,.10) !important;
}

#espacioLiquidacion {
    margin:4px 0 0 !important;
    padding:20px 8px 0 !important;
    border-top:1px solid rgba(201,162,74,.20);
    row-gap:18px;
}

.btn-haro-primary {
    min-height:52px;
    min-width:170px;
    padding:12px 26px !important;
    border:none !important;
    border-radius:16px !important;
    background:linear-gradient(135deg,var(--haro-red),#7d1118) !important;
    color:#fff !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.25rem !important;
    font-weight:400 !important;
    letter-spacing:.08em;
    text-transform:uppercase;
    box-shadow:0 14px 30px rgba(176,20,27,.24);
    transition:transform var(--haro-transition), box-shadow var(--haro-transition);
}

.btn-haro-primary:hover {
    transform:translateY(-2px);
    box-shadow:0 18px 38px rgba(176,20,27,.30);
}

.haro-finance-table-wrap {
    padding:0 !important;
}

.haro-finance-table-wrap h2 {
    margin:0 !important;
    padding:26px 30px 20px !important;
    color:#fff3df !important;
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.25), transparent 42%),
        linear-gradient(135deg,#111111 0%,#211714 55%,#7d1118 100%) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:2.05rem !important;
    font-weight:400 !important;
    letter-spacing:.06em;
    text-transform:uppercase;
}

.haro-finance-table-wrap table {
    margin:0 !important;
}

.haro-finance-table-wrap thead th {
    background:#181411 !important;
    color:#f9efe0 !important;
    border:none !important;
    padding:16px 18px !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1rem !important;
    font-weight:400 !important;
    letter-spacing:.07em;
    text-transform:uppercase;
}

.haro-finance-table-wrap tbody td {
    padding:16px 18px !important;
    border-color:rgba(19,19,22,.07) !important;
    font-family:'DM Sans',sans-serif !important;
    font-weight:650;
}

.haro-finance-table-wrap tbody tr:nth-child(even) {
    background:rgba(250,248,243,.72) !important;
}

.haro-footer { margin-top:34px !important; }

@media(max-width:768px) {
    .layout-px-spacing { padding:22px 14px !important; }
    .secondary-nav .header {
        align-items:flex-start !important;
        padding:18px !important;
    }
    .page-title h3 { font-size:2rem !important; }
    .haro-sale-hero,
    .haro-sale-hero .card-body { min-height:170px; }
    .haro-sale-hero .card-body { padding:20px !important; }
    .haro-form-card .widget-content { padding:18px !important; }
    .haro-form-header { padding:22px 20px 18px !important; }
    .haro-form-header h4,
    .haro-finance-table-wrap h2 { font-size:1.7rem !important; }
    #espacioLiquidacion { padding:18px 0 0 !important; }
    .btn-haro-primary { width:100%; }
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
                        <div class="breadcrumbs-container" data-page-heading="Ventas">
                            <header class="header navbar navbar-expand-sm">
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">

                                        <div class="page-title haro-page-title">
                                            <span class="haro-eyebrow">Ventas</span>
                                            <h3>Simulación de venta</h3>
                                        </div>

                                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                    <li class="breadcrumb-item active" aria-current="page">Ventas</li>
                                                </ol>
                                            </nav>

                                        </div>
                                    </div></header>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">

                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">

                            <div class="card bg-secondary haro-sale-hero" style="background-image: url('<?php echo $imagen ?>');  background-size: cover;  background-position: center;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $autoIdentificado ?></h5>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!--  END BREADCRUMBS  -->

                    <div class="row layout-top-spacing">

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow haro-form-card">
                                <div class="widget-header haro-form-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Datos de la venta</h4><p class="haro-form-subtitle">Define el precio, enganche, comisión y parcialidades para generar la corrida financiera.</p>
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
                                            <label for="inputState" class="form-label">Método de pago</label>
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
                                                <label for="inputState" class="form-label">Cantidad de pagos (meses)</label>
                                                <input oninput="actualizaPrecioComision(),calcularParcialidades(), actualizaTablaPagos()" type="number" name="acuerdo" id="acuerdo" class="form-control" require>
                                            </div>

                                            <div class="col-md-4" hidden>
                                                <label for="inputState" class="form-label">Calculo</label>
                                                <input type="text" name="calculo" id="calculo" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="inputState" class="form-label">Precio total con comisiones</label>
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
                                            <button onclick="verCorrida()" class="btn btn-haro-primary _effect--ripple waves-effect waves-light">Ver corrida</button>
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
                                    <h2>Corrida financiera</h2>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Interés</th>
                                                <th class="text-center" scope="col">Total</th>
                                                <th class="text-center" scope="col">Fecha de pago</th>
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
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Mostrar _MENU_ registros",
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
                        "El precio pactado debe ser igual al enganche en caso de liquidación total",
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