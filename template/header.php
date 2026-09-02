<!-- Loader -->
<div id="page-preloader"><span class="spinner border-t_second_b border-t_prim_a"></span></div>

<style>
/* ── Glassmorphism Header ──────────────────────────────────────── */
.header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.07);
    transition: background 0.35s ease, box-shadow 0.35s ease;
}

.header.scrolled {
    background: rgba(255, 255, 255, 0.82);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
}

.header-main { padding: 4px 0; }

/* Logo — más grande sin aumentar el header */
.header .navbar-brand img {
    height: 110px;
    width: auto;
    object-fit: contain;
    transition: opacity 0.2s;
}

.header .navbar-brand:hover img { opacity: 0.85; }

/* Nav links */
.main-menu .nav-link {
    color: #1a2340 !important;
    font-size: 0.92rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    padding: 7px 13px !important;
    border-radius: 8px;
    margin: 0 2px;
    transition: background 0.2s, color 0.2s;
}

.main-menu .nav-link:hover,
.main-menu .nav-item.active .nav-link {
    background: rgba(26, 35, 64, 0.09);
    color: #0a1628 !important;
}

/* CarHunter icon nav item */
.nav-item--carhunter .nav-link {
    padding: 4px 8px !important;
}

.nav-item--carhunter img {
    height: 46px;
    width: 46px;
    object-fit: contain;
    display: block;
}

/* WhatsApp contact */
.header-contacts {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #1a2340;
}

.header-contacts__info { line-height: 1.3; }

