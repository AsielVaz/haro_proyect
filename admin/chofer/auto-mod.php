<?php
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
    <title>Form Layouts | CORK - Multipurpose Bootstrap Dashboard Template </title>
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
</head>

</head>

<body class="layout-boxed enable-secondaryNav">
    <style>
        :root {
            --surface-color: #fff;
            --curve: 40;
        }

        * {
            box-sizing: border-box;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 5vw;
            padding: 0;
            list-style-type: none;
        }

        .card {
            position: relative;
            display: block;
            height: 100%;
            border-radius: calc(var(--curve) * 1px);
            overflow: hidden;
            text-decoration: none;
        }

        .card__image {
            width: 100%;
            height: auto;
        }

        .card__overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1;
            border-radius: calc(var(--curve) * 1px);
            background-color: var(--surface-color);
            transform: translateY(100%);
            transition: .2s ease-in-out;
        }

        .card:hover .card__overlay {
            transform: translateY(0);
        }

        .card__header {
            position: relative;
            display: flex;
            align-items: center;
            gap: 2em;
            padding: 2em;
            border-radius: calc(var(--curve) * 1px) 0 0 0;
            background-color: var(--surface-color);
            transform: translateY(-100%);
            transition: .2s ease-in-out;
        }

        .card__arc {
            width: 80px;
            height: 80px;
            position: absolute;
            bottom: 100%;
            right: 0;
            z-index: 1;
        }

        .card__arc path {
            fill: var(--surface-color);
            d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z");
        }

        .card:hover .card__header {
            transform: translateY(0);
        }

        .card__thumb {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .card__title {
            font-size: 1em;
            margin: 0 0 .3em;
            color: #6A515E;
        }

        .card__tagline {
            display: block;
            margin: 1em 0;
            font-family: "MockFlowFont";
            font-size: .8em;
            color: #D7BDCA;
        }

        .card__status {
            font-size: .8em;
            color: #D7BDCA;
        }

        .card__description {
            padding: 0 2em 2em;
            margin: 0;
            color: #D7BDCA;
            font-family: "MockFlowFont";
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }

        #formularioAuto .col-md-6,
        #formularioAuto .row > .form-group {
            display: none;
        }

        #almacen-group {
            display: block !important;
            width: 100%;
        }

        #almacen-group .form-group {
            display: flex !important;
        }

        .auto-info-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            border-radius: 14px;
            padding: 22px 28px;
            color: white;
            margin-bottom: 28px;
            box-shadow: 0 6px 20px rgba(15, 52, 96, 0.45);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .auto-info-card .car-icon {
            font-size: 2.8rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .auto-info-card .auto-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0 0 4px;
            letter-spacing: 0.3px;
        }

        .auto-info-card .auto-subtitle {
            font-size: 0.88rem;
            opacity: 0.75;
            margin: 0 0 10px;
        }

        .auto-info-card .auto-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .auto-info-card .badge-pill {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 0.78rem;
            font-weight: 500;
        }

        .location-wrapper {
            background: #f8f9fc;
            border-radius: 12px;
            padding: 24px 28px;
            border: 1px solid #e3e6f0;
            margin-bottom: 10px;
        }

        .location-wrapper .location-label {
            font-weight: 700;
            color: #374151;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .location-wrapper .location-label span.icon {
            font-size: 1rem;
        }

        .location-wrapper select.form-control {
            border-radius: 8px;
            border: 2px solid #d1d5db;
            padding: 10px 14px;
            font-size: 0.95rem;
            height: auto;
            color: #374151;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .location-wrapper select.form-control:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.15);
            outline: none;
        }

        .btn-guardar-ubicacion {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
            border: none;
            border-radius: 10px;
            padding: 13px 30px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 18px;
            letter-spacing: 0.4px;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(15, 52, 96, 0.35);
        }

        .btn-guardar-ubicacion:hover {
            opacity: 0.92;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(15, 52, 96, 0.45);
            color: white;
        }

        .btn-guardar-ubicacion:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(15, 52, 96, 0.3);
        }
    </style>
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

        $code = $_GET['code'];
        echo $code;
        include_once("../api/adminEditor.php");
        include_once("../api/adminAutos.php");
        include_once("../api/adminPublicaciones.php");
        include_once("../banca/api/adminAlmacenes.php");

        $id = $_GET['id'];
        $adminAuto = new AdministradorAutos();
        $adminPublicaciones = new AdministradorPublicaciones();
        $auto = $adminAuto->dameAuto($id);
        $adminAlmacenes = new AdministradorAlmacenes();
        $almacenes = $adminAlmacenes->dameAlmacnes();
        $ultimoLog = $adminAuto->dameUltimoLogAuto($id);

        function tiempoRelativo($fecha) {
            // menos 6 horas para evitar problemas de zona horaria
            if (!$fecha) return 'Sin registro';
            $horaActual = time() - 21600;
            $diff = $horaActual - strtotime($fecha);
            if ($diff < 60) return 'hace un momento';
            if ($diff < 120) return 'hace 1 minuto';
            if ($diff < 3600) return 'hace ' . floor($diff / 60) . ' minutos';
            if ($diff < 7200) return 'hace 1 hora';
            if ($diff < 86400) return 'hace ' . floor($diff / 3600) . ' horas';
            if ($diff < 172800) return 'hace 1 día';
            if ($diff < 604800) return 'hace ' . floor($diff / 86400) . ' días';
            if ($diff < 1209600) return 'hace 1 semana';
            if ($diff < 2592000) return 'hace ' . floor($diff / 604800) . ' semanas';
            if ($diff < 5184000) return 'hace 1 mes';
            if ($diff < 31536000) return 'hace ' . floor($diff / 2592000) . ' meses';
            if ($diff < 63072000) return 'hace 1 año';
            return 'hace ' . floor($diff / 31536000) . ' años';
        }
        ?>

        <?php

        if ((int) ($_SESSION['sesionUsuario']['permisos'] ?? 0) > 100) {
        }
        $admin = new AdministradorEditor();
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
                                            <h3>Modificación de autos </h3>
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

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Actualizar Ubicación del Vehículo</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="form-sample" id="formularioAuto">

                                        <div class="auto-info-card">
                                            <div class="car-icon">🚗</div>
                                            <div>
                                                <p class="auto-title"><?php echo $auto->marca->marca . ' ' . $auto->modelo->modelo ?></p>
                                                <p class="auto-subtitle">ID del vehículo: #<?php echo $id ?>  Ultimo cambio: <?php echo tiempoRelativo($ultimoLog->ultima_act) ?></p> 
                                                <div class="auto-badges">
                                                    <span class="badge-pill">📅 <?php echo $auto->anio ?></span>
                                                    <span class="badge-pill">🎨 <?php echo $auto->color ?></span>
                                                    <span class="badge-pill">⚙️ <?php echo $auto->transmicion->transmicion ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Marca</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="marca" onchange="filtro()" id="marcas">
                                                            <option value="<?php echo $auto->marca->id ?>"><?php echo $auto->marca->marca ?></option>
                                                            <?php
                                                            $marcas = $admin->dameMarcas();
                                                            foreach ($marcas as $marc) {
                                                                echo '<option value="' . $marc->id . '">' . $marc->marca . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Modelo</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="modelo" id="modelos">
                                                            <option value="<?php echo $auto->modelo->id ?>"><?php echo $auto->modelo->modelo ?></option>
                                                            <?php
                                                            $modelos = $admin->dameModelos();
                                                            foreach ($modelos as $modelos) {
                                                                echo '<option value="' . $modelos->id . '">' . $modelos->modelo . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Transmicion</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="trans">
                                                            <option value="<?php echo $auto->transmicion->id ?>"><?php echo $auto->transmicion->transmicion ?></option>
                                                            <?php
                                                            $transmiciones = $admin->dameTransmiciones();
                                                            foreach ($transmiciones as $transmiciones) {
                                                                echo '<option value="' . $transmiciones->id . '">' . ($transmiciones->transmicion)  . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Interior</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="interior">
                                                            <option value="<?php echo $auto->interiores->id ?>"><?php echo $auto->interiores->interior ?></option>
                                                            <?php

                                                            $interiores = $admin->dameInteriores();
                                                            foreach ($interiores as $interiores) {
                                                                echo '<option value="' . $interiores->id . '">' . $interiores->interior . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Dueño</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="duenio">
                                                            <option value="<?php echo $auto->duenio->id ?>"><?php echo $auto->duenio->nombre ?></option>
                                                            <?php
                                                            include_once("api/adminClientes.php");
                                                            $adminClientes = new AdministradorClientes();
                                                            $clientes = $adminClientes->getClientes();
                                                            foreach ($clientes as $clientes) {
                                                                echo '<option value="' . $clientes->id . '">' . $clientes->nombre . " " . $clientes->appat . '</option>';
                                                            }


                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Año</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="anio" value="<?php echo $auto->anio ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Cilindrage</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="cilindrage" value="<?php echo $auto->cilindrage ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Precio</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="precio" value="<?php echo $auto->precio ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Nacionalidad</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="nacionalidad" value="<?php echo $auto->nacionalidad ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Estatus</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="estatus" value="<?php echo $auto->estatus ?>" placeholder="Nuevo, Semi nuevo etc..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Combustible</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="combustible" value="<?php echo $auto->combustible ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Kilometrage</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" value="<?php echo $auto->kilometrage ?>" name="kilometros" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Color</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="color" value="<?php echo $auto->color ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Cuerpo</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="cuerpo" value="<?php echo $auto->cuerpo ?>" placeholder="Pic-up etc..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Poder</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="poder" value="<?php echo $auto->poder ?>" placeholder="180 hp..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Asientos</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="asientos" value="<?php echo $auto->asientos ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <?php

                                            if ($auto->consig) {
                                                $estatus = "checked";
                                            } else {
                                                $estatus = "";
                                            }


                                            ?>


                                            <div class="col-md-6" id="almacen-group">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="location-wrapper">
                                                            <div class="location-label">
                                                                <span class="icon">📍</span> Almacén donde se ubica el vehículo
                                                            </div>
                                                            <select class="form-control" name="id_almacen">
                                                                <option value="0">— Seleccione un almacén —</option>
                                                                <?php
                                                                foreach ($almacenes as $almacen) {
                                                                    echo '<option value="' . $almacen->id . '">' . $almacen->des_gen . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Consignación </label>
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="consig" class="form-check-input" <?php echo $estatus ?>> Automóvil a consignación <i class="input-helper"></i></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputUsername1">Descripción</label>
                                                <textarea class="form-control" name="descripcion" id="" cols="30" rows="10"><?php echo $auto->descripcion ?></textarea>
                                            </div>
                                            <button type="submit" class="btn-guardar-ubicacion">
                                                📦 Guardar Ubicación
                                            </button>
                                        </div>
                                    </form>



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
        var formularioAutoImg = document.getElementById("formularioAutoImg");

        formularioAutoImg.addEventListener("submit", function(e) {
            e.preventDefault();
            var datosDeInicioAutoImg = new FormData(formularioAutoImg);
            datosDeInicioAutoImg.append("accion", "imagen");
            datosDeInicioAutoImg.append("id_auto", "<?php echo $id; ?>");

            fetch("../api/apiAuto.php", {
                    method: "POST",
                    body: datosDeInicioAutoImg,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    if (data == "1") {
                        console.log("Registro Exitoso");
                        location.reload();
                    } else {
                        console.log("Error");
                    }
                });
        });
        var carruceImagenes = [];
        var contadorImagenes = 0;

        function aumentarCarrucel(imagen) {
            carruceImagenes[contadorImagenes] = imagen;
            contadorImagenes++;
            console.log(carruceImagenes);
        }

        function funcionEliminar(id) {
            var datosDeInicio = new FormData();
            console.log("Me precionaron para eliminar " + id);
            datosDeInicio.append("accion", "bimagen");
            datosDeInicio.append("id", id);
            fetch("../api/apiAuto.php", {
                    method: "POST",
                    body: datosDeInicio,
                })
                .then((respuesta) => respuesta.json())
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


        function portada(url) {
            var datosDeInicio = new FormData();

            datosDeInicio.append("accion", "asignarportada");
            datosDeInicio.append("url", url);
            datosDeInicio.append("auto", <?php echo $_GET['id'] ?>);

            fetch("../api/apiAuto.php", {
                    method: "POST",
                    body: datosDeInicio,
                })
                .then((respuesta) => respuesta.json())
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
    </script>

    <script>
        function eliminar(id) {

            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, eliminarla!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var datosDeInicio = new FormData();
                    datosDeInicio.append("accion", "bimagen");
                    datosDeInicio.append("id", id);
                    fetch("../api/apiAuto.php", {
                            method: "POST",
                            body: datosDeInicio,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {
                            console.log(data);
                            if (data == "1") {
                                Swal.fire(
                                    'Eliminado!',
                                    'Tu archivo ha sido eliminado.',
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                console.log("Error");
                            }
                        });

                } else {
                    Swal.fire('Cancelado', 'Tu archivo esta a salvo :)', 'error')
                }
            })




        }
    </script>


    <script>
        function filtro() {
            var x = document.getElementById("marcas").value;
            let modelo = document.getElementById("modelos");
            console.log(x);
            let datosMarca = new FormData();
            datosMarca.append("accion", "verModelos");
            datosMarca.append("id", x);

            fetch("../api/apiEditor.php", {
                    method: "POST",
                    body: datosMarca,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    let opciones = "";
                    for (i of data) {
                        opciones += "<option value='" + i.id + "'>" + i.modelo + "</option>";

                    }

                    modelo.innerHTML = opciones;

                });

        }

        function publicarSimple() {
            let datosInstagram3 = new FormData();
            datosInstagram3.append("caption", "Hola");
            datosInstagram3.append("image_url", "https://seminuevosharo.mx<?php echo $imagenIns; ?>");
            datosInstagram3.append("access_token", token);

            //cambiar el token por el de HARO 
            fetch("https://graph.facebook.com/v14.0/17841453586943090/media", {
                    method: "POST",
                    body: datosInstagram3,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    let id = data.id;
                    datosInstagram2 = new FormData();
                    datosInstagram2.append("creation_id", id);
                    datosInstagram2.append("access_token", token);


                    //cambiar por HARO 
                    fetch("https://graph.facebook.com/v14.0/17841453586943090/media_publish", {
                            method: "POST",
                            body: datosInstagram2,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {
                            console.log(data);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                background: '#0000',
                                title: 'Se publico correctamente con la id ' + data.id,
                                showConfirmButton: false,
                                timer: 2000
                            })

                            $("#btI").hide();


                            var datosPublicacion = new FormData();
                            datosPublicacion.append("accion", "agregar");
                            datosPublicacion.append("auto", <?php echo $id; ?>);
                            datosPublicacion.append("publicacion", data.id);
                            datosPublicacion.append("redSocial", "Instagram");


                            fetch("../api/apiPublicaciones.php", {
                                    method: "POST",
                                    body: datosPublicacion,
                                })
                                .then((respuesta) => respuesta.json())
                                .then((data) => {
                                    console.log(data);

                                });

                        });


                });
        }




        function iniciarSesionFace() {
            FB.login(function(response) {
                // handle the response
                if (response.status === 'connected') {
                    FB.getLoginStatus(function(response) {
                        statusChangeCallback(response);
                    });
                    $("#btF").show();
                    $("#btI").show();
                    $("#btFi").hide();
                } else {
                    // The person is not logged into your webpage or we are unable to tell. 
                }

            }, {
                scope: 'public_profile,email ,manage_fundraisers, publish_video, pages_manage_cta, pages_show_list, ads_management, ads_read, business_management, pages_messaging, pages_messaging_phone_number, pages_messaging_subscriptions, instagram_basic, instagram_manage_comments, instagram_manage_insights, instagram_content_publish, publish_to_groups, groups_access_member_info, leads_retrieval, attribution_read, page_events, pages_read_engagement, pages_read_user_content, pages_manage_posts'
            });




        }

        function subirAInstagram() {
            let imagenesID;
            let imagenesCadena = "";
            (async () => {
                for (let i = 0; i < carruceImagenes.length; i++) {

                    let datosInstagram = new FormData();
                    datosInstagram.append("image_url", "https://seminuevosharo.mx" + carruceImagenes[i]);
                    datosInstagram.append("is_carousel_item ", "true");
                    datosInstagram.append("access_token", token);
                    await
                    //cambiar el token por el de HARO 
                    fetch("https://graph.facebook.com/v14.0/17841453586943090/media", {
                            method: "POST",
                            body: datosInstagram,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {
                            console.log(data);
                            let id = data.id;
                            if (i == carruceImagenes.length - 1) {
                                imagenesCadena += id;
                            } else {
                                imagenesCadena += id + "%"
                            }


                        });
                }



                let datosInstagram3 = new FormData();
                datosInstagram3.append("caption", "Hola");
                datosInstagram3.append("media_type", "CAROUSEL");
                datosInstagram3.append("children  ", imagenesCadena);
                datosInstagram3.append("access_token", token);

                //cambiar el token por el de HARO 
                fetch("https://graph.facebook.com/v14.0/17841453586943090/media", {
                        method: "POST",
                        body: datosInstagram3,
                    })
                    .then((respuesta) => respuesta.json())
                    .then((data) => {
                        console.log(data);
                        let id = data.id;
                        datosInstagram2 = new FormData();
                        datosInstagram2.append("creation_id", id);
                        datosInstagram2.append("access_token", token);


                        //cambiar por HARO 
                        fetch("https://graph.facebook.com/v14.0/17841453586943090/media_publish", {
                                method: "POST",
                                body: datosInstagram2,
                            })
                            .then((respuesta) => respuesta.json())
                            .then((data) => {
                                console.log(data);

                            });


                    });



            })();



        }

        var formularioAuto = document.getElementById("formularioAuto");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();

            var selectAlmacen = formularioAuto.querySelector('select[name="id_almacen"]');
            var almacenTexto = selectAlmacen.options[selectAlmacen.selectedIndex].text;

            if (selectAlmacen.value == "0") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Almacén requerido',
                    text: 'Por favor selecciona un almacén antes de guardar.',
                    confirmButtonColor: '#0f3460'
                });
                return;
            }

            Swal.fire({
                title: '¿Confirmar cambio de ubicación?',
                html: `El vehículo <strong><?php echo $auto->marca->marca . ' ' . $auto->modelo->modelo ?></strong> será asignado a:<br><br><span style="font-size:1.1rem;font-weight:600;color:#0f3460;">📍 ${almacenTexto}</span>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0f3460',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;

                var datosDeInicioAuto = new FormData(formularioAuto);
                datosDeInicioAuto.append("accion", "modificar");
                datosDeInicioAuto.append("id", <?php echo $id ?>);

                fetch("../api/apiAuto.php", {
                        method: "POST",
                        body: datosDeInicioAuto,
                    })
                    .then((respuesta) => respuesta.json())
                    .then((data) => {
                        if (data == "1") {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Ubicación actualizada!',
                                text: 'El vehículo fue asignado correctamente.',
                                confirmButtonColor: '#0f3460'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo actualizar la ubicación. Intenta de nuevo.',
                                confirmButtonColor: '#0f3460'
                            });
                        }
                    });
            });
        });
    </script>

    <script>
        function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
            console.log('statusChangeCallback');
            console.log(response); // The current login status of the person.
            token = response.authResponse.accessToken;
            console.log("El token es: " + token);
            iniciarCookie("tokenG", token, 6);
            if (response.status === 'connected') { // Logged into your webpage and Facebook.
                testAPI();
            } else { // Not logged into your webpage or we are unable to tell.

            }
        }

        function iniciarCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function dameCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        var token = dameCookie("tokenG");

        console.log(token);

        function testAPI() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function(response) {
                console.log('Successful login for: ' + response.name);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    background: '#0000',
                    title: 'Se inicio Sesion Como ' + response.name,
                    showConfirmButton: false,
                    timer: 2000
                })


            });
        }

        $("#btFi").hide();
        $("#btF").hide();
        $("#btI").hide();
        console.log(token);
        if (token != "") {
            $("#btI").show();

            var datosInstagram = new FormData();
            datosInstagram.append("accion", "verPublicado");
            datosInstagram.append("redSocial", "Instagram");
            datosInstagram.append("auto", <?php echo $id ?>);

            fetch("../api/apiPublicaciones.php", {
                    method: "POST",
                    body: datosInstagram,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    if (data) {
                        $("#btI").hide();
                    }


                });



        } else {

            $("#btI").hide();
        }
    </script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '585534262944562',
                autoLogAppEvents: true,
                xfbml: false,
                version: 'v14.0'
            });
            console.log("Se cargo FB");
            $("#btFi").show();
        };
    </script>

</body>

</html>
