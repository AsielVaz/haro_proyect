<?php
header('Content-Type: text/html; charset=utf-8');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuarioId = (int) ($_SESSION['sesionUsuario']['id'] ?? 0);
$usuarioPermiso = (string) ($_SESSION['sesionUsuario']['permiso_banca'] ?? '');

if ($usuarioId <= 0 || !in_array($usuarioPermiso, ['Banca', 'Cashier'], true)) {
    header('Location: ../login.php');
    exit;
}

if ($usuarioPermiso === 'Cashier') {
    header('Location: autos-inventario.php');
    exit;
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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

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
        :root {
            --haro-black: #0b0b0d;
            --haro-900: #131316;
            --haro-800: #1b1b20;
            --haro-red: #b0141b;
            --haro-red-2: #dc2626;
            --haro-gold: #c9a24a;
            --haro-gold-soft: rgba(201, 162, 74, .14);
            --haro-red-soft: rgba(176, 20, 27, .12);
            --haro-green: #10b981;
            --haro-green-soft: rgba(16, 185, 129, .12);
            --haro-warning: #f59e0b;
            --page: #f4f1ea;
            --paper: #ffffff;
            --paper-2: #faf8f3;
            --line: rgba(19, 19, 22, .09);
            --line-2: rgba(19, 19, 22, .06);
            --text: #161616;
            --muted: #77736b;
            --soft: #a7a197;
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 26px;
            --shadow-sm: 0 10px 28px rgba(15, 15, 18, .08);
            --shadow-md: 0 18px 46px rgba(15, 15, 18, .12);
            --shadow-dark: 0 28px 70px rgba(0, 0, 0, .22);
            --transition: 220ms cubic-bezier(.4,0,.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background:
                radial-gradient(circle at top right, rgba(201,162,74,.14), transparent 32%),
                linear-gradient(180deg, #fbf8f1 0%, var(--page) 44%, #eee8dc 100%) !important;
            font-family: 'DM Sans', sans-serif !important;
            color: var(--text) !important;
            -webkit-font-smoothing: antialiased;
        }

        body.dark,
        body[data-theme="dark"],
        .dark body {
            background:
                radial-gradient(circle at top right, rgba(176,20,27,.18), transparent 34%),
                linear-gradient(180deg, #121214 0%, #0b0b0d 100%) !important;
        }

        #load_screen { background: var(--page) !important; }
        #load_screen .spinner-grow { color: var(--haro-red) !important; }

        .layout-px-spacing { padding: 30px 26px !important; }
        .layout-spacing { margin-bottom: 24px !important; }

        .secondary-nav {
            background: transparent !important;
            box-shadow: none !important;
            margin-bottom: 18px;
        }

        .breadcrumbs-container .header {
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(201,162,74,.20);
            border-radius: var(--radius-lg);
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
        }

        .btn-toggle.sidebarCollapse svg { width: 20px; height: 20px; }

        .page-title h3 {
            font-family: 'Bebas Neue', sans-serif !important;
            font-weight: 400 !important;
            font-size: clamp(1.25rem, 2vw, 1.75rem) !important;
            color: var(--haro-900) !important;
            letter-spacing: -.04em;
            margin-bottom: 4px !important;
        }

        .breadcrumb-style-one .breadcrumb {
            margin: 0 !important;
            gap: 6px;
        }

        .breadcrumb-style-one .breadcrumb-item,
        .breadcrumb-style-one .breadcrumb-item a {
            font-size: .78rem;
            color: var(--muted) !important;
            font-weight: 600;
            text-decoration: none !important;
        }

        .breadcrumb-style-one .breadcrumb-item.active {
            color: var(--haro-red) !important;
        }

        .summary-strip {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(176,20,27,.92) 0%, rgba(19,19,22,.98) 34%, #080809 100%);
            border: 1px solid rgba(201,162,74,.22);
            border-radius: 30px;
            padding: 30px 34px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            color: #fff;
            box-shadow: var(--shadow-dark);
        }

        .summary-strip::before {
            content: '';
            position: absolute;
            inset: -80px -80px auto auto;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,162,74,.32), transparent 68%);
            pointer-events: none;
        }

        .summary-strip__item {
            position: relative;
            min-width: 0;
            padding: 0 26px;
            border-right: 1px solid rgba(255,255,255,.10);
        }

        .summary-strip__item:first-child { padding-left: 0; }
        .summary-strip__item:last-child { border-right: 0; padding-right: 0; }

        .summary-strip__label {
            font-family: 'Bebas Neue', sans-serif;
            font-size: .68rem;
            font-weight: 400;
            letter-spacing: .11em;
            text-transform: uppercase;
            color: rgba(255,255,255,.52);
            margin-bottom: 8px;
        }

        .summary-strip__value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(1.35rem, 2.2vw, 2rem);
            font-weight: 400;
            letter-spacing: -.045em;
            color: #fff;
            line-height: 1;
        }

        .summary-strip__sub {
            font-size: .8rem;
            color: rgba(255,255,255,.55);
            margin-top: 8px;
        }

        .kpi-card,
        .credit-card,
        .chart-card {
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(201,162,74,.18);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(12px);
            transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        }

        .kpi-card:hover,
        .credit-card:hover,
        .chart-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: rgba(176,20,27,.22);
        }

        .kpi-card {
            position: relative;
            height: 100%;
            padding: 26px;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            right: -44px;
            bottom: -44px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: var(--haro-gold-soft);
            pointer-events: none;
        }

        .kpi-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            color: #fff;
            background: linear-gradient(135deg, var(--haro-red), var(--haro-900));
            box-shadow: 0 12px 26px rgba(176,20,27,.20);
        }

        .kpi-card__icon.blue,
        .kpi-card__icon.green,
        .kpi-card__icon.gold {
            background: linear-gradient(135deg, var(--haro-red), var(--haro-gold));
            color: #fff;
        }

        .kpi-card__label {
            font-family: 'Bebas Neue', sans-serif;
            font-size: .72rem;
            font-weight: 400;
            letter-spacing: .11em;
            text-transform: uppercase;
            color: var(--haro-red);
            margin-bottom: 10px;
        }

        .kpi-pair {
            display: flex;
            gap: 22px;
            position: relative;
            z-index: 1;
        }

        .kpi-item { flex: 1; min-width: 0; }
        .kpi-divider { width: 1px; background: var(--line); align-self: stretch; }

        .kpi-card__title {
            font-size: .78rem;
            font-weight: 400;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .kpi-card__value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(1.25rem, 2vw, 1.7rem);
            font-weight: 400;
            color: var(--haro-900);
            letter-spacing: -.04em;
            line-height: 1.08;
        }

        .kpi-card__value.accent,
        .kpi-card__value.success { color: var(--haro-red); }

        .credit-card {
            padding: 28px;
        }

        .credit-card__header,
        .chart-card__header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .section-heading {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--haro-900);
            letter-spacing: -.035em;
            margin: 0;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: .72rem;
            font-weight: 400;
            padding: 7px 13px;
            border-radius: 999px;
            letter-spacing: .02em;
            white-space: nowrap;
            border: 1px solid transparent;
        }

        .tag.blue,
        .tag.green {
            background: var(--haro-gold-soft);
            color: #8a661c;
            border-color: rgba(201,162,74,.22);
        }

        .tag.red {
            background: var(--haro-red-soft);
            color: var(--haro-red);
            border-color: rgba(176,20,27,.16);
        }

        .credit-item {
            display: grid;
            grid-template-columns: 46px minmax(0, 1fr) auto;
            align-items: center;
            gap: 16px;
            padding: 16px 12px;
            border-bottom: 1px solid var(--line-2);
            border-radius: 16px;
            text-decoration: none !important;
            color: inherit !important;
            transition: background var(--transition), transform var(--transition), border-color var(--transition);
        }

        .credit-item:last-child { border-bottom: 0; }

        .credit-item:hover {
            background: linear-gradient(90deg, rgba(176,20,27,.055), rgba(201,162,74,.055));
            transform: translateX(4px);
        }

        .credit-item__avatar {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            background: var(--haro-gold-soft);
            color: #8a661c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            font-size: .85rem;
            border: 1px solid rgba(201,162,74,.20);
        }

        .credit-item__avatar.late {
            background: var(--haro-red-soft);
            color: var(--haro-red);
            border-color: rgba(176,20,27,.18);
        }

        .credit-item__name {
            font-weight: 400;
            color: var(--haro-900);
            font-size: .92rem;
        }

        .credit-item__name.late { color: var(--haro-red); }

        .credit-item__pct {
            color: var(--muted);
            font-size: .78rem;
            font-weight: 400;
        }

        .credit-bar {
            height: 8px;
            border-radius: 99px;
            background: #eee8dc;
            overflow: hidden;
        }

        .credit-bar__fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--haro-red), var(--haro-gold));
        }

        .credit-bar__fill.late {
            background: linear-gradient(90deg, var(--haro-red-2), #fb7185);
        }

        .credit-item__badge {
            font-family: 'Bebas Neue', sans-serif;
            font-size: .72rem;
            font-weight: 400;
            padding: 6px 12px;
            border-radius: 999px;
            white-space: nowrap;
            background: var(--haro-green-soft);
            color: #087f5b;
        }

        .credit-item__badge.late {
            background: var(--haro-red-soft);
            color: var(--haro-red);
        }

        .chart-card {
            padding: 28px;
            overflow: hidden;
        }

        .chart-card__subtitle {
            color: var(--muted);
            font-size: .82rem;
            margin-top: 4px;
            margin-bottom: 0;
        }

        .apexcharts-toolbar { display: none !important; }

        .apexcharts-tooltip {
            border-radius: 14px !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid rgba(201,162,74,.22) !important;
            font-family: 'DM Sans', sans-serif !important;
        }

        .footer-wrapper {
            border-top: 1px solid rgba(201,162,74,.16);
            padding: 22px 28px !important;
            background: rgba(255,255,255,.70) !important;
            color: var(--muted);
            backdrop-filter: blur(10px);
            font-size: .82rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-up { animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both; }
        .delay-1 { animation-delay: .05s; }
        .delay-2 { animation-delay: .10s; }
        .delay-3 { animation-delay: .15s; }
        .delay-4 { animation-delay: .20s; }
        .delay-5 { animation-delay: .25s; }
        .delay-6 { animation-delay: .30s; }

        @media (max-width: 992px) {
            .summary-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); row-gap: 24px; }
            .summary-strip__item:nth-child(2) { border-right: 0; padding-right: 0; }
            .summary-strip__item:nth-child(3) { padding-left: 0; }
        }

        @media (max-width: 768px) {
            .layout-px-spacing { padding: 20px 14px !important; }
            .breadcrumbs-container .header { padding: 16px !important; align-items: flex-start; }
            .summary-strip { grid-template-columns: 1fr; padding: 24px; }
            .summary-strip__item {
                border-right: 0;
                border-bottom: 1px solid rgba(255,255,255,.10);
                padding: 0 0 18px !important;
            }
            .summary-strip__item:last-child { border-bottom: 0; padding-bottom: 0 !important; }
            .kpi-pair { flex-direction: column; gap: 14px; }
            .kpi-divider { width: 100%; height: 1px; }
            .credit-card__header,
            .chart-card__header { flex-direction: column; }
            .credit-item {
                grid-template-columns: 42px minmax(0, 1fr);
            }
            .credit-item__badge {
                grid-column: 2;
                justify-self: flex-start;
            }
            .footer-wrapper { flex-direction: column; gap: 8px; text-align: center; }
        }
    </style>




