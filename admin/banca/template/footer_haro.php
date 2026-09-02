<?php
    $anioActual = date('Y');
?>

<style>
    /* ==========================================
       FOOTER HARO SEMINUEVOS
       Archivo independiente para incluir en vistas
    ========================================== */

    .haro-footer {
        width: calc(100% - 72px);
        max-width: 1720px;
        margin: 34px auto 0;
        padding: 0 0 28px;
        font-family: 'Montserrat', 'DM Sans', Arial, sans-serif;
    }

    .haro-footer__inner {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        padding: 22px 28px;
        overflow: hidden;
        color: rgba(255, 246, 232, .72);
        background:
            radial-gradient(circle at 12% 0%, rgba(201, 162, 74, .16), transparent 32%),
            radial-gradient(circle at 92% 100%, rgba(176, 20, 27, .13), transparent 34%),
            linear-gradient(135deg, #090a0f 0%, #10131b 58%, #07080c 100%);
        border: 1px solid rgba(201, 162, 74, .18);
        border-radius: 24px;
        box-shadow: 0 18px 46px rgba(0, 0, 0, .16);
    }

    .haro-footer__inner::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, #b0141b, #c9a24a, #b0141b);
    }

    .haro-footer__copy,
    .haro-footer__powered {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .2px;
        line-height: 1.4;
    }

    .haro-footer__brand {
        color: #fff3df;
        font-weight: 800;
    }

    .haro-footer__dot {
        width: 5px;
        height: 5px;
        border-radius: 999px;
        background: #c9a24a;
        box-shadow: 0 0 0 4px rgba(201, 162, 74, .12);
    }

    .haro-footer__powered a {
        color: #fff3df !important;
        font-weight: 800;
        text-decoration: none;
        transition: color .22s ease, transform .22s ease;
    }

    .haro-footer__powered a:hover {
        color: #c9a24a !important;
        transform: translateY(-1px);
    }

    .haro-footer__logo {
        width: 22px;
        height: 22px;
        object-fit: contain;
        opacity: .82;
        filter: drop-shadow(0 8px 14px rgba(0, 0, 0, .22));
    }

    @media (max-width: 991.98px) {
        .haro-footer {
            width: calc(100% - 28px);
            margin-top: 26px;
            padding-bottom: 22px;
        }

        .haro-footer__inner {
            padding: 20px;
            border-radius: 22px;
        }
    }

    @media (max-width: 575.98px) {
        .haro-footer {
            width: calc(100% - 20px);
            margin-top: 22px;
            padding-bottom: 18px;
        }

        .haro-footer__inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 18px;
            border-radius: 20px;
        }

        .haro-footer__copy,
        .haro-footer__powered {
            font-size: 11.5px;
        }
    }
</style>

<footer class="haro-footer">
    <div class="haro-footer__inner">
        <p class="haro-footer__copy">
            <span class="haro-footer__dot"></span>
            © <?php echo $anioActual; ?> <span class="haro-footer__brand">Haro Seminuevos</span> — Todos los derechos reservados.
        </p>

        <p class="haro-footer__powered">
            <span>Powered by</span>
            <img src="../src/assets/img/logo.svg" alt="Código y Chips" class="haro-footer__logo">
            <a href="https://codigoychips.com" target="_blank" rel="noopener noreferrer">codigoychips.com</a>
        </p>
    </div>
</footer>
