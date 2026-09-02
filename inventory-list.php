<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Inventario | Haro Seminuevos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/master.css">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --ink:      #0d0f14;
      --ink-soft: #1a1d26;
      --surface:  #f5f4f0;
      --card:     #ffffff;
      --accent:   #c8102e;
      --accent-2: #ff3d5a;
      --gold:     #d4a843;
      --muted:    #8a8d99;
      --border:   #e4e3de;
      --text:     #1a1d26;
      --text-lt:  #5a5d6b;
      --radius:   14px;
      --trans:    0.28s cubic-bezier(.4,0,.2,1);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--surface);
      color: var(--text);
      -webkit-font-smoothing: antialiased;
    }

    /* ── HERO ───────────────────────────────────── */
    .inv-hero {
      background: var(--ink); padding: 52px 0 36px;
      position: relative; overflow: hidden;
    }
    .inv-hero::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 60% 80% at 80% 50%, rgba(200,16,46,.18) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(212,168,67,.10) 0%, transparent 60%);
    }
    .inv-hero .container { position: relative; z-index: 1; }
    .inv-hero h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(1.8rem, 5vw, 2.8rem);
      color: #fff; letter-spacing: .04em;
    }
    .breadcrumb {
      display: flex; gap: 8px; align-items: center;
      list-style: none; margin-top: 8px;
    }
    .breadcrumb li { font-size: .82rem; color: var(--muted); }
    .breadcrumb li a { color: var(--gold); text-decoration: none; transition: opacity var(--trans); }
    .breadcrumb li a:hover { opacity: .75; }
    .breadcrumb li + li::before { content: '›'; margin-right: 8px; }

    /* ── LAYOUT ─────────────────────────────────── */
    .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .inv-body  { padding: 40px 0 80px; }
    .inv-grid  {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 28px;
      align-items: start;
    }
    @media (max-width: 900px) { .inv-grid { grid-template-columns: 1fr; } }

    /* ── SIDEBAR ────────────────────────────────── */
    .inv-sidebar { display: flex; flex-direction: column; gap: 16px; }
    @media (min-width: 901px) { .inv-sidebar { position: sticky; top: 24px; } }

    .sidebar-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }
    .sidebar-card-header {
      background: var(--ink); color: #fff;
      padding: 14px 20px;
      display: flex; align-items: center; gap: 10px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.05rem; letter-spacing: .1em;
    }
    .sidebar-card-header i { color: var(--gold); }
    .sidebar-card-body { padding: 20px; }

    /* filter section label */
    .filter-label {
      font-size: .68rem; font-weight: 700; letter-spacing: .14em;
      text-transform: uppercase; color: var(--muted);
      margin-bottom: 8px; display: block;
    }

    /* text search */
    .inv-input {
      width: 100%;
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 9px;
      padding: 10px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: .9rem; color: var(--text);
      outline: none; margin-bottom: 12px;
      transition: border-color var(--trans), box-shadow var(--trans);
    }
    .inv-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(200,16,46,.1);
    }
    .inv-input::placeholder { color: var(--muted); }

    /* price display row */
    .price-row {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px; gap: 8px;
    }
    .price-val {
      flex: 1; background: var(--surface);
      border: 1.5px solid var(--border); border-radius: 8px;
      padding: 8px 10px; font-size: .88rem; font-weight: 600;
      color: var(--text); text-align: center;
    }
    .price-sep { color: var(--muted); font-size: .8rem; }

    /* range slider */
    .range-wrap { position: relative; height: 20px; margin: 18px 0 8px; }
    .range-track {
      position: absolute; top: 50%; transform: translateY(-50%);
      left: 0; right: 0; height: 4px;
      background: var(--border); border-radius: 4px; pointer-events: none;
    }
    .range-fill {
      position: absolute; height: 100%;
      background: var(--accent); border-radius: 4px;
    }
    input[type="range"].inv-range {
      -webkit-appearance: none; appearance: none;
      position: absolute; top: 50%; transform: translateY(-50%);
      width: 100%; height: 4px; background: transparent;
      pointer-events: none; outline: none;
    }
    input[type="range"].inv-range::-webkit-slider-thumb {
      -webkit-appearance: none;
      pointer-events: all; width: 20px; height: 20px;
      background: var(--card); border-radius: 50%;
      border: 2px solid var(--accent);
      box-shadow: 0 2px 6px rgba(0,0,0,.15);
      cursor: pointer; transition: transform var(--trans);
    }
    input[type="range"].inv-range::-webkit-slider-thumb:hover { transform: scale(1.2); }
    input[type="range"].inv-range::-moz-range-thumb {
      pointer-events: all; width: 20px; height: 20px;
      background: var(--card); border-radius: 50%;
      border: 2px solid var(--accent); cursor: pointer;
    }
    #fromSlider { z-index: 1; }
    #toSlider   { z-index: 2; }

    /* year inputs */
    .year-row {
      display: flex; gap: 10px; margin-top: 14px; margin-bottom: 14px;
    }
    .year-group { flex: 1; display: flex; flex-direction: column; gap: 4px; }
    .year-group label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }
    input[type="number"].year-input {
      width: 100%; background: var(--surface);
      border: 1.5px solid var(--border); border-radius: 8px;
      padding: 9px 10px; font-family: 'DM Sans', sans-serif;
      font-size: .92rem; font-weight: 600; color: var(--text);
      text-align: center; outline: none;
      transition: border-color var(--trans), box-shadow var(--trans);
    }
    input[type="number"].year-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(200,16,46,.1);
    }
    /* hide spinners */
    input[type="number"].year-input::-webkit-inner-spin-button,
    input[type="number"].year-input::-webkit-outer-spin-button { -webkit-appearance: none; }

    /* hidden inputs for form */
    .d-none { display: none !important; }

    /* sidebar divider */
    .sidebar-divider {
      border: none; border-top: 1px solid var(--border);
      margin: 16px 0;
    }

    /* filter btn */
    .btn-filter {
      width: 100%; background: var(--accent); color: #fff; border: none;
      padding: 11px; border-radius: 9px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1rem; letter-spacing: .1em; cursor: pointer;
      transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
      margin-top: 6px;
    }
    .btn-filter:hover {
      background: var(--accent-2); transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(200,16,46,.22);
    }

    /* Car Hunter card */
    .carhunter-img {
      display: block; margin: 10px auto 16px;
      max-width: 130px;
    }
    .carhunter-text {
      font-size: .85rem; color: var(--text-lt); text-align: center;
      line-height: 1.55; margin-bottom: 16px;
    }

    /* ── RESULTS HEADER ─────────────────────────── */
    .results-header {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 12px;
      margin-bottom: 22px;
    }
    .results-count {
      font-size: .9rem; color: var(--text-lt);
    }
    .results-count strong { color: var(--text); font-weight: 700; }

    .view-toggle { display: flex; gap: 6px; }
    .view-btn {
      width: 36px; height: 36px; border-radius: 8px;
      border: 1.5px solid var(--border);
      background: var(--card); color: var(--muted);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: .85rem;
      transition: all var(--trans);
    }
    .view-btn.active, .view-btn:hover {
      background: var(--ink); border-color: var(--ink); color: #fff;
    }

    /* ── VEHICLE CARDS (list mode) ──────────────── */
    .vehicles-list { display: flex; flex-direction: column; gap: 18px; }

    .vcard {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      display: flex;
      transition: box-shadow var(--trans), transform var(--trans);
      text-decoration: none; color: inherit;
    }
    .vcard:hover {
      box-shadow: 0 8px 28px rgba(13,15,20,.1);
      transform: translateY(-2px);
    }

    .vcard-img-wrap {
      flex: 0 0 260px; position: relative; overflow: hidden;
      background: #eee;
    }
    @media (max-width: 700px) { .vcard-img-wrap { flex: 0 0 120px; } }
    @media (max-width: 500px) { .vcard { flex-direction: column; } .vcard-img-wrap { flex: none; height: 200px; } }

    .vcard-img-wrap img {
      width: 100%; height: 100%;
      object-fit: cover; display: block;
      transition: transform .5s ease;
    }
    .vcard:hover .vcard-img-wrap img { transform: scale(1.04); }

    .vcard-overlay {
      position: absolute; inset: 0;
      background: rgba(13,15,20,0);
      display: flex; align-items: center; justify-content: center;
      transition: background var(--trans);
    }
    .vcard:hover .vcard-overlay { background: rgba(13,15,20,.35); }
    .vcard-overlay-icon {
      width: 44px; height: 44px; border-radius: 50%;
      background: #fff; color: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-size: .9rem; opacity: 0;
      transition: opacity var(--trans), transform var(--trans);
      transform: scale(.7);
    }
    .vcard:hover .vcard-overlay-icon { opacity: 1; transform: scale(1); }

    .vcard-body { flex: 1; padding: 20px 22px; display: flex; flex-direction: column; gap: 10px; }
    @media (max-width: 700px) { .vcard-body { padding: 14px 16px; } }

    .vcard-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.45rem; letter-spacing: .04em; color: var(--ink);
      line-height: 1.1; text-decoration: none;
    }
    .vcard-desc {
      font-size: .84rem; color: var(--text-lt); line-height: 1.6;
    }

    .vcard-specs {
      display: flex; flex-wrap: wrap; gap: 8px;
      list-style: none;
    }
    .vcard-spec {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 4px 10px;
      font-size: .75rem; font-weight: 600;
      color: var(--text-lt);
      display: flex; align-items: center; gap: 5px;
    }
    .vcard-spec i { color: var(--accent); font-size: .7rem; }

    .vcard-footer {
      display: flex; align-items: center;
      justify-content: space-between; flex-wrap: wrap; gap: 8px;
      margin-top: auto; padding-top: 10px;
      border-top: 1px solid var(--border);
    }
    .vcard-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.6rem; letter-spacing: .02em; color: var(--accent);
      line-height: 1;
    }
    .vcard-price-label { font-size: .68rem; color: var(--muted); margin-bottom: 2px; }
    .vcard-cta {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--ink); color: #fff;
      padding: 9px 18px; border-radius: 9px;
      font-size: .82rem; font-weight: 600; text-decoration: none;
      transition: background var(--trans), transform var(--trans);
    }
    .vcard-cta:hover { background: var(--accent); transform: translateY(-1px); }

    /* ── GRID MODE ──────────────────────────────── */
    .vehicles-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 18px;
    }

    .vcard-grid {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      display: flex; flex-direction: column;
      text-decoration: none; color: inherit;
      transition: box-shadow var(--trans), transform var(--trans);
    }
    .vcard-grid:hover {
      box-shadow: 0 8px 28px rgba(13,15,20,.1);
      transform: translateY(-3px);
    }
    .vcard-grid-img {
      height: 180px; overflow: hidden; position: relative;
      background: #eee;
    }
    .vcard-grid-img img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform .5s ease;
    }
    .vcard-grid:hover .vcard-grid-img img { transform: scale(1.06); }
    .vcard-grid-img .vcard-overlay { display: flex; }
    .vcard-grid-body { padding: 16px 18px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .vcard-grid-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.2rem; letter-spacing: .04em; color: var(--ink); line-height: 1.1;
    }
    .vcard-grid-specs { display: flex; flex-wrap: wrap; gap: 6px; }
    .vcard-grid-footer {
      margin-top: auto; padding-top: 10px;
      border-top: 1px solid var(--border);
      display: flex; align-items: flex-end; justify-content: space-between;
    }
    .vcard-grid-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.35rem; color: var(--accent); line-height: 1;
    }
    .vcard-grid-price-label { font-size: .65rem; color: var(--muted); margin-bottom: 2px; }

    /* hidden by default */
    .vehicles-grid { display: none; }

    /* ── PAGINATION ─────────────────────────────── */
    .inv-pagination {
      display: flex; justify-content: center; gap: 6px;
      margin-top: 36px; flex-wrap: wrap;
    }
    .page-btn {
      min-width: 38px; height: 38px; padding: 0 10px;
      border-radius: 9px; border: 1.5px solid var(--border);
      background: var(--card); color: var(--text-lt);
      font-family: 'DM Sans', sans-serif; font-size: .88rem; font-weight: 500;
      display: flex; align-items: center; justify-content: center;
      text-decoration: none; cursor: pointer;
      transition: all var(--trans);
    }
    .page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .page-btn.active {
      background: var(--accent); border-color: var(--accent);
      color: #fff; font-weight: 700;
    }
    .page-btn.disabled { opacity: .35; pointer-events: none; }

    /* ── EMPTY STATE ────────────────────────────── */
    .inv-empty {
      text-align: center; padding: 60px 20px; color: var(--text-lt);
    }
    .inv-empty i { font-size: 3rem; color: var(--border); margin-bottom: 16px; display: block; }
    .inv-empty h3 { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; color: var(--ink); margin-bottom: 8px; }
  </style>
