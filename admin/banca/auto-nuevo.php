<?php
header('Content-Type: text/html; charset=utf-8');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Nuevo auto - Haro</title>
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
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --haro-black:#111111; --haro-ink:#1f1b18; --haro-muted:#756f67;
            --haro-red:#9f1d1d; --haro-gold:#c49a4a; --haro-bg:#f4f0ea;
            --haro-card:#fffaf3; --haro-input:#ffffff;
            --haro-border:rgba(31,27,24,.12); --haro-shadow:0 20px 55px rgba(22,18,14,.10);
            --haro-radius:24px; --haro-transition:220ms ease;
        }

        body.layout-boxed {
            background: radial-gradient(circle at top left, rgba(196,154,74,.18), transparent 34%),
                        linear-gradient(180deg,#fbf7f1 0%,var(--haro-bg) 100%) !important;
            font-family:'DM Sans','Nunito',sans-serif !important;
            color:var(--haro-ink) !important;
        }

        #load_screen { background:var(--haro-bg) !important; }
        #load_screen .spinner-grow { background-color:var(--haro-red) !important; color:var(--haro-red) !important; }
        .layout-px-spacing { padding:30px 24px 24px !important; }

        .secondary-nav .header {
            background:rgba(255,250,243,.86) !important;
            border:1px solid var(--haro-border) !important;
            border-radius:var(--haro-radius) !important;
            padding:18px 20px !important;
            box-shadow:0 12px 32px rgba(22,18,14,.06);
            backdrop-filter:blur(14px);
        }

        .btn-toggle.sidebarCollapse {
            width:42px; height:42px; border-radius:14px;
            background:var(--haro-black); color:#fff !important;
            display:inline-flex; align-items:center; justify-content:center;
            margin-right:14px; transition:transform var(--haro-transition), background var(--haro-transition);
        }

        .btn-toggle.sidebarCollapse:hover { background:var(--haro-red); transform:translateY(-2px); }

        .haro-page-title .haro-eyebrow {
            display:inline-flex; align-items:center; gap:8px;
            color:var(--haro-red); font-family:'Bebas Neue',sans-serif;
            font-size:11px; font-weight:400; text-transform:uppercase;
            letter-spacing:.14em; margin-bottom:4px;
        }

        .haro-page-title .haro-eyebrow::before {
            content:""; width:28px; height:2px; border-radius:99px; background:var(--haro-gold);
        }

        .page-title h3 {
            color:var(--haro-ink) !important; font-family:'Bebas Neue',sans-serif !important;
            font-size:clamp(22px,2.4vw,32px) !important; line-height:1.05 !important;
            font-weight:400 !important; letter-spacing:-.04em; margin:0 !important;
        }

        .breadcrumb-style-one .breadcrumb { margin-top:8px !important; }
        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            color:var(--haro-muted) !important; font-size:12px; font-weight:600;
        }
        .breadcrumb-style-one .breadcrumb-item.active { color:var(--haro-red) !important; }

        .haro-form-card {
            background:var(--haro-card) !important;
            border:1px solid var(--haro-border) !important;
            border-radius:var(--haro-radius) !important;
            box-shadow:var(--haro-shadow) !important;
            overflow:hidden;
        }

        .haro-form-card .widget-content { padding:28px !important; background:transparent !important; }

        .haro-form-header {
            padding:26px 28px 20px !important;
            background:linear-gradient(135deg,#181411 0%,#2a1715 58%,#6f1818 100%) !important;
            border-bottom:1px solid rgba(196,154,74,.22) !important;
        }

        .haro-form-header h4 {
            color:#fff6e8 !important; font-family:'Bebas Neue',sans-serif !important;
            font-size:26px !important; font-weight:400 !important;
            letter-spacing:-.04em; margin:0 !important;
        }

        .haro-form-subtitle { color:rgba(255,246,232,.68); font-size:13px; margin:6px 0 0; max-width:620px; }

        .haro-section-label {
            display:inline-flex; align-items:center; gap:9px;
            color:var(--haro-red) !important; font-family:'Bebas Neue',sans-serif;
            font-size:12px !important; font-weight:400; text-transform:uppercase;
            letter-spacing:.14em; margin:0 0 20px !important;
        }

        .haro-section-label::before {
            content:""; width:30px; height:2px; border-radius:99px; background:var(--haro-gold);
        }

        #formularioAuto .row { row-gap:18px; }

        #formularioAuto .form-group {
            background:rgba(255,255,255,.48);
            border:1px solid rgba(31,27,24,.08);
            border-radius:18px; padding:16px; margin-bottom:0; height:100%;
            transition:border-color var(--haro-transition), box-shadow var(--haro-transition), transform var(--haro-transition);
        }

        #formularioAuto .form-group:focus-within {
            border-color:rgba(159,29,29,.34);
            box-shadow:0 0 0 4px rgba(159,29,29,.08);
            transform:translateY(-1px);
        }

        #formularioAuto label,
        #formularioAuto .col-form-label {
            color:var(--haro-ink) !important; font-family:'Bebas Neue',sans-serif;
            font-size:12px; font-weight:400; letter-spacing:.06em;
            text-transform:uppercase; margin-bottom:8px; padding-top:0;
        }

        #formularioAuto .form-control,
        #formularioAuto select,
        #formularioAuto textarea {
            background:var(--haro-input) !important;
            border:1px solid var(--haro-border) !important;
            border-radius:13px !important;
            color:var(--haro-ink) !important;
            min-height:44px;
            font-family:'DM Sans',sans-serif !important;
            font-size:14px !important;
            font-weight:600;
            outline:none !important;
            transition:border-color var(--haro-transition), box-shadow var(--haro-transition);
        }

        #formularioAuto textarea { min-height:140px; resize:vertical; }

        #formularioAuto .form-control:focus,
        #formularioAuto select:focus,
        #formularioAuto textarea:focus {
            border-color:var(--haro-red) !important;
            box-shadow:0 0 0 4px rgba(159,29,29,.10) !important;
        }

        #formularioAuto .form-control::placeholder { color:rgba(117,111,103,.75); font-weight:500; }

        #formularioAuto .form-check {
            background:rgba(196,154,74,.10);
            border:1px solid rgba(196,154,74,.20);
            border-radius:13px;
            padding:12px 12px 12px 38px;
            margin-bottom:10px;
        }

        #formularioAuto .form-check-label {
            color:var(--haro-muted) !important;
            font-family:'DM Sans',sans-serif !important;
            font-size:13px; font-weight:700;
            letter-spacing:0; text-transform:none; margin:0;
        }

        #formularioAuto .form-check-input { border-color:rgba(159,29,29,.35); }
        #formularioAuto .form-check-input:checked { background-color:var(--haro-red); border-color:var(--haro-red); }

        .btn-haro-submit {
            background:linear-gradient(135deg,var(--haro-red),#6f1818) !important;
            border:1px solid rgba(196,154,74,.28) !important;
            color:#fff !important;
            border-radius:15px !important;
            min-height:48px;
            padding:12px 24px !important;
            font-family:'Bebas Neue',sans-serif !important;
            font-weight:400 !important;
            letter-spacing:.04em;
            text-transform:uppercase;
            box-shadow:0 14px 28px rgba(159,29,29,.24);
            transition:transform var(--haro-transition), box-shadow var(--haro-transition);
        }

        .btn-haro-submit:hover { transform:translateY(-2px); box-shadow:0 18px 34px rgba(159,29,29,.32); }

        .footer-wrapper {
            background:transparent !important;
            border-top:1px solid var(--haro-border) !important;
            color:var(--haro-muted) !important;
            padding:22px 28px !important;
            font-family:'DM Sans',sans-serif !important;
            font-size:13px;
        }

        .footer-wrapper a { color:var(--haro-red) !important; font-weight:700; }

        html[data-theme="dark"] body.layout-boxed,
        body.dark.layout-boxed,
        .dark body.layout-boxed { background:#111111 !important; color:#f5ead9 !important; }

        html[data-theme="dark"] .secondary-nav .header,
        html[data-theme="dark"] .haro-form-card,
        body.dark .secondary-nav .header,
        body.dark .haro-form-card {
            background:#191512 !important;
            border-color:rgba(196,154,74,.18) !important;
        }

        html[data-theme="dark"] .page-title h3,
        body.dark .page-title h3 { color:#fff5e8 !important; }

        html[data-theme="dark"] #formularioAuto .form-group,
        body.dark #formularioAuto .form-group {
            background:rgba(255,255,255,.035);
            border-color:rgba(196,154,74,.16);
        }

        html[data-theme="dark"] #formularioAuto label,
        html[data-theme="dark"] #formularioAuto .col-form-label,
        body.dark #formularioAuto label,
        body.dark #formularioAuto .col-form-label { color:#fff5e8 !important; }

        html[data-theme="dark"] #formularioAuto .form-control,
        html[data-theme="dark"] #formularioAuto select,
        html[data-theme="dark"] #formularioAuto textarea,
        body.dark #formularioAuto .form-control,
        body.dark #formularioAuto select,
        body.dark #formularioAuto textarea {
            background:#120f0d !important;
            color:#fff5e8 !important;
            border-color:rgba(196,154,74,.18) !important;
        }

        @media (max-width:768px) {
            .layout-px-spacing { padding:18px 14px !important; }
            .secondary-nav .header { padding:16px !important; align-items:flex-start !important; }
            .page-title h3 { font-size:22px !important; }
            .haro-form-card .widget-content { padding:18px !important; }
            .haro-form-header { padding:22px 20px 18px !important; }
            .haro-form-header h4 { font-size:22px !important; }
            #formularioAuto .form-group { padding:14px; }
            .btn-haro-submit { width:100%; }
        }
    </style>


<style id="haro-auto-form-final">
/* ==========================================================
   NUEVO AUTO - ESTILO DASHBOARD HARO
   Solo diseño. No modifica PHP, sesiones ni funcionalidades.
========================================================== */

:root {
    --haro-black:#0b0b0d;
    --haro-ink:#161616;
    --haro-muted:#77736b;
    --haro-red:#b0141b;
    --haro-gold:#c9a24a;
    --haro-bg:#f4f1ea;
    --haro-paper:rgba(255,255,255,.90);
    --haro-border:rgba(201,162,74,.20);
    --haro-shadow:0 18px 48px rgba(15,15,18,.09);
    --haro-radius:26px;
    --haro-transition:220ms cubic-bezier(.4,0,.2,1);
}

body.layout-boxed {
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.16), transparent 32%),
        radial-gradient(circle at 7% 24%, rgba(176,20,27,.07), transparent 28%),
        linear-gradient(180deg,#fbf8f1 0%,var(--haro-bg) 46%,#eee8dc 100%) !important;
    font-family:'DM Sans','Nunito',sans-serif !important;
    color:var(--haro-ink) !important;
}

