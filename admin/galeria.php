<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
    <title>Catalogos - Modelos</title>

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

    <style>
        .cards {
            width: 100%;
            display: flex;
            display: -webkit-flex;
            justify-content: center;
            -webkit-justify-content: center;
        }

        .card--1 .card__img,
        .card--1 .card__img--hover {}

        .card--2 .card__img,
        .card--2 .card__img--hover {}

        .card__like {
            width: 18px;
        }

        .card__clock {
            width: 15px;
            vertical-align: middle;
            fill: #AD7D52;
        }

        .card__time {
            font-size: 12px;
            color: #AD7D52;
            vertical-align: middle;
            margin-left: 5px;
        }

        .card__clock-info {
            float: right;
        }

        .card__img {
            visibility: hidden;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 235px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;

        }

        .card__info-hover {
            position: absolute;
            padding: 16px;
            width: 100%;
            opacity: 0;
            top: 0;
        }

        .card__img--hover {
            transition: 0.2s all ease-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            position: absolute;
            height: 235px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            top: 0;

        }

        .card {
            margin-right: 25px;
            transition: all .4s cubic-bezier(0.175, 0.885, 0, 1);
            background-color: #fff;
            width: 100%;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 13px 10px -7px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 0px 30px 18px -8px rgba(0, 0, 0, 0.1);
            transform: scale(1.10, 1.10);
        }

        .card__info {
            z-index: 2;
            background-color: #fff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 16px 24px 24px 24px;
        }

        .card__category {
            font-family: 'Raleway', sans-serif;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 2px;
            font-weight: 500;
            color: #868686;
        }

        .card__title {
            margin-top: 5px;
            margin-bottom: 10px;
            font-family: 'Roboto Slab', serif;
        }

        .card__by {
            font-size: 12px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
        }

        .card__author {
            font-weight: 600;
            text-decoration: none;
            color: #AD7D52;
        }

        .card:hover .card__img--hover {
            height: 100%;
            opacity: 0.3;
        }

        .card:hover .card__info {
            background-color: transparent;
            position: relative;
        }

        .card:hover .card__info-hover {
            opacity: 1;
        }

        /* Media Query para resoluciones de computadora */
        @media only screen and (min-width: 769px) {
            .cards {
                max-width: 20%;
            }
        }

        /* Media Query para resoluciones de teléfono */
        @media only screen and (max-width: 768px) {
            .cards {
                max-width: none;
                /* Elimina el max-width para resoluciones de teléfono */
            }
        }

        .btn-flotante {
            font-size: 16px;
            /* Cambiar el tamaño de la tipografia */
            text-transform: uppercase;
            /* Texto en mayusculas */
            font-weight: bold;
            /* Fuente en negrita o bold */
            color: #ffffff;
            /* Color del texto */
            border-radius: 5px;
            /* Borde del boton */
            letter-spacing: 2px;
            /* Espacio entre letras */
            background-color: #363333;
            /* Color de fondo */
            padding: 18px 30px;
            /* Relleno del boton */
            position: fixed;
            bottom: 40px;
            right: 40px;
            transition: all 300ms ease 0ms;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        .btn-flotante:hover {
            background-color: #502222;
            /* Color de fondo al pasar el cursor */
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-7px);
        }
    </style>
    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Navbar Start -->

        <?php include_once("templates/header.php") ?>
        <?php
        include_once("api/adminAutos.php");

        include_once("api/adminUsuarios.php");
        $adminUsuarios = new administradorUsuarios();
        $usuarios = $adminUsuarios->dameUsuarios();
        $admin = new AdministradorAutos();
        $autos = $admin->dameAutos();
        $imagenes = $admin->dameImagenesSinAuto();

        ?>

        <!-- Main Container Start -->
        <main class="main--container">
            <!-- Page Header Start -->
            <section class="page--header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Page Title Start -->
                            <h2 class="page--title h5">Usuarios</h2>
                            <!-- Page Title End -->

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="autos.php">Usuarios</a></li>
                                <li class="breadcrumb-item active"><span>Usuarios activos</span></li>
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

            <button onclick="enviarImagen()" class="btn-flotante">Guardar Cambios</button>



            <!-- Main Content Start -->
            <section class="main--content">


                <section class="cards">



                    <?php

                    $fila = 0;
                    foreach ($imagenes as $imagen) {
                        if ($fila > 0) {
                            echo '</section><br><br><br><section class="cards">';
                            $fila = 0;
                        }
                        $fila++;

                        echo '
                    
                        <article class="card card--1">
                            <div class="card__info-hover">

                                <div class="card__clock-info">
                                    <svg class="card__clock" viewBox="0 0 24 24">
                                        <path d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M19.03,7.39L20.45,5.97C20,5.46 19.55,5 19.04,4.56L17.62,6C16.07,4.74 14.12,4 12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22C17,22 21,17.97 21,13C21,10.88 20.26,8.93 19.03,7.39M11,14H13V8H11M15,1H9V3H15V1Z" />
                                    </svg><span class="card__time">15 min</span>
                                </div>

                            </div>
                            <div class="card__img" style="background-image: url(' . "'" . $imagen->url . "'" . ');"></div>
                            <a  class="card_link">
                                <div class="card__img--hover" style="background-image: url(' . "'" . $imagen->url . "'" . ');"></div>
                            </a>
                            <div class="card__info">
                                <span class="card__category"> id: ' . $imagen->id . ' </span>
                                <select name=""  onchange="asignarValores(this.value);" id="" class="form-control">
                                    <option value="0">Auto...</option>
                                    ';
                        foreach ($autos as $auto) {
                            echo '<option value="' . $auto->id . ',' . $imagen->id . '">' . $auto->marca->marca . ' ' . $auto->modelo->modelo . '</option>';
                        }
                        echo '
                                </select>
                                <span class="card__by">Por <a  class="card__author" title="author">Correo HARO</a></span>
                            </div>
                        </article>
                        <br>
                    ';
                    }


                    ?>









                </section>

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

    <!-- Page Level Scripts -->

    <script>
        var boton =
            '<li class="nav-item nav-settings d-none d-lg-block"><button onclick="actualizar()" type="button" class="btn btn-warning btn-fw">Actualizar</button></li>';
        var barra = document.getElementById("menuSuperior");
        fetch("api/recividorEmail.php", {
                method: "POST",
            })
            .then((respuesta) => respuesta.json())
            .then((data) => {
                console.log(data);
                if (data == "1") {
                    console.log("Registro Exitoso");
                    //location.reload();
                    barra.innerHTML = boton;
                } else {
                    console.log("Error");
                }
            });

        function actualizar() {
            location.reload();
        }
        var formularioAutoImg = document.getElementById("formularioAutoImg");

        formularioAutoImg.addEventListener("submit", function(e) {
            e.preventDefault();
            var datosDeInicioAutoImg = new FormData(formularioAutoImg);
            datosDeInicioAutoImg.append("accion", "imagen");
            datosDeInicioAutoImg.append("id_auto", "<?php echo $id; ?>");

            fetch("api/apiAuto.php", {
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


        function funcionEliminar(id) {
            var datosDeInicio = new FormData();
            console.log("Me precionaron para eliminar " + id);
            datosDeInicio.append("accion", "bimagen");
            datosDeInicio.append("id", id);
            fetch("api/apiAuto.php", {
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
        var arreglo = [];
        var autoId = 0;
        var imagenId = 0;

        function asignarValores(valores) {
            var ids = valores.split(",");
            console.log(ids);
            autoId = ids[0];
            imagenId = ids[1];
            var par = new Object();
            par.auto = autoId;
            par.imagen = imagenId;
            arreglo.push(par);
            console.log(arreglo);
        }

        var contador = 0;

        function enviarImagen() {

            if (contador < arreglo.length) {

                (async () => {

                    let datosMarca = new FormData();
                    datosMarca.append("accion", "asignar");
                    datosMarca.append("id", arreglo[contador].imagen);
                    datosMarca.append("auto", arreglo[contador].auto);

                    await fetch("api/apiAuto.php", {
                            method: "POST",
                            body: datosMarca,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {
                            console.log(data);
                            if (data == 1) {

                            }

                        });

                    contador++;
                    enviarImagen();


                })();






            } else {
                location.reload();
            }










        }


        var formularioAuto = document.getElementById("formularioAuto");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();
            var datosDeInicioAuto = new FormData(formularioAuto);
            datosDeInicioAuto.append("accion", "modificar");
            datosDeInicioAuto.append("id", <?php echo $id ?>);

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
    <!-- End custom js for this page -->
</body>

</html>