</head>

<body class="page">
<?php include 'template/header.php'; ?>

<?php
include_once('admin/api/adminAutos.php');
$adminAutos = new AdministradorAutos();
if (!function_exists('haroFormatoNumero')) {
  function haroFormatoNumero(mixed $valor): string {
    return is_numeric($valor) ? number_format((float) $valor) : 'N/E';
  }
}
if (isset($_GET['marca'], $_GET['modelo'], $_GET['estatus'], $_GET['transmicion'], $_GET['combustible'])) {
  $autos = $adminAutos->dameAutosBusqueda((int) $_GET['marca'], (int) $_GET['modelo'], (string) $_GET['estatus'], (int) $_GET['transmicion'], (string) $_GET['combustible']);
} elseif (isset($_GET['min']) && isset($_GET['max'])) {
  $autos = $adminAutos->dameAutosPorPrecio((int) $_GET['min'], (int) $_GET['max']);
} else if (isset($_GET['marca'])) {
  $autos = $adminAutos->dameAutosMarca((int) $_GET['marca']);
} else if (isset($_GET['buscar'])) {
  $autos = $adminAutos->dameAutosBuscados(trim((string) $_GET['buscar']));
} else if (isset($_GET['pagina'])) {
  $pagina = max(1, (int) $_GET['pagina']);
  $autos = $adminAutos->dameAutosPaginacion($pagina);
} else if (isset($_GET['amin']) && isset($_GET['amax'])) {
  $autos = $adminAutos->dameAutosPorAnio((int) $_GET['amin'], (int) $_GET['amax']);
} else {
  $pagina = 1;
  $autos = $adminAutos->dameAutosPaginacion(1);
}
$adminAutosBuscarPrecio = $adminAutos;
[$max, $min] = $adminAutosBuscarPrecio->dameMaximoMinimo();
[$minAnio, $maxAnio] = $adminAutosBuscarPrecio->dameRangoAnios();
$min = str_replace(',', '', (string) $min);
$max = str_replace(',', '', (string) $max);
$minAnio = str_replace(',', '', (string) $minAnio);
$maxAnio = str_replace(',', '', (string) $maxAnio);
?>