#load_screen { background:var(--haro-bg) !important; }
#load_screen .spinner-grow { background-color:var(--haro-red) !important; color:var(--haro-red) !important; }

.layout-px-spacing {
    padding:30px 26px 24px !important;
}

.secondary-nav .header {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-border) !important;
    border-radius:var(--haro-radius) !important;
    padding:20px 22px !important;
    box-shadow:var(--haro-shadow) !important;
    backdrop-filter:blur(14px);
    position:relative;
    overflow:hidden;
}

.secondary-nav .header::before {
    content:"";
    position:absolute;
    inset:0 0 auto 0;
    height:4px;
    background:linear-gradient(90deg,var(--haro-red),var(--haro-gold),var(--haro-red));
}

.btn-toggle.sidebarCollapse {
    width:44px !important;
    height:44px !important;
    min-width:44px !important;
    border-radius:15px !important;
    background:linear-gradient(135deg,#ffffff,#f7efe2) !important;
    border:1px solid rgba(176,20,27,.18) !important;
    color:var(--haro-red) !important;
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    margin-right:14px;
    box-shadow:0 10px 24px rgba(16,15,12,.10) !important;
    transition:transform var(--haro-transition), box-shadow var(--haro-transition), border-color var(--haro-transition);
}

.btn-toggle.sidebarCollapse:hover {
    transform:translateY(-2px);
    border-color:rgba(176,20,27,.38) !important;
    box-shadow:0 16px 32px rgba(176,20,27,.13) !important;
}

.haro-page-title .haro-eyebrow {
    display:inline-flex;
    align-items:center;
    gap:9px;
    color:var(--haro-red);
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.05rem;
    font-weight:400 !important;
    letter-spacing:.09em;
    text-transform:uppercase;
    margin-bottom:5px;
}

.haro-page-title .haro-eyebrow::before {
    content:"";
    width:30px;
    height:2px;
    border-radius:999px;
    background:var(--haro-gold);
}

.page-title h3 {
    color:var(--haro-black) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:clamp(2rem,3vw,3.05rem) !important;
    line-height:.94 !important;
    font-weight:400 !important;
    letter-spacing:.035em !important;
    margin:0 !important;
    text-transform:uppercase;
}

.breadcrumb-style-one .breadcrumb { margin-top:9px !important; }
.breadcrumb-style-one .breadcrumb-item,
.breadcrumb-style-one .breadcrumb-item a {
    color:var(--haro-muted) !important;
    font-size:.8rem;
    font-weight:700;
    text-decoration:none !important;
}
.breadcrumb-style-one .breadcrumb-item.active { color:var(--haro-red) !important; }

.haro-form-card {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-border) !important;
    border-radius:var(--haro-radius) !important;
    box-shadow:var(--haro-shadow) !important;
    backdrop-filter:blur(12px);
    overflow:hidden;
}

