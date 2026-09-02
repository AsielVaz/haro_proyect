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
    <title>Modelos - Haro</title>
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
        :root {
            --haro-bg: #f4f1ec;
            --haro-card: #ffffff;
            --haro-card-2: #fbf8f3;
            --haro-ink: #15110f;
            --haro-muted: #7b7169;
            --haro-line: rgba(35, 24, 17, .12);
            --haro-red: #8f161d;
            --haro-red-2: #b41f2a;
            --haro-gold: #c7a45b;
            --haro-gold-soft: rgba(199, 164, 91, .16);
            --haro-shadow: 0 18px 46px rgba(33, 20, 12, .10);
            --haro-radius: 22px;
        }

        body.layout-boxed {
            background:
                radial-gradient(circle at top left, rgba(199,164,91,.22), transparent 32%),
                linear-gradient(135deg, #fffaf2 0%, var(--haro-bg) 45%, #ece4d9 100%) !important;
            font-family: 'DM Sans', 'Nunito', sans-serif !important;
            color: var(--haro-ink) !important;
        }

        body.dark,
        .dark body,
        body[data-theme="dark"],
        .dark .main-content {
            background: #12100f !important;
            color: #f8efe5 !important;
        }

        #load_screen .spinner-grow { color: var(--haro-red) !important; }
        .layout-px-spacing { padding: 30px 24px !important; }

        .secondary-nav,
        .breadcrumbs-container,
        .secondary-nav .header {
            background: transparent !important;
            box-shadow: none !important;
            border: 0 !important;
        }

        .secondary-nav .header {
            min-height: auto !important;
            padding: 0 !important;
            align-items: center !important;
            gap: 16px;
        }

        .btn-toggle.sidebarCollapse {
            width: 42px;
            height: 42px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--haro-card) !important;
            border: 1px solid var(--haro-line);
            color: var(--haro-red) !important;
            box-shadow: 0 8px 22px rgba(35, 24, 17, .08);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-toggle.sidebarCollapse:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(35, 24, 17, .14);
        }

        .page-header {
            padding: 18px 0 22px !important;
        }

        .page-title h3 {
            margin: 0 !important;
            color: var(--haro-ink) !important;
            font-family: 'Bebas Neue', 'DM Sans', sans-serif !important;
            font-size: clamp(1.35rem, 2.4vw, 2.05rem) !important;
            font-weight: 400 !important;
            letter-spacing: -.04em;
            text-transform: uppercase;
        }

        .page-title h3::after {
            content: '';
            display: block;
            width: 82px;
            height: 4px;
            margin-top: 11px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
        }

        .breadcrumb {
            margin-top: 10px !important;
            margin-bottom: 0 !important;
            gap: 6px;
        }

        .breadcrumb-item,
        .breadcrumb-item a {
            color: var(--haro-muted) !important;
            font-size: .82rem !important;
            font-weight: 600;
            text-decoration: none !important;
        }

        .breadcrumb-item.active {
            color: var(--haro-red) !important;
        }

        .breadcrumb-action-dropdown .btn {
            width: 50px !important;
            height: 50px !important;
            padding: 0 !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 16px !important;
            background: linear-gradient(135deg, var(--haro-red), var(--haro-red-2)) !important;
            border: 1px solid rgba(255,255,255,.20) !important;
            box-shadow: 0 16px 30px rgba(143,22,29,.28);
        }

        .breadcrumb-action-dropdown .btn svg {
            width: 26px !important;
            height: 26px !important;
            filter: brightness(0) invert(1);
        }

        .breadcrumb-action-dropdown .btn svg path:first-child { fill: transparent !important; }
        .breadcrumb-action-dropdown .btn svg path:not(:first-child) { fill: #fff !important; }

        .widget-content.widget-content-area {
            background: rgba(255,255,255,.92) !important;
            border: 1px solid var(--haro-line) !important;
            border-radius: var(--haro-radius) !important;
            box-shadow: var(--haro-shadow) !important;
            overflow: hidden;
            padding: 0 !important;
            backdrop-filter: blur(10px);
        }

        .dt--top-section {
            padding: 20px 22px 16px !important;
            border-bottom: 1px solid var(--haro-line);
            background: linear-gradient(180deg, rgba(255,255,255,.75), rgba(251,248,243,.95));
        }

        .dataTables_length label,
        .dataTables_info {
            color: var(--haro-muted) !important;
            font-size: .85rem !important;
            font-weight: 600 !important;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background: var(--haro-card-2) !important;
            border: 1px solid var(--haro-line) !important;
            border-radius: 12px !important;
            color: var(--haro-ink) !important;
            min-height: 40px;
            outline: none !important;
            font-family: 'DM Sans', sans-serif !important;
        }

        .dataTables_filter input {
            padding: 9px 14px 9px 38px !important;
            min-width: 240px;
        }

        .dataTables_filter input:focus,
        .dataTables_length select:focus {
            border-color: rgba(143,22,29,.45) !important;
            box-shadow: 0 0 0 4px rgba(143,22,29,.09) !important;
        }

        table#zero-config {
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        table#zero-config thead th {
            background: #211714 !important;
            color: #f8efe5 !important;
            border: 0 !important;
            padding: 16px 18px !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: .74rem !important;
            font-weight: 400 !important;
            letter-spacing: .09em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        table#zero-config tbody td {
            padding: 17px 18px !important;
            border-color: rgba(35, 24, 17, .08) !important;
            color: var(--haro-ink) !important;
            font-size: .93rem;
            vertical-align: middle;
            background: transparent !important;
        }

        table#zero-config tbody tr {
            transition: background .18s ease, transform .18s ease;
        }

        table#zero-config tbody tr:nth-child(even) {
            background: rgba(251,248,243,.72) !important;
        }

        table#zero-config tbody tr:hover {
            background: rgba(199,164,91,.13) !important;
        }

        table#zero-config tbody td:first-child {
            font-weight: 400;
            color: var(--haro-red) !important;
            font-family: 'Bebas Neue', sans-serif;
            width: 100px;
        }

        table#zero-config tbody td:nth-child(2) {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            letter-spacing: -.02em;
        }

        table#zero-config tbody td:nth-child(3) {
            color: var(--haro-muted) !important;
            font-weight: 700;
        }

        .dt--bottom-section {
            padding: 17px 22px !important;
            border-top: 1px solid var(--haro-line);
            background: var(--haro-card-2);
        }

        .dt--pagination .paginate_button,
        .dataTables_paginate .paginate_button {
            border-radius: 11px !important;
            border: 1px solid transparent !important;
            color: var(--haro-muted) !important;
            font-weight: 400 !important;
            margin: 0 2px !important;
        }

        .dt--pagination .paginate_button.current,
        .dataTables_paginate .paginate_button.current {
            background: var(--haro-red) !important;
            border-color: var(--haro-red) !important;
            color: #fff !important;
        }

        .footer-wrapper {
            background: rgba(255,255,255,.80) !important;
            border-top: 1px solid var(--haro-line) !important;
            color: var(--haro-muted) !important;
            padding: 18px 24px !important;
        }

        .footer-wrapper a { color: var(--haro-red) !important; }
        .footer-wrapper svg { color: var(--haro-red) !important; }

        body.dark .widget-content.widget-content-area,
        body.dark .btn-toggle.sidebarCollapse,
        .dark .widget-content.widget-content-area,
        .dark .btn-toggle.sidebarCollapse {
            background: #1c1714 !important;
            border-color: rgba(255,255,255,.10) !important;
        }

        body.dark .page-title h3,
        .dark .page-title h3,
        body.dark table#zero-config tbody td,
        .dark table#zero-config tbody td { color: #f8efe5 !important; }

        body.dark .dt--top-section,
        body.dark .dt--bottom-section,
        .dark .dt--top-section,
        .dark .dt--bottom-section {
            background: #181310 !important;
            border-color: rgba(255,255,255,.10) !important;
        }

        body.dark table#zero-config tbody tr:nth-child(even),
        .dark table#zero-config tbody tr:nth-child(even) { background: rgba(255,255,255,.03) !important; }

        body.dark table#zero-config tbody tr:hover,
        .dark table#zero-config tbody tr:hover { background: rgba(199,164,91,.10) !important; }

        body.dark .dataTables_length select,
        body.dark .dataTables_filter input,
        .dark .dataTables_length select,
        .dark .dataTables_filter input {
            background: #15110f !important;
            color: #f8efe5 !important;
            border-color: rgba(255,255,255,.12) !important;
        }

        @media (max-width: 768px) {
            .layout-px-spacing { padding: 22px 14px !important; }
            .secondary-nav .header { align-items: flex-start !important; }
            .breadcrumb-action-dropdown { margin-top: 6px; }
            .dataTables_filter input { min-width: 100%; width: 100% !important; }
            .dt--top-section .row > div { width: 100%; }
            table#zero-config thead th,
            table#zero-config tbody td { padding: 14px 14px !important; }
        }
    </style>


