
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$usuarioPermiso = $_SESSION['sesionUsuario']['permiso_banca'] ?? '';
if (!in_array($usuarioPermiso, ['Banca', 'Cashier'], true)) {
    if (!headers_sent()) {
        header('Location: ../index.php');
    } else {
        echo '<script>window.location.replace("../index.php");</script>';
    }
    exit;
}
?>

<style>
    /* Diseño HARO Seminuevos - solo estilos visuales del menú */
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;500;600;700;800&display=swap');

    :root {
        --haro-navy: #10152d;
        --haro-dark: #070b12;
        --haro-panel: #0e131f;
        --haro-red: #e1262f;
        --haro-gold: #c59a2e;
        --haro-white: #ffffff;
        --haro-muted: #aab1c4;
        --haro-line: rgba(255, 255, 255, .08);
        --haro-shadow: 0 18px 45px rgba(0, 0, 0, .28);
    }

    .sidebar-wrapper.sidebar-theme {
        background: linear-gradient(180deg, var(--haro-dark) 0%, var(--haro-panel) 48%, #07080d 100%) !important;
        border-right: 1px solid rgba(225, 38, 47, .22);
        box-shadow: var(--haro-shadow);
        font-family: 'Montserrat', Arial, sans-serif;
        z-index: 1030;
    }

    #sidebar {
        background: transparent !important;
        color: var(--haro-white);
        min-height: 100vh;
    }

    #sidebar .theme-brand {
        min-height: 98px;
        padding: 18px 18px 14px;
        background: #ffffff;
        border-bottom: 3px solid var(--haro-red);
        box-shadow: 0 8px 22px rgba(0, 0, 0, .12);
        align-items: center;
        justify-content: space-between;
    }

    #sidebar .nav-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    #sidebar .theme-logo a {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #sidebar .theme-logo img.navbar-logo {
        width: 118px !important;
        max-width: 118px;
        height: auto;
        object-fit: contain;
    }

    #sidebar .theme-text .nav-link {
        color: var(--haro-navy) !important;
        font-family: 'Bebas Neue', 'Oswald', Arial, sans-serif;
        font-size: 25px;
        letter-spacing: 2px;
        line-height: 1;
        padding: 0;
        text-transform: uppercase;
    }

    #sidebar .sidebar-toggle .btn-toggle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--haro-red);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(225, 38, 47, .28);
        cursor: pointer;
        transition: transform .2s ease, background .2s ease;
    }

    #sidebar .sidebar-toggle .btn-toggle:hover {
        background: var(--haro-navy);
        transform: translateX(-2px);
    }

    #sidebar .sidebar-toggle svg {
        width: 19px;
        height: 19px;
    }

    #sidebar .shadow-bottom {
        display: none;
    }

    #sidebar .menu-categories {
        padding: 18px 14px 26px;
        margin: 0;
        overflow-y: auto;
    }

    #sidebar .menu-heading {
        margin: 22px 4px 9px;
    }

    #sidebar .menu-heading .heading {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--haro-gold);
        font-family: 'Montserrat', Arial, sans-serif;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 2.4px;
        text-transform: uppercase;
    }

    #sidebar .menu-heading svg {
        width: 15px;
        height: 15px;
        stroke: var(--haro-red);
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 48px;
        margin: 6px 0;
        padding: 12px 14px;
        color: var(--haro-white) !important;
        background: rgba(255, 255, 255, .035);
        border: 1px solid var(--haro-line);
        border-radius: 14px;
        text-decoration: none;
        overflow: hidden;
        transition: background .2s ease, border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle::before,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle::before {
        content: '';
        position: absolute;
        left: 0;
        top: 12px;
        bottom: 12px;
        width: 3px;
        border-radius: 0 8px 8px 0;
        background: transparent;
        transition: background .2s ease;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle:hover,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle,
    #sidebar ul.menu-categories li.menu.active > a.dropdown-toggle,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true'] {
        background: linear-gradient(135deg, rgba(225, 38, 47, .16), rgba(197, 154, 46, .08));
        border-color: rgba(225, 38, 47, .46);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .20);
        transform: translateX(3px);
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover::before,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle::before,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true']::before {
        background: var(--haro-red);
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle > div:first-child {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    #sidebar ul.menu-categories li.menu svg {
        width: 20px;
        height: 20px;
        min-width: 20px;
        stroke: var(--haro-red);
        transition: stroke .2s ease, transform .2s ease;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover svg,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle svg,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true'] svg {
        stroke: var(--haro-gold);
        transform: scale(1.04);
    }

    #sidebar ul.menu-categories li.menu span {
        color: inherit;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .55px;
        text-transform: uppercase;
        white-space: normal;
    }

    #sidebar .submenu.dropdown-menu {
        position: static !important;
        float: none;
        width: auto;
        margin: 2px 0 8px 36px;
        padding: 8px 0 8px 14px;
        background: transparent;
        border: 0;
        border-left: 1px solid rgba(197, 154, 46, .34);
        box-shadow: none;
        transform: none !important;
    }

    #sidebar .submenu li a {
        display: block;
        padding: 9px 12px;
        color: var(--haro-muted) !important;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .35px;
        text-decoration: none;
        transition: color .2s ease, background .2s ease, padding-left .2s ease;
    }

    #sidebar .submenu li a:hover {
        color: var(--haro-white) !important;
        background: rgba(225, 38, 47, .14);
        padding-left: 16px;
    }

    .sidebar-wrapper .feather-chevron-right {
        stroke: var(--haro-muted) !important;
        transition: transform .2s ease, stroke .2s ease;
    }

    #sidebar .dropdown-toggle[aria-expanded='true'] .feather-chevron-right {
        transform: rotate(90deg);
        stroke: var(--haro-gold) !important;
    }

    @media (max-width: 991.98px) {
        .sidebar-wrapper.sidebar-theme {
            width: 290px;
            max-width: calc(100vw - 28px);
            border-radius: 0 22px 22px 0;
            overflow: hidden;
        }

        #sidebar .theme-brand {
            min-height: 88px;
            padding: 14px 16px;
        }

        #sidebar .theme-logo img.navbar-logo {
            width: 104px !important;
            max-width: 104px;
        }

        #sidebar .theme-text .nav-link {
            font-size: 21px;
            letter-spacing: 1.6px;
        }

        #sidebar .menu-categories {
            max-height: calc(100vh - 88px);
            padding: 14px 12px 24px;
        }

        #sidebar ul.menu-categories li.menu > .dropdown-toggle,
        #sidebar ul.menu-categories li.menu > a.dropdown-toggle {
            min-height: 46px;
            padding: 11px 13px;
        }

        #sidebar ul.menu-categories li.menu span {
            font-size: 12px;
        }
    }

    @media (max-width: 575.98px) {
        .sidebar-wrapper.sidebar-theme {
            width: 86vw;
        }

        #sidebar .theme-text .nav-link {
            display: none;
        }

        #sidebar .theme-logo img.navbar-logo {
            width: 128px !important;
            max-width: 128px;
        }
    }

    /* ==========================================================
       RESPONSIVE DEL MENÚ CENTRALIZADO EN barra.php
       Mantiene el sidebar funcional en móvil/tablet sin depender
       de hacks en barra_nav.php.
    ========================================================== */

    @media (max-width: 991.98px) {
        .sidebar-wrapper.sidebar-theme {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            width: 290px !important;
            max-width: calc(100vw - 28px) !important;
            border-radius: 0 22px 22px 0;
            overflow: hidden;
            transform: translateX(-112%) !important;
            transition: transform .28s cubic-bezier(.4,0,.2,1) !important;
            z-index: 1100 !important;
            visibility: visible !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }

        body.sidebar-noneoverflow .sidebar-wrapper.sidebar-theme,
        html.sidebar-noneoverflow .sidebar-wrapper.sidebar-theme,
        .sidebar-wrapper.sidebar-theme.active,
        .sidebar-wrapper.sidebar-theme.show {
            transform: translateX(0) !important;
        }

        body.sidebar-noneoverflow,
        html.sidebar-noneoverflow {
            overflow: hidden !important;
        }

        .overlay {
            z-index: 1090 !important;
        }

        .overlay.show,
        body.sidebar-noneoverflow .overlay,
        html.sidebar-noneoverflow .overlay {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            background: rgba(7, 11, 18, .56) !important;
            backdrop-filter: blur(3px);
        }

        #sidebar,
        #sidebar .menu-categories,
        #sidebar .menu,
        #sidebar a,
        #sidebar .dropdown-toggle,
        #sidebar .submenu,
        #sidebar .submenu li,
        #sidebar .submenu li a {
            pointer-events: auto !important;
        }

        #sidebar .menu-categories {
            max-height: calc(100vh - 88px) !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        #sidebar .submenu.dropdown-menu {
            display: none;
        }

        #sidebar .submenu.dropdown-menu.show,
        #sidebar .dropdown-toggle[aria-expanded="true"] + .submenu.dropdown-menu {
            display: block !important;
        }

        #sidebar .sidebar-toggle .btn-toggle {
            pointer-events: auto !important;
            cursor: pointer !important;
        }
    }

    @media (min-width: 992px) {
        .sidebar-wrapper.sidebar-theme {
            position: relative !important;
            transform: none !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    }

</style>



<style id="haro-menu-full-width-final">
/* ==========================================================
   HARO MENU FULL WIDTH
   Hace que la barra horizontal ocupe todo el ancho real
   de la pantalla en escritorio, aunque esté dentro de un
   contenedor con padding o max-width.
========================================================== */

@media (min-width: 992px) {
    .sidebar-wrapper.sidebar-theme {
        width: 100vw !important;
        max-width: none !important;
        margin-left: calc(50% - 50vw) !important;
        margin-right: calc(50% - 50vw) !important;
        margin-top: 0 !important;
        margin-bottom: 28px !important;
        border-radius: 0 !important;
        padding-left: clamp(18px, 3vw, 48px) !important;
        padding-right: clamp(18px, 3vw, 48px) !important;
    }

    .sidebar-wrapper.sidebar-theme::before {
        border-radius: 0 !important;
    }

    #sidebar .menu-categories {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="./index.php">
                                <img src="../src/assets/img/logo.svg" style="width: fit-content;" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="./index.php" class="nav-link">HARO</a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu active">
                        <a href="./index.php" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent">
                                    <line x1="19" y1="5" x2="5" y2="19"></line>
                                    <circle cx="6.5" cy="6.5" r="2.5"></circle>
                                    <circle cx="17.5" cy="17.5" r="2.5"></circle>
                                </svg> <span>Data</span>
                            </div>

                        </a>

                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>APLICACIONES</span></div>
                    </li>


                    <li class="menu active">
                        <a href="./cli-lista.php" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>Clientes</span>
                            </div>

                        </a>
                        <!-- <ul class="dropdown-menu submenu list-unstyled" id="clientes" data-bs-parent="#accordionExample">
                            <li>
                                <a href="./cli-lista.php"> Lista de clientes </a>
                            </li>
                            <li>
                                <a href="./cli-nuevo.php"> Agregar cliente  </a>
                            </li>
                           
                         
                           
                        </ul> -->
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>APLICACIONES</span></div>
                    </li>

                    <li class="menu active">
                        <a href="autos-inventario.php" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive">
                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                    <rect x="1" y="3" width="22" height="5"></rect>
                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                </svg> <span>Inventario</span>
                            </div>

                        </a>

                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>VENTAS</span></div>
                    </li>

                    <li class="menu">
                        <a href="#components" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg> <span>Ventas</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="components" data-bs-parent="#accordionExample">
                            <li>
                                <a href="./venta-rel.php"> Ventas </a>
                            </li>
                            <li>
                                <a href="./venta-pen.php"> Ventas no liquidadas </a>
                            </li>
                            <li>
                                <a href="./venta-con.php"> Ventas liquidadas </a>
                            </li>

                        </ul>
                    </li>

                    <li class="menu">
                        <a href="#elements" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                                <span>Pagos</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="elements" data-bs-parent="#accordionExample">
                            <?
                            if ($_SESSION['sesionUsuario']['permiso_banca'] == 'Banca') {
                                echo '
                                <li>
                                    <a href="./pago-nuevo.php"> Nuevo pago </a>
                                </li>
                                    <li>
                                        <a href="./pago-real.php"> Pagos entregados </a>
                                    </li>
                                    <li>
                                        <a href="./pago-pend.php"> Pagos pendientes  </a>
                                    </li>

                                    
                                   
                                    <li>
                                        <a href="./pago-ret.php"> Pagos atrasados </a>
                                    </li>
                                ';
                            } else if ($_SESSION['sesionUsuario']['permiso_banca'] == 'Cashier') {
                                echo '
                                <li>
                                    <a href="./pago-nuevo.php"> Nuevo pago </a>
                                </li>
                                    <li>
                                        <a href="./pago-real.php"> Pagos entregados </a>
                                    </li>
                                   
                                 
                                    <li>
                                        <a href="./pago-ret.php"> Pagos atrasados </a>
                                    </li>
                                    <li>
                                        <a href="./pago-pend.php"> Pagos pendientes  </a>
                                    </li>
                                
                                ';
                            } else {
                            }

                            ?>


                        </ul>
                    </li>




                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>ADMINISTRACIÓN</span></div>
                    </li>



                    <li class="menu">
                        <a href="#arch" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg><span>Archivo </span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="arch" data-bs-parent="#accordionExample">
                            <li>
                                <a href="autos-eliminados.php"> Autos vendidos </a>
                            </li>
                            <li>
                                <a href="autos-consig.php"> Autos consignación </a>
                            </li>


                        </ul>
                    </li>


                    

                    <li class="menu active">
                        <a href="galeria.php" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg><span>Galería</span>
                            </div>

                        </a>

                    </li>


                    <li class="menu">
                        <a href="#catalogos" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>                            <span>Catálogos</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="catalogos" data-bs-parent="#accordionExample">
                            <li>
                                <a href="cat-marcas.php"> Marcas  </a>
                            </li>
                            <li>
                                <a href="cat-modelos.php"> Modelos </a>
                            </li>


                        </ul>
                    </li>


                    

                    <?php
                    if ($_SESSION['sesionUsuario']['permiso_banca'] == 'Banca') {
                        echo '
                        
                        <li class="menu active">
                        <a href="car-hunter.php" class="dropdown-toggle">
                            <div class="">
                                
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-crosshair"><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></svg>
                            <span>Car Hunter</span>
                            </div>

                        </a>

                    </li>


                            
                    <li class="menu active">
                    <a href="usuarios.php" class="dropdown-toggle">
                        <div class="">
                            
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>                        <span>Usuarios</span>
                        </div>

                    </a>

                </li>
                        
                        ';
                    }

                    ?>





                </ul>

            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <script>
            let nivel_acceso = "<?php echo $_SESSION['sesionUsuario']['permiso_banca'] ?>";
            console.log("Nivel de acceso " + nivel_acceso);
        </script>

<script>
(function () {
    if (window.__haroMenuSeparadoReady) return;
    window.__haroMenuSeparadoReady = true;

    function mobile() {
        return window.innerWidth <= 991.98;
    }

    function sidebar() {
        return document.querySelector('.sidebar-wrapper.sidebar-theme');
    }

    function overlay() {
        return document.querySelector('.overlay');
    }

    function openMenu() {
        var s = sidebar();
        var o = overlay();
        if (!s) return;

        s.classList.add('active', 'show');
        document.body.classList.add('sidebar-noneoverflow');
        document.documentElement.classList.add('sidebar-noneoverflow');

        if (o) o.classList.add('show');
    }

    function closeMenu() {
        var s = sidebar();
        var o = overlay();
        if (!s) return;

        s.classList.remove('active', 'show');
        document.body.classList.remove('sidebar-noneoverflow');
        document.documentElement.classList.remove('sidebar-noneoverflow');

        if (o) o.classList.remove('show');
    }

    function isOpen() {
        var s = sidebar();
        return !!s && (
            s.classList.contains('active') ||
            s.classList.contains('show') ||
            document.body.classList.contains('sidebar-noneoverflow') ||
            document.documentElement.classList.contains('sidebar-noneoverflow')
        );
    }

    document.addEventListener('click', function (event) {
        if (!mobile()) return;

        var trigger = event.target.closest('.sidebarCollapse');
        var overlayClick = event.target.closest('.overlay');
        var sidebarLink = event.target.closest('#sidebar a');
        var insideSidebar = event.target.closest('.sidebar-wrapper.sidebar-theme');

        if (overlayClick) {
            closeMenu();
            return;
        }

        if (trigger) {
            setTimeout(function () {
                if (insideSidebar) {
                    closeMenu();
                } else if (isOpen()) {
                    closeMenu();
                } else {
                    openMenu();
                }
            }, 20);
            return;
        }

        if (sidebarLink) {
            var href = sidebarLink.getAttribute('href') || '';
            var dropdown = sidebarLink.getAttribute('data-bs-toggle') === 'dropdown';

            if (dropdown || href.charAt(0) === '#') {
                return;
            }

            closeMenu();
        }
    }, true);

    window.addEventListener('resize', function () {
        if (!mobile()) closeMenu();
    });
})();
</script>


<style id="haro-menu-premium-legible">
/* ==========================================================
   HARO MENU PREMIUM LEGIBLE
   Solo diseño. No modifica permisos, rutas, PHP ni JS.
========================================================== */

:root {
    --haro-menu-bg: #0a0b10;
    --haro-menu-bg-2: #11131a;
    --haro-menu-card: #171922;
    --haro-menu-card-hover: #23161a;
    --haro-menu-red: #c81924;
    --haro-menu-gold: #c9a24a;
    --haro-menu-cream: #fff3df;
    --haro-menu-muted: #d8cbb7;
    --haro-menu-line: rgba(201, 162, 74, .18);
}

/* CONTENEDOR HORIZONTAL */
@media (min-width: 992px) {
    .sidebar-wrapper.sidebar-theme {
        width: calc(100% - 72px) !important;
        max-width: 1720px !important;
        min-height: auto !important;
        margin: 18px auto 32px !important;
        padding: 22px 24px !important;
        position: relative !important;
        overflow: visible !important;
        background:
            radial-gradient(circle at 8% 0%, rgba(201,162,74,.18), transparent 25%),
            radial-gradient(circle at 92% 0%, rgba(200,25,36,.16), transparent 28%),
            linear-gradient(135deg, #090a0f 0%, #10131b 62%, #08090d 100%) !important;
        border: 1px solid rgba(201,162,74,.24) !important;
        border-radius: 28px !important;
        box-shadow: 0 24px 60px rgba(0,0,0,.22) !important;
        transform: none !important;
    }

    .sidebar-wrapper.sidebar-theme::before {
        /* content: "" !important; */
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 4px !important;
        border-radius: 28px 28px 0 0 !important;
        background: linear-gradient(90deg, var(--haro-menu-red), var(--haro-menu-gold), var(--haro-menu-red)) !important;
    }

    #sidebar {
        min-height: auto !important;
        background: transparent !important;
    }

    #sidebar .theme-brand,
    #sidebar .shadow-bottom,
    #sidebar .menu-heading {
        display: none !important;
    }

    #sidebar .menu-categories {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow: visible !important;
        min-height: 66px !important;
        background: transparent !important;
    }

    #sidebar .menu-categories > li.menu {
        position: relative !important;
        margin: 0 !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle {
        min-height: 54px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        margin: 0 !important;
        padding: 13px 18px !important;
        background: linear-gradient(180deg, rgba(255,255,255,.095), rgba(255,255,255,.045)) !important;
        border: 1px solid rgba(201,162,74,.20) !important;
        border-radius: 16px !important;
        color: var(--haro-menu-cream) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 10px 18px rgba(0,0,0,.12) !important;
        text-decoration: none !important;
        overflow: hidden !important;
        transform: none !important;
        opacity: 1 !important;
        filter: none !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle > div:first-child {
        display: inline-flex !important;
        align-items: center !important;
        gap: 12px !important;
        position: relative !important;
        z-index: 2 !important;
    }

    #sidebar ul.menu-categories li.menu span {
        color: var(--haro-menu-cream) !important;
        opacity: 1 !important;
        visibility: visible !important;
        font-size: 13px !important;
        font-weight: 800 !important;
        letter-spacing: .45px !important;
        line-height: 1.1 !important;
        text-transform: uppercase !important;
        text-shadow: 0 1px 1px rgba(0,0,0,.28) !important;
    }

    #sidebar ul.menu-categories li.menu svg {
        width: 21px !important;
        height: 21px !important;
        min-width: 21px !important;
        stroke: var(--haro-menu-gold) !important;
        opacity: 1 !important;
        filter: none !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle::before,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle::before {
        content: "" !important;
        position: absolute !important;
        left: 14px !important;
        right: 14px !important;
        bottom: 0 !important;
        height: 3px !important;
        width: auto !important;
        border-radius: 99px 99px 0 0 !important;
        background: transparent !important;
        top: auto !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle::after,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle::after {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        background: linear-gradient(135deg, rgba(200,25,36,.28), rgba(201,162,74,.14)) !important;
        opacity: 0 !important;
        pointer-events: none !important;
        transition: opacity .22s ease !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle:hover,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle,
    #sidebar ul.menu-categories li.menu.active > a.dropdown-toggle,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true'] {
        background: linear-gradient(135deg, rgba(200,25,36,.24), rgba(201,162,74,.12)) !important;
        border-color: rgba(201,162,74,.42) !important;
        color: #fff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 14px 28px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.12) !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover::before,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle::before,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true']::before {
        background: linear-gradient(90deg, var(--haro-menu-red), var(--haro-menu-gold)) !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover::after,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle::after,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true']::after {
        opacity: 1 !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover span,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle span,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true'] span {
        color: #ffffff !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle:hover svg,
    #sidebar ul.menu-categories li.menu.active > .dropdown-toggle svg,
    #sidebar ul.menu-categories li.menu > .dropdown-toggle[aria-expanded='true'] svg {
        stroke: #ffffff !important;
    }

    .sidebar-wrapper .feather-chevron-right {
        stroke: rgba(255,243,223,.72) !important;
        opacity: 1 !important;
    }

    #sidebar .dropdown-toggle[aria-expanded='true'] .feather-chevron-right {
        transform: rotate(90deg) !important;
        stroke: var(--haro-menu-gold) !important;
    }

    #sidebar .submenu.dropdown-menu {
        position: absolute !important;
        top: calc(100% + 12px) !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        min-width: 235px !important;
        width: max-content !important;
        margin: 0 !important;
        padding: 13px !important;
        background: #10131b !important;
        border: 1px solid rgba(201,162,74,.30) !important;
        border-radius: 18px !important;
        box-shadow: 0 24px 50px rgba(0,0,0,.35) !important;
        z-index: 9999 !important;
    }

    #sidebar .submenu.dropdown-menu::before {
        content: "" !important;
        position: absolute !important;
        top: -6px !important;
        left: 50% !important;
        width: 12px !important;
        height: 12px !important;
        background: #10131b !important;
        border-left: 1px solid rgba(201,162,74,.30) !important;
        border-top: 1px solid rgba(201,162,74,.30) !important;
        transform: translateX(-50%) rotate(45deg) !important;
    }

    #sidebar .submenu li a {
        display: block !important;
        color: var(--haro-menu-muted) !important;
        background: transparent !important;
        padding: 11px 14px 11px 24px !important;
        border-radius: 12px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        position: relative !important;
    }

    #sidebar .submenu li a::before {
        content: "" !important;
        position: absolute !important;
        left: 11px !important;
        top: 50% !important;
        width: 5px !important;
        height: 5px !important;
        border-radius: 50% !important;
        background: var(--haro-menu-gold) !important;
        transform: translateY(-50%) !important;
    }

    #sidebar .submenu li a:hover {
        color: #ffffff !important;
        background: rgba(200,25,36,.18) !important;
        transform: translateX(3px) !important;
    }
}