.haro-form-header {
    padding:28px 30px 22px !important;
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.25), transparent 42%),
        linear-gradient(135deg,#111111 0%,#211714 55%,#7d1118 100%) !important;
    border-bottom:1px solid rgba(201,162,74,.24) !important;
}

.haro-form-header h4 {
    color:#fff3df !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:2.15rem !important;
    font-weight:400 !important;
    letter-spacing:.06em !important;
    margin:0 !important;
    text-transform:uppercase;
}

.haro-form-subtitle {
    color:rgba(255,243,223,.72);
    font-size:13px;
    font-weight:500;
    margin:8px 0 0;
    max-width:640px;
}

.haro-form-card .widget-content {
    padding:28px !important;
    background:transparent !important;
}

.haro-section-label {
    display:inline-flex;
    align-items:center;
    gap:9px;
    color:var(--haro-red) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.08rem !important;
    font-weight:400 !important;
    text-transform:uppercase;
    letter-spacing:.09em;
    margin:0 0 20px !important;
}

.haro-section-label::before {
    content:"";
    width:30px;
    height:2px;
    border-radius:999px;
    background:var(--haro-gold);
}

#formularioAuto .row { row-gap:18px; }

#formularioAuto .form-group {
    height:100%;
    margin-bottom:0;
    padding:16px;
    background:rgba(255,255,255,.62);
    border:1px solid rgba(201,162,74,.16);
    border-radius:18px;
    transition:border-color var(--haro-transition), box-shadow var(--haro-transition), transform var(--haro-transition);
}