.header-contacts__label {
    font-size: 0.72rem;
    opacity: 0.65;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.header-contacts__number {
    font-size: 0.88rem;
    font-weight: 400;
    color: #1a2340;
    white-space: nowrap;
}

/* Mobile hamburger */
.menu-mobile-button {
    background: rgba(26, 35, 64, 0.07);
    border: 1px solid rgba(26, 35, 64, 0.15);
    border-radius: 8px;
    padding: 8px 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.menu-mobile-button:hover { background: rgba(26, 35, 64, 0.13); }

/* Layout de 3 zonas */
.header-layout {
    display: flex;
    align-items: center;
    width: 100%;
}

.header-left {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 16px;
    justify-content: flex-start;
}

.header-center {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 20px;
}

.header-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* Badge */
.header-badge-link {
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    background: transparent;
    border-radius: 50%;
    padding: 6px;
}

.header-badge-svg {
    transition: transform 0.35s cubic-bezier(.4,0,.2,1), filter 0.3s ease;
    filter: drop-shadow(0 2px 6px rgba(232, 80, 43, 0.25));
}

.header-badge-link:hover .header-badge-svg {
    transform: rotate(8deg) scale(1.08);
    filter: drop-shadow(0 4px 12px rgba(232, 80, 43, 0.45));
}

/* Mobile slidebar nav */
[data-off-canvas] .navbar-brand img {
    height: 48px;
    object-fit: contain;
}

[data-off-canvas] .navbar-nav .nav-link {
    padding: 10px 16px;
    border-radius: 8px;
    transition: background 0.2s;
}

[data-off-canvas] .navbar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
}
</style>

<script>
/* Add .scrolled class after 60px of scroll */
(function () {
    var header = document.querySelector('.header');
    if (!header) return;
    var onScroll = function () {
        header.classList.toggle('scrolled', window.scrollY > 60);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}());

/* Smooth scroll al footer desde el badge */
document.addEventListener('DOMContentLoaded', function () {
    var badges = document.querySelectorAll('.header-badge-link');
    badges.forEach(function (badge) {
        badge.addEventListener('click', function (e) {
            e.preventDefault();
            var target = document.getElementById('fondo') || document.querySelector('footer') || document.body.lastElementChild;
            if (!target) return;
            var top = target.getBoundingClientRect().top + window.pageYOffset;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    });
});
</script>

<div class="l-theme animated-css animsition" data-header="sticky" data-header-top="200">

    <!-- Mobile Slidebar -->
    <div data-off-canvas="mobile-slidebar left overlay">
        <a class="navbar-brand" href="index.php">
            <img class="scroll-logo" src="assets/media/general/footer.png" alt="Logo">
        </a>
        <ul class="navbar-nav mt-3">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="inventory-list.php">Inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">Nosotros</a></li>
            <li class="nav-item"><a class="nav-link" href="contacts.php">Contacto</a></li>
            <li class="nav-item">
                <a class="nav-link" href="car-hunter.php">
                    <img src="Imagenes/carHunter/carhunter-logo1.png" alt="Car Hunter" width="44" height="44" style="object-fit:contain;">
                </a>
            </li>
        </ul>
    </div>

    <div data-canvas="container">

        <header class="header">
            <div class="header-main">
                <div class="container">
                    <div class="header-layout">

                        <!-- IZQUIERDA: Logo + Teléfono -->
                        <div class="header-left">
                            <a class="navbar-brand" href="index.php">
                                <img class="normal-logo" src="assets/media/general/logo.png" alt="Logo" width="250" height="150">
                            </a>
                            <div class="header-contacts d-none d-xl-flex">
                                <a href="https://api.whatsapp.com/send?phone=523338082913" aria-label="WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" viewBox="0 0 512 512" aria-hidden="true">
                                        <path style="fill:#EDEDED;" d="M0,512l35.31-128C12.359,344.276,0,300.138,0,254.234C0,114.759,114.759,0,255.117,0S512,114.759,512,254.234S395.476,512,255.117,512c-44.138,0-86.51-14.124-124.469-35.31L0,512z"/>
                                        <path style="fill:#55CD6C;" d="M137.71,430.786l7.945,4.414c32.662,20.303,70.621,32.662,110.345,32.662c115.641,0,211.862-96.221,211.862-213.628S371.641,44.138,255.117,44.138S44.138,137.71,44.138,254.234c0,40.607,11.476,80.331,32.662,113.876l5.297,7.945l-20.303,74.152L137.71,430.786z"/>
                                        <path style="fill:#FEFEFE;" d="M187.145,135.945l-16.772-0.883c-5.297,0-10.593,1.766-14.124,5.297c-7.945,7.062-21.186,20.303-24.717,37.959c-6.179,26.483,3.531,58.262,26.483,90.041s67.09,82.979,144.772,105.048c24.717,7.062,44.138,2.648,60.028-7.062c12.359-7.945,20.303-20.303,22.952-33.545l2.648-12.359c0.883-3.531-0.883-7.945-4.414-9.71l-55.614-25.6c-3.531-1.766-7.945-0.883-10.593,2.648l-22.069,28.248c-1.766,1.766-4.414,2.648-7.062,1.766c-15.007-5.297-65.324-26.483-92.69-79.448c-0.883-2.648-0.883-5.297,0.883-7.062l21.186-23.834c1.766-2.648,2.648-6.179,1.766-8.828l-25.6-57.379C193.324,138.593,190.676,135.945,187.145,135.945"/>
                                    </svg>
                                </a>
                                <div class="header-contacts__info">
                                    <span class="header-contacts__label">¡Llámenos hoy!</span>
                                    <span class="header-contacts__number">33 3636 8433 &nbsp;·&nbsp; 33 1955 2634</span>
                                </div>
                            </div>
                            <!-- Hamburger (solo mobile) -->
                            <button class="menu-mobile-button js-toggle-mobile-slidebar toggle-menu-button d-lg-none" aria-label="Abrir menú">
                                <i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i>
                            </button>
                        </div>

                        <!-- CENTRO: Badge -->
                        <div class="header-center d-none d-lg-flex">
                            <a href="#footer" class="header-badge-link" aria-label="Suscríbete al boletín">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" width="120" height="120" class="header-badge-svg">
                                    <defs>
                                        <path id="arcoTexto" d="M 57 222 A 145.1 145.1 0 1 1 343 222" fill="none"/>
                                        <path id="arcoGratis" d="M 120 318 Q 200 336 280 318" fill="none"/>
                                    </defs>
                                    <text fill="#E8502B" font-family="Arial,Helvetica,sans-serif" font-size="21.5" font-weight="700" letter-spacing="3.5">
                                        <textPath href="#arcoTexto" startOffset="50%" text-anchor="middle">SUSCRÍBETE A NUESTRO BOLETÍN</textPath>
                                    </text>
                                    <circle cx="200" cy="190" r="64" fill="#23283A" stroke="#E8502B" stroke-width="4"/>
                                    <g stroke="#E8502B" stroke-width="4.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="171" y="171" width="58" height="40" rx="5"/>
                                        <polyline points="175,177 200,196 225,177"/>
                                    </g>
                                    <text fill="#E8502B" font-family="Arial,Helvetica,sans-serif" font-size="25" font-weight="800" letter-spacing="6">
                                        <textPath href="#arcoGratis" startOffset="50%" text-anchor="middle">GRATIS</textPath>
                                    </text>
                                    <path d="M 0 -9 L 2.2 -2.2 L 9 0 L 2.2 2.2 L 0 9 L -2.2 2.2 L -9 0 L -2.2 -2.2 Z" transform="translate(103 308)" fill="#E8502B"/>
                                    <path d="M 0 -9 L 2.2 -2.2 L 9 0 L 2.2 2.2 L 0 9 L -2.2 2.2 L -9 0 L -2.2 -2.2 Z" transform="translate(297 308)" fill="#E8502B"/>
                                </svg>
                            </a>
                        </div>

                        <!-- DERECHA: Suscríbete móvil + Navegación desktop -->
                        <div class="header-right d-flex">
                            <!-- Badge móvil (solo < lg) -->
                            <a href="#footer" class="header-badge-link d-flex d-lg-none" aria-label="Suscríbete al boletín" style="margin-right:100px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" width="68" height="68" class="header-badge-svg">
                                    <defs>
                                        <path id="arcoTextoM" d="M 57 222 A 145.1 145.1 0 1 1 343 222" fill="none"/>
                                        <path id="arcoGratisM" d="M 120 318 Q 200 336 280 318" fill="none"/>
                                    </defs>
                                    <text fill="#E8502B" font-family="Arial,Helvetica,sans-serif" font-size="21.5" font-weight="700" letter-spacing="3.5">
                                        <textPath href="#arcoTextoM" startOffset="50%" text-anchor="middle">SUSCRÍBETE A NUESTRO BOLETÍN</textPath>
                                    </text>
                                    <circle cx="200" cy="190" r="64" fill="#23283A" stroke="#E8502B" stroke-width="4"/>
                                    <g stroke="#E8502B" stroke-width="4.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="171" y="171" width="58" height="40" rx="5"/>
                                        <polyline points="175,177 200,196 225,177"/>
                                    </g>
                                    <text fill="#E8502B" font-family="Arial,Helvetica,sans-serif" font-size="25" font-weight="800" letter-spacing="6">
                                        <textPath href="#arcoGratisM" startOffset="50%" text-anchor="middle">GRATIS</textPath>
                                    </text>
                                    <path d="M 0 -9 L 2.2 -2.2 L 9 0 L 2.2 2.2 L 0 9 L -2.2 2.2 L -9 0 L -2.2 -2.2 Z" transform="translate(103 308)" fill="#E8502B"/>
                                    <path d="M 0 -9 L 2.2 -2.2 L 9 0 L 2.2 2.2 L 0 9 L -2.2 2.2 L -9 0 L -2.2 -2.2 Z" transform="translate(297 308)" fill="#E8502B"/>
                                </svg>
                            </a>
                            <!-- Nav desktop (solo >= lg) -->
                        <div class="d-none d-lg-flex">
                            <nav aria-label="Navegación principal">
                                <ul class="yamm main-menu navbar-nav align-items-center flex-row mb-0">
                                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                                    <li class="nav-item"><a class="nav-link" href="inventory-list.php">Inventario</a></li>
                                    <li class="nav-item"><a class="nav-link" href="about.php">Nosotros</a></li>
                                    <li class="nav-item"><a class="nav-link" href="contacts.php">Contacto</a></li>
                                    <li class="nav-item nav-item--carhunter">
                                        <a class="nav-link" href="car-hunter.php" aria-label="Car Hunter">
                                            <img src="Imagenes/carHunter/carhunter-logo1.png" alt="Car Hunter" width="46" height="46">
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        </div><!-- /header-right -->

                    </div>
                </div>
            </div>
        </header>

    </div>
</div>
