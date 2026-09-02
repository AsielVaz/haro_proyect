
<!--  BEGIN NAVBAR  -->
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<style>
    /* DiseÃąo HARO Seminuevos - solo estilos visuales del navbar */
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;500;600;700;800&display=swap');

    :root {
        --haro-navy: #10152d;
        --haro-dark: #070b12;
        --haro-panel: #0e131f;
        --haro-red: #e1262f;
        --haro-gold: #c59a2e;
        --haro-white: #ffffff;
        --haro-muted: #7e869b;
        --haro-line: rgba(16, 21, 45, .10);
        --haro-shadow: 0 12px 34px rgba(7, 11, 18, .12);
    }

    .header-container.container-xxl {
        max-width: 100% !important;
        padding: 0 24px !important;
        background: var(--haro-white) !important;
        border-bottom: 1px solid var(--haro-line);
        box-shadow: var(--haro-shadow);
        position: sticky;
        top: 0;
        z-index: 1025;
        font-family: 'Montserrat', Arial, sans-serif;
    }

    .header.navbar.expand-header {
        min-height: 92px;
        padding: 0 !important;
        background: transparent !important;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .header .sidebarCollapse {
        display: none;
    }

    @media (max-width: 991.98px) {
        .header .sidebarCollapse {
            width: 46px;
            height: 46px;
            min-width: 46px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            color: var(--haro-navy) !important;
            background: #fff;
            border: 1px solid rgba(225, 38, 47, .20);
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(16, 21, 45, .08);
            transition: all .22s ease;
        }
    }

    .header .sidebarCollapse:hover {
        color: var(--haro-red) !important;
        border-color: rgba(225, 38, 47, .50);
        transform: translateY(-1px);
    }

    .header .sidebarCollapse svg,
    .header .nav-link svg,
    .header .dropdown-item svg {
        width: 21px;
        height: 21px;
        stroke-width: 2.2;
    }

    .header .theme-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 !important;
        padding: 0 !important;
        min-width: 0;
    }

    .header .theme-logo a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .header .theme-logo img {
        width: 132px !important;
        max-width: 132px;
        height: 66px;
        object-fit: contain !important;
        display: block;
    }

    .header .theme-text .nav-link {
        color: var(--haro-navy) !important;
        font-family: 'Bebas Neue', 'Oswald', Arial, sans-serif;
        font-size: 30px;
        line-height: 1;
        letter-spacing: 2.4px;
        text-transform: uppercase;
        padding: 0 !important;
        margin: 0;
        text-decoration: none;
    }

    .header .theme-text .nav-link::after {
        content: 'SEMINUEVOS';
        display: block;
        margin-top: 3px;
        color: var(--haro-red);
        font-family: 'Montserrat', Arial, sans-serif;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 5px;
        line-height: 1;
    }

    .header .action-area {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-left: auto !important;
    }

    .header .theme-toggle-item .theme-toggle,
    .header .user-profile-dropdown > .nav-link {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 !important;
        background: #fff;
        border: 1px solid rgba(16, 21, 45, .10);
        border-radius: 50%;
        color: var(--haro-navy) !important;
        box-shadow: 0 10px 24px rgba(16, 21, 45, .08);
        transition: all .22s ease;
    }

    .header .theme-toggle-item .theme-toggle:hover,
    .header .user-profile-dropdown > .nav-link:hover {
        color: var(--haro-red) !important;
        border-color: rgba(225, 38, 47, .45);
        transform: translateY(-1px);
    }

    .header .theme-toggle .light-mode,
    .header .theme-toggle .dark-mode {
        color: currentColor !important;
    }

    .header .avatar-container,
    .header .avatar,
    .header .avatar img {
        width: 42px;
        height: 42px;
    }

    .header .avatar img {
        object-fit: cover;
        border: 2px solid var(--haro-red);
        box-shadow: 0 0 0 4px rgba(225, 38, 47, .10);
    }

    .header .dropdown-menu {
        min-width: 250px;
        padding: 12px;
        margin-top: 14px !important;
        border: 1px solid rgba(225, 38, 47, .16);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 22px 55px rgba(7, 11, 18, .18);
        overflow: hidden;
        font-family: 'Montserrat', Arial, sans-serif;
    }

    .header .dropdown-menu::before {
        content: '';
        display: block;
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
    }

    .header .user-profile-section {
        padding: 16px 14px 14px;
        margin-bottom: 8px;
        background: linear-gradient(135deg, rgba(16, 21, 45, .06), rgba(225, 38, 47, .05));
        border: 1px solid rgba(16, 21, 45, .06);
        border-radius: 16px;
    }

    .header .user-profile-section .media {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header .user-profile-section .emoji {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--haro-navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .header .user-profile-section h5 {
        margin: 0 0 3px;
        color: var(--haro-navy);
        font-family: 'Bebas Neue', 'Oswald', Arial, sans-serif;
        font-size: 24px;
        letter-spacing: 1.5px;
        line-height: 1;
    }

    .header .user-profile-section p {
        margin: 0;
        color: var(--haro-red);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .header .dropdown-item {
        padding: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .header .dropdown-item a {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 12px 14px;
        color: var(--haro-navy) !important;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .8px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all .22s ease;
    }

    .header .dropdown-item:hover,
    .header .dropdown-item:focus {
        background: transparent !important;
    }

    .header .dropdown-item a:hover {
        color: #fff !important;
        background: linear-gradient(135deg, var(--haro-red), #9f1018);
    }



    /* FIX: mantiene el navbar estable en modo oscuro y cuando se abre/cierra el sidebar */
    body.dark .header-container.container-xxl,
    .dark .header-container.container-xxl,
    [data-theme='dark'] .header-container.container-xxl,
    [data-bs-theme='dark'] .header-container.container-xxl {
        background: #ffffff !important;
        border-bottom-color: rgba(16, 21, 45, .10) !important;
    }

    body.dark .header.navbar.expand-header,
    .dark .header.navbar.expand-header,
    [data-theme='dark'] .header.navbar.expand-header,
    [data-bs-theme='dark'] .header.navbar.expand-header {
        background: transparent !important;
    }

    body.dark .header .sidebarCollapse,
    body.dark .header .theme-toggle-item .theme-toggle,
    body.dark .header .user-profile-dropdown > .nav-link,
    .dark .header .sidebarCollapse,
    .dark .header .theme-toggle-item .theme-toggle,
    .dark .header .user-profile-dropdown > .nav-link,
    [data-theme='dark'] .header .sidebarCollapse,
    [data-theme='dark'] .header .theme-toggle-item .theme-toggle,
    [data-theme='dark'] .header .user-profile-dropdown > .nav-link,
    [data-bs-theme='dark'] .header .sidebarCollapse,
    [data-bs-theme='dark'] .header .theme-toggle-item .theme-toggle,
    [data-bs-theme='dark'] .header .user-profile-dropdown > .nav-link {
        background: #ffffff !important;
        color: var(--haro-navy) !important;
        border-color: rgba(16, 21, 45, .10) !important;
    }

    .header-container.container-xxl {
        isolation: isolate;
    }

    @media (max-width: 991.98px) {
        .header-container.container-xxl {
            padding: 0 16px !important;
        }

        .header.navbar.expand-header {
            min-height: 82px;
            gap: 12px;
        }

        .header .theme-logo img {
            width: 112px !important;
            max-width: 112px;
            height: 56px;
        }

        .header .theme-text .nav-link {
            font-size: 25px;
            letter-spacing: 2px;
        }
    }

    @media (max-width: 575.98px) {
        .header-container.container-xxl {
            padding: 0 12px !important;
        }

        .header.navbar.expand-header {
            min-height: 74px;
        }

        .header .sidebarCollapse,
        .header .theme-toggle-item .theme-toggle,
        .header .user-profile-dropdown > .nav-link {
            width: 42px;
            height: 42px;
            min-width: 42px;
        }

        .header .theme-logo img {
            width: 92px !important;
            max-width: 92px;
            height: 48px;
        }

        .header .theme-text {
            display: none;
        }

        .header .action-area {
            gap: 8px;
        }

        .header .avatar-container,
        .header .avatar,
        .header .avatar img {
            width: 38px;
            height: 38px;
        }

        .header .dropdown-menu {
            min-width: 220px;
            right: 0 !important;
            left: auto !important;
        }
    }
</style>

<div class="header-container container-xxl">
    <header class="header navbar navbar-expand-sm expand-header">
        
        <a href="javascript:void(0);"
           class="sidebarCollapse mobile-menu-trigger"
           data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </a>

        <ul class="navbar-item theme-brand flex-row text-center">
            <li class="nav-item theme-logo">
                <a href="index.php">
                    <img src="media/logoNuevo.png" style="object-fit: contain; width: fit-content;" class="" alt="logo">
                </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">
            <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar-container">
                        <div class="avatar avatar-sm avatar-indicators avatar-online">
                            <img alt="avatar" 
                                 src="<?php echo (!empty($_SESSION['sesionUsuario']['imagen']) && file_exists((string) $_SESSION['sesionUsuario']['imagen'])) 
                                                 ? $_SESSION['sesionUsuario']['imagen']
                                                 : '../src/assets/img/default-avatar.png'; ?>" 
                                 onerror="this.onerror=null; this.src='../src/assets/img/default-avatar.png';" 
                                 class="rounded-circle">
                        </div>
                    </div>
                </a>

                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="emoji me-2">
                                &#x1F44B;
                            </div>
                            <div class="media-body">
                                <h5>USUARIO</h5>
                                <p><?php echo $_SESSION['sesionUsuario']['permiso_banca'] ?? '' ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-item">
                        <a href="../login.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                        </a>
                    </div>
                </div>
                
            </li>
        </ul>
    </header>
</div>

<!-- <script>
        let permiso = <?php echo (int) ($_SESSION['sesionUsuario']['permisos'] ?? 0); ?>;
        if (permiso < 100) {
            window.location.href = "../login.php";
        }
        </script> -->
<!--  END NAVBAR  -->

<style id="haro-navbar-premium">
/* ==========================================================
   HARO NAVBAR PREMIUM
   Solo diseÃąo. Conserva botÃģn mÃģvil, avatar, dropdown y PHP.
========================================================== */

:root {
    --hn-black: #0b0c10;
    --hn-ink: #111111;
    --hn-red: #b0141b;
    --hn-red-bright: #e1262f;
    --hn-gold: #c9a24a;
    --hn-cream: #fff6e8;
    --hn-paper: rgba(255,255,255,.86);
    --hn-line: rgba(201,162,74,.22);
    --hn-muted: #726b60;
    --hn-shadow: 0 18px 48px rgba(16, 15, 12, .13);
}

.header-container.container-xxl {
    max-width: calc(100% - 48px) !important;
    margin: 16px auto 0 !important;
    padding: 0 22px !important;
    position: sticky !important;
    top: 14px !important;
    z-index: 1045 !important;
    background:
        linear-gradient(135deg, rgba(255,255,255,.92), rgba(250,244,233,.82)) !important;
    border: 1px solid var(--hn-line) !important;
    border-radius: 26px !important;
    box-shadow: var(--hn-shadow) !important;
    backdrop-filter: blur(18px);
    overflow: visible !important;
}

.header-container.container-xxl::before {
    /* content: "" !important; */
    position: absolute !important;
    inset: 0 0 auto 0 !important;
    height: 4px !important;
    border-radius: 26px 26px 0 0 !important;
    background: linear-gradient(90deg, var(--hn-red), var(--hn-gold), var(--hn-red)) !important;
}

.header-container.container-xxl::after {
    content: "" !important;
    position: absolute !important;
    right: 84px !important;
    top: -42px !important;
    width: 145px !important;
    height: 145px !important;
    border-radius: 50% !important;
    background: radial-gradient(circle, rgba(201,162,74,.18), transparent 68%) !important;
    pointer-events: none !important;
}

.header.navbar.expand-header {
    min-height: 84px !important;
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 18px !important;
    position: relative !important;
    z-index: 2 !important;
}

.header .theme-brand {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    margin: 0 !important;
    padding: 0 !important;
}

.header .theme-logo a {
    width: 162px !important;
    min-height: 62px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    text-decoration: none !important;
}

.header .theme-logo img {
    width: 150px !important;
    max-width: 150px !important;
    height: 58px !important;
    object-fit: contain !important;
    filter: drop-shadow(0 10px 18px rgba(16, 15, 12, .12));
    transition: transform .22s ease, filter .22s ease;
}

.header .theme-logo a:hover img {
    transform: translateY(-1px) scale(1.02);
    filter: drop-shadow(0 14px 24px rgba(16, 15, 12, .16));
}

.header .mobile-menu-trigger {
    display: none !important;
}

@media (max-width: 991.98px) {
    .header .mobile-menu-trigger {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: var(--hn-ink) !important;
        background:
            linear-gradient(135deg, #ffffff, #f7efe2) !important;
        border: 1px solid rgba(176,20,27,.20) !important;
        border-radius: 15px !important;
        box-shadow: 0 12px 26px rgba(16,15,12,.12) !important;
        transition: transform .22s ease, border-color .22s ease, color .22s ease, box-shadow .22s ease !important;
    }

    .header .mobile-menu-trigger:hover,
    .header .mobile-menu-trigger:focus {
        color: var(--hn-red) !important;
        border-color: rgba(176,20,27,.42) !important;
        transform: translateY(-2px);
        box-shadow: 0 16px 32px rgba(176,20,27,.14) !important;
    }
}

.header .sidebarCollapse svg,
.header .nav-link svg,
.header .dropdown-item svg {
    width: 21px !important;
    height: 21px !important;
    stroke-width: 2.25 !important;
}

.header .action-area {
    margin-left: auto !important;
    display: flex !important;
    align-items: center !important;
    gap: 14px !important;
}

.header .user-profile-dropdown > .nav-link {
    width: 52px !important;
    height: 52px !important;
    min-width: 52px !important;
    padding: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    background:
        linear-gradient(135deg, #ffffff, #f8efe3) !important;
    border: 1px solid rgba(201,162,74,.30) !important;
    border-radius: 18px !important;
    color: var(--hn-ink) !important;
    box-shadow: 0 12px 28px rgba(16,15,12,.11) !important;
    transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease !important;
}

.header .user-profile-dropdown > .nav-link:hover,
.header .user-profile-dropdown > .nav-link[aria-expanded="true"] {
    transform: translateY(-2px);
    border-color: rgba(176,20,27,.34) !important;
    box-shadow: 0 18px 38px rgba(176,20,27,.13) !important;
}

.header .avatar-container,
.header .avatar,
.header .avatar img {
    width: 42px !important;
    height: 42px !important;
}

.header .avatar img {
    object-fit: cover !important;
    border: 2px solid var(--hn-gold) !important;
    box-shadow:
        0 0 0 4px rgba(201,162,74,.12),
        0 8px 18px rgba(16,15,12,.14) !important;
}

.header .avatar-indicators.avatar-online::before,
.header .avatar-indicators.avatar-online::after {
    border-color: #fff6e8 !important;
}

.header .dropdown-menu {
    min-width: 270px !important;
    padding: 14px !important;
    margin-top: 16px !important;
    right: 0 !important;
    left: auto !important;
    background:
        linear-gradient(145deg, rgba(255,255,255,.98), rgba(250,244,233,.96)) !important;
    border: 1px solid rgba(201,162,74,.26) !important;
    border-radius: 24px !important;
    box-shadow: 0 28px 70px rgba(16,15,12,.20) !important;
    overflow: hidden !important;
    backdrop-filter: blur(16px);
}

.header .dropdown-menu::before {
    content: "" !important;
    display: block !important;
    position: absolute !important;
    inset: 0 0 auto 0 !important;
    height: 4px !important;
    background: linear-gradient(90deg, var(--hn-red), var(--hn-gold)) !important;
}

.header .user-profile-section {
    padding: 17px 15px 15px !important;
    margin-bottom: 10px !important;
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.20), transparent 48%),
        linear-gradient(135deg, rgba(17,17,17,.045), rgba(176,20,27,.055)) !important;
    border: 1px solid rgba(201,162,74,.18) !important;
    border-radius: 18px !important;
}

.header .user-profile-section .media {
    display: flex !important;
    align-items: center !important;
    gap: 11px !important;
}

.header .user-profile-section .emoji {
    width: 40px !important;
    height: 40px !important;
    border-radius: 14px !important;
    background: #111111 !important;
    box-shadow: 0 12px 24px rgba(17,17,17,.16);
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 20px !important;
}

.header .user-profile-section h5 {
    margin: 0 0 4px !important;
    color: #111111 !important;
    font-family: 'Bebas Neue', Arial, sans-serif !important;
    font-size: 26px !important;
    font-weight: 400 !important;
    letter-spacing: 1.8px !important;
    line-height: .95 !important;
}

.header .user-profile-section p {
    margin: 0 !important;
    color: var(--hn-red) !important;
    font-size: 11px !important;
    font-weight: 800 !important;
    letter-spacing: 1.4px !important;
    text-transform: uppercase !important;
}

.header .dropdown-item {
    padding: 0 !important;
    border-radius: 16px !important;
    overflow: hidden !important;
}

.header .dropdown-item a {
    width: 100% !important;
    padding: 13px 14px !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    color: #111111 !important;
    background: rgba(255,255,255,.52) !important;
    border: 1px solid rgba(17,17,17,.055) !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    font-weight: 800 !important;
    letter-spacing: .9px !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    transition: transform .22s ease, background .22s ease, color .22s ease, border-color .22s ease !important;
}

.header .dropdown-item a:hover {
    color: #ffffff !important;
    background: linear-gradient(135deg, var(--hn-red), #8f1218) !important;
    border-color: rgba(176,20,27,.30) !important;
    transform: translateY(-1px);
}

.header .dropdown-item a:hover svg {
    stroke: #ffffff !important;
}

/* Modo oscuro: mantener navbar premium claro y legible */
body.dark .header-container.container-xxl,
.dark .header-container.container-xxl,
[data-theme='dark'] .header-container.container-xxl,
[data-bs-theme='dark'] .header-container.container-xxl {
    background:
        linear-gradient(135deg, rgba(255,255,255,.92), rgba(250,244,233,.82)) !important;
    border-color: var(--hn-line) !important;
}

@media (max-width: 991.98px) {
    .header-container.container-xxl {
        max-width: calc(100% - 28px) !important;
        margin-top: 12px !important;
        padding: 0 16px !important;
        border-radius: 22px !important;
    }

    .header-container.container-xxl::before {
        border-radius: 22px 22px 0 0 !important;
    }

    .header.navbar.expand-header {
        min-height: 78px !important;
        gap: 12px !important;
    }

    .header .theme-logo a {
        width: 128px !important;
        min-height: 54px !important;
    }

    .header .theme-logo img {
        width: 120px !important;
        max-width: 120px !important;
        height: 50px !important;
    }

    .header .user-profile-dropdown > .nav-link {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        border-radius: 16px !important;
    }

    .header .avatar-container,
    .header .avatar,
    .header .avatar img {
        width: 39px !important;
        height: 39px !important;
    }
}

@media (max-width: 575.98px) {
    .header-container.container-xxl {
        max-width: calc(100% - 20px) !important;
        padding: 0 12px !important;
        border-radius: 20px !important;
    }

    .header.navbar.expand-header {
        min-height: 72px !important;
    }

    .header .mobile-menu-trigger {
        width: 42px !important;
        height: 42px !important;
        min-width: 42px !important;
        border-radius: 14px !important;
    }

    .header .theme-logo a {
        width: 104px !important;
        min-height: 48px !important;
    }

    .header .theme-logo img {
        width: 100px !important;
        max-width: 100px !important;
        height: 44px !important;
    }

    .header .action-area {
        gap: 8px !important;
    }

    .header .dropdown-menu {
        min-width: 230px !important;
    }
}
</style>