#formularioAuto .form-group:focus-within {
    border-color:rgba(176,20,27,.36);
    box-shadow:0 0 0 4px rgba(176,20,27,.09);
    transform:translateY(-1px);
}

#formularioAuto label,
#formularioAuto .col-form-label {
    color:var(--haro-ink) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.02rem;
    font-weight:400 !important;
    letter-spacing:.07em;
    text-transform:uppercase;
    margin-bottom:8px;
    padding-top:0;
}

#formularioAuto .form-control,
#formularioAuto select,
#formularioAuto textarea {
    min-height:46px;
    background:#fff !important;
    border:1px solid rgba(201,162,74,.24) !important;
    border-radius:14px !important;
    color:var(--haro-ink) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:14px !important;
    font-weight:600;
    outline:none !important;
    transition:border-color var(--haro-transition), box-shadow var(--haro-transition);
}

#formularioAuto textarea {
    min-height:144px;
    resize:vertical;
}

#formularioAuto .form-control:focus,
#formularioAuto select:focus,
#formularioAuto textarea:focus {
    border-color:var(--haro-red) !important;
    box-shadow:0 0 0 4px rgba(176,20,27,.10) !important;
}

#formularioAuto .form-control::placeholder {
    color:rgba(119,115,107,.75);
    font-weight:500;
}

#formularioAuto .form-check {
    background:rgba(201,162,74,.12);
    border:1px solid rgba(201,162,74,.22);
    border-radius:14px;
    padding:12px 12px 12px 38px;
    margin-bottom:10px;
}

#formularioAuto .form-check-label {
    color:var(--haro-muted) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:13px;
    font-weight:700 !important;
    letter-spacing:0;
    text-transform:none;
    margin:0;
}

#formularioAuto .form-check-input { border-color:rgba(176,20,27,.35); }
#formularioAuto .form-check-input:checked {
    background-color:var(--haro-red);
    border-color:var(--haro-red);
}

