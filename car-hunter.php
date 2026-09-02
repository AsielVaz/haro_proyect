<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title id="titulo">Haro Seminuevos</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!--[if lt IE 9 ]>
<script src="/assets/js/separate-js/html5shiv-3.7.2.min.js" type="text/javascript"></script><meta content="no" http-equiv="imagetoolbar">
<![endif]-->
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4b519bfb72.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="page">
<?php header('Content-Type: text/html; charset=utf-8');?>


    <?php include 'template/header.php';
    include_once 'admin/api/adminEditor.php';
    $adminEditor = new AdministradorEditor();
    $marcas = $adminEditor->dameMarcasGenerales();
    $modelos = $adminEditor->dameModelosGenerales();
    ?>
    <!-- end .header-->
    <div class="section-title-page area-bg area-bg_dark area-bg_op_60">
        <div class="area-bg__inner">
            <div class="container">
                <div class="row">
                    <div class="col offset-lg-3">
                        <div class="b-title-page__wrap">
                            <h1 class="b-title-page">CAR HUNTER</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">CAR HUNTER</li>
                                </ol>
                                <!-- end breadcrumb-->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end .b-title-page-->
    <main>
        <section class="section-about2 section-default">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5">
                        <h2 class="ui-title-inner">CAR<span class="text-primary"> HUNTER</span></h2>
                        <div class="mb-4"></div>
                        <div id="success"></div>
                        <form class="b-form-contacts ui-form" id="form-carhunter">
                            <div class="form-group">
                                <input class="form-control " id="user-name" type="text" name="nombre" placeholder="TU NOMBRE" required="required" />
                            </div>
                            <div class="form-group">
                                <input class="form-control " id="user-email" type="email" name="correo" placeholder="CORREO" required="required" />
                            </div>
                            <div class="form-group">
                                <select name="marca" class="form-control" id="marcaCH" onchange="filtro();" required="required">
                                    <option selected>MARCA...</option>
                                    <?php foreach ($marcas as $marca) { ?>
                                        <option value="<?php echo $marca->id ?>"><?php echo $marca->marca ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="modelo" class="form-control" id="modeloCH" required="required">
                                    <option selected>MODELO...</option>
                                    <?php foreach ($modelos as $modelo) { ?>
                                        <option value="<?php echo $modelo->id ?>"><?php echo $modelo->modelo ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- precio min -->
                            <div class="row">
                                <div class="form-group col">
                                    <span class="span-form">Precio Mínimo</span>
                                    <input class="form-control input-width" id="precio-min" value="0" type="number" name="precioMinimo" placeholder="$" />
                                </div>
                                <!-- precio max -->
                                <div class="form-group col">
                                    <span class="span-form">Precio Máximo</span>
                                    <input class="form-control input-width" id="precio-max" type="number" value="0" name="precioMaximo" placeholder="$" />
                                </div>
                            </div>
                            <!-- año min -->
                            <div class="row">
                                <div class="form-group col">
                                    <span class="span-form">Año Mínimo</span>
                                    <input class="form-control input-width" id="anio-min" type="number" value="0" name="anioMinimo" placeholder="1992" />
                                </div>
                                <!-- año max -->
                                <div class="form-group col">
                                    <span class="span-form">Año Máximo</span>

                                    <input class="form-control input-width" id="anio-max" type="number" value="0" name="anioMaximo" placeholder="2022" />
                                </div>
                            </div>
                            <div class="mb-2"></div>
                            <div class="form-group col">
                                <input name="suscribirse" id="suscribirse" type="checkbox" checked>
                                <label for="suscribirse">
                                    <strong> Me interesa suscribirme a los boletines de autos nuevos. </strong>
                                </label>
                            </div>
                            <div class="mb-2"></div>
                            <div class="form-group col">
                                <div class="g-recaptcha" data-sitekey="6LcgrLcgAAAAACEWIlPfg0junlhoJYdV-12PJ2K3"></div>
                            </div>

                            <br>
                            <!-- Google reCAPTCHA -->
                            <div class="form-group col">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end .b-about-->


        <!-- end .b-progress-->
        <section class="b-bnr bg-dark b-bnr_mod-a">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="b-bnr__main">
                            <h2 class="b-bnr__title">¿Quieres vender tu auto?</h2>
                            <div class="b-bnr__info">Te ofrecemos el mejor precio para tu auto. Hazlo con nosotros!!
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="b-bnr__second"><a class="btn btn-primary" href="#">Contactanos</a>
                            <div class="b-bnr-contacts">
                                <div class="b-bnr-contacts__info">Llámenos para reservar un vehículo</div><a class="b-bnr-contacts__phone" href="tel:tel:3319552634"><i class="ic icon-call-end text-primary"></i>33 195 52634</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include 'template/footer.php'; ?>
    <!-- .footer-->
    </div>
    </div>
    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <!-- Color scheme-->
    <script src="assets/plugins/switcher/js/dmss.js"></script>
    <!-- Select customization & Color scheme-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js"></script>
    <!-- Pop-up window-->
    <script src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Headers scripts-->
    <script src="assets/plugins/headers/slidebar.js"></script>
    <script src="assets/plugins/headers/header.js"></script>
    <!-- Mail scripts-->
    <script src="assets/plugins/jqBootstrapValidation.js"></script>
    <script src="assets/plugins/contact_me.js"></script>
    <!-- Video player-->
    <script src="assets/plugins/flowplayer/flowplayer.min.js"></script>
    <!-- Filter and sorting images-->
    <script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/plugins/isotope/imagesLoaded.js"></script>
    <!-- Progress numbers-->
    <script src="assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/plugins/rendro-easy-pie-chart/jquery.waypoints.min.js"></script>
    <!-- Animations-->
    <script src="assets/plugins/scrollreveal/scrollreveal.min.js"></script>
    <!-- Scale images-->
    <script src="assets/plugins/ofi.min.js"></script>
    <!--Sliders-->
    <script src="assets/plugins/slick/slick.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>
    <script>
        const formCarhunter = document.getElementById('form-carhunter');
        formCarhunter.addEventListener('submit', e => {
            e.preventDefault();
            let formData = new FormData(formCarhunter);
            formData.append("accion", "agregar");
            fetch('admin/api/apiCarHunter.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data == "1") {
                        alert("Se ha enviado un correo a tu cuenta de email, gracias por tu visita");
                        window.location.href = "inventory-list.php";
                    } else if (data != "1" && data != "0") {
                        console.log("Auto encontrado");
                        alert("Tal ves tengamos un auto ideal para ti ¡¡");
                        window.location.href = "https://seminuevosharo.mx/vehicle-details.php?auto=" + data;
                    } else {
                        // comprobacion de el captcha
                        alert("Favor de verificar el captcha");
                        formCarhunter.reset();
                    }
                })
                .catch(err => console.log(err));
        })

        function filtro() {
            let x = document.getElementById("marcaCH").value;
            let modelo = document.getElementById("modeloCH");
            console.log(x);
            let datosMarca = new FormData();
            datosMarca.append("accion", "verModelosPorMarca");
            datosMarca.append("marca", x);

            fetch("admin/api/apiEditor.php", {
                    method: "POST",
                    body: datosMarca,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    let opciones = "";
                    opciones += "<option value='0'>OPCIONAL</option>";
                    for (i of data) {
                        opciones += "<option value='" + i.id + "'>" + i.modelo + "</option>";
                    }
                    modelo.innerHTML = opciones;
                });
        }
    </script>
</body>

</html>