<style>
.page-title h3,
table#zero-config thead th,
table#zero-config tbody td:first-child,
table#zero-config tbody td:nth-child(2),
.breadcrumb-action-dropdown .btn::after{
font-family:'Bebas Neue',sans-serif!important;
font-weight:400!important;
letter-spacing:.05em!important;
}
.page-title h3{
font-size:clamp(1.8rem,2.8vw,2.8rem)!important;
}
.breadcrumb-action-dropdown .btn{
background:linear-gradient(135deg,#b0141b,#6f1818)!important;
}
.breadcrumb-action-dropdown .btn::after{
content:'Nuevo modelo';
color:#fff;
margin-left:8px;
}
table#zero-config tbody td:first-child{
color:#b0141b!important;
font-size:1.1rem;
}
table#zero-config tbody td:nth-child(2){
font-size:1.15rem;
color:#131316!important;
}
</style>


<style id="haro-dashboard-style-final">
/* ==========================================================
   ESTILO DASHBOARD HARO - MODELOS
   Solo diseño. No modifica PHP, consultas, sesión ni JS.
========================================================== */

:root {
    --haro-bg: #f4f1ea;
    --haro-paper: rgba(255,255,255,.88);
    --haro-paper-solid: #fffaf3;
    --haro-black: #0b0b0d;
    --haro-ink: #161616;
    --haro-muted: #77736b;
    --haro-red: #b0141b;
    --haro-gold: #c9a24a;
    --haro-red-soft: rgba(176,20,27,.11);
    --haro-gold-soft: rgba(201,162,74,.14);
    --haro-line: rgba(19,19,22,.08);
    --haro-line-gold: rgba(201,162,74,.20);
    --haro-radius: 26px;
    --haro-shadow: 0 18px 48px rgba(15,15,18,.09);
    --haro-transition: 220ms cubic-bezier(.4,0,.2,1);
}

