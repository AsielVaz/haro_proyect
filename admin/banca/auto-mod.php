<?php session_start() ?>

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
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
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

        /* CORRECCIONES PARA EL TEMPLATE CORK */
        .main-content {
            overflow: visible !important;
        }

        .statbox.widget {
            background: #fff !important;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 2rem;
            overflow: visible !important;
        }

        /* Asegurar que el grid de Bootstrap baje correctamente */
        .form-sample .row {
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .form-sample .col-md-6 {
            margin-bottom: 15px;
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
    </style>
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <?php include_once("template/barra_nav.php") ?>
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
        include_once("api/adminAlmacenes.php");
        

        $id = $_GET['id'];
        $adminAuto = new AdministradorAutos();
        $adminPublicaciones = new AdministradorPublicaciones();
        $auto = $adminAuto->dameAuto($id);
        $adminAlmacenes = new AdministradorAlmacenes();
        $almacenes = $adminAlmacenes->dameAlmacnes();
        ?>

        <?php
        if (intval($_SESSION['sesionUsuario']['permisos']) > 100) {
        }
        $admin = new AdministradorEditor();
        ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">


                <div class="middle-content container-xxl p-0">

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
                    <div class="row layout-top-spacing">

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Nuevo Auto</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="form-sample" id="formularioAuto">
                                        <p class="card-description"> Informacion del auto </p>
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


                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">Almacén donde se ubica</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="id_almacen">
                                                            <option value="0">Seleccione un almacén</option>
                                                            <?php
                                                            foreach ($almacenes as $almacen) {
                                                                echo '<option value="' . $almacen->id . '">' . $almacen->des_gen . '</option>';
                                                            }


                                                            ?>

                                                        </select>
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
                                            <button type="submit" class="btn btn-outline-secondary btn-lg btn-block">Guardar Cambios</button>
                                        </div>
                                    </form>



                                </div>
                            </div>
                        </div>

                    </div>





                    <div class="row layout-top-spacing">

                        <div id="flLoginForm" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Imágenes</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">

                                    <div>


                                        <?php
                                        $carta = 0;
                                        if (strlen($auto->imagen)) {
                                            $imagenIns = $auto->imagen;
                                        } else {
                                            $imagenIns = $auto->imagenes[0]->url;
                                        }
                                        foreach ($auto->imagenes as $imag) {
                                            if ($carta == 0) {
                                                echo ' <ul class="cards">';
                                            }
                                            echo '
                                                        <li>
                                                        <div  class="card">
                                                            <img src="' . $imag->url . '" class="card__image" alt="" />
                                                            <div class="card__overlay">
                                                                <div class="card__header">
                                                                    <svg class="card__arc" xmlns="http://www.w3.org/2000/svg">
                                                                        <path />
                                                                    </svg>
                                                                    <div class="card__header-text">
                                                                        <span class="card__status">1 hour ago</span>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex;
                                                                justify-content: center; padding: 1rem;">
                                                                <a onclick="portada(' . "'" . $imag->url . "'" . ');" class="btn btn-rounded btn-block btn-success" style="">Asignar como portada</a>
                                                                <a onclick="eliminar(' . "'" . $imag->id . "'" . ');" class="btn btn-rounded btn-block btn-danger" style="">Eliminar imagen</a>

                                                                </div>

                                                                </div>
                                                        </div>
                                                    </li>';
                                            $carta++;
                                            if ($carta == 3) {
                                                echo '</ul>';
                                                $carta = 0;
                                            }
                                        }


                                        ?>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Código QR del vehículo</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div style="display: flex; flex-direction: column; align-items: center; padding: 2rem; gap: 1.2rem;">
                                        <?php
                                        $qrUrl = 'https://seminuevosharo.mx/vehicle-details.php?auto=' . intval($id);
                                        require_once(dirname(__FILE__) . '/api/phpqrcode/qrlib.php');

                                        // Generar QR crudo
                                        ob_start();
                                        QRcode::png($qrUrl, false, QR_ECLEVEL_M, 8, 2);
                                        $qrRaw = ob_get_clean();

                                        // Imagen compuesta 500×300 px (proporcional 50×30)
                                        $imgW = 500; $imgH = 300; $mid = 250;
                                        $canvas  = imagecreatetruecolor($imgW, $imgH);
                                        $cWhite  = imagecolorallocate($canvas, 255, 255, 255);
                                        $cBlack  = imagecolorallocate($canvas, 30,  30,  30);
                                        $cGray   = imagecolorallocate($canvas, 110, 110, 110);
                                        $cBorder = imagecolorallocate($canvas, 210, 210, 210);
                                        imagefill($canvas, 0, 0, $cWhite);

                                        // QR en lado izquierdo
                                        $qrSrc = imagecreatefromstring($qrRaw);
                                        $qrSz  = $imgH - 20;
                                        $qrTmp = imagecreatetruecolor($qrSz, $qrSz);
                                        imagecopyresampled($qrTmp, $qrSrc, 0, 0, 0, 0, $qrSz, $qrSz, imagesx($qrSrc), imagesy($qrSrc));
                                        imagecopy($canvas, $qrTmp, 10, 10, 0, 0, $qrSz, $qrSz);
                                        imagedestroy($qrSrc);
                                        imagedestroy($qrTmp);

                                        // Lado derecho: logo
                                        $rX = $mid + 10; $rW = $imgW - $rX - 10;
                                        $logoRaw = @file_get_contents('https://seminuevosharo.mx/assets/media/general/logo.png');
                                        $logoBottomY = 20;
                                        if ($logoRaw !== false) {
                                            $logoSrc = @imagecreatefromstring($logoRaw);
                                            if ($logoSrc) {
                                                $sW = imagesx($logoSrc); $sH = imagesy($logoSrc);
                                                $sc = min(($rW) / $sW, 143 / $sH);
                                                $lW = (int)($sW * $sc); $lH = (int)($sH * $sc);
                                                $logoTmp = imagecreatetruecolor($lW, $lH);
                                                $bgTmp   = imagecolorallocate($logoTmp, 255, 255, 255);
                                                imagefill($logoTmp, 0, 0, $bgTmp);
                                                imagealphablending($logoTmp, true);
                                                imagecopyresampled($logoTmp, $logoSrc, 0, 0, 0, 0, $lW, $lH, $sW, $sH);
                                                imagecopy($canvas, $logoTmp, $imgW - $lW, 10, 0, 0, $lW, $lH);
                                                $logoBottomY = 20 + $lH;
                                                imagedestroy($logoSrc);
                                                imagedestroy($logoTmp);
                                            }
                                        }

                                        // Modelo / Año como texto; Marca como imagen
                                        $modeloTxt   = isset($auto->modelo->modelo) ? $auto->modelo->modelo : '';
                                        $anioTxt     = isset($auto->anio)           ? (string)$auto->anio   : '';
                                        $marcaImagen = isset($auto->marca->imagen)  ? $auto->marca->imagen  : '';
                                        $cx          = $rX + (int)($rW / 2);
                                        $fitW        = $rW - 24;

                                        $textStartY = $logoBottomY + 12;
                                        $textAreaH  = $imgH - $textStartY - 10;
                                        $lineH      = (int)($textAreaH / 3);

                                        // Slot 0: logo de la marca
                                        if ($marcaImagen !== '') {
                                            $marcaRaw = @file_get_contents('https://seminuevosharo.mx' . $marcaImagen);
                                            if ($marcaRaw !== false) {
                                                $marcaSrc = @imagecreatefromstring($marcaRaw);
                                                if ($marcaSrc) {
                                                    $mSW = imagesx($marcaSrc); $mSH = imagesy($marcaSrc);
                                                    $mSc = min($fitW / $mSW, ($lineH * 1.6) / $mSH);
                                                    $mDW = (int)($mSW * $mSc); $mDH = (int)($mSH * $mSc);
                                                    $marcaTmp = imagecreatetruecolor($mDW, $mDH);
                                                    $bgM = imagecolorallocate($marcaTmp, 255, 255, 255);
                                                    imagefill($marcaTmp, 0, 0, $bgM);
                                                    imagealphablending($marcaTmp, true);
                                                    imagecopyresampled($marcaTmp, $marcaSrc, 0, 0, 0, 0, $mDW, $mDH, $mSW, $mSH);
                                                    imagecopy($canvas, $marcaTmp, (int)($rX + ($rW - $mDW) / 2), $textStartY + (int)(($lineH - $mDH) / 2), 0, 0, $mDW, $mDH);
                                                    imagedestroy($marcaSrc);
                                                    imagedestroy($marcaTmp);
                                                }
                                            }
                                        }

                                        // Slots 1-2: Modelo y Año como texto
                                        $ttfFont = null;
                                        $ttfPaths = array(
                                            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
                                            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
                                            '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
                                            '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf',
                                            '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',
                                            '/usr/share/fonts/liberation/LiberationSans-Bold.ttf',
                                        );
                                        foreach ($ttfPaths as $ttfP) {
                                            if (file_exists($ttfP)) { $ttfFont = $ttfP; break; }
                                        }

                                        if ($ttfFont && function_exists('imagettfbbox')) {
                                            $texts  = array($modeloTxt, $anioTxt);
                                            $colors = array($cBlack,    $cGray);
                                            foreach ($texts as $i => $txt) {
                                                if ($txt === '') continue;
                                                $slot  = $i + 1;
                                                $maxPt = min(42, (int)($lineH * 0.78));
                                                for ($pt = $maxPt; $pt >= 8; $pt--) {
                                                    $box = imagettfbbox($pt, 0, $ttfFont, $txt);
                                                    if (abs($box[4] - $box[0]) <= $fitW) break;
                                                }
                                                $box   = imagettfbbox($pt, 0, $ttfFont, $txt);
                                                $tw    = abs($box[4] - $box[0]);
                                                $th    = abs($box[5] - $box[1]);
                                                $drawX = $imgW - $tw - 15;
                                                $drawY = $textStartY + $slot * $lineH + (int)(($lineH + $th) / 2);
                                                imagettftext($canvas, $pt, 0, $drawX, $drawY, $colors[$i], $ttfFont, $txt);
                                            }
                                        } else {
                                            $modeloX = $cx - (int)(strlen($modeloTxt) * imagefontwidth(5) / 2);
                                            $anioX   = $cx - (int)(strlen($anioTxt)   * imagefontwidth(4) / 2);
                                            imagestring($canvas, 5, $modeloX, $textStartY + $lineH,   $modeloTxt, $cBlack);
                                            imagestring($canvas, 4, $anioX,   $textStartY + $lineH*2, $anioTxt,   $cGray);
                                        }

                                        ob_start();
                                        imagepng($canvas);
                                        $compositeRaw = ob_get_clean();
                                        imagedestroy($canvas);
                                        $compositeBase64 = base64_encode($compositeRaw);
                                        ?>
                                        <div style="padding: 12px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.12); display: inline-block;">
                                            <img id="imagenEtiquetaQR"
                                                 src="data:image/png;base64,<?php echo $compositeBase64; ?>"
                                                 alt="QR Code del auto <?php echo intval($id); ?>"
                                                 style="display: block; width: 500px; height: 300px;" />
                                        </div>
                                        <div style="text-align: center;">
                                            <p style="margin: 0 0 0.4rem; font-size: 0.85rem; color: #888;">Escanea para ver el vehículo en el sitio web</p>
                                            <a href="<?php echo $qrUrl; ?>" target="_blank"
                                               style="font-size: 0.8rem; color: #4361ee; word-break: break-all;">
                                                <?php echo $qrUrl; ?>
                                            </a>
                                        </div>
                                        <a href="data:image/png;base64,<?php echo $compositeBase64; ?>"
                                           download="etiqueta-qr-auto-<?php echo intval($id); ?>.png"
                                           class="btn btn-outline-primary btn-sm">
                                            Descargar etiqueta QR
                                        </a>
                                        <button id="btnImprimirNiimbot" class="btn btn-outline-success btn-sm" style="margin-top: 0.5rem;">
                                            Imprimir en NIIMBOT B1
                                        </button>
                                        <div id="niimbotEstado" style="font-size: 0.82rem; color: #555; margin-top: 0.4rem; min-height: 1.2em;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

            </div>




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
            </div>
        </div>
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <script src="../src/assets/js/custom.js"></script>
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <script src="../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var formularioAutoImg = document.getElementById("formularioAutoImg");

        if(formularioAutoImg) {
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
        }
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
            var datosDeInicioAuto = new FormData(formularioAuto);
            datosDeInicioAuto.append("accion", "modificar");
            datosDeInicioAuto.append("id", <?php echo $id ?>);

            fetch("../api/apiAuto.php", {
                    method: "POST",
                    body: datosDeInicioAuto,
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

    <script src="https://unpkg.com/niimbot-web-bluetooth@1.3.5/src/niimbot.js"></script>

    <script>
        (function () {
            var btnImprimir = document.getElementById('btnImprimirNiimbot');
            var estadoEl   = document.getElementById('niimbotEstado');

            function setEstado(msg) {
                if (estadoEl) estadoEl.textContent = msg;
            }

            function esperarImagen(img) {
                return new Promise(function (resolve, reject) {
                    if (img.complete && img.naturalWidth > 0) { resolve(); return; }
                    img.onload  = function () { resolve(); };
                    img.onerror = function () { reject(new Error('No se pudo cargar la imagen de la etiqueta.')); };
                });
            }

            btnImprimir.addEventListener('click', async function () {
                if (!navigator.bluetooth) {
                    alert('Este navegador no soporta Web Bluetooth.\nUsa Chrome o Edge en escritorio con HTTPS o localhost.');
                    return;
                }

                if (typeof Niimbot === 'undefined') {
                    alert('La librería NIIMBOT no cargó correctamente.\nVerifica tu conexión a internet y recarga la página.');
                    return;
                }

                if (typeof Niimbot.isSupported === 'function' && !Niimbot.isSupported()) {
                    alert('Tu navegador no es compatible con la impresora NIIMBOT.\nUsa Chrome o Edge.');
                    return;
                }

                var img = document.getElementById('imagenEtiquetaQR');
                if (!img) {
                    alert('No se encontró la imagen de la etiqueta en la página.');
                    return;
                }

                try {
                    setEstado('Cargando imagen…');
                    await esperarImagen(img);

                    var model = {
                        name_prefixes: ['B1'],
                        task: 'b1',
                        density: 3,
                        label_type: 1,
                        speed: 1
                    };

                    var size = {
                        w_px: img.naturalWidth,
                        h_px: img.naturalHeight,
                        offset_y_px: 4
                    };

                    setEstado('Buscando impresora Bluetooth… (acepta el diálogo del navegador)');

                    await Niimbot.printImage(img.src, {
                        model: model,
                        size: size,
                        copies: 1,
                        onProgress: function (estado) {
                            console.log('NIIMBOT progreso:', estado);
                            setEstado('Imprimiendo… ' + (typeof estado === 'object' ? JSON.stringify(estado) : estado));
                        }
                    });

                    setEstado('Imagen enviada a la NIIMBOT B1.');

                } catch (error) {
                    console.error('Error NIIMBOT:', error);

                    var msg = error.message || String(error);
                    if (msg.toLowerCase().includes('cancel') || msg.toLowerCase().includes('user')) {
                        setEstado('Conexión cancelada por el usuario.');
                    } else if (msg.toLowerCase().includes('not found') || msg.toLowerCase().includes('no device')) {
                        setEstado('No se encontró la impresora. Asegúrate de que esté encendida y cerca.');
                        alert('No se encontró la impresora NIIMBOT B1.\nVerifica que esté encendida y cerca del dispositivo.');
                    } else if (msg.toLowerCase().includes('image') || msg.toLowerCase().includes('imagen')) {
                        setEstado('Error al cargar la imagen.');
                        alert('No se pudo cargar la imagen de la etiqueta.');
                    } else {
                        setEstado('Error: ' + msg);
                        alert('No se pudo imprimir: ' + msg);
                    }
                }
            });
        })();
    </script>

</body>

</html>