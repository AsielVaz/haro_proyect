<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

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
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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


<style>
:root{
--haro-red:#b0141b;
--haro-gold:#c9a24a;
--page:#f4f1ea;
--text:#161616;
--radius:26px;
}
body.layout-boxed{
background:linear-gradient(180deg,#fbf8f1 0%,#f4f1ea 100%)!important;
font-family:'DM Sans',sans-serif!important;
}
.page-title h3,.haro-eyebrow,.haro-data-table thead th{
font-family:'Bebas Neue',sans-serif!important;
font-weight:400!important;
letter-spacing:.05em;
}
.haro-eyebrow{
color:var(--haro-red);
display:block;
margin-bottom:6px;
}
.secondary-nav .header{
background:rgba(255,255,255,.75)!important;
border:1px solid rgba(201,162,74,.2)!important;
border-radius:var(--radius)!important;
padding:18px 22px!important;
backdrop-filter:blur(12px);
}
.haro-table-card{
background:#fff!important;
border-radius:var(--radius)!important;
overflow:hidden;
box-shadow:0 12px 30px rgba(0,0,0,.08);
}
.haro-table-card:before{
content:"";
display:block;
height:4px;
background:linear-gradient(90deg,var(--haro-red),var(--haro-gold));
}
.haro-data-table thead th{
background:#181411!important;
color:#f9efe0!important;
font-size:1rem!important;
}
.haro-data-table tbody td{
font-family:'DM Sans',sans-serif!important;
vertical-align:middle;
}
.haro-data-table img{
width:70px!important;
height:50px!important;
object-fit:cover;
border-radius:12px;
border:2px solid rgba(201,162,74,.2);
}
.btn.btn-succes{
background:linear-gradient(135deg,var(--haro-red),#781313)!important;
border:none!important;
border-radius:14px!important;
}
.dataTables_filter input,
.dataTables_length select{
border-radius:12px!important;
}
.footer-wrapper{
font-family:'DM Sans',sans-serif!important;
}
</style>

</head>

<style>
    .columna {
        /* Ruta de la imagen de fondo */
        background-size: cover;
        /* Ajustar el tama単o de la imagen para cubrir toda la columna */
        background-position: center;
        /* Centrar la imagen de fondo */
       
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
        
        include_once("../api/adminAutos.php");
        $adminAutos = new AdministradorAutos();
        $autos = $adminAutos->dameAutosVendidos();
        
        ?>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Inventario">
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
                                            <span class="haro-eyebrow">Inventario</span><h3>Inventario de autos vendidos</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Inventario</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>

                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a style="background-color: #5A9F19;" class="btn btn-succes mb-2 me-4 _effect--ripple waves-effect waves-light" href="./auto-nuevo.php" >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"/><path fill="#fff" d="M21,14h6v20h-6V14z"/><path fill="#fff" d="M14,21h20v6H14V21z"/></svg>

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
                            <div class="widget-content widget-content-area br-8 haro-table-card">
                            <table id="zero-config" class="table table-striped dt-table-hover haro-data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Imagen </th>
                                    <th> Auto </th>
                                    <th> Color </th>
                                    <th> Año </th>

                                    <th> Precio </th>
                                    <th> Publicado </th>
                                    <th> Acciones </th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                    foreach($autos as $auto){
                                        if ($auto->imagen == "") {
                                            $imagen = $auto->imagenes[0]->url;
                                        } else {
                                            $imagen = $auto->imagen;
                                        }
                                        echo "<tr class='columna'>";
                                        echo "<td>".$auto->id."</td>";
                                        echo '<td><img alt="avatar" class="img-fluid" src="' . $imagen . '" style="width: 10%;"></td>';
                                        echo "<td>".$auto->marca->marca." ".$auto->modelo->modelo."</td>";
                                        echo "<td>".$auto->color."</td>";
                                        echo "<td>".$auto->anio."</td>";
                                        echo "<td>".$auto->precio."</td>";
                                        echo "<td>".$auto->estatus."</td>";
                                        echo "<td><div class='dropleft'><a href='#' class='btn-link' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a><div class='dropdown-menu'><a href='#' class='dropdown-item'>Edit</a><a href='#' class='dropdown-item'>Delete</a></div></div></td>";
                                        echo "</tr>";
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
             <?php include_once("template/footer_haro.php"); ?>
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
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar vehículo...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

<script>
    function eliminar(id) {

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#009378',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                let datos = new FormData();
                datos.append("accion", "eliminar");
                datos.append("id", id);

                fetch("../api/apiAuto.php", {
                        method: "POST",
                        body: datos,
                    })
                    .then((respuesta) => respuesta.json())
                    .then((data) => {

                        console.log(data);

                        console.log("Registro Exitoso");


                    });
                Swal.fire(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            }
            else{
                Swal.fire(
                    'Cancelado!',
                    'El registro no ha sido eliminado.',
                    'error'
                )
            }
        })




    }
</script>

</body>

</html>