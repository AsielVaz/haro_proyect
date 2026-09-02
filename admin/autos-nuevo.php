<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
    <title>Dashboard - DAdmin</title>

    <!-- ==== Document Meta ==== -->
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- ==== Favicon ==== -->
    <link rel="icon" href="favicon.png" type="image/png">

    <!-- ==== Google Font ==== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="assets/css/morris.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/jquery-jvectormap.min.css">
    <link rel="stylesheet" href="assets/css/horizontal-timeline.min.css">
    <link rel="stylesheet" href="assets/css/weather-icons.min.css">
    <link rel="stylesheet" href="assets/css/dropzone.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.skinFlat.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Page Level Stylesheets -->

</head>

<body>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <?php include_once("templates/header.php") ?>
        <?php

        include_once("api/adminEditor.php");
        include_once("api/adminAutos.php");
        if ((int) ($_SESSION['sesionUsuario']['permisos'] ?? 0) > 100) {
            header('Location: pruebas.seminuevosharo.mx');
        }
        $admin = new AdministradorEditor();

        ?>
        <?php
        include_once("api/adminUsuarios.php");
        $adminUsuario = new administradorUsuarios();
        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));
        ?>
        <!-- Main Container Start -->
        <main class="main--container">
            <!-- Page Header Start -->
            <section class="page--header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Page Title Start -->
                            <h2 class="page--title h5">Formulario Nuevo Auto </h2>
                            <!-- Page Title End -->

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Autos</a></li>
                                <li class="breadcrumb-item"><span>Nuevo Auto</span></li>
                            </ul>
                        </div>

                        <div class="col-lg-6">
                            <!-- Summary Widget Start -->
                            <div class="summary--widget">
                                <div class="summary--item">
                                    <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#009378">2,9,7,9,11,9,7,5,7,7,9,11</p>

                                    <p class="summary--title">This Month</p>
                                    <p class="summary--stats text-green">2,371,527</p>
                                </div>

                                <div class="summary--item">
                                    <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#e16123">2,3,7,7,9,11,9,7,9,11,9,7</p>

                                    <p class="summary--title">Last Month</p>
                                    <p class="summary--stats text-orange">2,527,371</p>
                                </div>
                            </div>
                            <!-- Summary Widget End -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- Page Header End -->

            <!-- Main Content Start -->
            <section class="main--content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Auto Nuevo</h3>
                    </div>

                    <div class="panel-content">
                        <!-- Form Wizard Start -->
                        <form id="formWizard" class="form--wizard">
                            <h3>Datos Básicos</h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Marca</span>
                                                <select class="form-control" name="marca" onchange="filtro()" id="marcas">
                                                    <option>Marca</option>
                                                    <?php
                                                    $marcas = $admin->dameMarcas();
                                                    foreach ($marcas as $marc) {
                                                        echo '<option value="' . $marc->id . '">' . $marc->marca . '</option>';
                                                    }


                                                    ?>

                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Modelo</span>
                                                <select class="form-control" name="modelo" id="modelos">
                                                    <option>Modelo</option>
                                                    <?php
                                                    $modelos = $admin->dameModelos();
                                                    foreach ($modelos as $modelos) {
                                                        echo '<option value="' . $modelos->id . '">' . $modelos->modelo . '</option>';
                                                    }


                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Transiciones </span>
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
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Interiores</span>
                                                <select class="form-control" name="interior">
                                                    <option>Interior</option>
                                                    <?php

                                                    $interiores = $admin->dameInteriores();
                                                    foreach ($interiores as $interiores) {
                                                        echo '<option value="' . $interiores->id . '">' . $interiores->interior . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Dueño</span>
                                                <select class="form-control" name="duenio">
                                                    <option value="0">Cliente</option>
                                                    <?php
                                                    include_once("api/adminClientes.php");
                                                    $adminClientes = new AdministradorClientes();
                                                    $clientes = $adminClientes->getClientes();
                                                    foreach ($clientes as $clientes) {
                                                        echo '<option value="' . $clientes->id . '">' . $clientes->nombre . " " . $clientes->appat . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Año</span>
                                                <input class="form-control" type="number" name="anio" />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Cilindrage </span>
                                                <input class="form-control" type="number" name="cilindrage" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h3>Datos Financieros</h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Precio </span>
                                                <input type="text" name="precio" class="form-control">
                                                <div class="form-group pt-1 pb-1">
                                                    <label class="form-check">
                                                        <input class="form-control" type="number" name="precio" />
                                                        <span class="form-check-label">Consignación </span>
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Nacionalidad</span>
                                                <input class="form-control" type="text" name="nacionalidad" />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Estatus</span>
                                                <select name="estatus" class="form-control">
                                                    <option value="">Selegir...</option>
                                                    <option value="Nuevo">Nuevo</option>
                                                    <option value="SemiNuevo">SemiNuevo</option>
                                                    <option value="Usado">Usado</option>


                                                </select>
                                            </label>
                                        </div>
                                    </div>


                                </div>
                            </section>

                            <h3>Datos opcionales </h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Combustible</span>
                                                <select class="form-control" name="combustible">
                                                    <option value="">Elegir...</option>
                                                    <option value="Gasolina">Gasolina</option>
                                                    <option value="Bencina">Bencina</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="Eléctrico">Eléctrico</option>
                                                    <option value="Híbrido">Híbrido</option>
                                                    <option value="Otros">Otros</option>

                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Kilometrage </span>
                                                <input class="form-control" type="number" name="kilometros" required />
                                                <div class="form-group pt-1 pb-1">
                                                    <label class="form-check">
                                                        <input type="checkbox" name="kilometragePermitido" value="1" class="form-check-input">
                                                        <span class="form-check-label">Omitir Kilometrage en pagina</span>
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Color</span>
                                                <select class="form-control" name="color">
                                                    <option value="Sin Color">Elige Un color</option>
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
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Cuerpo</span>
                                                <select class="form-control" name="cuerpo">
                                                    <option value="Otro">Elige Un Cuerpo</option>
                                                    <option value="Cabina Simple">Cabina Simple</option>
                                                    <option value="Camión Plano">Camión Plano</option>
                                                    <option value="Chasis Cabina">Chasis Cabina</option>
                                                    <option value="Chasis de la cabina">Chasis de la cabina
                                                    </option>
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
                                                    <option value="Sport calle - urbanas">Sport calle - urbanas
                                                    </option>
                                                    <option value="Station Wagon">Station Wagon</option>
                                                    <option value="SUV">SUV</option>
                                                    <option value="Todo Terreno">Todo Terreno</option>
                                                    <option value="Ute">Ute</option>
                                                    <option value="Van">Van</option>
                                                    <option value="No Especificado">Otro</option>


                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Poder </span>
                                                <input type="text" name="poder" id="poder" class="form-control">

                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <span class="label-text">Asientos </span>
                                                <input type="text" name="asientos" id="asientos" class="form-control">

                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <label for="exampleInputUsername1">Descipcion</label>
                                                <textarea class="form-control" name="descripcion" id="" cols="30" rows="10"></textarea>

                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <button type="submit" class="btn btn-sm btn-rounded btn-success mr-2 mb-3">Terminar</button>
                                        </div>
                                    </div>


                                </div>
                            </section>
                        </form>
                        <!-- Form Wizard End -->
                    </div>
                </div>
            </section>
            <!-- Main Content End -->

            <!-- Main Footer Start -->
            <footer class="main--footer main--footer-light">
                <p>Copyright &copy; <a href="#">DAdmin</a>. All Rights Reserved.</p>
            </footer>
            <!-- Main Footer End -->
        </main>
        <!-- Main Container End -->
    </div>
    <!-- Wrapper End -->

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script src="assets/js/jquery.sparkline.min.js"></script>
    <script src="assets/js/raphael.min.js"></script>
    <script src="assets/js/morris.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery-jvectormap.min.js"></script>
    <script src="assets/js/jquery-jvectormap-world-mill.min.js"></script>
    <script src="assets/js/horizontal-timeline.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/jquery.steps.min.js"></script>
    <script src="assets/js/dropzone.min.js"></script>
    <script src="assets/js/ion.rangeSlider.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var formularioAuto = document.getElementById("formWizard");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();
            let datosDeInicioAuto = new FormData(formularioAuto);
            datosDeInicioAuto.append("accion", "agregar");

            fetch("api/apiAuto.php", {
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
        function filtro() {
            let x = document.getElementById("marcas").value;
            let modelo = document.getElementById("modelos");
            console.log(x);
            let datosMarca = new FormData();
            datosMarca.append("accion", "verModelos");
            datosMarca.append("id", x);

            fetch("api/apiEditor.php", {
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
    </script>


    <!-- Page Level Scripts -->

</body>

</html>