/* MOBILE DRAWER LEGIBLE */
@media (max-width: 991.98px) {
    .sidebar-wrapper.sidebar-theme {
        background: linear-gradient(180deg, #08090d 0%, #10131b 54%, #07080c 100%) !important;
        border-right: 1px solid rgba(201,162,74,.28) !important;
        box-shadow: 0 28px 70px rgba(0,0,0,.44) !important;
    }

    #sidebar ul.menu-categories li.menu > .dropdown-toggle,
    #sidebar ul.menu-categories li.menu > a.dropdown-toggle {
        background: linear-gradient(180deg, rgba(255,255,255,.090), rgba(255,255,255,.045)) !important;
        border: 1px solid rgba(201,162,74,.20) !important;
        border-radius: 18px !important;
        color: var(--haro-menu-cream) !important;
    }

    #sidebar ul.menu-categories li.menu span {
        color: var(--haro-menu-cream) !important;
        opacity: 1 !important;
        font-weight: 800 !important;
    }

    #sidebar ul.menu-categories li.menu svg {
        stroke: var(--haro-menu-gold) !important;
        opacity: 1 !important;
    }
}
</style>


<style id="haro-menu-sticky-final">
/* ==========================================================
   HARO MENU STICKY
   Mantiene el menú pegado como el navbar en escritorio.
   En móvil conserva el comportamiento drawer.
========================================================== */

@media (min-width: 992px) {
    .sidebar-wrapper.sidebar-theme {
        position: sticky !important;
        top: 118px !important;
        z-index: 1020 !important;
        margin-top: 18px !important;
        margin-bottom: 28px !important;
    }

    .sidebar-wrapper.sidebar-theme .submenu.dropdown-menu {
        z-index: 1050 !important;
    }
}

@media (max-width: 991.98px) {
    .sidebar-wrapper.sidebar-theme {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 1100 !important;
    }
}
</style>
