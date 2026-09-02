<!DOCTYPE html>
<html lang="es">

<?php include 'template/head.php'; ?>

<body class="page">

    <?php include 'template/header.php'; ?>

    <!-- end .header-->
    <div class="section-title-page area-bg area-bg_dark area-bg_op_60">
        <div class="area-bg__inner">
            <div class="container">
                <div class="row">
                    <div class="col offset-lg-3">
                        <div class="b-title-page__wrap">
                            <h1 class="b-title-page">Contactanos</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Ponerse En Contacto</li>
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
    <main class="l-main-content">
        <div class="container">
            <div class="section-area">
                <div class="row center">
                    <div class="col-md-4 ">
                        <div class="b-contacts"><i class="ic icon-direction"></i>
                            <div class="b-contacts__title">Dirección:</div>
                            <div class="b-contacts__info">Av. Jorge Álvarez del Castillo No. 1264, Lomas del Country
                                <br>
                                Guadalajara, Jal.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="b-contacts"><i class="ic icon-call-end bg-primary"></i>
                            <div class="b-contacts__title">Telefono:</div>
                            <div class="b-contacts__info">33 3636 8433 <br> 33 1955 2634
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="b-contacts"><i class="ic icon-envelope"></i>
                            <div class="b-contacts__title">Correo:</div>
                            <div class="b-contacts__info">contacto@seminuevosharo.mx<br></div>
                        </div>
                    </div>

                </div>
                <!-- end .b-contacts-->
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="map">
                        <iframe class="map-responsive" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7464.517296916201!2d-103.367994!3d20.699719!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1963cbfa3606058a!2sHaro%20Seminuevos!5e0!3m2!1ses!2smx!4v1653418007149!5m2!1ses!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-5">
                    <section class="section-form-contacts">
                        <h2 class="ui-title-inner">Enviar un<span class="text-primary"> Mensaje</span></h2>
                        <p>Si tienes una solicitud o pregunta, puedes usar este formulario.<br>
                            No dudes en contáctarnos. con gusto te atenderémos.</p>
                        <div id="success"></div>
                        <form class="b-form-contacts ui-form" id="contactForm">
                            <div class="form-group">
                                <input class="form-control" id="user-name" type="text" name="nombre" placeholder="Tu Nombre" required="required" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="user-email" type="email" name="correo" placeholder="Correo" required="required" />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="user-message" name="mensaje" rows="7" placeholder="Mensaje" required="required"></textarea>
                            </div>
                            <button class="btn btn-primary">Enviar Mensaje</button>
                        </form>
                    </section>
                    <!-- end .b-form-contact-->
                </div>
            </div>
        </div>
    </main>
    <section class="b-bnr-4 bg-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-7">
                    <h3 class="ui-tilte">¡DESCARGA YA LA APP OFICIAL DE HARO SEMINUEVOS!</h3>
                    <!-- <a class="b-bnr-3__btn btn btn-primary" href="https://play.google.com/store/apps/details?id=tcs.autos_haro" target="_blank">Descargar</a> -->
                </div>
                <div class="col-5">
                    <a href="https://play.google.com/store/apps/details?id=tcs.autos_haro" target="_blank"><img src="../assets/media/content/b-bnr/playstore.png" alt="play store" class="img-fluid" style="object-fit: contain;"></a>
                    <!-- proximamente disponible en App store -->
                    <!-- <div class="b-bnr-3__info">Próximamente
                        disponible en
                        App store</div> -->
                    <img src="../assets/media/content/b-bnr/appstoreprox.png" alt="play store" class="img-fluid" style="object-fit: contain;">
                </div>
            </div>
        </div>
    </section>
    <?php include 'template/footer.php'; ?>
    <!-- .footer-->
    </div>
    </div>
    <!-- end layout-theme-->
    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <!-- MEDIA QUERY -->
    <script>
        var mq = window.matchMedia("(max-width: 512px)");
        mq.addListener(WidthChange);
        const dNone = document.getElementsByClassName('d-none-mobile');
        WidthChange(mq);

        function WidthChange(mq) {
            if (mq.matches) {
                // display none
                for (let i = 0; i < dNone.length; i++) {
                    dNone[i].style.display = 'none';
                }
            } else {
                // display 
                for (let i = 0; i < dNone.length; i++) {
                    dNone[i].style.display = 'block';
                }
            }
        }
    </script>
    <script>
        const active = document.getElementById('active-contact');
        console.log(active);
        active.classList.add('active');


        // Formulario de contacto

        const form = document.getElementById('contactForm');

        form.addEventListener('submit', e => {
            e.preventDefault();
            let formData = new FormData(form);
            formData.append('accion', 'agregar');
            fetch('admin/api/apiContactos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data == '1') {
                        alert('Mensaje enviado correctamente');
                        form.reset();
                    } else {
                        alert('Error al enviar el mensaje');
                    }
                })
                .catch(error => console.log(error))
        })
    </script>
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
    <!-- User map-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhTd-ZT5nzCNucY9AZUCspnXrw3votR34"></script>
    <!-- Maps customization-->
    <script src="assets/js/map-custom.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>
</body>

</html>