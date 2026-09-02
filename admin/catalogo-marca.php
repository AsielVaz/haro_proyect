<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
    <title>Catalogos - Marca</title>

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
        <!-- Navbar Start -->

        <?php include_once("templates/header.php") ?>
        <?php

        include_once("api/adminEditor.php");
        $adminEditor = new AdministradorEditor();
        $marcas = $adminEditor->dameMarcas();

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
                                <li class="breadcrumb-item active"><span>Autos Activos</span></li>
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
            <section class="main--content">


                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Formulario Marca</h3>
                    </div>
                    <div class="panel-content">
                        <form action="">
                            <div class="form-group"> <label> <span class="label-text">Nombre de la marca </span> <input type="text" name="nombre" placeholder="Ingresa el nombre de la marca ... " class="form-control"> </label> </div>
                            <div class="form-group">
                                <label> <span class="label-text">Imagen de la marca</span>
                                    <input type="file" name="file" class="form-control">
                                </label>
                            </div>
                            <div class="form-group pt-1 pb-1"> </div><input type="submit" value="Submit" class="btn btn-sm btn-rounded btn-success"> <button type="button" class="btn btn-sm btn-rounded btn-outline-secondary">Cancel</button>
                            </form>
                        </div>
                </div>

            </section>


            <!-- Main Content Start -->
            <section class="main--content">

                <div class="panel">
                    <!-- Records List Start -->
                    <div class="records--list" data-title="Product Listing">
                        <table id="recordsListView">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Marca </th>
                                    <th> Imagen </th>
                                    <th> Acciones </th>

                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                foreach ($marcas as $marca) {
                                    echo "<tr>";
                                    echo "<td>" . $marca->id . "</td>";
                                    echo "<td>" . $marca->marca . "</td>";
                                    echo "<td><img src='" . $marca->imagen . "' alt=''></td>";

                                    echo "<td><div class='dropleft'><a href='#' class='btn-link' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a><div class='dropdown-menu'><a href='#' class='dropdown-item'>Edit</a><a href='#' class='dropdown-item'>Delete</a></div></div></td>";
                                    echo "</tr>";
                                }

                                ?>




                            </tbody>
                        </table>
                    </div>
                    <!-- Records List End -->
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

    <!-- Page Level Scripts -->

</body>

</html>