<!-- HERO -->
<div class="inv-hero">
  <div class="container">
    <h1>Inventario de Vehículos</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Inventario</li>
      </ol>
    </nav>
  </div>
</div>

<!-- BODY -->
<div class="inv-body">
  <div class="container">
    <div class="inv-grid">

      <!-- ── SIDEBAR ─────────────────────────────── -->
      <aside class="inv-sidebar">

        <!-- Text search -->
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <i class="fas fa-magnifying-glass"></i> Buscar Vehículo
          </div>
          <div class="sidebar-card-body">
            <form action="" method="GET">
              <label class="filter-label">¿Qué auto buscas?</label>
              <input type="text" name="buscar" class="inv-input"
                     placeholder="Marca, modelo, transmisión…"
                     value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
              <button type="submit" class="btn-filter">
                <i class="fas fa-search" style="margin-right:6px"></i> Buscar
              </button>
            </form>
          </div>
        </div>

        <!-- Price filter -->
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <i class="fas fa-tag"></i> Filtrar por Precio
          </div>
          <div class="sidebar-card-body">
            <form method="GET">
              <div class="price-row">
                <div style="flex:1">
                  <div style="font-size:.65rem;color:var(--muted);font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:4px">Desde</div>
                  <div class="price-val" id="display-min">$<?php echo number_format($min); ?></div>
                </div>
                <div class="price-sep">—</div>
                <div style="flex:1">
                  <div style="font-size:.65rem;color:var(--muted);font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:4px">Hasta</div>
                  <div class="price-val" id="display-max">$<?php echo number_format($max); ?></div>
                </div>
              </div>

              <div class="range-wrap">
                <div class="range-track"><div class="range-fill" id="price-fill"></div></div>
                <input type="range" class="inv-range" id="fromSlider"
                       min="<?php echo $min; ?>" max="<?php echo $max; ?>"
                       value="<?php echo $min; ?>">
                <input type="range" class="inv-range" id="toSlider"
                       min="<?php echo $min; ?>" max="<?php echo $max; ?>"
                       value="<?php echo $max; ?>">
              </div>

              <input type="hidden" name="min" id="input-with-keypress-0" value="<?php echo $min; ?>">
              <input type="hidden" name="max" id="input-with-keypress-1" value="<?php echo $max; ?>">
              <button type="submit" class="btn-filter" style="margin-top:14px">Ver Resultados</button>
            </form>
          </div>
        </div>

        <!-- Year filter -->
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <i class="fas fa-calendar"></i> Filtrar por Año
          </div>
          <div class="sidebar-card-body">
            <div class="range-wrap">
              <div class="range-track"><div class="range-fill" id="year-fill"></div></div>
              <input type="range" class="inv-range" id="fromSliderYear"
                     min="<?php echo $minAnio; ?>" max="<?php echo $maxAnio; ?>"
                     value="<?php echo $minAnio; ?>">
              <input type="range" class="inv-range" id="toSliderYear"
                     min="<?php echo $minAnio; ?>" max="<?php echo $maxAnio; ?>"
                     value="<?php echo $maxAnio; ?>">
            </div>
            <div class="year-row">
              <div class="year-group">
                <label for="fromInput">Del año</label>
                <input type="number" class="year-input" id="fromInput"
                       value="<?php echo $minAnio; ?>"
                       min="<?php echo $minAnio; ?>" max="<?php echo $maxAnio; ?>">
              </div>
              <div class="year-group">
                <label for="toInput">Al año</label>
                <input type="number" class="year-input" id="toInput"
                       value="<?php echo $maxAnio; ?>"
                       min="<?php echo $minAnio; ?>" max="<?php echo $maxAnio; ?>">
              </div>
            </div>
            <button type="button" onclick="buscarAnios()" class="btn-filter">Ver Resultados</button>
          </div>
        </div>

        <!-- Car Hunter -->
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <i class="fas fa-crosshairs"></i> Car Hunter
          </div>
          <div class="sidebar-card-body" style="text-align:center">
            <img src="Imagenes/carHunter/carhunter-logo1.png" alt="Car Hunter" class="carhunter-img">
            <p class="carhunter-text">Encuentra el vehículo exacto que estás buscando</p>
            <a href="car-hunter.php" class="btn-filter" style="display:block;text-align:center;text-decoration:none">
              <i class="fas fa-search-location" style="margin-right:6px"></i> Buscar Ahora
            </a>
          </div>
        </div>

      </aside>

      <!-- ── MAIN CONTENT ───────────────────────── -->
      <div class="inv-main">

        <!-- Results header -->
        <div class="results-header">
          <div class="results-count">
            <?php
            $n = count($autos);
            if ($n <= 1) {
              echo 'Se encontró <strong>' . $n . '</strong> resultado';
            } else {
              echo 'Se encontraron <strong>' . $n . '</strong> resultados';
            }
            ?>
          </div>
          <div class="view-toggle">
            <button class="view-btn active" id="btn-list" title="Vista lista">
              <i class="fas fa-list"></i>
            </button>
            <button class="view-btn" id="btn-grid" title="Vista cuadrícula">
              <i class="fas fa-th"></i>
            </button>
          </div>
        </div>

        <?php
        function limpiaCaracteresEspeciales($cadena) {
          $map = ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','ñ'=>'n','Ñ'=>'N','´'=>'','¨'=>'','º'=>'','ª'=>'','·'=>'',' '=>'-',''=>'','Â'=>''];
          return str_replace(array_keys($map), array_values($map), $cadena);
        }

        $visibles = array_filter($autos, function($a) { return !$a->pausado; });
        ?>

        <?php if (empty($visibles)): ?>
        <div class="inv-empty">
          <i class="fas fa-car-side"></i>
          <h3>No se encontraron vehículos</h3>
          <p>Intenta ajustar los filtros de búsqueda.</p>
        </div>
        <?php else: ?>

        <!-- LIST VIEW -->
        <div class="vehicles-list" id="view-list">
          <?php foreach ($autos as $auto):
            if ($auto->pausado) continue;
            $imgSrc = !empty($auto->imagen) ? $auto->imagen : ($auto->imagenes[0]->url ?? 'assets/media/content/b-goods/main-slider/main/1.jpg');
            $descripcion = (string) ($auto->descripcion ?? '');
            $desc = strlen($descripcion) > 90 ? substr($descripcion, 0, 90) . '…' : $descripcion;
          ?>
          <a class="vcard" href="vehicle-details.php?auto=<?php echo $auto->id; ?>">
            <div class="vcard-img-wrap">
              <img src="<?php echo $imgSrc; ?>" alt="<?php echo $auto->marca->marca . ' ' . $auto->modelo->modelo; ?>" loading="lazy">
              <div class="vcard-overlay">
                <div class="vcard-overlay-icon"><i class="fas fa-eye"></i></div>
              </div>
            </div>
            <div class="vcard-body">
              <div class="vcard-title">
                <?php echo strtoupper($auto->marca->marca) . ' ' . $auto->modelo->modelo; ?>
              </div>
              <div class="vcard-desc"><?php echo limpiaCaracteresEspeciales($desc); ?></div>
              <ul class="vcard-specs">
                <li class="vcard-spec"><i class="fas fa-calendar-alt"></i> <?php echo $auto->anio; ?></li>
                <li class="vcard-spec"><i class="fas fa-cog"></i> <?php echo $auto->transmicion->transmicion; ?></li>
                <li class="vcard-spec"><i class="fas fa-gas-pump"></i> <?php echo $auto->combustible; ?></li>
                <li class="vcard-spec"><i class="fas fa-palette"></i> <?php echo $auto->color; ?></li>
                <li class="vcard-spec"><i class="fas fa-road"></i> <?php echo haroFormatoNumero($auto->kilometrage); ?> km</li>
              </ul>
              <div class="vcard-footer">
                <div>
                  <?php if ($auto->precio): ?>
                  <div class="vcard-price-label">PRECIO</div>
                  <div class="vcard-price">$<?php echo number_format($auto->precio); ?></div>
                  <?php endif; ?>
                </div>
                <span class="vcard-cta">Ver detalles <i class="fas fa-arrow-right"></i></span>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>

        <!-- GRID VIEW -->
        <div class="vehicles-grid" id="view-grid">
          <?php foreach ($autos as $auto):
            if ($auto->pausado) continue;
            $imgSrc = !empty($auto->imagen) ? $auto->imagen : ($auto->imagenes[0]->url ?? 'assets/media/content/b-goods/main-slider/main/1.jpg');
          ?>
          <a class="vcard-grid" href="vehicle-details.php?auto=<?php echo $auto->id; ?>">
            <div class="vcard-grid-img">
              <img src="<?php echo $imgSrc; ?>" alt="<?php echo $auto->marca->marca . ' ' . $auto->modelo->modelo; ?>" loading="lazy">
              <div class="vcard-overlay">
                <div class="vcard-overlay-icon"><i class="fas fa-eye"></i></div>
              </div>
            </div>
            <div class="vcard-grid-body">
              <div class="vcard-grid-title">
                <?php echo strtoupper($auto->marca->marca) . ' ' . $auto->modelo->modelo; ?>
              </div>
              <div class="vcard-grid-specs">
                <span class="vcard-spec"><i class="fas fa-calendar-alt"></i> <?php echo $auto->anio; ?></span>
                <span class="vcard-spec"><i class="fas fa-cog"></i> <?php echo $auto->transmicion->transmicion; ?></span>
                <span class="vcard-spec"><i class="fas fa-road"></i> <?php echo haroFormatoNumero($auto->kilometrage); ?> km</span>
              </div>
              <div class="vcard-grid-footer">
                <?php if ($auto->precio): ?>
                <div>
                  <div class="vcard-grid-price-label">PRECIO</div>
                  <div class="vcard-grid-price">$<?php echo number_format($auto->precio); ?></div>
                </div>
                <?php endif; ?>
                <span style="font-size:.78rem;color:var(--accent);font-weight:600">Ver más →</span>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>

        <?php endif; ?>

        <!-- PAGINATION -->
        <nav class="inv-pagination" aria-label="Paginación">
          <?php
          if (!isset($_GET['marca'])) {
            $total_paginas = ceil($adminAutos->cuentaAutos() / 6) - 2;
            $maximo_botones = 5;
            if ($total_paginas > 0) {
              if ($pagina > 1) {
                echo '<a class="page-btn" href="inventory-list.php?pagina=1" title="Primera"><i class="fas fa-angles-left"></i></a>';
                echo '<a class="page-btn" href="inventory-list.php?pagina=' . ($pagina - 1) . '" title="Anterior"><i class="fas fa-angle-left"></i></a>';
              }
              $inicio = max(1, min($pagina - floor($maximo_botones / 2), $total_paginas - $maximo_botones + 1));
              $fin = min($inicio + $maximo_botones - 1, $total_paginas);
              for ($i = $inicio; $i <= $fin; $i++) {
                $active = $i == $pagina ? 'active' : '';
                echo '<a class="page-btn ' . $active . '" href="inventory-list.php?pagina=' . $i . '">' . $i . '</a>';
              }
              if ($pagina < $total_paginas - 2) {
                echo '<a class="page-btn" href="inventory-list.php?pagina=' . ($pagina + 1) . '" title="Siguiente"><i class="fas fa-angle-right"></i></a>';
              }
            }
          }
          ?>
        </nav>

      </div><!-- /inv-main -->
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>