body.layout-boxed {
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.16), transparent 32%),
        radial-gradient(circle at 7% 24%, rgba(176,20,27,.07), transparent 28%),
        linear-gradient(180deg, #fbf8f1 0%, var(--haro-bg) 46%, #eee8dc 100%) !important;
    font-family: 'DM Sans', 'Nunito', sans-serif !important;
    color: var(--haro-ink) !important;
}

#load_screen {
    background: var(--haro-bg) !important;
}

#load_screen .spinner-grow {
    background-color: var(--haro-red) !important;
    color: var(--haro-red) !important;
}

.layout-px-spacing {
    padding: 30px 26px !important;
}

.secondary-nav,
.breadcrumbs-container {
    background: transparent !important;
    box-shadow: none !important;
    border: 0 !important;
}

.secondary-nav .header {
    background: var(--haro-paper) !important;
    border: 1px solid var(--haro-line-gold) !important;
    border-radius: var(--haro-radius) !important;
    padding: 20px 22px !important;
    min-height: auto !important;
    box-shadow: var(--haro-shadow) !important;
    backdrop-filter: blur(14px);
    position: relative;
    overflow: hidden;
}

.secondary-nav .header::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 4px;
    background: linear-gradient(90deg, var(--haro-red), var(--haro-gold), var(--haro-red));
}

.btn-toggle.sidebarCollapse {
    width: 44px !important;
    height: 44px !important;
    min-width: 44px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 15px !important;
    background: linear-gradient(135deg, #ffffff, #f7efe2) !important;
    border: 1px solid rgba(176,20,27,.18) !important;
    color: var(--haro-red) !important;
    box-shadow: 0 10px 24px rgba(16,15,12,.10) !important;
    transition: transform var(--haro-transition), box-shadow var(--haro-transition), border-color var(--haro-transition);
}

.btn-toggle.sidebarCollapse:hover {
    transform: translateY(-2px);
    border-color: rgba(176,20,27,.38) !important;
    box-shadow: 0 16px 32px rgba(176,20,27,.13) !important;
}

.page-header {
    padding: 0 !important;
}

.haro-page-title .haro-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--haro-red);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.05rem;
    font-weight: 400;
    letter-spacing: .09em;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.haro-page-title .haro-eyebrow::before {
    content: "";
    width: 30px;
    height: 2px;
    border-radius: 999px;
    background: var(--haro-gold);
}

.page-title h3 {
    margin: 0 !important;
    color: var(--haro-black) !important;
    font-family: 'Bebas Neue', sans-serif !important;
    font-size: clamp(2rem, 3vw, 3.05rem) !important;
    font-weight: 400 !important;
    letter-spacing: .035em !important;
    line-height: .94 !important;
    text-transform: uppercase;
}

