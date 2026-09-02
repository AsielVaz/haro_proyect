<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include_once("api/adminUsuarios.php");
$adminUsuarios = new administradorUsuarios();
$usuario = $adminUsuarios->dameUsuarioId((int) ($_SESSION['sesionUsuario']['id'] ?? 0));
if ($usuario->id === 0) {
    if (!headers_sent()) {
        header("Location: login.php");
    } else {
        echo "<script>location.replace('login.php');</script>";
    }
    exit;
}

?>

<header class="navbar navbar-fixed">
            <!-- Navbar Header Start -->
            <div class="navbar--header">
                <!-- Logo Start -->
                <a href="index.php" class="logo">
                    <img src="https://www.seminuevosharo.mx/assets/media/general/haro-logo.jpg" alt="">
                </a>
                <!-- Logo End -->

                <!-- Sidebar Toggle Button Start -->
                <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- Sidebar Toggle Button End -->
            </div>
            <!-- Navbar Header End -->

            <!-- Sidebar Toggle Button Start -->
            <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                <i class="fa fa-bars"></i>
            </a>
            <!-- Sidebar Toggle Button End -->

            <!-- Navbar Search Start -->
            <div class="navbar--search">
                <form action="search-results.html">
                    <input type="search" name="search" class="form-control" placeholder="Buscar algo..." required>
                    <button class="btn-link"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <!-- Navbar Search End -->

            <div class="navbar--nav ml-auto">
                <ul class="nav">
                   
                    <?php
                    
                    $imagenSesion = $_SESSION['sesionUsuario']['imagen'] ?? null;
                    if ($imagenSesion !== '-' && $imagenSesion !== null) {
                        $imagen = $imagenSesion;
                    }
                    else{
                        $imagen = "https://www.seminuevosharo.mx/assets/media/general/haro-logo.jpg";
                    }

                    ?>

                    <!-- Nav User Start -->
                    <li class="nav-item dropdown nav--user online">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <img src="<?php echo $imagen?>" alt="" class="rounded-circle">
                            <span><?php echo $usuario->nombre?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="profile.html"><i class="far fa-user"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="login.php"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </li>
                    <!-- Nav User End -->
                </ul>
            </div>
        </header>
        <!-- Navbar End -->

        <!-- Sidebar Start -->
        <aside class="sidebar" data-trigger="scrollbar">
            <!-- Sidebar Profile Start -->
            <div class="sidebar--profile">
                <div class="profile--img">
                    <a href="profile.html">
                        <img src="<?php echo $imagen?>" alt="" class="rounded-circle">
                    </a>
                </div>

                <div class="profile--name">
                    <a href="profile.html" class="btn-link"><?php echo $usuario->nombre?></a>
                </div>

                <div class="profile--nav">
                    <ul class="nav">
                        
                        <li class="nav-item">
                            <a href="login.php" class="nav-link" title="Logout">
                                <i class="fa fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sidebar Profile End -->

            <!-- Sidebar Navigation Start -->
            <?php include_once("barra.php") ?>
            <!-- Sidebar Navigation End -->

           
        </aside>
        <!-- Sidebar End -->
