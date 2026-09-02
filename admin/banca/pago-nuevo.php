<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Pagos - Haro</title>
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

        .haro-form-card .widget-content {
            padding:28px !important;
            background:transparent !important;
        }

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

        .haro-form-subtitle {
            color:rgba(255,246,232,.68);
            font-size:13px;
            margin:6px 0 0;
            max-width:620px;
        }

        #formulario {
            row-gap:18px;
        }

        #formulario > div {
            background:rgba(255,255,255,.48);
            border:1px solid rgba(31,27,24,.08);
            border-radius:18px;
            padding:16px;
            transition:border-color var(--haro-transition), box-shadow var(--haro-transition), transform var(--haro-transition);
        }

        #formulario > div:focus-within {
            border-color:rgba(159,29,29,.34);
            box-shadow:0 0 0 4px rgba(159,29,29,.08);
            transform:translateY(-1px);
        }

        #formulario label,
        #formulario .form-label {
            color:var(--haro-ink) !important;
            font-family:'Bebas Neue',sans-serif;
            font-size:12px;
            font-weight:400;
            letter-spacing:.06em;
            text-transform:uppercase;
            margin-bottom:8px;
        }

        #formulario .form-control,
        #formulario .form-select,
        #formulario select,
        #formulario input {
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

        #formulario .form-control:focus,
        #formulario .form-select:focus,
        #formulario select:focus,
        #formulario input:focus {
            border-color:var(--haro-red) !important;
            box-shadow:0 0 0 4px rgba(159,29,29,.10) !important;
        }

        #formulario input[readonly] {
            background:rgba(196,154,74,.11) !important;
            color:#7b551c !important;
            border-color:rgba(196,154,74,.22) !important;
        }

        .btn-haro-submit {
            background:linear-gradient(135deg,var(--haro-red),#6f1818) !important;
            border:1px solid rgba(196,154,74,.28) !important;
            color:#fff !important;
            border-radius:15px !important;
            min-height:48px;
            padding:12px 28px !important;
            font-family:'Bebas Neue',sans-serif !important;
            font-weight:400 !important;
            letter-spacing:.04em;
            text-transform:uppercase;
            box-shadow:0 14px 28px rgba(159,29,29,.24);
            transition:transform var(--haro-transition), box-shadow var(--haro-transition);
        }

        .btn-haro-submit:hover {
            transform:translateY(-2px);
            box-shadow:0 18px 34px rgba(159,29,29,.32);
        }

        .footer-wrapper {
            background:transparent !important;
            border-top:1px solid var(--haro-border) !important;
            color:var(--haro-muted) !important;
            padding:22px 28px !important;
            font-family:'DM Sans',sans-serif !important;
            font-size:13px;
        }

        .footer-wrapper a { color:var(--haro-red) !important; font-weight:400; }

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

        html[data-theme="dark"] #formulario > div,
        body.dark #formulario > div {
            background:rgba(255,255,255,.035);
            border-color:rgba(196,154,74,.16);
        }

        html[data-theme="dark"] #formulario label,
        body.dark #formulario label { color:#fff5e8 !important; }

        html[data-theme="dark"] #formulario .form-control,
        html[data-theme="dark"] #formulario .form-select,
        html[data-theme="dark"] #formulario select,
        html[data-theme="dark"] #formulario input,
        body.dark #formulario .form-control,
        body.dark #formulario .form-select,
        body.dark #formulario select,
        body.dark #formulario input {
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
            #formulario > div { padding:14px; }
            .btn-haro-submit { width:100%; }
        }
    </style>


    <style>
        :root {
            --haro-black: #0b0b0d;
            --haro-900: #131316;
            --haro-red: #b0141b;
            --haro-gold: #c9a24a;
            --haro-gold-soft: rgba(201, 162, 74, .14);
            --haro-red-soft: rgba(176, 20, 27, .12);
            --page: #f4f1ea;
            --paper: #ffffff;
            --line: rgba(19, 19, 22, .09);
            --text: #161616;
            --muted: #77736b;
            --radius-lg: 26px;
            --shadow-sm: 0 10px 28px rgba(15, 15, 18, .08);
            --transition: 220ms cubic-bezier(.4,0,.2,1);
        }

        body.layout-boxed {
            background:
                radial-gradient(circle at top right, rgba(201,162,74,.14), transparent 32%),
                linear-gradient(180deg, #fbf8f1 0%, var(--page) 44%, #eee8dc 100%) !important;
            font-family: 'DM Sans', 'Nunito', sans-serif !important;
            color: var(--text) !important;
            -webkit-font-smoothing: antialiased;
        }

        #load_screen { background: var(--page) !important; }
        #load_screen .spinner-grow { background-color: var(--haro-red) !important; color: var(--haro-red) !important; }

        .layout-px-spacing { padding: 30px 26px !important; }
        .secondary-nav { background: transparent !important; box-shadow: none !important; margin-bottom: 18px; }

        .breadcrumbs-container .header,
        .secondary-nav .header {
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(201,162,74,.20) !important;
            border-radius: var(--radius-lg) !important;
            padding: 18px 22px !important;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(14px);
        }

        .btn-toggle.sidebarCollapse {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--haro-900);
            color: #fff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            box-shadow: 0 10px 22px rgba(19,19,22,.16);
            transition: transform var(--transition), background var(--transition);
        }

        .btn-toggle.sidebarCollapse:hover {
            background: var(--haro-red);
            transform: translateY(-2px);
        }

        .page-title h3,
        .haro-page-title .haro-eyebrow,
        .haro-form-header h4,
        #formulario label,
        #formulario .form-label,
        .btn-haro-submit {
            font-family: 'Bebas Neue', sans-serif !important;
            font-weight: 400 !important;
            letter-spacing: .05em !important;
        }

        .page-title h3 {
            font-size: clamp(1.8rem, 2.8vw, 2.8rem) !important;
            line-height: .96 !important;
            color: var(--haro-900) !important;
            margin: 0 !important;
        }

        .haro-page-title .haro-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--haro-red) !important;
            font-size: 1rem !important;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .haro-page-title .haro-eyebrow::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 99px;
            background: var(--haro-gold);
        }

        .breadcrumb-style-one .breadcrumb { margin-top: 8px !important; }
        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            color: var(--muted) !important;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none !important;
        }
        .breadcrumb-style-one .breadcrumb-item.active { color: var(--haro-red) !important; }

        .haro-form-card {
            background: rgba(255,255,255,.88) !important;
            border: 1px solid rgba(201,162,74,.18) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm) !important;
            backdrop-filter: blur(12px);
            overflow: hidden;
        }

        .haro-form-card::before {
            content: "";
            display: block;
            height: 4px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
        }

        .haro-form-card .widget-content {
            padding: 28px !important;
            background: transparent !important;
        }

        .haro-form-header {
            padding: 26px 28px 20px !important;
            background: linear-gradient(135deg, #181411 0%, #2a1715 58%, #6f1818 100%) !important;
            border-bottom: 1px solid rgba(201,162,74,.22) !important;
        }

        .haro-form-header h4 {
            color: #fff6e8 !important;
            font-size: clamp(1.8rem, 2.6vw, 2.5rem) !important;
            line-height: .95;
            margin: 0 !important;
        }

        .haro-form-subtitle {
            color: rgba(255,246,232,.68);
            font-size: 13px;
            margin: 6px 0 0;
            max-width: 620px;
            font-family: 'DM Sans', sans-serif !important;
        }

        #formulario { row-gap: 18px; }

        #formulario > div {
            background: rgba(255,255,255,.48);
            border: 1px solid rgba(19,19,22,.08);
            border-radius: 18px;
            padding: 16px;
            transition: border-color var(--transition), box-shadow var(--transition), transform var(--transition);
        }

        #formulario > div:focus-within {
            border-color: rgba(176,20,27,.34);
            box-shadow: 0 0 0 4px rgba(176,20,27,.08);
            transform: translateY(-1px);
        }

        #formulario label,
        #formulario .form-label {
            color: var(--haro-900) !important;
            font-size: 1rem !important;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        #formulario .form-control,
        #formulario .form-select,
        #formulario select,
        #formulario input {
            background: #fff !important;
            border: 1px solid rgba(201,162,74,.22) !important;
            border-radius: 13px !important;
            color: var(--text) !important;
            min-height: 44px;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 14px !important;
            font-weight: 600;
            outline: none !important;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        #formulario .form-control:focus,
        #formulario .form-select:focus,
        #formulario select:focus,
        #formulario input:focus {
            border-color: rgba(176,20,27,.45) !important;
            box-shadow: 0 0 0 4px rgba(176,20,27,.10) !important;
        }

        #formulario input[readonly] {
            background: var(--haro-gold-soft) !important;
            color: #8a661c !important;
            border-color: rgba(201,162,74,.22) !important;
        }

        .btn-haro-submit {
            background: linear-gradient(135deg, var(--haro-red), #6f1818) !important;
            border: 1px solid rgba(201,162,74,.28) !important;
            color: #fff !important;
            border-radius: 15px !important;
            min-height: 48px;
            padding: 12px 28px !important;
            font-size: 1.1rem !important;
            text-transform: uppercase;
            box-shadow: 0 14px 28px rgba(176,20,27,.24);
            transition: transform var(--transition), box-shadow var(--transition);
        }

        .btn-haro-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(176,20,27,.32);
        }

        .footer-wrapper {
            background: rgba(255,255,255,.70) !important;
            border-top: 1px solid rgba(201,162,74,.16) !important;
            color: var(--muted) !important;
            padding: 22px 28px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 13px;
            backdrop-filter: blur(10px);
        }

        .footer-wrapper a { color: var(--haro-red) !important; font-weight: 700; }

        @media (max-width:768px) {
            .layout-px-spacing { padding: 20px 14px !important; }
            .breadcrumbs-container .header,
            .secondary-nav .header { padding: 16px !important; align-items: flex-start !important; }
            .page-title h3 { font-size: 2rem !important; }
            .haro-form-card .widget-content { padding: 18px !important; }
            .haro-form-header { padding: 22px 20px 18px !important; }
            #formulario > div { padding: 14px; }
            .btn-haro-submit { width: 100%; }
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
        include "api/adminVentas.php";
        $adminVentas = new AdministradorVentas();
        $ventas = $adminVentas->dameVentas();
        if(isset($_GET['id'])){
            $editando = 1;
        }   
        else{
            $editando = 0;
        }
        ?>

        <script>
            var ventas = <?php echo json_encode($ventas); ?>;
            console.log(ventas);
        </script>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Pagos">
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
                                            <span class="haro-eyebrow">Pagos</span>
                                            <h3>Panel de creación de pagos</h3>
                                        </div>

                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Pagos</li>
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
                                            <h4>Nuevo pago</h4><p class="haro-form-subtitle">Registra pagos, intereses y saldos pendientes de cada venta.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form class="row g-3" id="formulario">


                                    <div class="col-12">
                                            <label for="inputAddress" class="form-label">Vehículo</label>
                                            <select onchange="cambiaRestante(this.value)" name="venta" id="venta" class="form-control">
                                                <option value="0">Seleccionar un vehículo</option>
                                                <?php 
                                                foreach($ventas as $venta){
                                                    echo "<option value='".$venta->id."'>".$venta->fecha_inserta . " - " . $venta->identificador .  "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Monto del pago</label>
                                            <input type="text" oninput="formatearPrecio()" class="form-control" id="monto_pago" name="monto_pago">
                                        </div>
                                       
                                        
                                  
                                        <div class="col-md-2">
                                            <label for="inputCity" class="form-label">Faltante antes del pago</label>
                                            <input type="text" class="form-control" id="faltante" name="faltante" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="inputCity" class="form-label">Intereses por atraso </label>
                                            <input type="text" class="form-control" id="interes_ac" name="interes_ac" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputCity" class="form-label">Faltante después del pago</label>
                                            <input type="text" class="form-control" id="restante" name="restante" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="inputState" class="form-label">Método Pago</label>
                                            <select id="metodo" name="metodo" class="form-select" >
                                                <option value="Efectivo">Seleccionar ... </option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Transferencia">Transferencia</option>
                                                <option value="Condonación">Condonación</option>

                                                
                                            </select>
                                        </div>
                                      
                                        <div class="col-md-3" hidden>
                                            <label for="inputState" class="form-label">Estatus del pago</label>
                                            <input type="text" name="estatus" value="Pendiente">
                                        </div>

                                        <div class="col-md-4" hidden>
                                            <label for="inputCity" class="form-label">Fecha del pago</label>
                                            <input type="date" class="form-control" value="<?php echo date("Y-m-d")?>" id="fecha" name="fecha" readonly>
                                        </div>
                                     
                                       
                                      
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light btn-haro-submit">Terminar</button>
                                        </div>
                                    </form>


                                </div>
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
                "sSearchPlaceholder": "Buscar pago...",
                "sLengthMenu": "Mostrar _MENU_ registros",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
        var restanteTotal = 0;
        var maximoC = 99999999;
        function cambiaRestante(id){
            var venta = ventas.find(venta => venta.id == id);
            var saldoRestanteM = new Intl.NumberFormat('en-US', {
						style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
						minimumFractionDigits: 2,
						maximumFractionDigits: 2,
						currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
						currency: 'MXN',
						useGrouping: true
					}).format(parseFloat(venta.restante));
            document.getElementById("faltante").value = saldoRestanteM;
            restanteTotal = venta.interes_acumulado;
            var interesM = new Intl.NumberFormat('en-US', {
                style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
						minimumFractionDigits: 2,
						maximumFractionDigits: 2,
						currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
						currency: 'MXN',
						useGrouping: true
					}).format(parseFloat(restanteTotal));
            document.getElementById("interes_ac").value = interesM;
        }
    </script>

    <script>
        function ajustarMonto(){
            var espacioMonto = document.getElementById("monto_pago");
            var monto = espacioMonto.value;
            var restanteEspacio = document.getElementById("restante");
            monto = monto.replace(/,/g, '');
            var restante = restanteTotal - monto;
            var saldoRestanteMM = new Intl.NumberFormat('en-US', {
						style: 'currency', // Puedes usar 'decimal', 'currency' o 'percent'
						minimumFractionDigits: 2,
						maximumFractionDigits: 2,
						currencyDisplay: 'symbol', // Puedes usar 'symbol', 'code' o 'name'
						currency: 'MXN',
						useGrouping: true
					}).format(parseFloat(restante));
            restanteEspacio.value = saldoRestanteMM;

            if(parseFloat(monto)  > parseFloat(restanteTotal) ){
                espacioMonto.value = restanteTotal;
            }
        }
    </script>


    <script>
        const formulario = document.getElementById("formulario");


        formulario.addEventListener("submit", function(e) {
            e.preventDefault();
            var autoSeleccionado = document.getElementById("venta").value;
            const enviaDatosContra = new FormData(formulario);
            if (<?php echo $editando ?> == 1) {
                enviaDatosContra.append("accion", "modifica");
                enviaDatosContra.append("id", "<?php echo $_GET['id'] ?>");

            } else {
                enviaDatosContra.append("accion", "inserta");

            }
            fetch("api/apiPagos.php", {
                    method: "POST",
                    body: enviaDatosContra,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    Swal.fire(
                        data.estatus,
                        data.mensaje,
                        data.status
                    ).then((result) => {
                        if (data.status == "success") {
                            window.location.href = "venta-detalle.php?id="+autoSeleccionado;
                        }
                    });

                });
        });
    </script>

<script>
        function formatearPrecio() {
            var input = document.getElementById('monto_pago');
            var valor = input.value.replace(/[^\d.]/g, ''); // Eliminar caracteres no numéricos ni puntos
            var partes = valor.split('.');

            if (partes.length > 2) {
                partes = [partes.shift(), partes.join('.')];
            }

            if (partes.length > 0) {
                partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Agregar comas
            }

            input.value = partes.join('.');
        }
    </script>

</body>

</html>