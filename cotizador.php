<!DOCTYPE html>
<html lang="es">

<?php include 'template/head.php'; ?>

<body class="page">


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
              <h1 class="b-title-page">Cotizador</h1>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Cotizador</li>
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
    <section class="section-about section-default">
      <div class="container">
        <div class="row">
          <div class="col-xl-6">
            <h2 class="ui-title-inner">Consigue tu<span class="text-primary"> Cotisacion</span></h2>

            <div id="success"></div>
            <form>
              <div class="form-group">
                <label for="name">Marca</label>
                <select id="marcas" class="form-control" onchange="filtro()">
                  <option id="marca" selected>Marca...</option>
                  <?php foreach ($marcas as $marca) { ?>
                    <option value="<?php echo $marca->id ?>"><?php echo $marca->marca ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="email">Modelo</label>
                <select id="modelos" class="form-control">
                  <option selected>Modelo...</option>
                  <?php foreach ($modelos as $modelo) { ?>
                    <option value="<?php echo $modelo->id ?>"><?php echo $modelo->modelo ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="phone">Año de Salida</label>
                <input class="form-control" type="number">
              </div>

              <div class="form-group">
                <label for="phone">Kilometrage</label>
                <select class="form-control">
                  <option selected>Kilometros...</option>
                  <option value="1">Entre 0 y 1,000</option>
                  <option value="2">Entre 1,000 y 10,000</option>
                  <option value="3">Entre 10,000 y 50,000</option>
                  <option value="4">Entre 50,000 y 100,000</option>
                  <option value="5">Mas de 100,000</option>


                </select>
              </div>

              <div class="form-group">
                <label for="phone">Color</label>
                <input type="color" class="form-control">
              </div>

              <div class="form-group">
                <label for="phone">Placas</label>
                <select class="form-control">
                  <option value="no">Seleccione uno...</option>
                  <option value="Aguascalientes">Aguascalientes</option>
                  <option value="Baja California">Baja California</option>
                  <option value="Baja California Sur">Baja California Sur</option>
                  <option value="Campeche">Campeche</option>
                  <option value="Chiapas">Chiapas</option>
                  <option value="Chihuahua">Chihuahua</option>
                  <option value="CDMX">Ciudad de México</option>
                  <option value="Coahuila">Coahuila</option>
                  <option value="Colima">Colima</option>
                  <option value="Durango">Durango</option>
                  <option value="Estado de México">Estado de México</option>
                  <option value="Guanajuato">Guanajuato</option>
                  <option value="Guerrero">Guerrero</option>
                  <option value="Hidalgo">Hidalgo</option>
                  <option value="Jalisco">Jalisco</option>
                  <option value="Michoacán">Michoacán</option>
                  <option value="Morelos">Morelos</option>
                  <option value="Nayarit">Nayarit</option>
                  <option value="Nuevo León">Nuevo León</option>
                  <option value="Oaxaca">Oaxaca</option>
                  <option value="Puebla">Puebla</option>
                  <option value="Querétaro">Querétaro</option>
                  <option value="Quintana Roo">Quintana Roo</option>
                  <option value="San Luis Potosí">San Luis Potosí</option>
                  <option value="Sinaloa">Sinaloa</option>
                  <option value="Sonora">Sonora</option>
                  <option value="Tabasco">Tabasco</option>
                  <option value="Tamaulipas">Tamaulipas</option>
                  <option value="Tlaxcala">Tlaxcala</option>
                  <option value="Veracruz">Veracruz</option>
                  <option value="Yucatán">Yucatán</option>
                  <option value="Zacatecas">Zacatecas</option>
                </select>
              </div>
              <div class="form-group">
                <label for="phone">Dueño unico</label>
                <select class="form-control">
                  <option selected>Duaño Unico...</option>
                  <option value="1">Si</option>
                  <option value="2">No</option>

                </select>
              </div>

              <label for="formControlRange">Llantas <span id="llantasLavel"></span>% Integridad</label>

              <input type="range" class="form-control" id="rangoLlantas">

              <label for="formControlRange">Pintura <span id="pinturaLavel"></span>% Integridad</label>
              <input type="range" class="form-control" id="rangoPintura">

              <label for="formControlRange">Interiores <span id="interiorLavel"></span>% Integridad</label>

              <input type="range" class="form-control" id="rangoInterior">

              <div class="form-group">
                <label for="message">Consideraciones</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- end .b-about-->
    <div class="section-progress">
      <div class="container">
        <?php
        include_once('admin/api/adminAutos.php');
        $autos = new administradorAutos();
        $cuenta = $autos->cuentaAutos();
        ?>
        <ul class="b-progress-list b-progress-list_mod-a row list-unstyled">
          <li class="b-progress-list__item col-md-3">
            <!-- <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">vehículos en línea</span><span class="b-progress-list__percent js-chart" data-percent="3874"><span class="js-percent"></span></span></div> -->
          </li>
          <li class="b-progress-list__item col-md-3">
            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Vehículos En Línea</span><span class="b-progress-list__percent js-chart" data-percent="<?php echo $cuenta ?>"><span class="js-percent"></span><span></span></span></div>
          </li>
          <li class="b-progress-list__item col-md-3">
            <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">Clientes Satisfechos</span><span class="b-progress-list__percent js-chart" data-percent="2400"><span class="js-percent"></span></span></div>
          </li>
          <li class="b-progress-list__item col-md-3">
            <!-- <div class="b-progress-list__wrap bg-light"><span class="b-progress-list__name">vehicles on sale</span><span class="b-progress-list__percent js-chart" data-percent="1450"><span class="js-percent"></span><span>+</span></span></div> -->
          </li>
        </ul>
      </div>
    </div>

    <!-- end .b-progress-->
    <section class="b-bnr bg-dark b-bnr_mod-a">
      <div class="container">
        <div class="row">
          <div class="col-xl-6">
            <div class="b-bnr__main">
              <h2 class="b-bnr__title">¿Quieres vender tu auto?</h2>
              <div class="b-bnr__info">Te ofrecemos el mejor precio para tu auto. Hazlo con nosotros!!</div>
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
    <!-- end .b-bnr-->
    <!-- <section class="b-steps section-default parallax">
      <div class="b-steps__inner">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="ui-title-slogan">Helps you to find perfect car</div>
              <h2 class="ui-title">How Revus<span class="text-primary"> Works</span></h2>
              <ul class="b-steps-list list-unstyled row">
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">01</span>
                  <div class="b-steps-list__title">Search Our Inventory</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">02</span>
                  <div class="b-steps-list__title">Choose The Car You Like</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">03</span>
                  <div class="b-steps-list__title">Apply For Auto Finance</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
                <li class="b-steps-list__item col-lg"><span class="b-steps-list__number">04</span>
                  <div class="b-steps-list__title">Get Approved & Drive</div>
                  <div class="b-steps-list__info">Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat.</div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section> -->
  </main>

  <?php include 'template/footer.php'; ?>
  <!-- .footer-->
  </div>
  </div>
  <!-- end layout-theme-->


  <!-- ++++++++++++-->
  <!-- MAIN SCRIPTS-->
  <!-- ++++++++++++-->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
  <!-- Bootstrap-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
    const rangoLlantas = document.getElementById('rangoLlantas');
    const llanta = document.getElementById('llantasLavel');

    rangoLlantas.addEventListener('change', (e) => {
      const llantaValue = e.target.value;
      llanta.textContent = llantaValue;

    });


    const rangoPintura = document.getElementById('rangoPintura');
    const pintura = document.getElementById('pinturaLavel');


    rangoPintura.addEventListener('change', (e) => {
      const pinturaValue = e.target.value;
      pintura.textContent = pinturaValue;
    });


    const rangoInterior = document.getElementById('rangoInterior');
    const interior = document.getElementById('interiorLavel');
    rangoInterior.addEventListener('change', (e) => {
      const interiorValue = e.target.value;
      interior.textContent = interiorValue;
    });

    function calcularPrecio() {

    }
  </script>


  <script>
    function filtro() {
      let x = document.getElementById("marcas").value;
      let modelo = document.getElementById("modelos");
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
          for (i of data) {
            opciones += "<option value='" + i.id + "'>" + i.modelo + "</option>";
          }
          modelo.innerHTML = opciones;
        });
    }
  </script>



</body>

</html>