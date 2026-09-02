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
    <title>Banca - Haro</title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Original framework styles (kept for PHP template includes) -->
    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/light/apex/custom-apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/dark/apex/custom-apexcharts.css" rel="stylesheet" type="text/css">

    <style>
        /* ============================================
           DESIGN SYSTEM — WHITE PALETTE
        ============================================ */
        :root {
            --white:       #ffffff;
            --surface:     #f7f8fc;
            --surface-2:   #eef0f7;
            --border:      #e4e7f0;
            --border-soft: #f0f2f8;

            --ink-900: #0d0f1a;
            --ink-700: #2e3349;
            --ink-500: #6b7190;
            --ink-300: #adb3cc;

            --accent:      #2563eb;
            --accent-soft: #eff4ff;
            --accent-mid:  #93b4fd;

            --danger:      #ef4444;
            --danger-soft: #fef2f2;
            --success:     #10b981;
            --success-soft:#ecfdf5;
            --warning:     #f59e0b;
            --warning-soft:#fffbeb;

            --shadow-xs: 0 1px 3px rgba(13,15,26,.04), 0 1px 2px rgba(13,15,26,.03);
            --shadow-sm: 0 4px 16px rgba(13,15,26,.06), 0 1px 4px rgba(13,15,26,.04);
            --shadow-md: 0 8px 32px rgba(13,15,26,.09), 0 2px 8px rgba(13,15,26,.05);
            --shadow-lg: 0 20px 48px rgba(13,15,26,.12), 0 4px 16px rgba(13,15,26,.06);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --radius-xl: 30px;

            --transition: 220ms cubic-bezier(.4,0,.2,1);
        }

        /* ============================================
           BASE RESETS & BODY
        ============================================ */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--surface) !important;
            font-family: 'Inter', sans-serif !important;
            color: var(--ink-700) !important;
            -webkit-font-smoothing: antialiased;
        }

        /* ============================================
           LOADER OVERRIDE
        ============================================ */
        #load_screen {
            background: var(--white) !important;
        }

        /* ============================================
           PAGE HEADER
        ============================================ */
        .page-title h3 {
            font-family: 'Inter', sans-serif !important;
            font-weight: 700 !important;
            font-size: 1.45rem !important;
            color: var(--ink-900) !important;
            letter-spacing: -.02em;
        }

        /* ============================================
           LAYOUT WRAPPER
        ============================================ */
        .layout-px-spacing {
            padding: 28px 24px !important;
        }

        /* ============================================
           KPI STAT CARDS
        ============================================ */
        .kpi-card {
            background: var(--white);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: 28px 28px 24px;
            height: 100%;
            box-shadow: var(--shadow-sm);
            transition: box-shadow var(--transition), transform var(--transition);
            position: relative;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            background: linear-gradient(90deg, var(--accent), var(--accent-mid));
            opacity: 0;
            transition: opacity var(--transition);
        }

        .kpi-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .kpi-card:hover::before { opacity: 1; }

        .kpi-card__label {
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--ink-300);
            margin-bottom: 6px;
        }

        .kpi-card__title {
            font-family: 'Inter', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            color: var(--ink-500);
            margin-bottom: 4px;
        }

        .kpi-card__value {
            font-family: 'Inter', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--ink-900);
            letter-spacing: -.03em;
            line-height: 1.1;
        }

        .kpi-card__value.danger { color: var(--danger); }
        .kpi-card__value.success { color: var(--success); }
        .kpi-card__value.accent { color: var(--accent); }

        .kpi-card__icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
            flex-shrink: 0;
        }

        .kpi-card__icon.blue  { background: var(--accent-soft);  color: var(--accent); }
        .kpi-card__icon.red   { background: var(--danger-soft);  color: var(--danger); }
        .kpi-card__icon.green { background: var(--success-soft); color: var(--success); }
        .kpi-card__icon.gold  { background: var(--warning-soft); color: var(--warning); }

        .kpi-divider {
            width: 1px;
            background: var(--border);
            margin: 0 4px;
            align-self: stretch;
        }

        .kpi-pair {
            display: flex;
            gap: 24px;
        }

        .kpi-pair .kpi-item { flex: 1; }

        /* ============================================
           SECTION TITLES
        ============================================ */
        .section-heading {
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink-900);
            letter-spacing: -.02em;
            margin: 0;
        }

        /* ============================================
           CREDIT LIST CARD
        ============================================ */
        .credit-card {
            background: var(--white);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 28px 28px 20px;
        }

        .credit-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .credit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-soft);
            text-decoration: none !important;
            color: inherit !important;
            transition: background var(--transition);
            border-radius: 8px;
        }

        .credit-item:last-child { border-bottom: none; }

        .credit-item:hover { background: var(--surface); padding-left: 8px; }

        .credit-item__avatar {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--accent-soft);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: .85rem;
        }

        .credit-item__avatar.late {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .credit-item__name {
            font-weight: 600;
            font-size: .9rem;
            color: var(--ink-900);
            margin-bottom: 2px;
        }

        .credit-item__name.late { color: var(--danger); }

        .credit-item__pct {
            font-size: .78rem;
            color: var(--ink-500);
        }

        .credit-item__bar-wrap {
            flex: 1;
        }

        .credit-bar {
            height: 6px;
            border-radius: 99px;
            background: var(--surface-2);
            overflow: hidden;
        }

        .credit-bar__fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), var(--accent-mid));
            transition: width .6s cubic-bezier(.4,0,.2,1);
        }

        .credit-bar__fill.late {
            background: linear-gradient(90deg, var(--danger), #fb7185);
        }

        .credit-item__badge {
            font-family: 'Inter', sans-serif;
            font-size: .72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 99px;
            white-space: nowrap;
            background: var(--accent-soft);
            color: var(--accent);
        }

        .credit-item__badge.late {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* ============================================
           CHART CARDS
        ============================================ */
        .chart-card {
            background: var(--white);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 28px;
            transition: box-shadow var(--transition);
        }

        .chart-card:hover { box-shadow: var(--shadow-md); }

        .chart-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .chart-card__subtitle {
            font-size: .78rem;
            color: var(--ink-300);
            margin-top: 2px;
        }

        /* ============================================
           BADGE / PILL TAGS
        ============================================ */
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 99px;
            letter-spacing: .02em;
        }

        .tag.blue   { background: var(--accent-soft);  color: var(--accent); }
        .tag.green  { background: var(--success-soft); color: var(--success); }
        .tag.red    { background: var(--danger-soft);  color: var(--danger); }

        /* ============================================
           SUMMARY STRIP
        ============================================ */
        .summary-strip {
            background: linear-gradient(135deg, var(--ink-900) 0%, #1e2440 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            display: flex;
            gap: 0;
            flex-wrap: wrap;
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .summary-strip__item {
            flex: 1;
            min-width: 160px;
            padding: 0 24px;
            border-right: 1px solid rgba(255,255,255,.08);
        }

        .summary-strip__item:first-child { padding-left: 0; }
        .summary-strip__item:last-child  { border-right: none; }

        .summary-strip__label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(255,255,255,.45);
            margin-bottom: 6px;
        }

        .summary-strip__value {
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -.03em;
            color: var(--white);
        }

        .summary-strip__sub {
            font-size: .78rem;
            color: rgba(255,255,255,.5);
            margin-top: 2px;
        }

        /* ============================================
           LAYOUT SPACING OVERRIDES
        ============================================ */
        .layout-spacing { margin-bottom: 24px !important; }

        /* ============================================
           APEXCHARTS OVERRIDES
        ============================================ */
        .apexcharts-toolbar { display: none !important; }
        .apexcharts-tooltip {
            border-radius: 12px !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid var(--border) !important;
            font-family: 'Inter', sans-serif !important;
        }

        /* ============================================
           FOOTER
        ============================================ */
        .footer-wrapper {
            border-top: 1px solid var(--border-soft);
            padding: 20px 28px !important;
            background: var(--white) !important;
            font-size: .8rem;
            color: var(--ink-300);
        }

        /* ============================================
           FADE-IN ANIMATION
        ============================================ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-up {
            animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both;
        }

        .delay-1 { animation-delay: .05s; }
        .delay-2 { animation-delay: .10s; }
        .delay-3 { animation-delay: .15s; }
        .delay-4 { animation-delay: .20s; }
        .delay-5 { animation-delay: .25s; }
        .delay-6 { animation-delay: .30s; }

        /* ============================================
           RESPONSIVE TWEAKS
        ============================================ */
        @media (max-width: 768px) {
            .summary-strip { flex-direction: column; gap: 20px; }
            .summary-strip__item { border-right: none; border-bottom: 1px solid rgba(255,255,255,.08); padding: 0 0 20px; }
            .summary-strip__item:last-child { border-bottom: none; padding-bottom: 0; }
            .kpi-pair { flex-direction: column; }
        }
    </style>
</head>

<body class="layout-boxed enable-secondaryNav">
    <?php
    $usuarioPermiso = $_SESSION['sesionUsuario']['permiso_banca'] ?? '';
    if ($usuarioPermiso === 'Banca') {
    } else if ($usuarioPermiso === 'Cashier') {
        echo '<script> window.location.href = "autos-inventario.php"; </script>';
    } else {
        echo '<script> window.location.href = "../index.php"; </script>';
    }
    ?>

    <!-- LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center" style="color: var(--accent, #2563eb);"></div>
            </div>
        </div>
    </div>

    <!-- JS Data from PHP -->
    <script>
        var montosEstadisticaInventario = [];
        var mesesEstadisticaInventario  = [];
        var cantidadEstadoInventario    = [];
        var montosEstadisticaVenta      = [];
        var mesesEstadisticaVenta       = [];
        var intereses                   = [];
        var mesSinVender                = [];
        var cantidadSinVender           = [];
    </script>

    <?php include_once("template/barra_nav.php") ?>

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include("template/barra.php") ?>

        <?php
        include_once("api/adminVentas.php");
        include_once("api/adminUtil.php");
        include_once("../api/adminAutos.php");

        $adminAutos   = new AdministradorAutos();
        $adminVentas  = new AdministradorVentas();
        $adminUtil    = new AdminUtil();

        $estadisticasVentas = $adminUtil->dameEstadisticasVenta();
        $esatisticas        = $adminUtil->dameEstadisticaInventarioA();
        $ventasConcluidas   = $adminVentas->dameVentasConcluidas();
        $ventasPendinetes   = $adminVentas->dameVentasSinCompletar();
        $sinVender          = $adminUtil->estadisticasInvSinVender();

        $porCobrar = 0;
        $atrasado  = 0;
        foreach ($ventasPendinetes as $ven) {
            $porCobrar += $ven->restante;
            foreach ($ven->pagos_acumulados as $pago) {
                if ($pago->fecha_prospecto < date("Y-m-d") && $pago->monto_acumulado > ($ven->precio_pactado - $ven->restante)) {
                    $atrasado += $pago->monto_pagar;
                    $ven->color = "#FF0000";
                }
            }
        }
        $porcentajeAtrazado = $porCobrar > 0 ? (100 / $porCobrar) * $atrasado : 0;

        foreach ($esatisticas as $estad) {
            echo "<script>montosEstadisticaInventario.push(" . $estad->monto_cantidad . ")</script>";
            echo "<script>cantidadEstadoInventario.push(" . $estad->autos_cantidad . ")</script>";
            echo "<script>mesesEstadisticaInventario.push('" . $estad->mes . "/" . $estad->anio . "')</script>";
        }
        foreach ($estadisticasVentas as $estats) {
            echo "<script>montosEstadisticaVenta.push(" . $estats->monto_cantidad . ")</script>";
            echo "<script>mesesEstadisticaVenta.push('" . $estats->mes . "/" . $estats->anio . "')</script>";
            echo "<script>intereses.push(" . $estats->intereses . ")</script>";
        }
        foreach ($sinVender as $sin) {
            echo "<script>mesSinVender.push('" . $sin->mes . "/" . $sin->anio . "')</script>";
            echo "<script>cantidadSinVender.push(" . $sin->autos_cantidad . ")</script>";
        }
        ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">

                    <!-- BREADCRUMBS -->
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
                                        <div class="page-title">
                                            <h3>Panel de administración de cobros</h3>
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

                    <div class="row layout-top-spacing">

                        <!-- ═══════════════════════════════════════
                             DARK SUMMARY STRIP
                        ════════════════════════════════════════ -->
                        <div class="col-12 layout-spacing animate-up delay-1">
                            <div class="summary-strip">
                                <div class="summary-strip__item">
                                    <div class="summary-strip__label">Créditos activos</div>
                                    <div class="summary-strip__value"><?php echo count($ventasPendinetes) ?></div>
                                    <div class="summary-strip__sub">Autos en crédito</div>
                                </div>
                                <div class="summary-strip__item">
                                    <div class="summary-strip__label">Por cobrar</div>
                                    <div class="summary-strip__value">$<?php echo number_format($porCobrar, 0) ?></div>
                                    <div class="summary-strip__sub">Crédito pendiente total</div>
                                </div>
                                <div class="summary-strip__item">
                                    <div class="summary-strip__label">Atrasado</div>
                                    <div class="summary-strip__value" style="color:#fb7185;">$<?php echo number_format($atrasado, 0) ?></div>
                                    <div class="summary-strip__sub"><?php echo round($porcentajeAtrazado, 1) ?>% del total</div>
                                </div>
                                <div class="summary-strip__item">
                                    <div class="summary-strip__label">Intereses generados</div>
                                    <div class="summary-strip__value" style="color:#34d399;">$<?php echo number_format($adminVentas->sumaIntereses(), 0) ?></div>
                                    <div class="summary-strip__sub">Acumulado total</div>
                                </div>
                            </div>
                        </div>

                        <!-- ═══════════════════════════════════════
                             KPI ROW — INVENTARIO & VENTAS
                        ════════════════════════════════════════ -->

                        <!-- Inventario -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 layout-spacing animate-up delay-2">
                            <div class="kpi-card h-100">
                                <div class="kpi-card__icon blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                </div>
                                <div class="kpi-card__label">Inventario</div>
                                <div class="kpi-pair">
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Valor total</div>
                                        <div class="kpi-card__value accent">$<?php echo number_format($adminAutos->sumaMontosAutos(), 0) ?></div>
                                    </div>
                                    <div class="kpi-divider"></div>
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Autos</div>
                                        <div class="kpi-card__value"><?php echo $adminAutos->cuentaAutosValidos() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Consignación -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 layout-spacing animate-up delay-3">
                            <div class="kpi-card h-100">
                                <div class="kpi-card__icon gold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div class="kpi-card__label">Consignación</div>
                                <div class="kpi-pair">
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Valor</div>
                                        <div class="kpi-card__value">$<?php echo number_format($adminUtil->dameSumaConsig(), 0) ?></div>
                                    </div>
                                    <div class="kpi-divider"></div>
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Autos</div>
                                        <div class="kpi-card__value"><?php echo number_format($adminUtil->dameConteoConsig()) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ventas -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 layout-spacing animate-up delay-4">
                            <div class="kpi-card h-100">
                                <div class="kpi-card__icon green">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                </div>
                                <div class="kpi-card__label">Ventas concluidas</div>
                                <div class="kpi-pair">
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Monto vendido</div>
                                        <div class="kpi-card__value success">$<?php echo number_format($adminVentas->sumaVentas(), 0) ?></div>
                                    </div>
                                    <div class="kpi-divider"></div>
                                    <div class="kpi-item">
                                        <div class="kpi-card__title">Autos</div>
                                        <div class="kpi-card__value"><?php echo $adminVentas->cuentaVentas() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ═══════════════════════════════════════
                             AUTOS POR LIQUIDAR
                        ════════════════════════════════════════ -->
                        <div class="col-12 layout-spacing animate-up delay-5">
                            <div class="credit-card">
                                <div class="credit-card__header">
                                    <div>
                                        <h5 class="section-heading">Autos por liquidar</h5>
                                        <p style="font-size:.8rem;color:var(--ink-300);margin:2px 0 0;">Créditos activos — progreso de pago</p>
                                    </div>
                                    <span class="tag blue"><?php echo count($ventasPendinetes) ?> activos</span>
                                </div>

                                <?php foreach ($ventasPendinetes as $venta):
                                    $pct  = round((100 / $venta->precio_pactado) * ($venta->precio_pactado - $venta->restante), 1);
                                    $late = isset($venta->color) && $venta->color === '#FF0000';
                                    $initials = strtoupper(substr($venta->identificador, 0, 2));
                                ?>
                                <a href="venta-detalle.php?id=<?php echo $venta->id ?>" class="credit-item">
                                    <div class="credit-item__avatar <?php echo $late ? 'late' : '' ?>"><?php echo $initials ?></div>
                                    <div class="credit-item__bar-wrap">
                                        <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:6px;">
                                            <span class="credit-item__name <?php echo $late ? 'late' : '' ?>"><?php echo htmlspecialchars($venta->identificador) ?></span>
                                            <span class="credit-item__pct"><?php echo $pct ?>% pagado</span>
                                        </div>
                                        <div class="credit-bar">
                                            <div class="credit-bar__fill <?php echo $late ? 'late' : '' ?>" style="width:<?php echo $pct ?>%"></div>
                                        </div>
                                    </div>
                                    <span class="credit-item__badge <?php echo $late ? 'late' : '' ?>"><?php echo $late ? '⚠ Atrasado' : 'Al día' ?></span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- ═══════════════════════════════════════
                             CHARTS
                        ════════════════════════════════════════ -->

                        <!-- Valor del Inventario -->
                        <div class="col-12 layout-spacing animate-up delay-6">
                            <div class="chart-card">
                                <div class="chart-card__header">
                                    <div>
                                        <h5 class="section-heading">Valor del Inventario</h5>
                                        <p class="chart-card__subtitle">Evolución mensual en MXN</p>
                                    </div>
                                    <span class="tag blue">Inventario</span>
                                </div>
                                <div id="valorInventario" style="min-height:340px;"></div>
                            </div>
                        </div>

                        <!-- Inventario sin vender -->
                        <div class="col-12 layout-spacing animate-up delay-6">
                            <div class="chart-card">
                                <div class="chart-card__header">
                                    <div>
                                        <h5 class="section-heading">Inventario sin vender</h5>
                                        <p class="chart-card__subtitle">Cantidad de autos por mes</p>
                                    </div>
                                    <span class="tag red">Sin venta</span>
                                </div>
                                <div id="sinVenta" style="min-height:340px;"></div>
                            </div>
                        </div>

                        <!-- Ventas por mes -->
                        <div class="col-12 layout-spacing animate-up delay-6">
                            <div class="chart-card">
                                <div class="chart-card__header">
                                    <div>
                                        <h5 class="section-heading">Ventas por mes</h5>
                                        <p class="chart-card__subtitle">Monto de inventario vendido en MXN</p>
                                    </div>
                                    <span class="tag green">Ventas</span>
                                </div>
                                <div id="ventas" style="min-height:340px;"></div>
                            </div>
                        </div>

                        <!-- Cantidad de inventario -->
                        <div class="col-12 layout-spacing animate-up delay-6">
                            <div class="chart-card">
                                <div class="chart-card__header">
                                    <div>
                                        <h5 class="section-heading">Cantidad de Inventario</h5>
                                        <p class="chart-card__subtitle">Número de autos por mes</p>
                                    </div>
                                    <span class="tag blue">Inventario</span>
                                </div>
                                <div id="inventario" style="min-height:340px;"></div>
                            </div>
                        </div>

                    </div><!-- /row -->
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer-wrapper" style="display:flex;justify-content:space-between;align-items:center;">
                <p style="margin:0;">Copyright © <span class="dynamic-year">2024</span> Banca Haro — Todos los derechos reservados.</p>
                <p style="margin:0;display:flex;align-items:center;gap:5px;">Hecho con
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    en Guadalajara
                </p>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <script src="../src/assets/js/scrollspyNav.js"></script>
    <script src="../src/plugins/src/apex/custom-apexcharts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
    // ─── Shared chart defaults ───────────────────────────────────────────────
    var fmtMXN = function(val) {
        return val.toLocaleString('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 0 });
    };

    var baseChart = {
        fontFamily: "'Inter', sans-serif",
        toolbar:    { show: false },
        animations: { enabled: true, easing: 'easeinout', speed: 600 },
        dropShadow: { enabled: false }
    };

    var baseGrid = {
        borderColor: '#f0f2f8',
        strokeDashArray: 4,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } }
    };

    var baseXaxis = {
        axisBorder: { show: false },
        axisTicks:  { show: false },
        labels: { style: { fontFamily: "'Inter',sans-serif", fontWeight: 500, colors: '#adb3cc', fontSize: '12px' } }
    };

    var baseYaxisMoney = {
        labels: {
            style: { fontFamily: "'Inter',sans-serif", colors: '#adb3cc', fontSize: '11px' },
            formatter: fmtMXN
        }
    };

    var baseYaxisCount = {
        labels: {
            style: { fontFamily: "'Inter',sans-serif", colors: '#adb3cc', fontSize: '11px' },
            formatter: function(v){ return v + ' autos'; }
        }
    };

    // ─── Tooltip shared ──────────────────────────────────────────────────────
    var baseTooltip = {
        theme: 'light',
        style: { fontFamily: "'Inter',sans-serif" }
    };

    $(document).ready(function () {

        /* ── 1. Valor del inventario (line) ───────────────────────────── */
        new ApexCharts(document.querySelector("#valorInventario"), {
            series: [{ name: "Valor del inventario", data: montosEstadisticaInventario }],
            chart:  Object.assign({}, baseChart, { height: 340, type: 'area' }),
            colors: ['#2563eb'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: .25, opacityTo: .02, stops: [0, 100] }
            },
            stroke: { curve: 'smooth', width: 2.5 },
            dataLabels: { enabled: false },
            grid:   baseGrid,
            xaxis:  Object.assign({}, baseXaxis, { categories: mesesEstadisticaInventario }),
            yaxis:  baseYaxisMoney,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: fmtMXN } })
        }).render();

        /* ── 2. Ventas por mes (bar) ──────────────────────────────────── */
        new ApexCharts(document.querySelector("#ventas"), {
            series: [{ name: 'Ventas', data: montosEstadisticaVenta }],
            chart:  Object.assign({}, baseChart, { height: 340, type: 'bar' }),
            colors: ['#10b981'],
            plotOptions: { bar: { borderRadius: 8, columnWidth: '50%', dataLabels: { position: 'top' } } },
            dataLabels: {
                enabled: true,
                formatter: fmtMXN,
                offsetY: -22,
                style: { fontSize: '11px', fontFamily: "'Inter',sans-serif", colors: ['#6b7190'] }
            },
            grid:  baseGrid,
            xaxis: Object.assign({}, baseXaxis, { categories: mesesEstadisticaVenta, position: 'bottom' }),
            yaxis: baseYaxisMoney,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: fmtMXN } })
        }).render();

        /* ── 3. Inventario sin vender (bar) ──────────────────────────── */
        new ApexCharts(document.querySelector("#sinVenta"), {
            series: [{ name: 'Sin vender', data: cantidadSinVender }],
            chart:  Object.assign({}, baseChart, { height: 340, type: 'bar' }),
            colors: ['#f59e0b'],
            plotOptions: { bar: { borderRadius: 8, columnWidth: '50%', dataLabels: { position: 'top' } } },
            dataLabels: {
                enabled: true,
                formatter: function(v){ return v + ' autos'; },
                offsetY: -22,
                style: { fontSize: '11px', fontFamily: "'Inter',sans-serif", colors: ['#6b7190'] }
            },
            grid:  baseGrid,
            xaxis: Object.assign({}, baseXaxis, { categories: mesSinVender, position: 'bottom' }),
            yaxis: baseYaxisCount,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: function(v){ return v + ' autos'; } } })
        }).render();

        /* ── 4. Cantidad de inventario (bar) ─────────────────────────── */
        new ApexCharts(document.querySelector("#inventario"), {
            series: [{ name: 'Autos', data: cantidadEstadoInventario }],
            chart:  Object.assign({}, baseChart, { height: 340, type: 'bar' }),
            colors: ['#2563eb'],
            plotOptions: { bar: { borderRadius: 8, columnWidth: '50%', dataLabels: { position: 'top' } } },
            dataLabels: {
                enabled: true,
                formatter: function(v){ return v + ' autos'; },
                offsetY: -22,
                style: { fontSize: '11px', fontFamily: "'Inter',sans-serif", colors: ['#6b7190'] }
            },
            grid:  baseGrid,
            xaxis: Object.assign({}, baseXaxis, { categories: mesesEstadisticaInventario, position: 'bottom' }),
            yaxis: baseYaxisCount,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: function(v){ return v + ' autos'; } } })
        }).render();

    });
    </script>

</body>
</html>
