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
        header('Content-Type: text/html; charset=utf-8');

        include_once("../api/adminEditor.php");
        include_once("../api/adminAutos.php");
        if ((int) ($_SESSION['sesionUsuario']['permisos'] ?? 0) > 100) {
            header('Location: pruebas.seminuevosharo.mx');
        }
        $admin = new AdministradorEditor();

        ?>
        <?php
        include_once("../api/adminUsuarios.php");
        $adminUsuario = new administradorUsuarios();
        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));

        include_once("api/adminAlmacenes.php");

        $adminAlmacen = new AdministradorAlmacenes();
        $almacenes = $adminAlmacen->dameAlmacnes();
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
                                            <h3>Panel de creación autos </h3>
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
                                            <h4>Nuevo Auto</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="row g-3" id="formularioAuto">

                                        <!-- Campos ocultos -->
                                        <div style="display:none;">
                                            <input type="text" name="duenio" value="4">
                                            <input type="text" name="nacionalidad" value="MEXICANA">
                                        </div>

                                        <!-- Vehículo -->
                                        <div class="col-12">
                                            <p class="card-description mb-1">Vehículo</p>
                                            <hr class="mt-0 mb-2">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-form-label">Marca</label>
                                            <select class="form-control" name="marca" onchange="filtro()" id="marcas">
                                                <option>Marca</option>
                                                <?php
                                                $marcas = $admin->dameMarcas();
                                                foreach ($marcas as $marc) {
                                                    echo '<option value="' . $marc->id . '">' . $marc->marca . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-form-label">Modelo</label>
                                            <select class="form-control" name="modelo" id="modelos">
                                                <option>Modelo</option>
                                                <?php
                                                $modelos = $admin->dameModelos();
                                                foreach ($modelos as $modelos) {
                                                    echo '<option value="' . $modelos->id . '">' . $modelos->modelo . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Características -->
                                        <div class="col-12 mt-3">
                                            <p class="card-description mb-1">Características</p>
                                            <hr class="mt-0 mb-2">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Año</label>
                                            <input class="form-control" type="number" name="anio" />
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Cilindrage</label>
                                            <input class="form-control" type="number" name="cilindrage" />
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Transmisión</label>
                                            <select class="form-control" name="trans">
                                                <option>Transmisión</option>
                                                <?php
                                                $transmiciones = $admin->dameTransmiciones();
                                                foreach ($transmiciones as $transmiciones) {
                                                    echo '<option value="' . $transmiciones->id . '">' . $transmiciones->transmicion . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Interior</label>
                                            <select class="form-control" name="interior">
                                                <option>Interior</option>
                                                <?php
                                                $interiores = $admin->dameInteriores();
                                                foreach ($interiores as $interiores) {
                                                    echo '<option value="' . $interiores->id . '">' . $interiores->interior . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Combustible</label>
                                            <select class="form-control" name="combustible">
                                                <option value="Gasolina">Gasolina</option>
                                                <option value="Bencina">Bencina</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Eléctrico">Eléctrico</option>
                                                <option value="Híbrido">Híbrido</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Kilometraje</label>
                                            <div class="form-check mb-1">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="kilometragePermitido" class="form-check-input" checked=""> Omitir km en no esenciales <i class="input-helper"></i>
                                                </label>
                                            </div>
                                            <input class="form-control" type="number" name="kilometros" required />
                                        </div>

                                        <!-- Aspecto -->
                                        <div class="col-12 mt-3">
                                            <p class="card-description mb-1">Aspecto</p>
                                            <hr class="mt-0 mb-2">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Color</label>
                                            <select class="form-control" name="color">
                                                <option value="Sin Color">Elige un color</option>
                                                <option value="Beige">Beige</option>
                                                <option value="Negro">Negro</option>
                                                <option value="Azul">Azul</option>
                                                <option value="Bronce">Bronce</option>
                                                <option value="Marrón">Marrón</option>
                                                <option value="Borgoña">Borgoña</option>
                                                <option value="Dorado">Dorado</option>
                                                <option value="Verde">Verde</option>
                                                <option value="Gris">Gris</option>
                                                <option value="Magenta">Magenta</option>
                                                <option value="Bordo">Bordo</option>
                                                <option value="Naranja">Naranja</option>
                                                <option value="Rosa">Rosa</option>
                                                <option value="Rojo">Rojo</option>
                                                <option value="Plata">Plata</option>
                                                <option value="Blanco">Blanco</option>
                                                <option value="Amarillo">Amarillo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Cuerpo</label>
                                            <select class="form-control" name="cuerpo">
                                                <option value="Otro">Elige un cuerpo</option>
                                                <option value="Cabina Simple">Cabina Simple</option>
                                                <option value="Camión Plano">Camión Plano</option>
                                                <option value="Chasis Cabina">Chasis Cabina</option>
                                                <option value="Chasis de la cabina">Chasis de la cabina</option>
                                                <option value="Citycar">Citycar</option>
                                                <option value="Convertible">Convertible</option>
                                                <option value="Coupé">Coupé</option>
                                                <option value="Deportivas">Deportivas</option>
                                                <option value="Furgón">Furgón</option>
                                                <option value="Hatchback">Hatchback</option>
                                                <option value="Media Barandas">Media Barandas</option>
                                                <option value="Pick up">Pick up</option>
                                                <option value="Plegables">Plegables</option>
                                                <option value="Sedán">Sedán</option>
                                                <option value="Sport calle - urbanas">Sport calle - urbanas</option>
                                                <option value="Station Wagon">Station Wagon</option>
                                                <option value="SUV">SUV</option>
                                                <option value="Todo Terreno">Todo Terreno</option>
                                                <option value="Ute">Ute</option>
                                                <option value="Van">Van</option>
                                                <option value="No Especificado">Otro</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">Asientos</label>
                                            <input class="form-control" type="number" name="asientos" />
                                        </div>

                                        <!-- Comercial -->
                                        <div class="col-12 mt-3">
                                            <p class="card-description mb-1">Comercial</p>
                                            <hr class="mt-0 mb-2">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="col-form-label">Estatus</label>
                                            <input class="form-control" type="text" name="estatus" placeholder="Nuevo, Semi nuevo etc..." />
                                        </div>

                                        <div class="col-md-3">
                                            <label class="col-form-label">Precio</label>
                                            <input class="form-control" type="number" name="precio" />
                                        </div>

                                        <div class="col-md-3">
                                            <label class="col-form-label">Poder</label>
                                            <input class="form-control" type="text" name="poder" placeholder="180 hp..." />
                                        </div>

                                        <div class="col-md-3">
                                            <label class="col-form-label">Almacén</label>
                                            <select class="form-control" name="id_almacen">
                                                <option value="0">Seleccione un almacén</option>
                                                <?php
                                                foreach ($almacenes as $almacen) {
                                                    echo '<option value="' . $almacen->id . '">' . $almacen->des_gen . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-form-label">Consignación</label>
                                            <div class="form-check mt-1">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="consig" class="form-check-input"> Automóvil a consignación <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Descripción -->
                                        <div class="col-12 mt-3">
                                            <p class="card-description mb-1">Descripción</p>
                                            <hr class="mt-0 mb-2">
                                        </div>

                                        <div class="col-12">
                                            <textarea class="form-control" name="descripcion" cols="30" rows="5"></textarea>
                                        </div>

                                        <!-- Botón -->
                                        <div class="col-12 mt-3 d-flex justify-content-end">
                                            <button id="botonNuevo" type="submit" class="btn btn-rounded _effect--ripple waves-effect waves-light" style="background-color: #5A9F19; color: #fff;">Nuevo Auto</button>
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
        function filtro() {
            let x = document.getElementById("marcas").value;
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



        var formularioAuto = document.getElementById("formularioAuto");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();
            let datosDeInicioAuto = new FormData(formularioAuto);
            var botonAgregar = document.getElementById("botonNuevo");
            botonAgregar.disabled = true;
            botonAgregar.innerHTML = "Agregando...";
            datosDeInicioAuto.append("accion", "agregar");

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

</body>

</html>