<?php include 'template/js-import.php'; ?>

<script>
/* ── View toggle ───────────────────────────────── */
const btnList = document.getElementById('btn-list');
const btnGrid = document.getElementById('btn-grid');
const viewList = document.getElementById('view-list');
const viewGrid = document.getElementById('view-grid');

btnList?.addEventListener('click', () => {
  viewList.style.display = 'flex';
  viewGrid.style.display = 'none';
  btnList.classList.add('active');
  btnGrid.classList.remove('active');
});
btnGrid?.addEventListener('click', () => {
  viewList.style.display = 'none';
  viewGrid.style.display = 'grid';
  btnGrid.classList.add('active');
  btnList.classList.remove('active');
});

/* ── Price range slider ────────────────────────── */
const fromSlider = document.getElementById('fromSlider');
const toSlider   = document.getElementById('toSlider');
const inputMin   = document.getElementById('input-with-keypress-0');
const inputMax   = document.getElementById('input-with-keypress-1');
const dispMin    = document.getElementById('display-min');
const dispMax    = document.getElementById('display-max');
const priceFill  = document.getElementById('price-fill');

function fmtMXN(n) { return '$' + parseInt(n).toLocaleString('es-MX'); }

function updatePriceSlider() {
  const min = parseInt(fromSlider.min), max = parseInt(fromSlider.max);
  const from = parseInt(fromSlider.value), to = parseInt(toSlider.value);
  const left  = ((from - min) / (max - min)) * 100;
  const right = ((to - min) / (max - min)) * 100;
  priceFill.style.left  = left  + '%';
  priceFill.style.width = (right - left) + '%';
  dispMin.textContent = fmtMXN(from);
  dispMax.textContent = fmtMXN(to);
  inputMin.value = from;
  inputMax.value = to;
}