<style id="haro-chart-mobile-readable-v2">
/* ==========================================================
   GRÁFICAS RESPONSIVE HARO V2
   Fuerza etiquetas visibles y legibles en celular.
========================================================== */

.chart-card {
    overflow: visible !important;
}

.chart-card .apexcharts-canvas,
.chart-card .apexcharts-svg {
    overflow: visible !important;
}

@media (max-width: 575.98px) {
    .chart-card {
        padding: 26px 16px 36px !important;
        border-radius: 26px !important;
    }

    .chart-card__header {
        margin-bottom: 12px !important;
    }

    .chart-card > div[id] {
        min-height: 365px !important;
        overflow: visible !important;
    }

    .apexcharts-canvas,
    .apexcharts-svg,
    .apexcharts-inner,
    .apexcharts-graphical {
        overflow: visible !important;
    }

    .apexcharts-xaxis text,
    .apexcharts-yaxis text {
        fill: #2f3448 !important;
        color: #2f3448 !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        opacity: 1 !important;
    }

    .apexcharts-xaxis-label {
        fill: #2f3448 !important;
        opacity: 1 !important;
    }

    .apexcharts-yaxis-label {
        fill: #4b5268 !important;
        opacity: 1 !important;
    }

    .apexcharts-datalabel,
    .apexcharts-data-labels text {
        display: none !important;
    }
}
</style>

