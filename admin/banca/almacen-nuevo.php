<?php
header('Content-Type: text/html; charset=utf-8');
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
        include_once("api/adminAlmacenes.php");
        if ((int) ($_SESSION['sesionUsuario']['permisos'] ?? 0) > 100) {
            header('Location: pruebas.seminuevosharo.mx');
        }
        $admin = new AdministradorAlmacenes();

        ?>
        <?php
        include_once("../api/adminUsuarios.php");
        $adminUsuario = new administradorUsuarios();
        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));



        if(isset($_GET['id'])) {
            $almacen = $admin->dameAlmacen(intval($_GET['id']));
            $editando = true;
        }
        else {
            $editando = false;
        }


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
                                        <p class="card-description"> Información del auto </p>
                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="col-form-label">Dirección del almacén</label>
                                                <input class="form-control" type="text" name="direccion" value="<?php echo isset($almacen) ? $almacen->direccion : ''; ?>" />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label">Código postal</label>
                                                <input type="text" name="cp" value="<?php echo isset($almacen) ? $almacen->cp : ''; ?>" class="form-control" />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label">Etiqueta</label>
                                                <input class="form-control" type="text" name="des_gen" value="<?php echo isset($almacen) ? $almacen->des_gen : ''; ?>" />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label">Latitud</label>
                                                <input class="form-control" type="text" name="lat" id="lat" value="<?php echo (isset($almacen) && isset($almacen->lat)) ? $almacen->lat : ''; ?>" placeholder="Selecciona un punto en el mapa" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label">Longitud</label>
                                                <input class="form-control" type="text" name="lon" id="lon" value="<?php echo (isset($almacen) && isset($almacen->lon)) ? $almacen->lon : ''; ?>" placeholder="Selecciona un punto en el mapa" readonly />
                                            </div>

                                            <div class="col-12 mt-3">
                                                <label class="col-form-label">Ubicación en el mapa</label>
                                                <div class="input-group mb-2">
                                                    <input type="text" id="buscarDireccion" class="form-control" placeholder="Buscar dirección..." />
                                                    <button class="btn btn-outline-secondary" type="button" id="btnBuscar">Buscar</button>
                                                </div>
                                                <div id="resultadosBusqueda" class="list-group mb-2" style="position:relative; z-index:1000;"></div>
                                                <div id="mapa" style="height: 400px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                                                <small class="text-muted">Haz clic en el mapa para colocar el marcador y obtener las coordenadas.</small>
                                            </div>

                                            <div class="col-12 mt-4 d-flex justify-content-end">
                                                <button id="botonNuevo" type="submit" class="btn btn-rounded _effect--ripple waves-effect waves-light" style="background-color: #5A9F19; color: #fff;">Nuevo almacén</button>
                                            </div>

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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php
        $almacenArr  = isset($almacen) ? (array)$almacen : array();
        $mapInitLat  = !empty($almacenArr['lat']) ? floatval($almacenArr['lat']) : 20.6597;
        $mapInitLon  = !empty($almacenArr['lon']) ? floatval($almacenArr['lon']) : -103.3496;
    ?>
    <script>
        // Centro Guadalajara
        var initLat = <?php echo $mapInitLat; ?>;
        var initLon = <?php echo $mapInitLon; ?>;

        var map = L.map('mapa').setView([initLat, initLon], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        var marker = null;

        function rellenarDireccion(addr) {
            var partes = [];
            if (addr.road)         partes.push(addr.road);
            if (addr.house_number) partes.push(addr.house_number);
            if (addr.suburb)       partes.push(addr.suburb);
            if (addr.city || addr.town || addr.municipality)
                partes.push(addr.city || addr.town || addr.municipality);
            if (partes.length > 0)
                document.querySelector('[name="direccion"]').value = partes.join(', ');
            if (addr.postcode)
                document.querySelector('[name="cp"]').value = addr.postcode;
        }

        function colocarMarcador(lat, lon) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lon]).addTo(map);
            document.getElementById('lat').value = lat.toFixed(7);
            document.getElementById('lon').value = lon.toFixed(7);
        }

        function colocarMarcadorConReversa(lat, lon) {
            colocarMarcador(lat, lon);
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lon + '&accept-language=es')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.address) rellenarDireccion(data.address);
                });
        }

        // Si hay coordenadas guardadas, mostrar el marcador
        if (document.getElementById('lat').value !== '') {
            colocarMarcador(initLat, initLon);
        }

        // Clic en el mapa → reverse geocoding para rellenar campos
        map.on('click', function(e) {
            colocarMarcadorConReversa(e.latlng.lat, e.latlng.lng);
        });

        // Buscador de direcciones con Nominatim
        function buscarDireccion() {
            var query = document.getElementById('buscarDireccion').value.trim();
            if (!query) return;

            fetch('https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=' + encodeURIComponent(query) + '&limit=5&accept-language=es&countrycodes=mx')
                .then(function(r) { return r.json(); })
                .then(function(resultados) {
                    var lista = document.getElementById('resultadosBusqueda');
                    lista.innerHTML = '';
                    if (resultados.length === 0) {
                        lista.innerHTML = '<div class="list-group-item text-muted">Sin resultados</div>';
                        return;
                    }
                    resultados.forEach(function(res) {
                        var item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = res.display_name;
                        item.addEventListener('click', function() {
                            var lat = parseFloat(res.lat);
                            var lon = parseFloat(res.lon);
                            map.setView([lat, lon], 16);
                            colocarMarcador(lat, lon);
                            if (res.address) rellenarDireccion(res.address);
                            lista.innerHTML = '';
                            document.getElementById('buscarDireccion').value = res.display_name;
                        });
                        lista.appendChild(item);
                    });
                });
        }

        document.getElementById('btnBuscar').addEventListener('click', buscarDireccion);

        document.getElementById('buscarDireccion').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                buscarDireccion();
            }
        });
    </script>

    <script>

        var formularioAuto = document.getElementById("formularioAuto");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();
            let datosDeInicioAuto = new FormData(formularioAuto);
            var botonAgregar = document.getElementById("botonNuevo");
            botonAgregar.disabled = true;
            botonAgregar.innerHTML = "Agregando...";


            if (<?php echo $editando ? 'true' : 'false'; ?>) {
                datosDeInicioAuto.append("id", "<?php echo isset($almacen) ? $almacen->id : ''; ?>");
                datosDeInicioAuto.append("accion", "modificacion");
            }
            else {

            datosDeInicioAuto.append("accion", "alta");
            }

            fetch("api/apiAlmacen.php", {
                    method: "POST", 
                    body: datosDeInicioAuto,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.mensaje,
                        }).then(() => {
                            window.location.href = "almacenes.php";
                        });
                    }
                });
        });
    </script>

</body>

</html>
