<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Galería de imágenes — Haro</title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />

    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --bg-page:       #f0f2f7;
            --bg-card:       #ffffff;
            --bg-input:      #f8f9fc;
            --border:        #e4e7ef;
            --border-focus:  #3b82f6;
            --accent:        #2563eb;
            --accent-light:  rgba(37,99,235,0.08);
            --accent-red:    #dc2626;
            --accent-red-bg: rgba(220,38,38,0.07);
            --accent-green:  #16a34a;
            --accent-green-bg: rgba(22,163,74,0.08);
            --text-1:        #111827;
            --text-2:        #374151;
            --text-muted:    #9ca3af;
            --text-label:    #6b7280;
            --radius:        14px;
            --radius-sm:     9px;
            --ease:          0.22s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body.layout-boxed {
            background: var(--bg-page) !important;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-1);
        }

        /* Wrapper */
        .gallery-wrapper { padding: 28px 24px 100px; }

        /* Header */
        .gallery-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 22px;
        }

        .gallery-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 23px;
            font-weight: 800;
            color: var(--text-1);
            letter-spacing: -0.3px;
            line-height: 1.1;
        }

        .breadcrumb-track {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .breadcrumb-track span { color: var(--accent); font-weight: 500; }

        /* Stats */
        .stats-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }

        .stat-pill {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: 12.5px;
            color: var(--text-label);
            display: flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .stat-pill strong { color: var(--text-1); font-weight: 600; }

        .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }

        /* Banner */
        .update-banner {
            display: none;
            align-items: center;
            gap: 10px;
            background: var(--accent-green-bg);
            border: 1px solid rgba(22,163,74,0.22);
            border-radius: var(--radius-sm);
            padding: 11px 16px;
            margin-bottom: 16px;
            color: var(--accent-green);
            font-size: 13px;
            font-weight: 500;
        }

        .update-banner.show { display: flex; }

        .update-banner button {
            margin-left: auto;
            background: var(--accent-green);
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Syne', sans-serif;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .toolbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 13px;
            width: 230px;
            transition: border-color var(--ease), box-shadow var(--ease);
        }

        .toolbar-search:focus-within {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .toolbar-search input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-1);
            font-size: 13px;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .toolbar-search input::placeholder { color: var(--text-muted); }
        .toolbar-search svg { color: var(--text-muted); flex-shrink: 0; }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--accent);
            color: #fff !important;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(37,99,235,0.22);
            transition: background var(--ease), transform var(--ease), box-shadow var(--ease);
        }

        .btn-add:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.32);
        }

        /* ── Grid ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 16px;
        }

        /* ── Card ── */
        .img-card {
            background: var(--bg-card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;                /* bloquea cualquier desbordamiento */
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            transition: transform var(--ease), box-shadow var(--ease), border-color var(--ease);
            animation: cardIn .4s ease both;
            /* Evitar que el contenido interno expanda el ancho de la tarjeta */
            min-width: 0;
        }

        .img-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 36px rgba(0,0,0,0.09);
            border-color: rgba(37,99,235,0.25);
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .img-card:nth-child(1) { animation-delay:.04s }
        .img-card:nth-child(2) { animation-delay:.08s }
        .img-card:nth-child(3) { animation-delay:.12s }
        .img-card:nth-child(4) { animation-delay:.16s }
        .img-card:nth-child(5) { animation-delay:.20s }
        .img-card:nth-child(6) { animation-delay:.24s }
        .img-card:nth-child(7) { animation-delay:.28s }
        .img-card:nth-child(8) { animation-delay:.32s }

        /* Thumbnail */
        .img-card__thumb {
            position: relative;
            height: 180px;
            overflow: hidden;
            background: #e9ecf1;
            flex-shrink: 0;
        }

        .img-card__thumb img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .45s ease;
        }

        .img-card:hover .img-card__thumb img { transform: scale(1.06); }

        .img-card__badge {
            position: absolute;
            top: 9px; left: 9px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(0,0,0,0.07);
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            font-family: 'Syne', sans-serif;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }

        /* Body */
        .img-card__body {
            padding: 13px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
            /* Fundamental: evita que el body crezca horizontalmente */
            min-width: 0;
            width: 100%;
            overflow: hidden;
        }

        .img-card__label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 3px;
        }

        /* ──────────────────────────────────────────────────────
           SELECT WRAPPER — ancla Select2 al ancho de la tarjeta
           ────────────────────────────────────────────────────── */
        .select-wrapper {
            width: 100%;
            min-width: 0;
            /* Oculta cualquier desbordamiento del componente Select2 */
            overflow: hidden;
        }

        /* El contenedor que Select2 inyecta */
        .select-wrapper .select2-container {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            display: block !important;
        }

        /* La caja visible del trigger */
        .select2-container--default .select2-selection--single {
            background: var(--bg-input) !important;
            border: 1.5px solid var(--border) !important;
            border-radius: var(--radius-sm) !important;
            height: 38px !important;
            transition: border-color var(--ease) !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open  .select2-selection--single {
            border-color: var(--border-focus) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
            outline: none !important;
        }

        /* Texto seleccionado — SIEMPRE truncado */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-2) !important;
            font-size: 13px !important;
            font-family: 'DM Sans', sans-serif !important;
            line-height: 38px !important;
            padding-left: 11px !important;
            padding-right: 30px !important;
            /* Truncar texto largo — clave para que la card no crezca */
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            display: block !important;
            max-width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-muted) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            right: 8px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-label) transparent transparent transparent !important;
        }

        /* Dropdown flotante (position:absolute — NO altera el flujo del DOM) */
        .select2-dropdown {
            background: #fff !important;
            border: 1.5px solid var(--border) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 28px rgba(0,0,0,0.11) !important;
            font-family: 'DM Sans', sans-serif !important;
            overflow: hidden;
            /* Limitar al ancho del trigger — se refuerza en JS */
            max-width: 100%;
        }

        .select2-container--default .select2-search--dropdown {
            padding: 8px 8px 4px !important;
            border-bottom: 1px solid var(--border) !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            background: var(--bg-input) !important;
            border: 1.5px solid var(--border) !important;
            border-radius: 7px !important;
            color: var(--text-1) !important;
            font-size: 13px !important;
            padding: 7px 10px !important;
            font-family: 'DM Sans', sans-serif !important;
            outline: none !important;
            width: 100% !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--border-focus) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
        }

        .select2-results__options {
            max-height: 195px !important;
            overflow-y: auto !important;
        }

        .select2-container--default .select2-results__option {
            color: var(--text-2) !important;
            font-size: 13px !important;
            padding: 8px 13px !important;
            transition: background .12s !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .select2-container--default .select2-results__option--highlighted {
            background: var(--accent-light) !important;
            color: var(--accent) !important;
        }

        .select2-container--default .select2-results__option[aria-selected="true"] {
            background: rgba(37,99,235,0.06) !important;
            color: var(--accent) !important;
            font-weight: 500 !important;
        }

        .select2-container--default .select2-results__option:first-child {
            color: var(--text-muted) !important;
            font-style: italic;
        }

        /* ── Acciones ── */
        .img-card__actions { display: flex; gap: 7px; }

        .btn-assign {
            flex: 1;
            background: var(--accent-light);
            color: var(--accent);
            border: 1.5px solid rgba(37,99,235,0.18);
            border-radius: var(--radius-sm);
            padding: 8px 0;
            font-size: 12px;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            cursor: pointer;
            transition: background var(--ease), transform var(--ease);
        }

        .btn-assign:hover { background: rgba(37,99,235,0.14); transform: translateY(-1px); }

        .btn-delete {
            background: var(--accent-red-bg);
            color: var(--accent-red);
            border: 1.5px solid rgba(220,38,38,0.16);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background var(--ease), transform var(--ease);
        }

        .btn-delete:hover { background: rgba(220,38,38,0.14); transform: translateY(-1px); }
        .btn-delete svg { width: 14px; height: 14px; pointer-events: none; }

        /* Empty */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 72px 20px;
            color: var(--text-muted);
        }

        .empty-state svg { opacity:.25; margin-bottom:14px; }
        .empty-state p { font-size: 14px; }

        /* FAB */
        .fab-save {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px 24px;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .2px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 999;
            box-shadow: 0 6px 22px rgba(37,99,235,0.32);
            transition: transform var(--ease), box-shadow var(--ease), background var(--ease);
        }

        .fab-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(37,99,235,0.42);
            background: #1d4ed8;
        }

        .fab-save svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* Responsive */
        @media (max-width: 768px) {
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .toolbar-search { width: 100%; }
        }

        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; }
            .fab-save { bottom: 14px; right: 14px; padding: 11px 18px; font-size: 12px; }
        }
    </style>