.page-title h3::after {
    display: none !important;
}

.breadcrumb {
    margin: 9px 0 0 !important;
}

.breadcrumb-item,
.breadcrumb-item a {
    color: var(--haro-muted) !important;
    font-size: .8rem !important;
    font-weight: 700;
    text-decoration: none !important;
}

.breadcrumb-item.active {
    color: var(--haro-red) !important;
}

.breadcrumb-action-dropdown .btn {
    width: auto !important;
    height: 48px !important;
    min-width: 148px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    padding: 0 18px !important;
    border-radius: 16px !important;
    background: linear-gradient(135deg, var(--haro-red), #7d1118) !important;
    border: 1px solid rgba(201,162,74,.28) !important;
    box-shadow: 0 14px 30px rgba(176,20,27,.22) !important;
    color: #fff !important;
    text-decoration: none !important;
    transition: transform var(--haro-transition), box-shadow var(--haro-transition);
}

.breadcrumb-action-dropdown .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(176,20,27,.28) !important;
}

.breadcrumb-action-dropdown .btn svg {
    width: 22px !important;
    height: 22px !important;
    filter: brightness(0) invert(1);
}

.breadcrumb-action-dropdown .btn::after {
    content: 'Nuevo modelo';
    color: #fff;
    font-family: 'Bebas Neue', sans-serif !important;
    font-size: 1.05rem;
    font-weight: 400 !important;
    letter-spacing: .06em;
    line-height: 1;
}

.haro-table-card,
.widget-content.widget-content-area {
    background: var(--haro-paper) !important;
    border: 1px solid var(--haro-line-gold) !important;
    border-radius: var(--haro-radius) !important;
    box-shadow: var(--haro-shadow) !important;
    backdrop-filter: blur(12px);
    overflow: hidden;
    padding: 0 !important;
}

.haro-table-card::before,
.widget-content.widget-content-area::before {
    content: "";
    display: block;
    height: 4px;
    background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
}

.dt--top-section {
    padding: 22px 24px 18px !important;
    background: linear-gradient(135deg, rgba(176,20,27,.04), rgba(201,162,74,.08)) !important;
    border-bottom: 1px solid var(--haro-line);
}

.dataTables_length label,
.dataTables_info {
    color: var(--haro-muted) !important;
    font-size: 13px !important;
    font-weight: 700 !important;
}

.dataTables_length select,
.dataTables_filter input {
    background: #fff !important;
    border: 1px solid rgba(201,162,74,.23) !important;
    border-radius: 14px !important;
    color: var(--haro-ink) !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 13px !important;
    min-height: 40px;
    outline: none !important;
}

.dataTables_filter input {
    min-width: 260px;
    padding: 8px 14px 8px 38px !important;
}

.dataTables_filter input:focus,
.dataTables_length select:focus {
    border-color: rgba(176,20,27,.42) !important;
    box-shadow: 0 0 0 4px rgba(176,20,27,.10) !important;
}

table#zero-config,
.haro-data-table {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0 !important;
}

table#zero-config thead th,
.haro-data-table thead th {
    background: #181411 !important;
    color: #f9efe0 !important;
    border: none !important;
    padding: 16px 18px !important;
    font-family: 'Bebas Neue', sans-serif !important;
    font-size: 1rem !important;
    font-weight: 400 !important;
    letter-spacing: .07em !important;
    text-transform: uppercase;
    white-space: nowrap;
}

table#zero-config tbody td,
.haro-data-table tbody td {
    padding: 16px 18px !important;
    border-color: rgba(19,19,22,.07) !important;
    color: var(--haro-ink) !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 14px;
    font-weight: 650;
    vertical-align: middle !important;
    background: transparent !important;
}

table#zero-config tbody tr:nth-child(even) {
    background: rgba(250,248,243,.72) !important;
}

table#zero-config tbody tr:hover {
    background: linear-gradient(90deg, rgba(176,20,27,.055), rgba(201,162,74,.055)) !important;
}

table#zero-config tbody td:first-child {
    color: var(--haro-red) !important;
    font-family: 'Bebas Neue', sans-serif !important;
    font-size: 1.15rem !important;
    font-weight: 400 !important;
    letter-spacing: .05em !important;
}

table#zero-config tbody td:nth-child(2) {
    color: var(--haro-black) !important;
    font-family: 'Bebas Neue', sans-serif !important;
    font-size: 1.18rem !important;
    font-weight: 400 !important;
    letter-spacing: .05em !important;
}