</head>

<body class="layout-boxed enable-secondaryNav">
    <?php
    
    if (!function_exists('haroTexto')) {
        function haroTexto($texto) {
            $texto = (string) $texto;

            if (function_exists('mb_detect_encoding') && !mb_detect_encoding($texto, 'UTF-8', true)) {
                $texto = mb_convert_encoding($texto, 'UTF-8', 'ISO-8859-1');
            }

            $map = array(
                '�' => 'é',
                'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãº' => 'ú',
                'Ã�' => 'Á', 'Ã‰' => 'É', 'Ã�' => 'Í', 'Ã“' => 'Ó', 'Ãš' => 'Ú',
                'Ã±' => 'ñ', 'Ã‘' => 'Ñ',
                'Garc�a' => 'García',
                'Guti�rrez' => 'Gutiérrez',
                'P�rez' => 'Pérez',
                'Gonz�lez' => 'González',
                'Hern�ndez' => 'Hernández',
                'Mart�nez' => 'Martínez',
                'L�pez' => 'López',
                'S�nchez' => 'Sánchez',
                'Ram�rez' => 'Ramírez',
                'Jim�nez' => 'Jiménez',
                'Rodr�guez' => 'Rodríguez',
                'D�az' => 'Díaz',
                'Mu�oz' => 'Muñoz',
                'N��ez' => 'Núñez'
            );

            return strtr($texto, $map);
        }
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
                                    $initials = strtoupper(substr(haroTexto($venta->identificador), 0, 2));
                                ?>
                                <a href="venta-detalle.php?id=<?php echo $venta->id ?>" class="credit-item">
                                    <div class="credit-item__avatar <?php echo $late ? 'late' : '' ?>"><?php echo $initials ?></div>
                                    <div class="credit-item__bar-wrap">
                                        <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:6px;">
                                            <span class="credit-item__name <?php echo $late ? 'late' : '' ?>"><?php echo htmlspecialchars(haroTexto($venta->identificador), ENT_QUOTES, 'UTF-8') ?></span>
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
            <?php include_once("template/footer_haro.php"); ?>
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

    var isMobileChart = function() {
        return window.innerWidth <= 575.98;
    };

    var shortDateLabel = function(value) {
        if (!value) return '';

        var parts = String(value).split('/');
        if (parts.length >= 2) {
            var month = parseInt(parts[0], 10);
            var year = String(parts[1]).slice(-2);
            var months = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

            if (!isNaN(month) && month >= 1 && month <= 12) {
                return months[month - 1] + ' ' + year;
            }
        }

        return String(value);
    };

    var mobileLabelStep = function(categories) {
        if (!categories || !categories.length) return 1;
        if (categories.length <= 5) return 1;
        return Math.ceil(categories.length / 5);
    };

    var responsiveXaxis = function(categories) {
        var step = mobileLabelStep(categories);

        return Object.assign({}, baseXaxis, {
            categories: categories,
            tickPlacement: 'on',
            tickAmount: isMobileChart() ? Math.min(5, Math.max(2, categories.length - 1)) : undefined,
            labels: {
                show: true,
                rotate: isMobileChart() ? -35 : -45,
                rotateAlways: isMobileChart(),
                hideOverlappingLabels: false,
                showDuplicates: false,
                trim: false,
                minHeight: isMobileChart() ? 64 : 80,
                maxHeight: isMobileChart() ? 86 : 100,
                offsetY: isMobileChart() ? 8 : 0,
                style: {
                    fontFamily: "'DM Sans',sans-serif",
                    fontWeight: 700,
                    colors: Array((categories || []).length).fill('#2f3448'),
                    fontSize: isMobileChart() ? '10px' : '12px'
                },
                formatter: function(value, timestamp, opts) {
                    if (!isMobileChart()) return value;

                    var index = opts && typeof opts.i !== 'undefined' ? opts.i : -1;
                    if (index > -1 && index % step !== 0 && index !== categories.length - 1) {
                        return '';
                    }

                    return shortDateLabel(value);
                }
            }
        });
    };

    var responsiveBarOptions = function() {
        return {
            borderRadius: isMobileChart() ? 5 : 8,
            columnWidth: isMobileChart() ? '42%' : '50%',
            dataLabels: { position: 'top' }
        };
    };

    var responsiveDataLabels = function(formatterFn) {
        return {
            enabled: !isMobileChart(),
            formatter: formatterFn,
            offsetY: -22,
            style: {
                fontSize: '11px',
                fontFamily: "'DM Sans',sans-serif",
                colors: ['#6b7190']
            }
        };
    };

    var responsiveChartOptions = function(type) {
        return Object.assign({}, baseChart, {
            height: isMobileChart() ? 365 : 340,
            type: type,
            parentHeightOffset: isMobileChart() ? 16 : 0,
            offsetY: 0
        });
    };

    var baseChart = {
        fontFamily: "'DM Sans', sans-serif",
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
        labels: { style: { fontFamily: "'DM Sans',sans-serif", fontWeight: 500, colors: '#adb3cc', fontSize: '12px' } }
    };

    var baseYaxisMoney = {
        labels: {
            style: { fontFamily: "'DM Sans',sans-serif", colors: '#adb3cc', fontSize: '11px' },
            formatter: fmtMXN
        }
    };

    var baseYaxisCount = {
        labels: {
            style: { fontFamily: "'DM Sans',sans-serif", colors: '#adb3cc', fontSize: '11px' },
            formatter: function(v){ return v + ' autos'; }
        }
    };

    // ─── Tooltip shared ──────────────────────────────────────────────────────
    var baseTooltip = {
        theme: 'light',
        style: { fontFamily: "'DM Sans',sans-serif" }
    };

    $(document).ready(function () {

        /* ── 1. Valor del inventario (line) ───────────────────────────── */
        new ApexCharts(document.querySelector("#valorInventario"), {
            series: [{ name: "Valor del inventario", data: montosEstadisticaInventario }],
            chart:  responsiveChartOptions('area'),
            colors: ['#2563eb'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: .25, opacityTo: .02, stops: [0, 100] }
            },
            stroke: { curve: 'smooth', width: 2.5 },
            dataLabels: { enabled: false },
            grid:   baseGrid,
            xaxis:  responsiveXaxis(mesesEstadisticaInventario),
            yaxis:  baseYaxisMoney,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: fmtMXN } })
        }).render();

        /* ── 2. Ventas por mes (bar) ──────────────────────────────────── */
        new ApexCharts(document.querySelector("#ventas"), {
            series: [{ name: 'Ventas', data: montosEstadisticaVenta }],
            chart:  responsiveChartOptions('bar'),
            colors: ['#10b981'],
            plotOptions: { bar: responsiveBarOptions() },
            dataLabels: responsiveDataLabels(fmtMXN),
            grid:  baseGrid,
            xaxis: Object.assign({}, responsiveXaxis(mesesEstadisticaVenta), { position: 'bottom' }),
            yaxis: baseYaxisMoney,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: fmtMXN } })
        }).render();

        /* ── 3. Inventario sin vender (bar) ──────────────────────────── */
        new ApexCharts(document.querySelector("#sinVenta"), {
            series: [{ name: 'Sin vender', data: cantidadSinVender }],
            chart:  responsiveChartOptions('bar'),
            colors: ['#f59e0b'],
            plotOptions: { bar: responsiveBarOptions() },
            dataLabels: responsiveDataLabels(function(v){ return v + ' autos'; }),
            grid:  baseGrid,
            xaxis: Object.assign({}, responsiveXaxis(mesSinVender), { position: 'bottom' }),
            yaxis: baseYaxisCount,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: function(v){ return v + ' autos'; } } })
        }).render();

        /* ── 4. Cantidad de inventario (bar) ─────────────────────────── */
        new ApexCharts(document.querySelector("#inventario"), {
            series: [{ name: 'Autos', data: cantidadEstadoInventario }],
            chart:  responsiveChartOptions('bar'),
            colors: ['#2563eb'],
            plotOptions: { bar: responsiveBarOptions() },
            dataLabels: responsiveDataLabels(function(v){ return v + ' autos'; }),
            grid:  baseGrid,
            xaxis: Object.assign({}, responsiveXaxis(mesesEstadisticaInventario), { position: 'bottom' }),
            yaxis: baseYaxisCount,
            tooltip: Object.assign({}, baseTooltip, { y: { formatter: function(v){ return v + ' autos'; } } })
        }).render();

    });
    </script>

</body>
</html>
