<style>
/* ── Footer moderno ────────────────────────────────────────────── */
.footer {
    background: #0d1424;
    color: rgba(255, 255, 255, 0.7);
    padding-top: 0;
    font-size: 0.9rem;
}

/* Banda superior con logo centrado */
.footer__hero {
    background: linear-gradient(135deg, #111827 0%, #1a2340 100%);
    text-align: center;
    padding: 48px 0 36px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.footer__logo img {
    height: 130px;
    width: auto;
    object-fit: contain;
    filter: brightness(1.05);
    transition: transform 0.3s ease, filter 0.3s ease;
}

.footer__logo img:hover {
    transform: scale(1.04);
    filter: brightness(1.15);
}

.footer__tagline {
    color: rgba(255, 255, 255, 0.45);
    font-size: 0.78rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-top: 10px;
}

/* Divisor decorativo */
.footer__divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin: 0 0 8px;
}

.footer__divider-line {
    flex: 1;
    max-width: 120px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2));
}

.footer__divider-line:last-child {
    background: linear-gradient(90deg, rgba(255,255,255,0.2), transparent);
}

.footer__divider-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
}

/* Cuerpo del footer */
.footer__body {
    padding: 44px 0 32px;
}

/* Títulos de sección */
.footer-section__title {
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.footer-section__title::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 28px; height: 2px;
    background: #c0392b;
    border-radius: 2px;
}

/* Contactos */
.footer-contacts__item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 14px;
    color: rgba(255, 255, 255, 0.65);
    line-height: 1.5;
}

.footer-contacts__item i {
    color: #c0392b;
    font-size: 1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-contacts__item a {
    color: rgba(255, 255, 255, 0.65);
    text-decoration: none;
    transition: color 0.2s;
}

.footer-contacts__item a:hover { color: #fff; }

/* Lista de navegación */
.footer-list li {
    margin-bottom: 10px;
}

.footer-list a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.2s, padding-left 0.2s;
    display: inline-block;
}

.footer-list a:hover {
    color: #fff;
    padding-left: 4px;
}

/* Formulario suscripción */
.footer-form__input {
    background: rgba(255, 255, 255, 0.06) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 8px !important;
    color: #fff !important;
    padding: 10px 14px !important;
    width: 100%;
    transition: border-color 0.2s, background 0.2s;
}

.footer-form__input::placeholder { color: rgba(255,255,255,0.35); }

.footer-form__input:focus {
    background: rgba(255, 255, 255, 0.10) !important;
    border-color: rgba(255, 255, 255, 0.28) !important;
    outline: none;
    box-shadow: none !important;
}

/* ── Borde de luz giratorio ──────────────────────────────── */
.input-light-wrap {
    position: relative;
    padding: 2px;
    border-radius: 9px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.06);
}

.input-light-wrap::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 250%;
    height: 250%;
    transform: translate(-50%, -50%) rotate(0deg);
    background: conic-gradient(
        transparent    0deg,
        transparent  285deg,
        #ff8a4c      305deg,
        #ffffff      322deg,
        #ff5533      340deg,
        transparent  360deg
    );
    opacity: 0;
    pointer-events: none;
    z-index: 0;
}

.input-light-wrap.spinning::before {
    opacity: 1;
    animation: lightSpin 1s linear 1 forwards;
}

@keyframes lightSpin {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to   { transform: translate(-50%, -50%) rotate(360deg); }
}

/* El input tapa el centro, dejando solo el borde visible */
.input-light-wrap .footer-form__input {
    position: relative;
    z-index: 1;
    border: none !important;
    border-radius: 7px !important;
    background: #0d1424 !important;
    width: 100%;
    box-shadow: none !important;
}

.footer-form .btn-primary {
    background: #c0392b;
    border: none;
    border-radius: 8px;
    padding: 9px 22px;
    font-size: 0.82rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    transition: background 0.2s, transform 0.15s;
    margin-top: 10px;
    width: 100%;
}

.footer-form .btn-primary:hover {
    background: #a93226;
    transform: translateY(-1px);
}

/* Barra de copyright */
.footer__copyright {
    border-top: 1px solid rgba(255, 255, 255, 0.07);
    padding: 18px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 0.78rem;
    color: rgba(255, 255, 255, 0.35);
}

.footer__copyright a {
    color: rgba(255, 255, 255, 0.45);
    text-decoration: none;
    transition: color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.footer__copyright a:hover { color: rgba(255, 255, 255, 0.8); }

/* Botón ir arriba */
.footer__btn-up {
    position: fixed;
    bottom: 28px;
    right: 28px;
    width: 44px;
    height: 44px;
    background: #c0392b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(192, 57, 43, 0.4);
    transition: transform 0.2s, box-shadow 0.2s;
    z-index: 999;
}

.footer__btn-up:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(192, 57, 43, 0.5);
}