.dt--bottom-section {
    padding: 18px 24px !important;
    border-top: 1px solid var(--haro-line);
    background: rgba(250,248,243,.88) !important;
}

.dt--pagination .paginate_button,
.dataTables_paginate .paginate_button {
    border-radius: 12px !important;
    border: 1px solid transparent !important;
    color: var(--haro-muted) !important;
    font-family: 'Bebas Neue', sans-serif !important;
    font-weight: 400 !important;
    letter-spacing: .05em;
    margin: 0 2px !important;
}

.dt--pagination .paginate_button.current,
.dataTables_paginate .paginate_button.current {
    background: var(--haro-red) !important;
    border-color: var(--haro-red) !important;
    color: #fff !important;
}

/* El footer externo ya trae estilo; se ajusta separación en esta vista */
.haro-footer {
    margin-top: 34px !important;
}

/* Dark mode controlado para que no rompa contraste */
body.dark,
.dark body,
body[data-theme="dark"],
.dark .main-content {
    background: #111111 !important;
    color: #f8efe5 !important;
}

body.dark .secondary-nav .header,
.dark .secondary-nav .header,
body.dark .haro-table-card,
.dark .haro-table-card,
body.dark .widget-content.widget-content-area,
.dark .widget-content.widget-content-area {
    background: rgba(25,21,18,.92) !important;
    border-color: rgba(201,162,74,.18) !important;
}

body.dark .page-title h3,
.dark .page-title h3,
body.dark table#zero-config tbody td,
.dark table#zero-config tbody td {
    color: #f8efe5 !important;
}

body.dark table#zero-config tbody td:first-child,
.dark table#zero-config tbody td:first-child,
body.dark table#zero-config tbody td:nth-child(2),
.dark table#zero-config tbody td:nth-child(2) {
    color: #fff3df !important;
}

body.dark .dt--top-section,
.dark .dt--top-section,
body.dark .dt--bottom-section,
.dark .dt--bottom-section {
    background: #181310 !important;
    border-color: rgba(255,255,255,.09) !important;
}

body.dark .dataTables_length select,
body.dark .dataTables_filter input,
.dark .dataTables_length select,
.dark .dataTables_filter input {
    background: #15110f !important;
    color: #f8efe5 !important;
    border-color: rgba(255,255,255,.12) !important;
}

@media (max-width: 768px) {
    .layout-px-spacing {
        padding: 22px 14px !important;
    }

    .secondary-nav .header {
        align-items: flex-start !important;
        padding: 18px !important;
    }

    .page-title h3 {
        font-size: 2rem !important;
    }

    .breadcrumb-action-dropdown {
        margin-top: 10px;
    }

    .breadcrumb-action-dropdown .btn {
        min-width: 138px !important;
        height: 44px !important;
    }

    .dataTables_filter input {
        min-width: 100%;
        width: 100% !important;
    }

    .dt--top-section .row {
        gap: 12px;
    }

    .dt--top-section .row > div {
        width: 100%;
    }

    table#zero-config thead th,
    table#zero-config tbody td {
        padding: 14px 12px !important;
    }
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
        $admin = new AdministradorEditor();

        ?>



        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Modelos">
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
                                            <span class="haro-eyebrow">Catálogos</span>
                                            <h3>Panel de administración de modelos</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Modelos</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item more-dropdown">
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a style="background-color: #5A9F19;" class="btn btn-succes mb-2 me-4 _effect--ripple waves-effect waves-light" href="cat-modelos-nuevo.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                                    <path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z" />
                                                    <path fill="#fff" d="M21,14h6v20h-6V14z" />
                                                    <path fill="#fff" d="M14,21h20v6H14V21z" />
                                                </svg>

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
                                <table class="table haro-data-table" id="zero-config">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Modelo</th>
                                            <th>Marca</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $modelos = $admin->dameModelos();
                                        foreach ($modelos as $modelos) {
                                            echo '
                        <tr>
                          <td>' . $modelos->id . '</td>
                          <td>' . $modelos->modelo . '</td>
                          <td>' . $modelos->marca . '</td>

                        </tr>';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                "sSearchPlaceholder": "Buscar modelo...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->


    <script>
        function baja(id) {

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

                    fetch("../api/apiUsuarios.php", {
                            method: "POST",
                            body: datos,
                        })
                        .then((respuesta) => respuesta.json())
                        .then((data) => {

                            console.log(data);

                            console.log("Registro Exitoso");
                            location.reload();
                        });
                }
            })




        }
    </script>

</body>

</html>
