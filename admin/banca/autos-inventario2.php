<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Inventario - Haro</title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Framework styles -->
    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/dt-global_style.css">

    <style>
        /* ============================================
           DESIGN SYSTEM — WHITE PALETTE (shared)
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

            --transition: 220ms cubic-bezier(.4,0,.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--surface) !important;
            font-family: 'DM Sans', sans-serif !important;
            color: var(--ink-700) !important;
            -webkit-font-smoothing: antialiased;
        }

        .page-title h3 {
            font-family: 'Syne', sans-serif !important;
            font-weight: 700 !important;
            font-size: 1.45rem !important;
            color: var(--ink-900) !important;
            letter-spacing: -.02em;
        }

        .layout-px-spacing { padding: 28px 24px !important; }
        .layout-spacing { margin-bottom: 24px !important; }

        /* ── Add new car button ───────────────────────────────────── */
        .btn-add-car {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: var(--white) !important;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .82rem;
            letter-spacing: .02em;
            padding: 9px 20px;
            border-radius: 10px;
            border: none;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
            transition: box-shadow var(--transition), transform var(--transition), background var(--transition);
        }

        .btn-add-car:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 20px rgba(37,99,235,.4);
            transform: translateY(-1px);
            color: var(--white) !important;
        }

        .btn-add-car svg { flex-shrink: 0; }

        /* ── Table container ─────────────────────────────────────── */
        .inv-table-card {
            background: var(--white);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        /* ── DataTables overrides ────────────────────────────────── */
        .dt--top-section {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border-soft);
        }

        table.dataTable thead th {
            font-family: 'Syne', sans-serif !important;
            font-size: .72rem !important;
            font-weight: 700 !important;
            letter-spacing: .07em !important;
            text-transform: uppercase !important;
            color: var(--ink-300) !important;
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 14px 16px !important;
            white-space: nowrap;
        }

        table.dataTable tbody td {
            vertical-align: middle !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid var(--border-soft) !important;
            font-size: .88rem;
            color: var(--ink-700);
        }

        table.dataTable tbody tr {
            transition: background var(--transition);
        }

        table.dataTable tbody tr:hover {
            background: var(--accent-soft) !important;
        }

        table.dataTable tbody tr:last-child td { border-bottom: none !important; }

        /* ── Car thumbnail ───────────────────────────────────────── */
        .car-thumb {
            width: 80px;
            height: 56px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: var(--shadow-xs);
            transition: transform var(--transition), box-shadow var(--transition);
            display: block;
        }

        tr:hover .car-thumb {
            transform: scale(1.06);
            box-shadow: var(--shadow-sm);
        }

        .thumb-placeholder {
            width: 80px; height: 56px;
            border-radius: 10px;
            background: var(--surface-2);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-300);
        }

        /* ── Car name cell ───────────────────────────────────────── */
        .car-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .9rem;
            color: var(--ink-900);
            margin-bottom: 2px;
        }

        .car-year {
            font-size: .78rem;
            color: var(--ink-300);
        }

        /* ── Price cell ──────────────────────────────────────────── */
        .car-price {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: var(--accent);
            letter-spacing: -.02em;
        }

        /* ── Status badge ────────────────────────────────────────── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .status-badge.visible  { background: var(--success-soft); color: var(--success); }
        .status-badge.hidden   { background: var(--surface-2);    color: var(--ink-300); }
        .status-badge.banner   { background: var(--accent-soft);  color: var(--accent); }
        .status-badge.dot::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        /* ── Action buttons ──────────────────────────────────────── */
        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        .btn-act {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
            text-decoration: none !important;
        }

        .btn-act.green {
            background: var(--success-soft);
            color: var(--success);
            border-color: rgba(16,185,129,.2);
        }
        .btn-act.green:hover {
            background: var(--success);
            color: var(--white);
            border-color: var(--success);
        }

        .btn-act.yellow {
            background: var(--warning-soft);
            color: var(--warning);
            border-color: rgba(245,158,11,.2);
        }
        .btn-act.yellow:hover {
            background: var(--warning);
            color: var(--white);
            border-color: var(--warning);
        }

        .btn-act.red {
            background: var(--danger-soft);
            color: var(--danger);
            border-color: rgba(239,68,68,.2);
        }
        .btn-act.red:hover {
            background: var(--danger);
            color: var(--white);
            border-color: var(--danger);
        }

        .btn-act.blue {
            background: var(--accent-soft);
            color: var(--accent);
            border-color: rgba(37,99,235,.2);
        }
        .btn-act.blue:hover {
            background: var(--accent);
            color: var(--white);
            border-color: var(--accent);
        }

        .btn-act.grey {
            background: var(--surface-2);
            color: var(--ink-500);
            border-color: var(--border);
        }
        .btn-act.grey:hover {
            background: var(--ink-500);
            color: var(--white);
            border-color: var(--ink-500);
        }

        /* ── DataTable search & length ───────────────────────────── */
        .dataTables_filter input {
            border: 1.5px solid var(--border) !important;
            border-radius: 10px !important;
            padding: 7px 14px 7px 38px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: .85rem !important;
            color: var(--ink-700) !important;
            background: var(--surface) !important;
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none !important;
        }

        .dataTables_filter input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1) !important;
        }

        .dataTables_length select {
            border: 1.5px solid var(--border) !important;
            border-radius: 10px !important;
            padding: 6px 32px 6px 12px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: .85rem !important;
            color: var(--ink-700) !important;
            background: var(--surface) !important;
            outline: none !important;
            appearance: auto;
        }

        .dataTables_info,
        .dataTables_length label {
            font-size: .82rem !important;
            color: var(--ink-300) !important;
            font-family: 'DM Sans', sans-serif !important;
        }

        /* ── Pagination ──────────────────────────────────────────── */
        .dt--pagination .paginate_button {
            border-radius: 8px !important;
            font-family: 'Syne', sans-serif !important;
            font-size: .8rem !important;
            font-weight: 600 !important;
        }

        .dt--pagination .paginate_button.current {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--white) !important;
        }

        /* ── Footer ──────────────────────────────────────────────── */
        .footer-wrapper {
            border-top: 1px solid var(--border-soft);
            padding: 20px 28px !important;
            background: var(--white) !important;
            font-size: .8rem;
            color: var(--ink-300);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Animations ──────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-up { animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both; }

        /* ── SweetAlert2 overrides ───────────────────────────────── */
        .swal2-popup {
            border-radius: var(--radius-lg) !important;
            font-family: 'DM Sans', sans-serif !important;
        }
        .swal2-title {
            font-family: 'Syne', sans-serif !important;
            font-weight: 700 !important;
            color: var(--ink-900) !important;
        }
        .swal2-confirm {
            border-radius: 10px !important;
            font-family: 'Syne', sans-serif !important;
            font-weight: 700 !important;
        }
        .swal2-cancel {
            border-radius: 10px !important;
            font-family: 'Syne', sans-serif !important;
            font-weight: 600 !important;
        }

        /* ── Responsive ──────────────────────────────────────────── */
        @media (max-width: 768px) {
            .car-thumb { width: 60px; height: 42px; }
            .action-group { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>

<body class="layout-boxed enable-secondaryNav">

    <!-- LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center" style="color:#2563eb;"></div>
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
        $adminAutos = new AdministradorAutos();
        $autos = $adminAutos->dameAutos();
        ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">

                    <!-- BREADCRUMBS -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Inventario">
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
                                            <h3>Inventario de Autos</h3>
                                        </div>
                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Inventario</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>

                                <!-- Add new car button -->
                                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                                    <li class="nav-item">
                                        <a href="./auto-nuevo.php" class="btn-add-car">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Agregar auto
                                        </a>
                                    </li>
                                </ul>
                            </header>
                        </div>
                    </div>

                    <div class="row layout-top-spacing">
                        <div class="col-12 layout-spacing animate-up">
                            <div class="inv-table-card">
                                <table id="zero-config" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Vehículo</th>
                                            <th>Precio</th>
                                            <th style="display:none;">PrecioSort</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($autos as $auto):
                                            $imagen = ($auto->imagen != "") ? $auto->imagen : (isset($auto->imagenes[0]) ? $auto->imagenes[0]->url : '');
                                            $isHidden = $auto->pausado;
                                            $hasBanner = !$isHidden && $auto->banner;
                                        ?>
                                        <tr>
                                            <!-- Thumbnail -->
                                            <td>
                                                <?php if ($imagen): ?>
                                                    <a target="_blank" href="venta-nueva.php?auto=<?php echo $auto->id ?>">
                                                        <img class="car-thumb" src="<?php echo htmlspecialchars($imagen) ?>" alt="<?php echo htmlspecialchars($auto->marca->marca . ' ' . $auto->modelo->modelo) ?>">
                                                    </a>
                                                <?php else: ?>
                                                    <div class="thumb-placeholder">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Name -->
                                            <td>
                                                <div class="car-name"><?php echo htmlspecialchars($auto->marca->marca . ' ' . $auto->modelo->modelo) ?></div>
                                                <div class="car-year"><?php echo htmlspecialchars($auto->anio) ?></div>
                                            </td>

                                            <!-- Price formatted -->
                                            <td>
                                                <div class="car-price">$<?php echo number_format($auto->precio, 0) ?></div>
                                            </td>

                                            <!-- Hidden sort column -->
                                            <td style="display:none;"><?php echo $auto->precio ?></td>

                                            <!-- Status badges -->
                                            <td>
                                                <div style="display:flex;flex-direction:column;gap:4px;">
                                                    <?php if ($isHidden): ?>
                                                        <span class="status-badge hidden dot">Oculto</span>
                                                    <?php else: ?>
                                                        <span class="status-badge visible dot">Visible</span>
                                                    <?php endif; ?>
                                                    <?php if ($hasBanner): ?>
                                                        <span class="status-badge banner dot">Banner</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="action-group">
                                                    <a target="_blank" href="venta-nueva.php?auto=<?php echo $auto->id ?>" class="btn-act green">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                                        Venta nueva
                                                    </a>

                                                    <a target="_blank" href="auto-mod.php?id=<?php echo $auto->id ?>" class="btn-act yellow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                        Editar
                                                    </a>

                                                    <button onclick="renovar(<?php echo $auto->id ?>)" class="btn-act blue">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                                        Renovar
                                                    </button>

                                                    <a target="_blank" href="https://seminuevosharo.mx/admin/banca/genqr.php?id_auto=<?php echo $auto->id ?>" class="btn-act grey">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                                            <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                            <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                            <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                                                            <rect x="13" y="13" width="3" height="3" rx="0.5" fill="currentColor"/>
                                                            <rect x="16" y="16" width="3" height="3" rx="0.5" fill="currentColor"/>
                                                            <rect x="19" y="13" width="3" height="3" rx="0.5" fill="currentColor"/>
                                                            <rect x="19" y="19" width="3" height="3" rx="0.5" fill="currentColor"/>
                                                            <rect x="13" y="19" width="3" height="3" rx="0.5" fill="currentColor"/>
                                                        </svg>
                                                        Obtener código QR
                                                    </a>

                                                    <?php if ($isHidden): ?>
                                                        <button onclick="despausar(<?php echo $auto->id ?>)" class="btn-act green">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                            Poner visible
                                                        </button>
                                                    <?php else: ?>
                                                        <button onclick="pausar(<?php echo $auto->id ?>)" class="btn-act grey">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                                            Ocultar
                                                        </button>

                                                        <?php if ($auto->banner): ?>
                                                            <button onclick="bannerBaja(<?php echo $auto->id ?>)" class="btn-act grey">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                                                Quitar banner
                                                            </button>
                                                        <?php else: ?>
                                                            <button onclick="bannerAlta(<?php echo $auto->id ?>)" class="btn-act blue">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="14" rx="2"/><polyline points="3 15 9 9 13 13 16 10 21 15"/></svg>
                                                                Poner en banner
                                                            </button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <button onclick="eliminar(<?php echo $auto->id ?>)" class="btn-act red">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer-wrapper">
                <p style="margin:0;">Copyright © <span class="dynamic-year">2024</span> Banca Haro — Todos los derechos reservados.</p>
                <p style="margin:0;display:flex;align-items:center;gap:5px;">Hecho con
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    en Guadalajara
                </p>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
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

    <script>
        // ─── DataTable init ────────────────────────────────────────────────────
        $('#zero-config').DataTable({
            dom: "<'dt--top-section'<'row align-items-center'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                 "<'table-responsive'tr>" +
                 "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center px-4 py-3'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: {
                    sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
                    sNext:     '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>'
                },
                sInfo:             "Mostrando página _PAGE_ de _PAGES_",
                sSearch:           '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
                sSearchPlaceholder:"Buscar vehículo...",
                sLengthMenu:       "Mostrar _MENU_ registros",
                sZeroRecords:      "No se encontraron vehículos",
                sEmptyTable:       "No hay vehículos en inventario"
            },
            stripeClasses: [],
            lengthMenu: [7, 10, 20, 50],
            pageLength: 10,
            columnDefs: [
                { orderable: false, targets: [0, 4, 5] }, // thumb, status, actions not sortable
                { visible: false, targets: 3 }             // hide raw price col
            ],
            order: [[2, 'asc']] // default sort by price
        });

        // ─── Shared API call helper ────────────────────────────────────────────
        function apiAuto(accion, id) {
            const f = new FormData();
            f.append("accion", accion);
            f.append("id", id);
            return fetch("../api/apiAuto.php", { method: "POST", body: f })
                   .then(r => r.json());
        }

        // ─── Swal theme presets ────────────────────────────────────────────────
        const swalConfirm = {
            confirmButtonColor: '#2563eb',
            cancelButtonColor:  '#ef4444',
            reverseButtons: true
        };

        // ─── Eliminar ──────────────────────────────────────────────────────────
        function eliminar(id) {
            Swal.fire({
                title: '¿Eliminar vehículo?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                ...swalConfirm
            }).then(r => {
                if (!r.isConfirmed) return;
                apiAuto("eliminar", id).then(() => {
                    Swal.fire({ title: 'Eliminado', text: 'El vehículo fue eliminado.', icon: 'success', confirmButtonColor: '#2563eb' })
                        .then(r2 => { if (r2.isConfirmed) location.reload(); });
                });
            });
        }

        // ─── Renovar ──────────────────────────────────────────────────────────
        function renovar(id) {
            Swal.fire({
                title: '¿Renovar vehículo?',
                text: 'Se actualizará la fecha del auto.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, renovar',
                cancelButtonText: 'Cancelar',
                ...swalConfirm
            }).then(r => {
                if (!r.isConfirmed) return;
                apiAuto("renovar", id).then(data => {
                    if (data == "1") location.reload();
                });
            });
        }

        // ─── Pausar / Despausar ────────────────────────────────────────────────
        function pausar(id)    { apiAuto("pausar",    id).then(d => { if (d == "1") location.reload(); }); }
        function despausar(id) { apiAuto("despausar", id).then(d => { if (d == "1") location.reload(); }); }

        // ─── Banner Alta / Baja ────────────────────────────────────────────────
        function bannerAlta(id) { apiAuto("banner",  id).then(d => { if (d == "1") location.reload(); }); }
        function bannerBaja(id) { apiAuto("ebanner", id).then(d => { if (d == "1") location.reload(); }); }
    </script>

</body>
</html>