.footer__btn-up i {
    color: #fff;
    font-size: 1.1rem;
}

.footer__btn-up img { display: none; }
</style>

<footer class="footer">

    <!-- Hero: logo con protagonismo -->
    <div class="footer__hero">
        <div class="footer__logo">
            <img src="assets/media/general/logo_dark.png" alt="Haro Seminuevos">
        </div>
        <p class="footer__tagline">Seminuevos · Guadalajara</p>
        <div class="footer__divider">
            <span class="footer__divider-line"></span>
            <span class="footer__divider-dot"></span>
            <span class="footer__divider-line"></span>
        </div>
    </div>

    <!-- Cuerpo -->
    <div class="footer__body">
        <div class="container">
            <div class="row">

                <!-- Contacto -->
                <div class="col-lg-4 col-sm-12 mb-4 mb-lg-0">
                    <section class="footer-section">
                        <h3 class="footer-section__title">Contacto</h3>
                        <div class="footer-contacts">
                            <div class="footer-contacts__item">
                                <i class="ic icon-location-pin"></i>
                                <span>Av. Cvln. División del Nte. 1264, Jardines del Country, Guadalajara, Jal.</span>
                            </div>
                            <div class="footer-contacts__item">
                                <i class="ic icon-earphones-alt"></i>
                                <span>
                                    <a href="tel:3336368433">33 3636 8433</a> &nbsp;/&nbsp;
                                    <a href="tel:3319552634">33 1955 2634</a>
                                </span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Navegación -->
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                    <section class="footer-section">
                        <h3 class="footer-section__title">Acerca de Haro</h3>
                        <ul class="footer-list list-unstyled">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="inventory-list.php">Inventario</a></li>
                            <li><a href="about.php">Quiénes Somos</a></li>
                            <li><a href="contacts.php">Contacto</a></li>
                            <li><a href="car-hunter.php">Car Hunter</a></li>
                        </ul>
                    </section>
                </div>

                <!-- Suscripción -->
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                    <section class="footer-section">
                        <h3 class="footer-section__title">Boletín de autos</h3>
                        <p style="color:rgba(255,255,255,0.45); font-size:0.82rem; margin-bottom:16px;">
                            Recibe en tu correo las últimas incorporaciones al inventario.
                        </p>
                        <form class="footer-form" id="form-boletin">
                            <div class="input-light-wrap" id="input-light-wrap">
                                <input class="footer-form__input" type="email" name="subscripcion_correo" placeholder="tu@correo.com" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Suscribirse</button>
                        </form>
                    </section>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="container">
        <div class="footer__copyright">
            <span>
                &copy; <script>document.write(new Date().getFullYear())</script> Haro Seminuevos &mdash; Todos los derechos reservados.
            </span>
            <a href="https://codigoychips.com" target="_blank" rel="noopener">
                Powered by
                <img src="https://codigoychips.com/logo.png" alt="Código y Chips" width="22" height="22" style="vertical-align:middle; filter:invert(1); opacity:0.6;">
                codigoychips.com
            </a>
        </div>
    </div>

    <!-- Ir arriba -->
    <span class="footer__btn-up js-scroll-top" aria-label="Volver arriba">
        <i class="ic fas fa-angle-up"></i>
    </span>

    <div id="fondo"></div>

    <script>
    (function () {
        var wrap   = document.getElementById('input-light-wrap');
        var footer = document.querySelector('footer.footer');
        if (!wrap || !footer) return;

        wrap.addEventListener('animationend', function () {
            wrap.classList.remove('spinning');
        });

        new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                wrap.classList.remove('spinning');
                void wrap.offsetWidth;
                wrap.classList.add('spinning');
            }
        }, { threshold: 0.5 }).observe(footer);
    }());

        const formBoletin = document.getElementById('form-boletin');
        formBoletin.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(formBoletin);
            formData.append('accion', 'suscribirse');
            fetch('admin/api/apiCarHunter.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data == '1') {
                        alert('Gracias por suscribirse');
                        formBoletin.reset();
                    } else if (data == 3) {
                        alert('Esta dirección de correo ya se encuentra suscrita');
                    } else {
                        alert('Error al suscribirse');
                        formBoletin.reset();
                    }
                })
                .catch(err => console.error(err));
        });
    </script>

</footer>