.btn-haro-submit {
    min-height:56px;
    min-width:190px;
    padding:12px 28px !important;
    border:none !important;
    border-radius:16px !important;
    background:linear-gradient(135deg,var(--haro-red),#7d1118) !important;
    color:#fff !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.35rem !important;
    font-weight:400 !important;
    letter-spacing:.08em;
    text-transform:uppercase;
    box-shadow:0 14px 30px rgba(176,20,27,.24);
    transition:transform var(--haro-transition), box-shadow var(--haro-transition);
}

.btn-haro-submit:hover {
    transform:translateY(-2px);
    box-shadow:0 18px 38px rgba(176,20,27,.30);
}

.haro-footer { margin-top:34px !important; }

@media (max-width:768px) {
    .layout-px-spacing { padding:22px 14px !important; }
    .secondary-nav .header {
        padding:18px !important;
        align-items:flex-start !important;
    }
    .page-title h3 { font-size:2rem !important; }
    .haro-form-card .widget-content { padding:18px !important; }
    .haro-form-header { padding:22px 20px 18px !important; }
    .haro-form-header h4 { font-size:1.7rem !important; }
    #formularioAuto .form-group { padding:14px; }
    .btn-haro-submit { width:100%; }
}
</style>


<style id="haro-search-select-style">
/* Buscador tipo Nice Select 2 para Marca y Modelo.
   El select original se mantiene con el mismo name/id para no alterar el FormData. */
#formularioAuto select.haro-search-source.haro-search-native {
    display:none !important;
}

.haro-search-select {
    position:relative;
    width:100%;
    font-family:'DM Sans',sans-serif;
}

.haro-search-select__button {
    min-height:46px;
    width:100%;
    background:#fff;
    border:1px solid rgba(201,162,74,.24);
    border-radius:14px;
    color:var(--haro-ink);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:10px 14px;
    cursor:pointer;
    font-size:14px;
    font-weight:700;
    transition:border-color var(--haro-transition), box-shadow var(--haro-transition), background var(--haro-transition);
}

.haro-search-select__button:hover,
.haro-search-select.is-open .haro-search-select__button {
    border-color:var(--haro-red);
    box-shadow:0 0 0 4px rgba(176,20,27,.10);
}

