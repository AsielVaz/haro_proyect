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
    </style>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Navbar Start -->

        <?php include_once("templates/header.php") ?>
        <?php
        $code = $_GET['code'];
        echo $code;
        include_once("api/adminEditor.php");
        include_once("api/adminAutos.php");
        include_once("api/adminPublicaciones.php");

        $id = $_GET['id'];
        $adminAuto = new AdministradorAutos();
        $adminPublicaciones = new AdministradorPublicaciones();
        $auto = $adminAuto->dameAuto($id);
        $admin = new AdministradorEditor();
        ?>

        <!-- Main Container Start -->
        <main class="main--container">
            <!-- Page Header Start -->
            <section class="page--header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Page Title Start -->
                            <h2 class="page--title h5">Autos</h2>
                            <!-- Page Title End -->

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="autos.php">Autos</a></li>
                                <li class="breadcrumb-item active"><span>Modificar Auto</span></li>
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

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modificar <?php echo $auto->marca->marca . " " . $auto->modelo->modelo ?></h3>
                        </div>
                        <div class="panel-content">
                            <form id="formularioAuto">
                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Marca</span>

                                        <select class="form-control" name="marca" onchange="filtro()" id="marcas">
                                            <option value="<?php echo $auto->marca->id ?>"><?php echo $auto->marca->marca ?></option>
                                            <?php
                                            $marcas = $admin->dameMarcas();
                                            foreach ($marcas as $marc) {
                                                echo '<option value="' . $marc->id . '">' . $marc->marca . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>



                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Modelo</span>

                                        <select class="form-control" name="modelo" id="modelos">
                                            <option value="<?php echo $auto->modelo->id ?>"><?php echo $auto->modelo->modelo ?></option>
                                            <?php
                                            $modelos = $admin->dameModelos();
                                            foreach ($modelos as $modelos) {
                                                echo '<option value="' . $modelos->id . '">' . $modelos->modelo . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Transición</span>

                                        <select class="form-control" name="trans">
                                            <option value="<?php echo $auto->transmicion->id ?>"><?php echo $auto->transmicion->transmicion ?></option>
                                            <?php
                                            $transmiciones = $admin->dameTransmiciones();
                                            foreach ($transmiciones as $transmiciones) {
                                                echo '<option value="' . $transmiciones->id . '">' . $transmiciones->transmicion . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Interior</span>

                                        <select class="form-control" name="interior">
                                            <option value="<?php echo $auto->interiores->id ?>"><?php echo $auto->interiores->interior ?></option>
                                            <?php

                                            $interiores = $admin->dameInteriores();
                                            foreach ($interiores as $interiores) {
                                                echo '<option value="' . $interiores->id . '">' . $interiores->interior . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Dueño</span>

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
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Año</span>

                                        <input class="form-control" type="number" name="anio" value="<?php echo $auto->anio ?>" />
                                    </label>
                                </div>



                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Cilindrage </span>

                                        <input class="form-control" type="number" name="cilindrage" value="<?php echo $auto->cilindrage ?>" />
                                    </label>
                                </div>



                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Precio </span>

                                        <input class="form-control" type="number" name="precio" value="<?php echo $auto->precio ?>" />
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Nacionalidad </span>

                                        <input class="form-control" type="text" name="nacionalidad" value="<?php echo $auto->nacionalidad ?>" />
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Estatus </span>

                                        <input class="form-control" type="text" name="estatus" value="<?php echo $auto->estatus ?>" placeholder="Nuevo, Semi nuevo etc..." />
                                    </label>
                                </div>



                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Combustible </span>

                                        <input class="form-control" type="text" name="combustible" value="<?php echo $auto->combustible ?>" />
                                    </label>
                                </div>





                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Kilomtraje </span>

                                        <input class="form-control" type="number" value="<?php echo $auto->kilometrage ?>" name="kilometros" />
                                    </label>
                                </div>





                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Color </span>

                                        <input class="form-control" type="text" name="color" value="<?php echo $auto->color ?>" />
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Cuerpo </span>

                                        <input class="form-control" type="text" name="cuerpo" value="<?php echo $auto->cuerpo ?>" placeholder="Pic-up etc..." />
                                    </label>
                                </div>



                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Poder</span>

                                        <input class="form-control" type="text" name="poder" value="<?php echo $auto->poder ?>" placeholder="180 hp..." />
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Asientos </span>

                                        <input class="form-control" type="number" name="asientos" value="<?php echo $auto->asientos ?>" />
                                    </label>
                                </div>

                                <?php

                                if ($auto->consig) {
                                    $estatus = "checked";
                                } else {
                                    $estatus = "";
                                }


                                ?>
                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Consignación </span>
                                        <div class="form-group pt-1 pb-1">
                                            <label class="form-check">
                                                <input type="checkbox" name="consig" class="form-check-input" <?php echo $estatus ?>>
                                                <span class="form-check-label">Automóvil a consignación</span>
                                            </label>
                                        </div>

                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <span class="label-text">Descripción </span>

                                        <textarea class="form-control" name="descripcion" id="" cols="30" rows="10"><?php echo $auto->descripcion ?></textarea>
                                    </label>
                                </div>


                                <button type="submit" class="btn btn-outline-secondary btn-lg btn-block">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>


            <section>


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
                              <a onclick="portada(' . "'" . $imag->url . "'" . ');" class="btn btn-rounded btn-block btn-success" data-toggle="modal">Asignar como portada</a>

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
    <script>
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


        function portada(url) {
            var datosDeInicio = new FormData();

            datosDeInicio.append("accion", "asignarportada");
            datosDeInicio.append("url", url);
            datosDeInicio.append("auto", <?php echo $_GET['id'] ?>);

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
        function filtro() {
            var x = document.getElementById("marcas").value;
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


                            fetch("api/apiPublicaciones.php", {
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

            fetch("api/apiPublicaciones.php", {
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
    <!-- Page Level Scripts -->

</body>

</html>