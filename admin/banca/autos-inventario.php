<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuarioId = (int) ($_SESSION['sesionUsuario']['id'] ?? 0);
$usuarioPermiso = (string) ($_SESSION['sesionUsuario']['permiso_banca'] ?? '');

if ($usuarioId <= 0 || !in_array($usuarioPermiso, ['Banca', 'Cashier'], true)) {
    header('Location: ../login.php');
    exit;
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Inventario - Haro</title>
    <link rel="icon" type="image/x-icon" href="media/logo.png" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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

<style id="haro-inventario-final">
/* ==========================================================
   INVENTARIO - ESTILO DASHBOARD HARO
   Solo diseño. No modifica PHP, consultas ni funcionalidades.
========================================================== */

:root {
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

body,
body.layout-boxed {
    background:
        radial-gradient(circle at top right, rgba(201,162,74,.16), transparent 32%),
        radial-gradient(circle at 7% 24%, rgba(176,20,27,.07), transparent 28%),
        linear-gradient(180deg,#fbf8f1 0%,var(--haro-bg) 46%,#eee8dc 100%) !important;
    font-family:'DM Sans','Nunito',sans-serif !important;
    color:var(--haro-ink) !important;
}

#load_screen { background:var(--haro-bg) !important; }
#load_screen .spinner-grow {
    background-color:var(--haro-red) !important;
    color:var(--haro-red) !important;
}

.layout-px-spacing { padding:30px 26px !important; }

.secondary-nav,
.breadcrumbs-container {
    background:transparent !important;
    border:0 !important;
    box-shadow:none !important;
}

.secondary-nav .header {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-line-gold) !important;
    border-radius:var(--haro-radius) !important;
    padding:20px 22px !important;
    min-height:auto !important;
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
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    border-radius:15px !important;
    background:linear-gradient(135deg,#ffffff,#f7efe2) !important;
    border:1px solid rgba(176,20,27,.18) !important;
    color:var(--haro-red) !important;
    box-shadow:0 10px 24px rgba(16,15,12,.10) !important;
    transition:transform var(--haro-transition), box-shadow var(--haro-transition), border-color var(--haro-transition);
}

.btn-toggle.sidebarCollapse:hover {
    transform:translateY(-2px);
    border-color:rgba(176,20,27,.38) !important;
    box-shadow:0 16px 32px rgba(176,20,27,.13) !important;
}

.page-header { padding:0 !important; }

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
    margin:0 !important;
    color:var(--haro-black) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:clamp(2rem,3vw,3.05rem) !important;
    font-weight:400 !important;
    letter-spacing:.035em !important;
    line-height:.94 !important;
    text-transform:uppercase;
}

.breadcrumb {
    margin:9px 0 0 !important;
}

.breadcrumb-item,
.breadcrumb-item a {
    color:var(--haro-muted) !important;
    font-size:.8rem !important;
    font-weight:700;
    text-decoration:none !important;
}

.breadcrumb-item.active { color:var(--haro-red) !important; }

.btn-add-car {
    min-height:48px;
    padding:11px 20px !important;
    border-radius:16px !important;
    background:linear-gradient(135deg,var(--haro-red),#7d1118) !important;
    border:1px solid rgba(201,162,74,.26) !important;
    color:#fff !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.1rem !important;
    font-weight:400 !important;
    letter-spacing:.07em !important;
    text-transform:uppercase;
    box-shadow:0 14px 30px rgba(176,20,27,.22) !important;
}

.btn-add-car:hover {
    background:linear-gradient(135deg,#c31d28,#7d1118) !important;
    box-shadow:0 18px 38px rgba(176,20,27,.28) !important;
    transform:translateY(-2px);
}

.inv-table-card {
    background:var(--haro-paper) !important;
    border:1px solid var(--haro-line-gold) !important;
    border-radius:var(--haro-radius) !important;
    box-shadow:var(--haro-shadow) !important;
    backdrop-filter:blur(12px);
    overflow:hidden;
    position:relative;
}

.inv-table-card::before {
    content:"";
    display:block;
    height:4px;
    background:linear-gradient(90deg,var(--haro-red),var(--haro-gold));
}

.dt--top-section {
    padding:22px 24px 18px !important;
    background:linear-gradient(135deg,rgba(176,20,27,.04),rgba(201,162,74,.08)) !important;
    border-bottom:1px solid var(--haro-line);
}

.dataTables_length label,
.dataTables_info {
    color:var(--haro-muted) !important;
    font-size:13px !important;
    font-weight:700 !important;
    font-family:'DM Sans',sans-serif !important;
}

.dataTables_length select,
.dataTables_filter input {
    background:#fff !important;
    border:1px solid rgba(201,162,74,.23) !important;
    border-radius:14px !important;
    color:var(--haro-ink) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:13px !important;
    min-height:40px;
    outline:none !important;
}

.dataTables_filter input {
    min-width:260px;
    padding:8px 14px 8px 38px !important;
}

.dataTables_filter input:focus,
.dataTables_length select:focus {
    border-color:rgba(176,20,27,.42) !important;
    box-shadow:0 0 0 4px rgba(176,20,27,.10) !important;
}

table#zero-config,
table.dataTable {
    width:100% !important;
    margin:0 !important;
    border-collapse:separate !important;
    border-spacing:0 !important;
}

table.dataTable thead th {
    background:#181411 !important;
    color:#f9efe0 !important;
    border:none !important;
    padding:16px 18px !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1rem !important;
    font-weight:400 !important;
    letter-spacing:.07em !important;
    text-transform:uppercase !important;
    white-space:nowrap;
}

table.dataTable tbody td {
    padding:16px 18px !important;
    border-color:rgba(19,19,22,.07) !important;
    color:var(--haro-ink) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:14px;
    font-weight:650;
    vertical-align:middle !important;
    background:transparent !important;
}

table.dataTable tbody tr:nth-child(even) {
    background:rgba(250,248,243,.72) !important;
}

table.dataTable tbody tr:hover {
    background:linear-gradient(90deg,rgba(176,20,27,.055),rgba(201,162,74,.055)) !important;
}

.car-thumb,
.thumb-placeholder {
    width:86px !important;
    height:60px !important;
    object-fit:cover !important;
    border-radius:16px !important;
    border:1px solid rgba(201,162,74,.22);
    box-shadow:0 12px 26px rgba(15,15,18,.12);
}

.car-name {
    color:var(--haro-black) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.25rem !important;
    font-weight:400 !important;
    letter-spacing:.04em !important;
    margin:0 !important;
}

.car-year {
    color:var(--haro-muted) !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:.82rem !important;
    font-weight:700;
}

.car-price {
    color:var(--haro-red) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-size:1.25rem !important;
    font-weight:400 !important;
    letter-spacing:.05em !important;
}

.status-badge {
    font-family:'DM Sans',sans-serif !important;
    font-size:.72rem !important;
    font-weight:800 !important;
    border-radius:999px !important;
    padding:5px 11px !important;
}

.status-badge.visible {
    background:rgba(25,135,84,.10) !important;
    color:#198754 !important;
}

.status-badge.hidden {
    background:rgba(17,17,17,.08) !important;
    color:#555 !important;
}

.status-badge.banner {
    background:rgba(201,162,74,.16) !important;
    color:#8a6422 !important;
}

.action-group {
    gap:7px !important;
}

.btn-act {
    border-radius:13px !important;
    padding:8px 12px !important;
    font-family:'DM Sans',sans-serif !important;
    font-size:.76rem !important;
    font-weight:800 !important;
    letter-spacing:.01em;
    transition:all var(--haro-transition);
}

.btn-act.green {
    background:rgba(25,135,84,.10) !important;
    color:#198754 !important;
    border-color:rgba(25,135,84,.18) !important;
}

.btn-act.yellow {
    background:rgba(201,162,74,.16) !important;
    color:#8a6422 !important;
    border-color:rgba(201,162,74,.22) !important;
}

.btn-act.blue {
    background:rgba(176,20,27,.10) !important;
    color:var(--haro-red) !important;
    border-color:rgba(176,20,27,.18) !important;
}

.btn-act.grey {
    background:rgba(17,17,17,.06) !important;
    color:#444 !important;
    border-color:rgba(17,17,17,.10) !important;
}

.btn-act.red {
    background:rgba(176,20,27,.10) !important;
    color:var(--haro-red) !important;
    border-color:rgba(176,20,27,.18) !important;
}

.btn-act:hover {
    background:linear-gradient(135deg,var(--haro-red),#7d1118) !important;
    border-color:rgba(201,162,74,.26) !important;
    color:#fff !important;
    transform:translateY(-2px);
    box-shadow:0 12px 26px rgba(176,20,27,.20);
}

.dt--bottom-section {
    border-top:1px solid var(--haro-line);
    background:rgba(250,248,243,.88) !important;
}

.dt--pagination .paginate_button,
.dataTables_paginate .paginate_button {
    border-radius:12px !important;
    border:1px solid transparent !important;
    color:var(--haro-muted) !important;
    font-family:'Bebas Neue',sans-serif !important;
    font-weight:400 !important;
    letter-spacing:.05em;
    margin:0 2px !important;
}

.dt--pagination .paginate_button.current,
.dataTables_paginate .paginate_button.current {
    background:var(--haro-red) !important;
    border-color:var(--haro-red) !important;
    color:#fff !important;
}

.swal2-popup {
    border-radius:var(--haro-radius) !important;
    font-family:'DM Sans',sans-serif !important;
}

.swal2-title {
    font-family:'Bebas Neue',sans-serif !important;
    font-weight:400 !important;
    letter-spacing:.05em;
}

.haro-footer {
    margin-top:34px !important;
}

@media(max-width:768px) {
    .layout-px-spacing { padding:22px 14px !important; }

    .secondary-nav .header {
        align-items:flex-start !important;
        padding:18px !important;
    }

    .page-title h3 { font-size:2rem !important; }

    .breadcrumb-action-dropdown {
        margin-top:12px;
        width:100%;
    }

    .btn-add-car {
        width:100%;
        justify-content:center;
    }

    .dataTables_filter input {
        min-width:100%;
        width:100% !important;
    }

    .dt--top-section .row { gap:12px; }
    .dt--top-section .row > div { width:100%; }

    .car-thumb,
    .thumb-placeholder {
        width:72px !important;
        height:52px !important;
        border-radius:13px !important;
    }

    .action-group {
        flex-direction:column;
        align-items:stretch;
    }

    .btn-act {
        width:100%;
        justify-content:center;
    }
}

@media (max-width: 992px) {
    .secondary-nav .header {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    .breadcrumb-action-dropdown {
        padding-left: 0 !important;
        margin-bottom: 10px;
    }
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
                                
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">
                                        <div class="page-title haro-page-title">
                                            <span class="haro-eyebrow">Inventario</span>
                                            <h3>Inventario de autos</h3>
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
                                            <th>id</th>
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
                                            <td><?php echo htmlspecialchars($auto->id) ?></td>
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

            <?php include_once("template/footer_haro.php"); ?></div>
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
            order: [[0, 'desc']] // default sort by price
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