.haro-search-select__value {
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.haro-search-select__arrow {
    width:9px;
    height:9px;
    min-width:9px;
    border-right:2px solid rgba(22,22,22,.58);
    border-bottom:2px solid rgba(22,22,22,.58);
    transform:rotate(45deg) translateY(-2px);
    transition:transform var(--haro-transition);
}

.haro-search-select.is-open .haro-search-select__arrow {
    transform:rotate(225deg) translateY(-1px);
}

.haro-search-select__dropdown {
    position:absolute;
    z-index:9999;
    left:0;
    right:0;
    top:calc(100% + 8px);
    background:#fff;
    border:1px solid rgba(201,162,74,.28);
    border-radius:16px;
    box-shadow:0 18px 42px rgba(15,15,18,.16);
    padding:10px;
    display:none;
}

.haro-search-select.is-open .haro-search-select__dropdown {
    display:block;
}

.haro-search-select__search {
    width:100%;
    min-height:42px;
    border:1px solid rgba(201,162,74,.24);
    border-radius:12px;
    padding:9px 12px;
    color:var(--haro-ink);
    background:#fff;
    font-size:14px;
    font-weight:600;
    outline:none;
    margin-bottom:8px;
}

.haro-search-select__search:focus {
    border-color:var(--haro-red);
    box-shadow:0 0 0 3px rgba(176,20,27,.09);
}

.haro-search-select__options {
    max-height:230px;
    overflow-y:auto;
    margin:0;
    padding:0;
    list-style:none;
}

.haro-search-select__option {
    width:100%;
    border:0;
    background:transparent;
    color:var(--haro-ink);
    text-align:left;
    padding:10px 12px;
    border-radius:11px;
    font-size:14px;
    font-weight:650;
    cursor:pointer;
    transition:background var(--haro-transition), color var(--haro-transition);
}

.haro-search-select__option:hover,
.haro-search-select__option.is-selected {
    background:rgba(176,20,27,.10);
    color:var(--haro-red);
}

.haro-search-select__empty {
    padding:12px;
    color:var(--haro-muted);
    font-size:13px;
    font-weight:700;
    text-align:center;
}

html[data-theme="dark"] .haro-search-select__button,
html[data-theme="dark"] .haro-search-select__dropdown,
html[data-theme="dark"] .haro-search-select__search,
body.dark .haro-search-select__button,
body.dark .haro-search-select__dropdown,
body.dark .haro-search-select__search {
    background:#120f0d;
    color:#fff5e8;
    border-color:rgba(196,154,74,.18);
}

html[data-theme="dark"] .haro-search-select__arrow,
body.dark .haro-search-select__arrow {
    border-color:rgba(255,245,232,.72);
}

html[data-theme="dark"] .haro-search-select__option,
body.dark .haro-search-select__option {
    color:#fff5e8;
}

html[data-theme="dark"] .haro-search-select__option:hover,
html[data-theme="dark"] .haro-search-select__option.is-selected,
body.dark .haro-search-select__option:hover,
body.dark .haro-search-select__option.is-selected {
    background:rgba(176,20,27,.24);
    color:#fff3df;
}
</style>

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
        include_once("../api/adminEditor.php");
        include_once("../api/adminAutos.php");
        if ((int) ($_SESSION['sesionUsuario']['permisos'] ?? 0) > 100) {
            header('Location: pruebas.seminuevosharo.mx');
        }
        $admin = new AdministradorEditor();

        ?>
        <?php
        include_once("../api/adminUsuarios.php");
        $adminUsuario = new administradorUsuarios();
        $usuarioAd = $adminUsuario->dameUsuarioId(intval($_SESSION['sesionUsuario']['id']));
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
                                            <span class="haro-eyebrow">Inventario</span>
                                            <h3>Panel de creación de autos</h3>
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
                                <div class="widget-header haro-form-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Nuevo auto</h4><p class="haro-form-subtitle">Captura la información principal del vehículo para publicarlo en inventario.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="row g-3" id="formularioAuto">
                                        <p class="card-description haro-section-label">Información del auto</p>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Marca</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control haro-search-source" name="marca" onchange="filtro()" id="marcas" data-haro-placeholder="Buscar marca">
                                                            <option>Marca</option>
                                                            <?php
                                                            $marcas = $admin->dameMarcas();
                                                            foreach ($marcas as $marc) {
                                                                echo '<option value="' . $marc->id . '">' . $marc->marca . '</option>';
                                                            }


                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Modelo</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control haro-search-source" name="modelo" id="modelos" data-haro-placeholder="Buscar modelo">
                                                            <option>Modelo</option>
                                                            <?php
                                                            $modelos = $admin->dameModelos();
                                                            foreach ($modelos as $modelos) {
                                                                echo '<option value="' . $modelos->id . '">' . $modelos->modelo . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Transmisión</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="trans">
                                                            <option>Transmisión</option>
                                                            <?php
                                                            $transmiciones = $admin->dameTransmiciones();
                                                            foreach ($transmiciones as $transmiciones) {
                                                                echo '<option value="' . $transmiciones->id . '">' . $transmiciones->transmicion . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Interior</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="interior">
                                                            <option>Interior</option>
                                                            <?php

                                                            $interiores = $admin->dameInteriores();
                                                            foreach ($interiores as $interiores) {
                                                                echo '<option value="' . $interiores->id . '">' . $interiores->interior . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="display: none;">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Dueño</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="duenio" value="4">
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Año</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="anio" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Cilindraje</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="cilindrage" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Precio</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="precio" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="display: none;">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Nacionalidad</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" value="MEXICANA" type="text" name="nacionalidad" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Estatus</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="estatus" placeholder="Nuevo, Seminuevo etc..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Combustible</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="combustible">
                                                            <option value="Gasolina">Gasolina</option>
                                                            <option value="Bencina">Bencina</option>
                                                            <option value="Diesel">Diesel</option>
                                                            <option value="Eléctrico">Eléctrico</option>
                                                            <option value="Híbrido">Híbrido</option>
                                                            <option value="Otros">Otros</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Kilometraje</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="kilometragePermitido" class="form-check-input" checked=""> OMITIR KM EN NO
                                                                ESENCIALES <i class="input-helper"></i></label>
                                                        </div>
                                                        <input class="form-control" type="number" name="kilometros" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Consignación </label>
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="consig" class="form-check-input"=""> Automóvil a consignación <i class="input-helper"></i></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Color</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="color">
                                                            <option value="Sin Color">Elige un color</option>
                                                            <option value="Beige">Beige</option>
                                                            <option value="Negro">Negro</option>
                                                            <option value="Azul">Azul</option>
                                                            <option value="Bronce">Bronce</option>
                                                            <option value="Marrón">Marrón</option>
                                                            <option value="Borgoña">Borgoña</option>
                                                            <option value="Dorado">Dorado</option>
                                                            <option value="Verde">Verde</option>
                                                            <option value="Gris">Gris</option>
                                                            <option value="Magenta">Magenta</option>
                                                            <option value="Bordo">Bordo</option>
                                                            <option value="Naranja">Naranja</option>
                                                            <option value="Rosa">Rosa</option>
                                                            <option value="Rojo">Rojo</option>
                                                            <option value="Plata">Plata</option>
                                                            <option value="Blanco">Blanco</option>
                                                            <option value="Amarillo">Amarillo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Cuerpo</label>
                                                    <div class="col-sm-12">

                                                        <select class="form-control" name="cuerpo">
                                                            <option value="Otro">Elige un cuerpo</option>
                                                            <option value="Cabina Simple">Cabina Simple</option>
                                                            <option value="Camión Plano">Camión Plano</option>
                                                            <option value="Chasis Cabina">Chasis Cabina</option>
                                                            <option value="Chasis de la cabina">Chasis de la cabina
                                                            </option>
                                                            <option value="Citycar">Citycar</option>
                                                            <option value="Convertible">Convertible</option>
                                                            <option value="Coupé">Coupé</option>
                                                            <option value="Deportivas">Deportivas</option>
                                                            <option value="Furgón">Furgón</option>
                                                            <option value="Hatchback">Hatchback</option>
                                                            <option value="Media Barandas">Media Barandas</option>
                                                            <option value="Pick up">Pick up</option>
                                                            <option value="Plegables">Plegables</option>
                                                            <option value="Sedán">Sedán</option>
                                                            <option value="Sport calle - urbanas">Sport calle - urbanas
                                                            </option>
                                                            <option value="Station Wagon">Station Wagon</option>
                                                            <option value="SUV">SUV</option>
                                                            <option value="Todo Terreno">Todo Terreno</option>
                                                            <option value="Ute">Ute</option>
                                                            <option value="Van">Van</option>
                                                            <option value="No Especificado">Otro</option>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Potencia</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="text" name="poder" placeholder="180 hp..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class=" col-form-label">Asientos</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="number" name="asientos" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                <label for="exampleInputUsername1">Descripción</label>
                                                    <div class="col-sm-12">
                                                    <textarea class="form-control" name="descripcion" id="" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                    <button id="botonNuevo" type="submit" class="btn btn-susses btn-rounded mb-2 me-4 _effect--ripple waves-effect waves-light btn-haro-submit">Nuevo auto</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <button type="submit" class="btn btn-outline-secondary btn-lg btn-block">Nuevo auto</button> -->
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

        function normalizarTextoBuscadorHaro(texto) {
            texto = (texto || "").toString().toLowerCase();
            if (typeof texto.normalize === "function") {
                texto = texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }
            return texto;
        }

        function inicializarBuscadorSelectHaro(select) {
            if (!select) {
                return;
            }

            if (select.haroSearchSelect) {
                select.haroSearchSelect.refresh();
                return;
            }

            select.classList.add("haro-search-native");

            var wrapper = document.createElement("div");
            wrapper.className = "haro-search-select";

            var button = document.createElement("button");
            button.type = "button";
            button.className = "haro-search-select__button";

            var valueText = document.createElement("span");
            valueText.className = "haro-search-select__value";

            var arrow = document.createElement("span");
            arrow.className = "haro-search-select__arrow";

            button.appendChild(valueText);
            button.appendChild(arrow);

            var dropdown = document.createElement("div");
            dropdown.className = "haro-search-select__dropdown";

            var search = document.createElement("input");
            search.type = "text";
            search.className = "haro-search-select__search";
            search.placeholder = select.getAttribute("data-haro-placeholder") || "Buscar";

            var optionsList = document.createElement("div");
            optionsList.className = "haro-search-select__options";

            dropdown.appendChild(search);
            dropdown.appendChild(optionsList);
            wrapper.appendChild(button);
            wrapper.appendChild(dropdown);

            select.parentNode.insertBefore(wrapper, select.nextSibling);

            function obtenerOpcionSeleccionada() {
                if (select.selectedIndex >= 0 && select.options[select.selectedIndex]) {
                    return select.options[select.selectedIndex];
                }
                return select.options.length ? select.options[0] : null;
            }

            function sincronizarTexto() {
                var opcion = obtenerOpcionSeleccionada();
                valueText.textContent = opcion ? opcion.text : "";
            }

            function cerrar() {
                wrapper.classList.remove("is-open");
                search.value = "";
                renderizarOpciones("");
            }

            function abrir() {
                wrapper.classList.add("is-open");
                search.value = "";
                renderizarOpciones("");
                setTimeout(function() {
                    search.focus();
                }, 0);
            }

            function elegirOpcion(indice) {
                select.selectedIndex = indice;
                sincronizarTexto();
                renderizarOpciones(search.value);
                select.dispatchEvent(new Event("change", { bubbles: true }));
                cerrar();
            }

            function renderizarOpciones(filtroTexto) {
                var filtroNormalizado = normalizarTextoBuscadorHaro(filtroTexto);
                optionsList.innerHTML = "";

                var encontrados = 0;
                for (var i = 0; i < select.options.length; i++) {
                    var opcion = select.options[i];
                    var texto = opcion.text || "";
                    var textoNormalizado = normalizarTextoBuscadorHaro(texto);

                    if (filtroNormalizado && textoNormalizado.indexOf(filtroNormalizado) === -1) {
                        continue;
                    }

                    encontrados++;

                    var optionButton = document.createElement("button");
                    optionButton.type = "button";
                    optionButton.className = "haro-search-select__option";
                    if (i === select.selectedIndex) {
                        optionButton.className += " is-selected";
                    }
                    optionButton.textContent = texto;
                    optionButton.setAttribute("data-index", i);

                    optionButton.addEventListener("click", function() {
                        elegirOpcion(parseInt(this.getAttribute("data-index"), 10));
                    });

                    optionsList.appendChild(optionButton);
                }

                if (!encontrados) {
                    var empty = document.createElement("div");
                    empty.className = "haro-search-select__empty";
                    empty.textContent = "Sin resultados";
                    optionsList.appendChild(empty);
                }
            }

            button.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (wrapper.classList.contains("is-open")) {
                    cerrar();
                } else {
                    abrir();
                }
            });

            search.addEventListener("keyup", function() {
                renderizarOpciones(search.value);
            });

            search.addEventListener("click", function(e) {
                e.stopPropagation();
            });

            document.addEventListener("click", function(e) {
                if (!wrapper.contains(e.target)) {
                    cerrar();
                }
            });

            select.addEventListener("change", function() {
                sincronizarTexto();
                renderizarOpciones(search.value);
            });

            select.haroSearchSelect = {
                refresh: function() {
                    sincronizarTexto();
                    renderizarOpciones("");
                }
            };

            sincronizarTexto();
            renderizarOpciones("");
        }

        function actualizarBuscadorSelectHaro(select) {
            inicializarBuscadorSelectHaro(select);
        }

        document.addEventListener("DOMContentLoaded", function() {
            inicializarBuscadorSelectHaro(document.getElementById("marcas"));
            inicializarBuscadorSelectHaro(document.getElementById("modelos"));
        });


        function filtro() {
            let x = document.getElementById("marcas").value;
            let modelo = document.getElementById("modelos");
            console.log(x);
            let datosMarca = new FormData();
            datosMarca.append("accion", "verModelos");
            datosMarca.append("id", x);

            fetch("../api/apiEditor.php", {
                    method: "POST",
                    body: datosMarca,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    let opciones = "";
                    for (i of data) {
                        opciones += "<option value='" + i.id + "'>" + i.modelo + "</option>";
                    }
                    modelo.innerHTML = opciones;
                    actualizarBuscadorSelectHaro(modelo);
                });
        }



        var formularioAuto = document.getElementById("formularioAuto");

        formularioAuto.addEventListener("submit", function(e) {
            e.preventDefault();
            let datosDeInicioAuto = new FormData(formularioAuto);
            var botonAgregar = document.getElementById("botonNuevo");
            botonAgregar.disabled = true;
            botonAgregar.innerHTML = "Agregando...";
            datosDeInicioAuto.append("accion", "agregar");

            fetch("../api/apiAuto.php", {
                    method: "POST",
                    body: datosDeInicioAuto,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    if (data == "1") {
                        console.log("Registro Exitoso");
                        location.reload();
                    } else {
                        console.log("Error");
                    }
                });
        });
    </script>

</body>

</html>
