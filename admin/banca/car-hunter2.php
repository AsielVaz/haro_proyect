<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Banca - Haro </title>
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

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/dt-global_style.css">

</head>

<style>
    .columna {
        /* Ruta de la imagen de fondo */
        background-size: cover;
        /* Ajustar el tamaño de la imagen para cubrir toda la columna */
        background-position: center;
        /* Centrar la imagen de fondo */

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
        include_once("../api/adminUsuarios.php");
        include_once("../api/adminCarHunter.php");
        include_once("../api/adminAutos.php");

        $adminAutos = new AdministradorAutos();
        $adminCarHunter = new AdministradorCarHunter();
        $hunters = $adminCarHunter->dameCarHunter();
        $adminUsuario = new administradorUsuarios();
        $autos = $adminAutos->dameAutosSinPausar();

        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));
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
                                            <h3>Prospectos por CAR-HUNTER</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>

                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a style="background-color: #5A9F19;" class="btn btn-succes mb-2 me-4 _effect--ripple waves-effect waves-light" href="./auto-nuevo.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                                    <path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z" />
                                                    <path fill="#fff" d="M21,14h6v20h-6V14z" />
                                                    <path fill="#fff" d="M14,21h20v6H14V21z" />
                                                </svg>

                                            </a>
                                        </div>
                                    </li>
                                </ul>

                            </header>
                        </div>
                    </div>
                    <!--  END BREADCRUMBS  -->



                    <div class="row layout-top-spacing">

                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                            <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th> Nombre </th>
                                                    <th> Busca Marca </th>
                                                    <th> Busca Modelo </th>
                                                    <th> Correo </th>
                                                    <th> Precio </th>
                                                    <th> Auto Prospecto </th>
                                                    <th> Mensaje </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                        foreach ($hunters as $hunter) {
                          echo '
                          <tr>
                            <td> ' . $hunter->nombre . ' </td>
                            <td> ' . $hunter->marca . ' </td>
                            ';

                          if ($hunter->modelo == "") {
                            echo '<td> No Especifico </td>';
                          } else {
                            echo '<td> ' . $hunter->modelo . ' </td>';
                          }
                          echo ' 
                            
                            <td> ' . $hunter->email . ' </td>

                            <td> $' . number_format($hunter->precioMin)  . ' - $' . number_format($hunter->precioMax) . ' </td>
                            <td> 
                            <select onchange="asignarValores(this.value)" class="form-control form-control-lg" id="exampleFormControlSelect1">
                      

                              ';

                          if ($hunter->avisado == "0") {
                            echo '<option value="0">Seleccione Un auto</option>';

                            foreach ($autos as $auto) {

                              echo '
                                  <option value="' . $hunter->id . ',' . $auto->id . '"> ' . $auto->marca->marca . ' ' . $auto->modelo->modelo . ' $' . number_format($auto->precio) . ' </option>
                                  ';
                            }
                          } else {
                            echo '
                            <option value="0"> Ya fue avisado </option>
                            ';
                          }



                          echo ' 
                          <td> <textarea name="" id="mensaje' . $hunter->id . '" cols="20" rows="5"></textarea></td>

                            </select>
                            </td>
                          </tr>
                          ';
                        }
                        ?>
                                            </tbody>
                                        </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!--  BEGIN FOOTER  -->
            <button onclick="notificar()" class="btn-flotante">Notificar</button>

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
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
    var arreglo = [];
    var autoId = 0;
    var imagenId = 0;

    function asignarValores(valores) {
        console.log(valores);
        var ids = valores.split(",");
        console.log(ids);
        autoId = ids[0];
        imagenId = ids[1];
        var par = new Object();
        par.carHunter = autoId;
        par.auto = imagenId;
        arreglo.push(par);
        console.log(arreglo);
    }

    // Eliminar Cliente
    function deleteCliente(id) {
        let datosDeInicioAuto = new FormData();
        datosDeInicioAuto.append("accion", "eliminar");
        datosDeInicioAuto.append("id", id);
        fetch("../api/apiCliente.php", {
                method: "POST",
                body: datosDeInicioAuto,
            })
            .then((res) => res.json())
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

    // Agregar Cliente
    const formCliente = document.getElementById("formCliente");

    formCliente.addEventListener("submit", (e) => {
        e.preventDefault();
        let formData = new FormData(formCliente);
        formData.append("accion", "agregar");
        fetch("../api/apiCliente.php", {
                method: "POST",
                body: formData,
            })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                if (data == "1") {
                    console.log("Registro Exitoso");
                } else {
                    console.log("Error");
                }
            });
        formCliente.reset();
    });

    function notificar() {
        for (let i = 0; i < arreglo.length; i++) {
            let chData = new FormData();
            mensaje = document.getElementById("mensaje" + arreglo[i].carHunter).value;
            console.log(arreglo[i].carHunter);
            chData.append("accion", "notificarManual");
            chData.append("carHunter", arreglo[i].carHunter);
            chData.append("auto", arreglo[i].auto);
            chData.append("mensaje", mensaje);
            fetch("../api/apiCarHunter.php", {
                    method: "POST",
                    body: chData,
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log(data);
                    if (data == "1") {
                        console.log("Registro Exitoso");
                    } else {
                        console.log("Error");
                    }
                });

            if (i == arreglo.length - 1) {
                location.reload();
            }
        }
    }
    </script>

</body>

</html>