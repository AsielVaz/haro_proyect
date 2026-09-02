<div class="sidebar--nav">
    <ul>
        <li>
            <ul>
                <li class="active">
                    <a href="index.php">
                        <i class="fa fa-home"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-car"></i>
                        <span>Autos</span>
                    </a>

                    <ul>
                        <li><a href="autos.php">Inventario Activo</a></li>
                        <li><a href="autos-inactivo.php">Inventario Eliminado</a></li>
                        <!-- <li><a href="autos-ventas.php">Ventas</a></li> -->
                        <li><a href="autos-consig.php">Consignación </a></li>
                        <li><a href="autos-nuevo.php">Nuevo Auto </a></li>


                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-file"></i>
                        <span>Catálogos</span>
                    </a>

                    <ul>
                        <li><a href="catalogo-marca.php">Marcas</a></li>
                        <li><a href="catalogo-modelo.php">Modelos</a></li>
                        <li><a href="catalogo-interiores.php">Interiores</a></li>
                        <li><a href="catalogo-transmiciones.php">Transiciones </a></li>


                    </ul>
                </li>
                <?php
                if($_SESSION['sesionUsuario']['permiso_banca'] == 'Banca'){
                    echo '<li>
                    <a href="usuario-nuevo.php">
                        <i class="fa fa-user"></i>
                        <span>Usuarios</span>
                    </a>

                </li>';
                }
                else if($_SESSION['sesionUsuario']['permiso_banca'] == 'Cashier'){
        
                }
                ?>
                
                <li>
                    <a href="galeria.php">
                        <i class="fa fa-file-image"></i>
                        <span>Galería</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/banca">
                        <i class="fa fa-line-chart"></i>
                        <span>Ir a la Banca</span>
                    </a>
                </li>
                <?php 
                
                if($_SESSION['sesionUsuario']['permiso_banca'] == 'Banca'){
                    echo ' <li>
                    <a href="galeria.php">
                        <i class="fa fa-thumbs-o-up"></i>
                        <span>Car Hunter</span>
                    </a>
                </li>';
                }
                else if($_SESSION['sesionUsuario']['permiso_banca'] == 'Cashier'){
        
                }
                
                
                ?>
               
            </ul>
        </li>


    </ul>
</div>


<!-- Sidebar Widgets Start -->
<!-- <div class="sidebar--widgets">
                <div class="widget">
                    <h3 class="h6 widget--title">Information Summary</h3> -->

<!-- Summary Widget Start -->
<!-- <div class="summary--widget">
                        <div class="summary--item">
                            <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#2bb3c0">5,6,7,9,15,5,6,7,9,11,7,9,11,7,9,9,3,2</p>

                            <p class="summary--title">Daily Traffic</p>
                            <p class="summary--stats">307.512</p>
                        </div>

                        <div class="summary--item">
                            <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#e16123">2,3,7,7,9,11,9,7,9,11,9,7,5,4,9,7,5,4</p>

                            <p class="summary--title">Average Usage</p>
                            <p class="summary--stats">2,371,527</p>
                        </div>

                        <div class="summary--item">
                            <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#cccccc">5,6,7,9,15,5,6,7,9,11,7,9,11,7,9,9,3,2</p>

                            <p class="summary--title">Disk Usage</p>
                            <p class="summary--stats">37.5%</p>
                        </div>

                        <div class="summary--item">
                            <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#009378">2,3,7,7,9,11,9,7,9,11,9,7,5,4,9,7,5,4</p>

                            <p class="summary--title">CPU Usage</p>
                            <p class="summary--stats">37.05-32</p>
                        </div>
                        
                        <div class="summary--item">
                            <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5" data-height="38" data-color="#ff4040">5,6,7,9,15,5,6,7,9,11,7,9,11,7,9,9,3,2</p>

                            <p class="summary--title">Memory Usage</p>
                            <p class="summary--stats">37.05%</p>
                        </div>
                    </div> -->
<!-- Summary Widget End -->
<!-- </div>
            </div> -->
<!-- Sidebar Widgets End -->