<style id="haro-gallery-final">
/* ==========================================================
   GALERÍA HARO - ESTILO DASHBOARD
   Solo diseño. No modifica PHP, JS ni funcionalidad.
========================================================== */

:root{
    --haro-bg:#f4f1ea;
    --haro-paper:rgba(255,255,255,.90);
    --haro-black:#0b0b0d;
    --haro-ink:#161616;
    --haro-muted:#77736b;
    --haro-red:#b0141b;
    --haro-gold:#c9a24a;
    --haro-line:rgba(19,19,22,.08);
    --haro-line-gold:rgba(201,162,74,.20);
    --haro-radius:26px;
    --haro-shadow:0 18px 48px rgba(15,15,18,.09);
    --haro-transition:220ms cubic-bezier(.4,0,.2,1);
}

body.layout-boxed{
    background:
        radial-gradient(circle at top right,rgba(201,162,74,.16),transparent 32%),
        radial-gradient(circle at 7% 24%,rgba(176,20,27,.07),transparent 28%),
        linear-gradient(180deg,#fbf8f1 0%,var(--haro-bg) 46%,#eee8dc 100%)!important;
    font-family:'DM Sans','Nunito',sans-serif!important;
    color:var(--haro-ink)!important;
}

#load_screen{background:var(--haro-bg)!important;}
#load_screen .spinner-grow{background-color:var(--haro-red)!important;color:var(--haro-red)!important;}

.layout-px-spacing{padding:30px 26px!important;}

.gallery-wrapper{
    padding:0 0 96px!important;
}

.gallery-header{
    background:var(--haro-paper)!important;
    border:1px solid var(--haro-line-gold)!important;
    border-radius:var(--haro-radius)!important;
    padding:22px 24px!important;
    box-shadow:var(--haro-shadow)!important;
    backdrop-filter:blur(14px);
    position:relative;
    overflow:hidden;
    margin-bottom:22px!important;
}

.gallery-header::before{
    content:"";
    position:absolute;
    inset:0 0 auto 0;
    height:4px;
    background:linear-gradient(90deg,var(--haro-red),var(--haro-gold),var(--haro-red));
}

.gallery-header h1{
    color:var(--haro-black)!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:clamp(2rem,3vw,3.05rem)!important;
    font-weight:400!important;
    letter-spacing:.035em!important;
    line-height:.94!important;
    text-transform:uppercase;
    margin:0!important;
}

.gallery-header h1::before{
    content:"Galería";
    display:inline-flex;
    align-items:center;
    gap:9px;
    color:var(--haro-red);
    font-family:'Bebas Neue',sans-serif;
    font-size:1.05rem;
    letter-spacing:.09em;
    text-transform:uppercase;
    margin-bottom:8px;
    width:100%;
}

.breadcrumb-track{
    margin-top:10px!important;
    color:var(--haro-muted)!important;
    font-size:.8rem!important;
    font-weight:700!important;
}

.breadcrumb-track span{
    color:var(--haro-red)!important;
    font-weight:700!important;
}

.stats-bar{
    gap:12px!important;
    margin-bottom:22px!important;
}

.stat-pill{
    background:var(--haro-paper)!important;
    border:1px solid var(--haro-line-gold)!important;
    border-radius:999px!important;
    padding:9px 18px!important;
    box-shadow:0 10px 24px rgba(16,15,12,.07)!important;
    color:var(--haro-muted)!important;
    font-family:'DM Sans',sans-serif!important;
    font-weight:700;
}

.stat-pill strong{
    color:var(--haro-black)!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1.15rem;
    font-weight:400!important;
    letter-spacing:.05em;
}

.dot[style*="#2563eb"],
.dot[style*="#16a34a"]{
    background:var(--haro-gold)!important;
}

.update-banner{
    background:rgba(255,255,255,.88)!important;
    border:1px solid rgba(201,162,74,.22)!important;
    border-radius:18px!important;
    color:var(--haro-red)!important;
    box-shadow:0 12px 28px rgba(16,15,12,.08)!important;
    font-weight:700!important;
}

.update-banner button{
    background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;
    border-radius:13px!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-weight:400!important;
    letter-spacing:.07em;
    font-size:1rem!important;
}

.toolbar{
    margin-bottom:24px!important;
}

.toolbar-search{
    width:280px!important;
    background:#fff!important;
    border:1px solid rgba(201,162,74,.23)!important;
    border-radius:16px!important;
    min-height:46px;
    box-shadow:0 10px 24px rgba(16,15,12,.06);
}

.toolbar-search:focus-within{
    border-color:rgba(176,20,27,.42)!important;
    box-shadow:0 0 0 4px rgba(176,20,27,.10)!important;
}

.toolbar-search input{
    font-family:'DM Sans',sans-serif!important;
    font-weight:600!important;
    color:var(--haro-ink)!important;
}

.btn-add{
    min-height:48px;
    padding:11px 20px!important;
    border-radius:16px!important;
    background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;
    border:1px solid rgba(201,162,74,.26)!important;
    color:#fff!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1.1rem!important;
    font-weight:400!important;
    letter-spacing:.07em!important;
    text-transform:uppercase;
    box-shadow:0 14px 30px rgba(176,20,27,.22)!important;
}

.btn-add:hover{
    background:linear-gradient(135deg,#c31d28,#7d1118)!important;
    box-shadow:0 18px 38px rgba(176,20,27,.28)!important;
}

.gallery-grid{
    grid-template-columns:repeat(auto-fill,minmax(250px,1fr))!important;
    gap:20px!important;
}

.img-card{
    background:var(--haro-paper)!important;
    border:1px solid var(--haro-line-gold)!important;
    border-radius:24px!important;
    box-shadow:var(--haro-shadow)!important;
    backdrop-filter:blur(12px);
    overflow:hidden!important;
}

.img-card:hover{
    transform:translateY(-5px)!important;
    border-color:rgba(176,20,27,.26)!important;
    box-shadow:0 24px 58px rgba(15,15,18,.13)!important;
}

.img-card__thumb{
    height:190px!important;
    background:#181411!important;
}

.img-card__thumb::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(180deg,rgba(0,0,0,0),rgba(11,11,13,.28));
    pointer-events:none;
}

.img-card__badge{
    background:rgba(255,250,243,.94)!important;
    border:1px solid rgba(201,162,74,.28)!important;
    color:var(--haro-red)!important;
    border-radius:999px!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1rem!important;
    font-weight:400!important;
    letter-spacing:.05em;
    padding:4px 12px!important;
}

.img-card__body{
    padding:16px!important;
    gap:12px!important;
}

.img-card__label{
    color:var(--haro-red)!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1rem!important;
    font-weight:400!important;
    letter-spacing:.08em!important;
    margin-bottom:7px!important;
}

.select2-container--default .select2-selection--single{
    background:#fff!important;
    border:1px solid rgba(201,162,74,.24)!important;
    border-radius:14px!important;
    height:44px!important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered{
    color:var(--haro-ink)!important;
    font-family:'DM Sans',sans-serif!important;
    line-height:44px!important;
    font-weight:600!important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow{
    height:44px!important;
}

.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single{
    border-color:var(--haro-red)!important;
    box-shadow:0 0 0 4px rgba(176,20,27,.10)!important;
}

.select2-dropdown{
    border:1px solid rgba(201,162,74,.24)!important;
    border-radius:16px!important;
    box-shadow:0 20px 44px rgba(15,15,18,.14)!important;
}

.select2-container--default .select2-results__option--highlighted{
    background:rgba(176,20,27,.10)!important;
    color:var(--haro-red)!important;
}

.img-card__actions{
    gap:9px!important;
}

.btn-assign{
    background:rgba(176,20,27,.10)!important;
    border:1px solid rgba(176,20,27,.18)!important;
    color:var(--haro-red)!important;
    border-radius:14px!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1.05rem!important;
    font-weight:400!important;
    letter-spacing:.07em!important;
    text-transform:uppercase;
}

.btn-assign:hover{
    background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;
    color:#fff!important;
}

.btn-delete{
    background:rgba(17,17,17,.06)!important;
    border:1px solid rgba(17,17,17,.10)!important;
    color:var(--haro-black)!important;
    border-radius:14px!important;
}

.btn-delete:hover{
    background:rgba(176,20,27,.12)!important;
    color:var(--haro-red)!important;
}

.fab-save{
    background:linear-gradient(135deg,var(--haro-red),#7d1118)!important;
    border:1px solid rgba(201,162,74,.26)!important;
    border-radius:18px!important;
    font-family:'Bebas Neue',sans-serif!important;
    font-size:1.15rem!important;
    font-weight:400!important;
    letter-spacing:.08em!important;
    text-transform:uppercase;
    box-shadow:0 18px 42px rgba(176,20,27,.30)!important;
}

.fab-save:hover{
    background:linear-gradient(135deg,#c31d28,#7d1118)!important;
    box-shadow:0 24px 52px rgba(176,20,27,.38)!important;
}

.empty-state{
    background:var(--haro-paper);
    border:1px solid var(--haro-line-gold);
    border-radius:var(--haro-radius);
    box-shadow:var(--haro-shadow);
}

.empty-state p{
    color:var(--haro-muted)!important;
    font-family:'DM Sans',sans-serif!important;
    font-weight:700;
}

.haro-footer{
    margin-top:34px!important;
}

@media(max-width:768px){
    .layout-px-spacing{padding:22px 14px!important;}
    .gallery-header{padding:18px!important;}
    .gallery-grid{grid-template-columns:1fr 1fr!important;gap:14px!important;}
    .toolbar-search{width:100%!important;}
    .btn-add{width:100%;justify-content:center;}
}

@media(max-width:480px){
    .gallery-grid{grid-template-columns:1fr!important;}
    .fab-save{left:14px;right:14px;justify-content:center;}
}
</style>


<style id="haro-auto-search-select-rendered">
/* ==========================================================
   BUSCADOR POR CADA AUTO RENDERIZADO
   Mantiene intacto el <select> original y sus valores.
   El componente solo agrega una capa visual buscable.
========================================================== */
.img-select.haro-search-source {
    display: none !important;
}

.haro-auto-search-select {
    width: 100%;
    min-width: 0;
    position: relative;
}

.haro-auto-search-select__button {
    width: 100%;
    min-height: 44px;
    background: #fff;
    border: 1px solid rgba(201,162,74,.24);
    border-radius: 14px;
    color: var(--haro-ink, #161616);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 0 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    outline: none;
    transition: border-color var(--haro-transition, 220ms ease), box-shadow var(--haro-transition, 220ms ease);
}

.haro-auto-search-select__button:hover,
.haro-auto-search-select.is-open .haro-auto-search-select__button,
.haro-auto-search-select__button:focus {
    border-color: var(--haro-red, #b0141b);
    box-shadow: 0 0 0 4px rgba(176,20,27,.10);
}

.haro-auto-search-select__text {
    display: block;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-align: left;
}

.haro-auto-search-select__arrow {
    width: 8px;
    height: 8px;
    border-right: 2px solid var(--haro-muted, #77736b);
    border-bottom: 2px solid var(--haro-muted, #77736b);
    transform: rotate(45deg) translateY(-2px);
    flex: 0 0 auto;
    transition: transform var(--haro-transition, 220ms ease);
}

.haro-auto-search-select.is-open .haro-auto-search-select__arrow {
    transform: rotate(225deg) translateY(-2px);
}

.haro-auto-search-dropdown {
    position: absolute;
    z-index: 99999;
    background: #fff;
    border: 1px solid rgba(201,162,74,.24);
    border-radius: 16px;
    box-shadow: 0 20px 44px rgba(15,15,18,.14);
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}

.haro-auto-search-dropdown__search-wrap {
    padding: 9px;
    border-bottom: 1px solid rgba(201,162,74,.18);
    background: #fffaf3;
}

.haro-auto-search-dropdown__search {
    width: 100%;
    min-height: 38px;
    background: #fff;
    border: 1px solid rgba(201,162,74,.24);
    border-radius: 10px;
    color: var(--haro-ink, #161616);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    outline: none;
    padding: 0 11px;
}

.haro-auto-search-dropdown__search:focus {
    border-color: var(--haro-red, #b0141b);
    box-shadow: 0 0 0 3px rgba(176,20,27,.10);
}

.haro-auto-search-dropdown__options {
    max-height: 230px;
    overflow-y: auto;
    padding: 6px;
}

.haro-auto-search-dropdown__option {
    width: 100%;
    background: transparent;
    border: 0;
    border-radius: 10px;
    color: var(--haro-ink, #161616);
    display: block;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    overflow: hidden;
    padding: 9px 10px;
    text-align: left;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
}

.haro-auto-search-dropdown__option:hover,
.haro-auto-search-dropdown__option.is-selected {
    background: rgba(176,20,27,.10);
    color: var(--haro-red, #b0141b);
}

.haro-auto-search-dropdown__option:first-child {
    color: var(--haro-muted, #77736b);
    font-style: italic;
}

.haro-auto-search-dropdown__empty {
    color: var(--haro-muted, #77736b);
    font-size: 13px;
    font-weight: 600;
    padding: 12px 10px;
    text-align: center;
}
</style>

</head>

<body class="layout-boxed enable-secondaryNav">

    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <?php include_once("template/barra_nav.php") ?>

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include("template/barra.php") ?>
        <?php
            include_once("../api/adminAutos.php");
            include_once("../api/adminUsuarios.php");
            $adminUsuarios = new administradorUsuarios();
            $usuarios      = $adminUsuarios->dameUsuarios();
            $admin         = new AdministradorAutos();
            $autos         = $admin->dameAutos();
            $imagenes      = $admin->dameImagenesSinAuto();
            $totalImagenes = count($imagenes);
            $totalAutos    = count($autos);
        ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="gallery-wrapper">

                        <!-- Header -->
                        <div class="gallery-header">
                            <div>
                                <h1>Galería de imágenes</h1>
                                <div class="breadcrumb-track">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                    Dashboard
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                                    <span>Galería</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="stats-bar">
                            <div class="stat-pill">
                                <div class="dot" style="background:#2563eb"></div>
                                <strong><?php echo $totalImagenes; ?></strong> imágenes sin asignar
                            </div>
                            <div class="stat-pill">
                                <div class="dot" style="background:#16a34a"></div>
                                <strong><?php echo $totalAutos; ?></strong> vehículos disponibles
                            </div>
                        </div>

                        <!-- Banner -->
                        <div id="updateBanner" class="update-banner">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            Nuevas imágenes disponibles para asignar.
                            <button onclick="location.reload()">Actualizar</button>
                        </div>

                        <!-- Toolbar -->
                        <div class="toolbar">
                            <div class="toolbar-search">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input type="text" placeholder="Filtrar por ID…" oninput="filtrarTarjetas(this.value)">
                            </div>
                            <a href="./auto-nuevo.php" class="btn-add">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Nuevo vehículo
                            </a>
                        </div>

                        <!-- Grid -->
                        <div class="gallery-grid" id="galleryGrid">

                            <?php if (empty($imagenes)): ?>
                            <div class="empty-state">
                                <svg width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <p>No hay imágenes sin asignar</p>
                            </div>
                            <?php else: ?>

                            <?php foreach ($imagenes as $imagen): ?>
                            <div class="img-card" data-id="<?php echo $imagen->id; ?>">

                                <div class="img-card__thumb">
                                    <img src="<?php echo htmlspecialchars($imagen->url); ?>"
                                         alt="Imagen <?php echo $imagen->id; ?>"
                                         loading="lazy"
                                         onerror="this.src='media/placeholder.png'">
                                    <span class="img-card__badge">#<?php echo $imagen->id; ?></span>
                                </div>

                                <div class="img-card__body">
                                    <div class="select-wrapper">
                                        <p class="img-card__label">Asignar a vehículo</p>
                                        <select class="img-select haro-search-source"
                                                data-imagen-id="<?php echo $imagen->id; ?>"
                                                data-haro-placeholder="Buscar auto…">
                                            <option value="0">Selecciona un auto…</option>
                                            <?php foreach ($autos as $auto): ?>
                                            <option value="<?php echo $auto->id . ',' . $imagen->id; ?>">
                                                <?php echo htmlspecialchars($auto->marca->marca . ' ' . $auto->modelo->modelo); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="img-card__actions">
                                        <button class="btn-assign"
                                                onclick="guardarIndividual(<?php echo $imagen->id; ?>, this)">
                                            Asignar
                                        </button>
                                        <button class="btn-delete"
                                                onclick="funcionEliminar(<?php echo $imagen->id; ?>, this)">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <?php endif; ?>
                        </div>

                    </div>

                    <?php include_once("template/footer_haro.php"); ?></div>
            </div>
        </div>

        <button class="fab-save" onclick="enviarImagen()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Guardar cambios
        </button>
    </div>

    <!-- Scripts globales -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <script src="../src/assets/js/custom.js"></script>
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <script src="../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    /* ── Buscador visual por cada selector de auto renderizado ── */
    var haroAutoSearchActivo = null;

    function normalizarTextoBuscadorHaro(texto) {
        return String(texto || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function cerrarBuscadorAutoHaro() {
        if (!haroAutoSearchActivo) return;
        haroAutoSearchActivo.wrapper.classList.remove('is-open');
        if (haroAutoSearchActivo.dropdown && haroAutoSearchActivo.dropdown.parentNode) {
            haroAutoSearchActivo.dropdown.parentNode.removeChild(haroAutoSearchActivo.dropdown);
        }
        haroAutoSearchActivo = null;
    }

    function posicionarDropdownAutoHaro(instancia) {
        if (!instancia || !instancia.dropdown) return;
        var rect = instancia.wrapper.getBoundingClientRect();
        var top = rect.bottom + window.pageYOffset + 6;
        var left = rect.left + window.pageXOffset;
        instancia.dropdown.style.top = top + 'px';
        instancia.dropdown.style.left = left + 'px';
        instancia.dropdown.style.width = rect.width + 'px';
        instancia.dropdown.style.maxWidth = rect.width + 'px';
    }

    function sincronizarTextoAutoHaro(instancia) {
        var select = instancia.select;
        var opcion = select.options[select.selectedIndex];
        instancia.textNode.textContent = opcion ? opcion.text : (select.getAttribute('data-haro-placeholder') || 'Selecciona un auto…');
    }

    function elegirOpcionAutoHaro(instancia, indice) {
        instancia.select.selectedIndex = indice;
        sincronizarTextoAutoHaro(instancia);
        instancia.select.dispatchEvent(new Event('change', { bubbles: true }));
        cerrarBuscadorAutoHaro();
    }

    function renderizarOpcionesAutoHaro(instancia, filtroTexto) {
        var filtroNormalizado = normalizarTextoBuscadorHaro(filtroTexto);
        var select = instancia.select;
        var opciones = instancia.optionsList;
        opciones.innerHTML = '';

        var encontrados = 0;
        for (var i = 0; i < select.options.length; i++) {
            var opcion = select.options[i];
            var texto = opcion.text || '';
            var textoNormalizado = normalizarTextoBuscadorHaro(texto);

            if (filtroNormalizado && textoNormalizado.indexOf(filtroNormalizado) === -1) {
                continue;
            }

            encontrados++;
            var item = document.createElement('button');
            item.type = 'button';
            item.className = 'haro-auto-search-dropdown__option';
            if (i === select.selectedIndex) item.className += ' is-selected';
            item.textContent = texto;
            item.setAttribute('data-index', i);
            item.addEventListener('click', function () {
                elegirOpcionAutoHaro(instancia, parseInt(this.getAttribute('data-index'), 10));
            });
            opciones.appendChild(item);
        }

        if (!encontrados) {
            var empty = document.createElement('div');
            empty.className = 'haro-auto-search-dropdown__empty';
            empty.textContent = 'Sin resultados';
            opciones.appendChild(empty);
        }
    }

    function abrirBuscadorAutoHaro(instancia) {
        if (haroAutoSearchActivo && haroAutoSearchActivo !== instancia) {
            cerrarBuscadorAutoHaro();
        }

        instancia.dropdown = document.createElement('div');
        instancia.dropdown.className = 'haro-auto-search-dropdown';
        instancia.dropdown.innerHTML = '<div class="haro-auto-search-dropdown__search-wrap"><input type="text" class="haro-auto-search-dropdown__search" placeholder="Buscar auto..."></div><div class="haro-auto-search-dropdown__options"></div>';

        instancia.searchInput = instancia.dropdown.querySelector('.haro-auto-search-dropdown__search');
        instancia.optionsList = instancia.dropdown.querySelector('.haro-auto-search-dropdown__options');

        instancia.searchInput.addEventListener('keyup', function () {
            renderizarOpcionesAutoHaro(instancia, instancia.searchInput.value);
        });
        instancia.searchInput.addEventListener('click', function (e) {
            e.stopPropagation();
        });
        instancia.dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.body.appendChild(instancia.dropdown);
        instancia.wrapper.classList.add('is-open');
        haroAutoSearchActivo = instancia;

        renderizarOpcionesAutoHaro(instancia, '');
        posicionarDropdownAutoHaro(instancia);
        setTimeout(function () { instancia.searchInput.focus(); }, 0);
    }

    function inicializarBuscadorAutoHaro(select) {
        if (!select || select.haroAutoSearchSelect) return;

        var wrapper = document.createElement('div');
        wrapper.className = 'haro-auto-search-select';

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'haro-auto-search-select__button';

        var textNode = document.createElement('span');
        textNode.className = 'haro-auto-search-select__text';

        var arrow = document.createElement('span');
        arrow.className = 'haro-auto-search-select__arrow';

        button.appendChild(textNode);
        button.appendChild(arrow);
        wrapper.appendChild(button);
        select.parentNode.insertBefore(wrapper, select.nextSibling);

        var instancia = {
            select: select,
            wrapper: wrapper,
            button: button,
            textNode: textNode,
            dropdown: null,
            searchInput: null,
            optionsList: null
        };

        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (haroAutoSearchActivo === instancia) {
                cerrarBuscadorAutoHaro();
            } else {
                abrirBuscadorAutoHaro(instancia);
            }
        });

        select.addEventListener('change', function () {
            sincronizarTextoAutoHaro(instancia);
        });

        select.haroAutoSearchSelect = instancia;
        sincronizarTextoAutoHaro(instancia);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.img-select').forEach(function (select) {
            inicializarBuscadorAutoHaro(select);

            select.addEventListener('change', function () {
                var val = this.value;
                if (val && val !== '0') asignarValores(val);
            });
        });
    });

    document.addEventListener('click', function (e) {
        if (!haroAutoSearchActivo) return;
        if (!haroAutoSearchActivo.wrapper.contains(e.target) && !haroAutoSearchActivo.dropdown.contains(e.target)) {
            cerrarBuscadorAutoHaro();
        }
    });

    window.addEventListener('resize', function () {
        if (haroAutoSearchActivo) posicionarDropdownAutoHaro(haroAutoSearchActivo);
    });

    window.addEventListener('scroll', function () {
        if (haroAutoSearchActivo) posicionarDropdownAutoHaro(haroAutoSearchActivo);
    }, true);

    /* ── Filtrar tarjetas ── */
    function filtrarTarjetas(q) {
        document.querySelectorAll('.img-card').forEach(function (card) {
            card.style.display = (!q || card.dataset.id.includes(q.trim())) ? '' : 'none';
        });
    }

    /* ── Arreglo de asignaciones ── */
    var arreglo = [];

    function asignarValores(valor) {
        if (!valor || valor === '0') return;
        var p = valor.split(',');
        if (p.length < 2) return;
        var idx = arreglo.findIndex(function (x) { return x.imagen === p[1]; });
        var par = { auto: p[0], imagen: p[1] };
        if (idx !== -1) arreglo[idx] = par;
        else arreglo.push(par);
    }

    /* ── Guardar individual ── */
    async function guardarIndividual(imagenId, btn) {
        cerrarBuscadorAutoHaro();
        var par = arreglo.find(function (p) { return p.imagen == imagenId; });
        if (!par || par.auto === '0') {
            Swal.fire({ icon: 'warning', title: 'Selecciona un auto',
                text: 'Elige un vehículo antes de asignar.', confirmButtonColor: '#2563eb' });
            return;
        }
        btn.disabled = true;
        btn.textContent = '…';

        var form = new FormData();
        form.append('accion', 'asignar');
        form.append('id', par.imagen);
        form.append('auto', par.auto);

        try {
            var data = await fetch('../api/apiAuto.php', { method: 'POST', body: form }).then(function (r) { return r.json(); });
            if (data == 1) {
                var card = btn.closest('.img-card');
                card.style.transition = 'opacity .32s, transform .32s';
                card.style.opacity    = '0';
                card.style.transform  = 'scale(0.92)';
                setTimeout(function () { card.remove(); }, 340);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo asignar la imagen.', confirmButtonColor: '#2563eb' });
                btn.disabled = false; btn.textContent = 'Asignar';
            }
        } catch (e) { btn.disabled = false; btn.textContent = 'Asignar'; }
    }

    /* ── Guardar todos (FAB) ── */
    var contador = 0;

    function enviarImagen() {
        if (!arreglo.length) {
            Swal.fire({ icon: 'info', title: 'Sin cambios',
                text: 'No hay selecciones pendientes.', confirmButtonColor: '#2563eb' });
            return;
        }
        contador = 0;
        procesarSiguiente();
    }

    function procesarSiguiente() {
        if (contador < arreglo.length) {
            (async function () {
                var form = new FormData();
                form.append('accion', 'asignar');
                form.append('id',   arreglo[contador].imagen);
                form.append('auto', arreglo[contador].auto);
                await fetch('../api/apiAuto.php', { method: 'POST', body: form });
                contador++;
                procesarSiguiente();
            })();
        } else {
            Swal.fire({ icon: 'success', title: '¡Guardado!',
                text: 'Todos los cambios fueron guardados.', confirmButtonColor: '#2563eb',
                timer: 2000, showConfirmButton: false
            }).then(function () { location.reload(); });
        }
    }

    /* ── Eliminar ── */
    function funcionEliminar(id, btn) {
        cerrarBuscadorAutoHaro();
        Swal.fire({
            title: '¿Eliminar imagen?', text: 'Esta acción no se puede revertir.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#2563eb', cancelButtonColor: '#dc2626',
            confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(async function (result) {
            if (!result.isConfirmed) return;
            var card = btn.closest('.img-card');
            var form = new FormData();
            form.append('accion', 'bimagen');
            form.append('id', id);
            var data = await fetch('../api/apiAuto.php', { method: 'POST', body: form }).then(function (r) { return r.json(); });
            if (data == 1) {
                card.style.transition = 'opacity .32s, transform .32s';
                card.style.opacity    = '0';
                card.style.transform  = 'scale(0.88)';
                setTimeout(function () { card.remove(); }, 340);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo eliminar.', confirmButtonColor: '#2563eb' });
            }
        });
    }

    /* ── Banner nuevas imágenes ── */
    fetch('../api/recividorEmail.php', { method: 'POST' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data == '1') document.getElementById('updateBanner').classList.add('show');
        });
    </script>
</body>
</html>