fromSlider?.addEventListener('input', () => {
  if (parseInt(fromSlider.value) > parseInt(toSlider.value))
    fromSlider.value = toSlider.value;
  updatePriceSlider();
});
toSlider?.addEventListener('input', () => {
  if (parseInt(toSlider.value) < parseInt(fromSlider.value))
    toSlider.value = fromSlider.value;
  updatePriceSlider();
});
updatePriceSlider();

/* ── Year range slider ─────────────────────────── */
const fromSliderYear = document.getElementById('fromSliderYear');
const toSliderYear   = document.getElementById('toSliderYear');
const fromInput      = document.getElementById('fromInput');
const toInput        = document.getElementById('toInput');
const yearFill       = document.getElementById('year-fill');

function updateYearSlider() {
  const min = parseInt(fromSliderYear.min), max = parseInt(fromSliderYear.max);
  const from = parseInt(fromSliderYear.value), to = parseInt(toSliderYear.value);
  const left  = ((from - min) / (max - min)) * 100;
  const right = ((to   - min) / (max - min)) * 100;
  yearFill.style.left  = left  + '%';
  yearFill.style.width = (right - left) + '%';
  fromInput.value = from;
  toInput.value   = to;
}

fromSliderYear?.addEventListener('input', () => {
  if (parseInt(fromSliderYear.value) > parseInt(toSliderYear.value))
    fromSliderYear.value = toSliderYear.value;
  updateYearSlider();
});
toSliderYear?.addEventListener('input', () => {
  if (parseInt(toSliderYear.value) < parseInt(fromSliderYear.value))
    toSliderYear.value = fromSliderYear.value;
  updateYearSlider();
});
fromInput?.addEventListener('input', () => {
  fromSliderYear.value = fromInput.value;
  updateYearSlider();
});
toInput?.addEventListener('input', () => {
  toSliderYear.value = toInput.value;
  updateYearSlider();
});
updateYearSlider();

/* ── Year search ───────────────────────────────── */
function buscarAnios() {
  const min = document.getElementById('fromInput').value;
  const max = document.getElementById('toInput').value;
  window.location.href = 'inventory-list.php?amin=' + min + '&amax=' + max;
}

/* ── Brand → model selector ────────────────────── */
function changeMarca() {
  let id = document.getElementById("select-marca").value;
  let fd = new FormData();
  fd.append("accion", "verModelos");
  fd.append("id", id);
  fetch("admin/api/apiEditor.php", { method: "POST", body: fd })
    .then(r => r.json())
    .then(data => {
      const sel = document.getElementById("select-modelo");
      sel.innerHTML = data.length
        ? data.map(e => `<option value="${e.id}">${e.modelo}</option>`).join('')
        : '<option>No hay modelos</option>';
    })
    .catch(console.error);
}
</script>
</body>
</html>
