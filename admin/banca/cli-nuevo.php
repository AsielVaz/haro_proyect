<?php session_start(); ?>
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

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>
:root{
--haro-red:#b0141b;
--haro-gold:#c9a24a;
--haro-shadow:0 18px 48px rgba(15,15,18,.09);
}
body.layout-boxed{
font-family:'DM Sans',sans-serif!important;
background:radial-gradient(circle at top right,rgba(201,162,74,.16),transparent 32%),linear-gradient(180deg,#fbf8f1 0%,#f4f1ea 100%)!important;
}
.secondary-nav .header{
background:rgba(255,255,255,.88)!important;
border-radius:26px!important;
border:1px solid rgba(201,162,74,.18)!important;
box-shadow:var(--haro-shadow)!important;
overflow:hidden;
position:relative;
}
.secondary-nav .header:before{
content:"";
position:absolute;top:0;left:0;right:0;height:4px;
background:linear-gradient(90deg,var(--haro-red),var(--haro-gold),var(--haro-red));
}
.haro-page-title .haro-eyebrow{
display:inline-flex;align-items:center;gap:8px;
font-family:'Bebas Neue',sans-serif;
color:var(--haro-red);font-size:18px;letter-spacing:.08em;
}
.haro-page-title .haro-eyebrow:before{
content:"";width:28px;height:2px;background:var(--haro-gold);
}
.page-title h3{
font-family:'Bebas Neue',sans-serif!important;
font-size:48px!important;
font-weight:400!important;
text-transform:uppercase;
}
.haro-form-card{
background:rgba(255,255,255,.92)!important;
border-radius:26px!important;
border:1px solid rgba(201,162,74,.18)!important;
box-shadow:var(--haro-shadow)!important;
overflow:hidden;
}
.haro-form-card:before{
content:"";display:block;height:4px;
background:linear-gradient(90deg,var(--haro-red),var(--haro-gold));
}
.haro-card-title{
font-family:'Bebas Neue',sans-serif!important;
font-size:32px!important;
font-weight:400!important;
}
.form-label{
font-family:'DM Sans',sans-serif!important;
font-weight:700!important;
}
.form-control{
min-height:48px!important;
border-radius:14px!important;
border:1px solid rgba(201,162,74,.25)!important;
}
.form-control:focus{
border-color:var(--haro-red)!important;
box-shadow:0 0 0 4px rgba(176,20,27,.1)!important;
}
.btn-haro-primary{
height:52px;
min-width:180px;
border:none!important;
border-radius:16px!important;
background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;
color:#fff!important;
font-family:'Bebas Neue',sans-serif!important;
font-size:22px!important;
letter-spacing:.06em;
}
@media(max-width:768px){
.page-title h3{font-size:34px!important;}
.btn-haro-primary{width:100%;}
}
</style>

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
        include_once("api/adminClientes.php");
        $adminClientes = new AdministradorClientesBanca();
        $hiddenEditar = "";
        if(isset($_GET['id'])){
            $editando = 1;
            $cliente = $adminClientes->dameCliente($_GET['id']);
            $hiddenEditar = "hidden";
        }
        else{
            $editando = 0;
            $hiddenEditar = "";

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

                                        <div class="page-title haro-page-title">
                                            <span class="haro-eyebrow">Clientes</span>
                                            <h3>Panel de creación de clientes</h3>
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
                            <div class="statbox widget box box-shadow haro-form-card">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4 class="haro-card-title">Información del cliente</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="row g-3" id="formulario">
                                        <div class="col-md-6" <?php echo $hiddenEditar?>>
                                            <label for="inputEmail4" class="form-label" >Nombre</label>
                                            <input type="text" value="<?php echo $cliente->nombre?>" class="form-control" id="nombre" name="nombre">
                                        </div>
                                        <div class="col-md-6" hidden>
                                            <label for="inputPassword4" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="app" name="app">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputPassword4"  class="form-label">Correo electrónico</label>
                                            <input type="email" value="<?php echo $cliente->email?>" class="form-control" id="correo" name="correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword4" class="form-label">Teléfono</label>
                                            <input type="text" value="<?php echo $cliente->telefono ?>" class="form-control" id="telefono" name="telefono">
                                        </div>

                                        <div class="col-md-3" <?php echo $hiddenEditar?>>
                                            <label for="inputPassword4" class="form-label">Comisión por crédito  (%)</label>
                                            <input type="text" value="5" oninput="verificaSoloNumeros('comision')" class="form-control" id="comision" name="comision">
                                        </div>

                                        <div class="col-md-3" <?php echo $hiddenEditar?>>
                                            <label for="inputPassword4" class="form-label">Imágen</label>
                                            <input type="file" class="form-control" id="archivo" name="archivo">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-haro-primary _effect--ripple waves-effect waves-light">Terminar</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>





                </div>

            </div>
            <?php include_once("template/footer_haro.php"); ?>
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
    function verificaSoloNumeros(nombre){
      var espacioComision = document.getElementById(nombre);
      //solo numeros en imput y punto 
      espacioComision.value = espacioComision.value.replace(/[^\d\.]/g, '');
      //solo un punto decimal
      espacioComision.value = espacioComision.value.replace(/\.{2,}/g, '.');
      espacioComision.value = espacioComision.value.replace('.', '$#$').replace(/\./g, '').replace('$#$', '.');
      //solo un punto decimal
      espacioComision.value = espacioComision.value.replace(/^(\d+)\.(\d\d).*$/, '$1.$2');

    }
  </script>
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
        const formulario = document.getElementById("formulario");


        formulario.addEventListener("submit", function(e) {
            e.preventDefault();
            const enviaDatos = new FormData(formulario);
           // enviaDatos.append("usuarioInserta", <?php echo $_SESSION["usuario_id"] ?>)

            if (<?php echo intval($editando) ?> == 1) {
                enviaDatos.append("accion", "modificar");
                enviaDatos.append("id", "<?php echo $_GET['id'] ?>");

            } else {
                enviaDatos.append("accion", "agregar");

            }
            fetch("api/apiClientes.php", {
                    method: "POST",
                    body: enviaDatos,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    Swal.fire(
                        data.status,
                        data.mensaje,
                        data.status
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "cli-lista.php";
                        }
                    });

                });
        });
    </script>

</body>

</html>