<?php
header('Content-Type: text/html; charset=UTF-8');

$id = filter_var(
  $_GET['auto'] ?? null,
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]]
);

if ($id === false || $id === null) {
  http_response_code(400);
  echo '<!DOCTYPE html><html lang="es"><meta charset="UTF-8"><title>Vehículo no válido</title><main style="font-family:sans-serif;padding:4rem 1rem"><h1>Vehículo no válido</h1><p>El identificador solicitado no es válido.</p></main></html>';
  exit;
}

include_once("admin/api/adminEstadisticas.php");
include_once("admin/api/adminAutos.php");
$admin = new AdministradorAutos();
$adminEstats = new AdministradorEstadisticas();
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$adminEstats->insertaVisita($ip, $id);
$auto = $admin->dameAuto($id);

if ($auto->id === 0) {
  http_response_code(404);
  echo '<!DOCTYPE html><html lang="es"><meta charset="UTF-8"><title>Vehículo no encontrado</title><main style="font-family:sans-serif;padding:4rem 1rem"><h1>Vehículo no encontrado</h1><p>El vehículo solicitado no existe.</p></main></html>';
  exit;
}

$imagenes = is_array($auto->imagenes) ? $auto->imagenes : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Detalles del vehículo | Haro Seminuevos</title>
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
    .vd-hero {
      background: var(--ink); padding: 52px 0 36px;
      position: relative; overflow: hidden;
    }
    .vd-hero::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 60% 80% at 80% 50%, rgba(200,16,46,.18) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(212,168,67,.10) 0%, transparent 60%);
    }
    .vd-hero .container { position: relative; z-index: 1; }
    .vd-hero h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(1.8rem, 5vw, 2.8rem);
      color: #fff; letter-spacing: .04em;
    }
    .breadcrumb {
      display: flex; gap: 8px; align-items: center;
      list-style: none; margin-top: 8px;
    }
    .breadcrumb li { font-size: .82rem; color: var(--muted); }
    .breadcrumb li a { color: var(--gold); text-decoration: none; }
    .breadcrumb li + li::before { content: '›'; margin-right: 8px; }

    /* ── CONTAINER ──────────────────────────────── */
    .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

    /* ── TITLE STRIP ────────────────────────────── */
    .vd-title-strip {
      background: var(--card);
      border-bottom: 1px solid var(--border);
      padding: 26px 0 20px;
    }
    .vd-title-inner {
      display: flex; align-items: flex-start;
      justify-content: space-between; flex-wrap: wrap; gap: 16px;
    }
    .vd-subtitle {
      font-size: .7rem; font-weight: 700; letter-spacing: .16em;
      text-transform: uppercase; color: var(--accent); margin-bottom: 5px;
    }
    .vd-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2rem, 4vw, 3rem);
      line-height: 1; letter-spacing: .03em; color: var(--ink);
    }
    .vd-location {
      display: flex; align-items: center; gap: 6px;
      font-size: .84rem; color: var(--text-lt); margin-top: 8px;
    }
    .vd-location i { color: var(--accent); }
    .vd-price-badge {
      background: var(--ink); color: #fff;
      border-radius: var(--radius);
      padding: 15px 26px; text-align: center;
      min-width: 160px; align-self: center;
    }
    .vd-price-label  { font-size: .67rem; letter-spacing: .14em; text-transform: uppercase; color: var(--muted); }
    .vd-price-amount {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem; color: var(--gold); line-height: 1.1;
    }
    .vd-price-note { font-size: .68rem; color: var(--muted); margin-top: 3px; }

    /* ── GALLERY (full-width) ───────────────────── */
    .vd-gallery-wrap { background: var(--ink); width: 100%; }

    .gallery-main {
      position: relative; width: 100%;
      /* scales with viewport width, capped at 580px */
      height: clamp(240px, 48vw, 580px);
      overflow: hidden; cursor: zoom-in;
      background: var(--ink);
    }
    .gallery-track {
      display: flex; height: 100%;
      transition: transform .42s cubic-bezier(.4,0,.2,1);
      will-change: transform;
    }
    .gallery-slide { flex: 0 0 100%; height: 100%; }
    .gallery-slide img {
      width: 100%; height: 100%;
      object-fit: contain; object-position: center;
      display: block; user-select: none; pointer-events: none;
      background: var(--ink);
    }

    /* arrows */
    .g-arrow {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: rgba(13,15,20,.6); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.13);
      color: #fff; border-radius: 50%;
      width: 48px; height: 48px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; z-index: 10; font-size: .95rem;
      transition: background var(--trans), transform var(--trans);
    }
    .g-arrow:hover  { background: var(--accent); transform: translateY(-50%) scale(1.1); }
    .g-arrow.prev   { left: 18px; }
    .g-arrow.next   { right: 18px; }
    @media (max-width: 600px) {
      .g-arrow { width: 36px; height: 36px; font-size: .8rem; }
      .g-arrow.prev { left: 10px; }
      .g-arrow.next { right: 10px; }
    }

    .g-counter {
      position: absolute; bottom: 14px; right: 16px;
      background: rgba(13,15,20,.6); backdrop-filter: blur(6px);
      color: #fff; font-size: .76rem; letter-spacing: .07em;
      padding: 4px 12px; border-radius: 30px;
      border: 1px solid rgba(255,255,255,.1);
    }
    .g-zoom-hint {
      position: absolute; bottom: 14px; left: 16px;
      background: rgba(13,15,20,.55); backdrop-filter: blur(6px);
      color: rgba(255,255,255,.55); font-size: .7rem; letter-spacing: .05em;
      padding: 4px 11px; border-radius: 30px;
      border: 1px solid rgba(255,255,255,.08);
      display: flex; align-items: center; gap: 5px;
      pointer-events: none;
    }
    @media (hover: none) { .g-zoom-hint { display: none; } }

    /* thumbnail strip */
    .gallery-thumbs-wrap {
      background: #0e1018;
      padding: 9px 0;
    }
    .gallery-thumbs {
      display: flex; gap: 8px;
      overflow-x: auto; overflow-y: hidden;
      padding: 0 16px;
      scroll-behavior: smooth;
      scrollbar-width: none;
    }
    .gallery-thumbs::-webkit-scrollbar { display: none; }
    .g-thumb {
      flex: 0 0 72px; height: 50px;
      border-radius: 7px; overflow: hidden;
      cursor: pointer; flex-shrink: 0;
      border: 2px solid transparent;
      opacity: .42;
      transition: border-color var(--trans), opacity var(--trans);
    }
    @media (max-width: 600px) { .g-thumb { flex: 0 0 54px; height: 38px; } }
    .g-thumb.active { border-color: var(--accent); opacity: 1; }
    .g-thumb:hover  { opacity: .78; }
    .g-thumb img    { width: 100%; height: 100%; object-fit: cover; display: block; pointer-events: none; }

    /* ── LIGHTBOX ───────────────────────────────── */
    .lightbox-overlay {
      position: fixed; inset: 0; z-index: 9999;
      background: rgba(6,7,10,.97); backdrop-filter: blur(14px);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; pointer-events: none;
      transition: opacity .28s ease;
    }
    .lightbox-overlay.open { opacity: 1; pointer-events: auto; }
    .lb-inner {
      position: relative; width: 100%; max-width: 1200px;
      padding: 0 68px;
      display: flex; flex-direction: column; align-items: center;
    }
    @media (max-width: 600px) { .lb-inner { padding: 0 48px; } }
    .lb-img-wrap {
      width: 100%; height: clamp(240px, 68vh, 680px);
      position: relative; border-radius: var(--radius); overflow: hidden;
    }
    .lb-track {
      display: flex; height: 100%;
      transition: transform .4s cubic-bezier(.4,0,.2,1);
    }
    .lb-slide { flex: 0 0 100%; height: 100%; }
    .lb-slide img { width: 100%; height: 100%; object-fit: contain; display: block; }
    .lb-close {
      position: fixed; top: 18px; right: 20px;
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
      color: #fff; border-radius: 50%;
      width: 46px; height: 46px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 1.1rem; z-index: 10;
      transition: background var(--trans);
    }
    .lb-close:hover { background: var(--accent); }
    .lb-arrow {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
      color: #fff; border-radius: 50%;
      width: 50px; height: 50px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; z-index: 2; font-size: 1rem;
      transition: background var(--trans);
    }
    .lb-arrow:hover  { background: var(--accent); }
    .lb-arrow.prev   { left: 0; }
    .lb-arrow.next   { right: 0; }
    .lb-counter {
      margin-top: 14px;
      font-size: .78rem; color: rgba(255,255,255,.4); letter-spacing: .08em;
    }
    .lb-thumbs {
      display: flex; gap: 7px; margin-top: 11px;
      overflow-x: auto; max-width: 100%;
      scrollbar-width: none; padding: 2px 0;
    }
    .lb-thumbs::-webkit-scrollbar { display: none; }
    .lb-thumb {
      flex: 0 0 54px; height: 38px; border-radius: 6px; overflow: hidden;
      cursor: pointer; border: 2px solid transparent;
      opacity: .38; flex-shrink: 0;
      transition: opacity var(--trans), border-color var(--trans);
    }
    .lb-thumb.active { border-color: var(--accent); opacity: 1; }
    .lb-thumb:hover  { opacity: .72; }
    .lb-thumb img    { width: 100%; height: 100%; object-fit: cover; display: block; pointer-events: none; }

    /* ── CONTENT GRID ───────────────────────────── */
    .vd-content { padding: 36px 0 80px; }
    .vd-content-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 30px;
      align-items: start;
    }

    /* ── SPECS ──────────────────────────────────── */
    .vd-specs-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); overflow: hidden; margin-bottom: 26px;
    }
    .vd-specs-header {
      background: var(--ink); color: #fff;
      padding: 16px 22px;
      display: flex; align-items: center; gap: 10px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.1rem; letter-spacing: .1em;
    }
    .vd-specs-header i { color: var(--gold); }
    .vd-specs-grid { display: grid; grid-template-columns: 1fr 1fr; }
    @media (max-width: 480px) { .vd-specs-grid { grid-template-columns: 1fr; } }
    .vd-spec {
      padding: 14px 20px; border-bottom: 1px solid var(--border);
    }
    .vd-spec:nth-child(odd) { border-right: 1px solid var(--border); }
    @media (max-width: 480px) { .vd-spec:nth-child(odd) { border-right: none; } }
    .vd-spec-label { font-size: .67rem; font-weight: 700; letter-spacing: .13em; text-transform: uppercase; color: var(--muted); margin-bottom: 3px; }
    .vd-spec-value { font-size: .93rem; font-weight: 500; color: var(--text); }

    /* ── DESCRIPTION ────────────────────────────── */
    .vd-desc-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 26px; margin-bottom: 26px;
    }
    .vd-section-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.3rem; letter-spacing: .08em; color: var(--ink);
      margin-bottom: 14px;
      display: flex; align-items: center; gap: 10px;
    }
    .vd-section-title::after {
      content: ''; flex: 1; height: 2px;
      background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
      border-radius: 2px;
    }
    .vd-desc-text { font-size: .92rem; line-height: 1.78; color: var(--text-lt); margin-bottom: 20px; }
    .vd-highlights { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .vd-highlights li {
      display: flex; align-items: flex-start; gap: 12px;
      font-size: .9rem; color: var(--text-lt); line-height: 1.5;
    }
    .vd-highlights li::before {
      content: ''; flex: 0 0 18px; height: 18px; margin-top: 2px;
      border-radius: 50%; background: var(--accent);
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M2 6l3 3 5-5' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-size: 70%; background-position: center; background-repeat: no-repeat;
    }
    .vd-highlights strong { color: var(--text); }

    /* ── SIDEBAR ────────────────────────────────── */
    .vd-sidebar { display: flex; flex-direction: column; gap: 18px; }
    @media (min-width: 901px) { .vd-sidebar { position: sticky; top: 24px; } }

    .vd-seller-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); overflow: hidden;
    }
    .vd-seller-banner {
      background: linear-gradient(135deg, var(--ink) 0%, #1e2235 100%);
      padding: 22px; display: flex; flex-direction: column;
      align-items: center; gap: 12px; text-align: center;
    }
    .vd-seller-logo {
      width: 76px; height: 76px; border-radius: 50%;
      overflow: hidden; border: 3px solid rgba(255,255,255,.12);
    }
    .vd-seller-logo img { width: 100%; height: 100%; object-fit: cover; }
    .vd-seller-name  { font-weight: 700; font-size: .97rem; color: #fff; }
    .vd-seller-email { font-size: .78rem; color: var(--muted); }
    .vd-seller-contact { padding: 16px 20px; }
    .vd-phone-btn {
      display: flex; align-items: center; justify-content: center; gap: 9px;
      background: #25D366; color: #fff;
      padding: 13px 18px; border-radius: 10px;
      text-decoration: none; font-weight: 600; font-size: .9rem;
      transition: filter var(--trans), transform var(--trans);
    }
    .vd-phone-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

    .vd-msg-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); overflow: hidden;
    }
    .vd-msg-header {
      background: var(--ink); color: #fff;
      padding: 14px 20px;
      display: flex; align-items: center; gap: 9px;
      font-weight: 600; font-size: .87rem;
    }
    .vd-msg-header i { color: var(--gold); }
    .vd-msg-body { padding: 18px 20px; }
    .vd-input, .vd-textarea {
      width: 100%; background: var(--surface);
      border: 1.5px solid var(--border); border-radius: 9px;
      padding: 11px 14px;
      font-family: 'DM Sans', sans-serif; font-size: .9rem; color: var(--text);
      outline: none; margin-bottom: 11px; resize: vertical;
      transition: border-color var(--trans), box-shadow var(--trans);
    }
    .vd-input:focus, .vd-textarea:focus {
      border-color: var(--accent); box-shadow: 0 0 0 3px rgba(200,16,46,.1);
    }
    .vd-textarea { min-height: 95px; }
    .vd-send-btn {
      width: 100%; background: var(--accent); color: #fff; border: none;
      padding: 13px; border-radius: 10px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.05rem; letter-spacing: .1em; cursor: pointer;
      transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
    }
    .vd-send-btn:hover {
      background: var(--accent-2); transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(200,16,46,.25);
    }
  </style>
</head>

<body class="page">
<?php include 'template/header.php'; ?>

<!-- HERO -->
<div class="vd-hero">
  <div class="container">
    <h1>Detalles del Vehículo</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Detalles del Vehículo</li>
      </ol>
    </nav>
  </div>
</div>

<!-- TITLE STRIP -->
<div class="vd-title-strip">
  <div class="container">
    <div class="vd-title-inner">
      <div>
        <div class="vd-subtitle">La mejor elección</div>
        <h1 class="vd-title" id="titulo">
          <?php echo $auto->marca->marca . " " . $auto->modelo->modelo; ?>
        </h1>
        <div class="vd-location">
          <i class="fas fa-map-marker-alt"></i>
          <?php echo $auto->nacionalidad; ?>
        </div>
      </div>
      <?php if ($auto->precio): ?>
      <div class="vd-price-badge">
        <div class="vd-price-label">Precio</div>
        <div class="vd-price-amount">$<?php echo number_format($auto->precio); ?></div>
        <div class="vd-price-note">Incluye impuestos</div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- FULL-WIDTH GALLERY -->
<div class="vd-gallery-wrap">

  <div class="gallery-main" id="galleryMain">
    <div class="gallery-track" id="galleryTrack">
      <?php if (count($imagenes) > 0): ?>
        <?php foreach ($imagenes as $image): ?>
          <div class="gallery-slide">
            <img src="<?php echo $image->url; ?>" alt="Foto del vehículo" loading="lazy">
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="gallery-slide">
          <img src="assets/media/content/b-goods/main-slider/main/1.jpg" alt="Foto del vehículo">
        </div>
      <?php endif; ?>
    </div>

    <?php if (count($imagenes) > 1): ?>
    <button class="g-arrow prev" id="gPrev" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
    <button class="g-arrow next" id="gNext" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>
    <?php endif; ?>

    <div class="g-counter" id="gCounter">1 / <?php echo count($imagenes) ?: 1; ?></div>
    <div class="g-zoom-hint"><i class="fas fa-magnifying-glass-plus"></i> Clic para ampliar</div>
  </div>

  <?php if (count($imagenes) > 1): ?>
  <div class="gallery-thumbs-wrap">
    <div class="gallery-thumbs" id="galleryThumbs">
      <?php foreach ($imagenes as $i => $image): ?>
        <div class="g-thumb <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>">
          <img src="<?php echo $image->url; ?>" alt="Miniatura <?php echo $i+1; ?>" loading="lazy">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

</div>

<!-- CONTENT -->
<div class="vd-content">
  <div class="container">
    <div class="vd-content-grid">

      <!-- LEFT -->
      <div>
        <div class="vd-specs-card">
          <div class="vd-specs-header"><i class="fas fa-list-check"></i> Especificaciones del Vehículo</div>
          <div class="vd-specs-grid">
            <div class="vd-spec"><div class="vd-spec-label">Año</div><div class="vd-spec-value"><?php echo $auto->anio; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Modelo</div><div class="vd-spec-value"><?php echo $auto->modelo->modelo . " " . $auto->marca->marca; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Carrocería</div><div class="vd-spec-value"><?php echo $auto->cuerpo; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Color</div><div class="vd-spec-value"><?php echo $auto->color; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Combustible</div><div class="vd-spec-value"><?php echo $auto->combustible; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Potencia</div><div class="vd-spec-value"><?php echo $auto->poder; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Condición</div><div class="vd-spec-value"><?php echo $auto->estatus; ?></div></div>
            <?php if ($auto->kilometragePermitido): ?>
            <div class="vd-spec"><div class="vd-spec-label">Kilometraje</div><div class="vd-spec-value"><?php echo $auto->kilometrage; ?> KM</div></div>
            <?php endif; ?>
            <div class="vd-spec"><div class="vd-spec-label">Transmisión</div><div class="vd-spec-value"><?php echo $auto->transmicion->transmicion; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Cilindraje</div><div class="vd-spec-value"><?php echo $auto->cilindrage; ?> Cilindros</div></div>
            <div class="vd-spec"><div class="vd-spec-label">Interiores</div><div class="vd-spec-value"><?php echo $auto->interiores->interiores; ?></div></div>
            <div class="vd-spec"><div class="vd-spec-label">Asientos</div><div class="vd-spec-value"><?php echo $auto->asientos; ?></div></div>
          </div>
        </div>

        <div class="vd-desc-card">
          <h2 class="vd-section-title">Descripción</h2>
          <p class="vd-desc-text"><?php echo $auto->descripcion; ?></p>
          <h3 class="vd-section-title" style="font-size:1.1rem">Lo que lo hace especial</h3>
          <ul class="vd-highlights">
            <li>Motor de <strong><?php echo $auto->cilindrage; ?> cilindros</strong> para que nunca te falte poder</li>
            <li>Interiores de <strong><?php echo $auto->interiores->interiores; ?></strong> para la experiencia de manejo más cómoda</li>
            <li>Transmisión <strong><?php echo $auto->transmicion->transmicion; ?></strong> — siente la verdadera experiencia de manejo</li>
            <li><strong><?php echo $auto->asientos; ?> asientos</strong> para que lleves a quien tú quieras</li>
            <li><?php echo $auto->estatus; ?></li>
          </ul>
        </div>
      </div>


    </div>
  </div>
</div>

<!-- LIGHTBOX -->
<div class="lightbox-overlay" id="lightbox" role="dialog" aria-modal="true" aria-label="Galería">
  <button class="lb-close" id="lbClose" aria-label="Cerrar"><i class="fas fa-times"></i></button>
  <div class="lb-inner">
    <div class="lb-img-wrap" style="position:relative">
      <div class="lb-track" id="lbTrack">
        <?php if (count($imagenes) > 0): ?>
          <?php foreach ($imagenes as $image): ?>
            <div class="lb-slide"><img src="<?php echo $image->url; ?>" alt="Foto"></div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="lb-slide"><img src="assets/media/content/b-goods/main-slider/main/1.jpg" alt="Foto"></div>
        <?php endif; ?>
      </div>
      <?php if (count($imagenes) > 1): ?>
      <button class="lb-arrow prev" id="lbPrev"><i class="fas fa-chevron-left"></i></button>
      <button class="lb-arrow next" id="lbNext"><i class="fas fa-chevron-right"></i></button>
      <?php endif; ?>
    </div>
    <div class="lb-counter" id="lbCounter">1 / <?php echo count($imagenes) ?: 1; ?></div>
    <div class="lb-thumbs" id="lbThumbs">
      <?php foreach ($imagenes as $i => $image): ?>
        <div class="lb-thumb <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>">
          <img src="<?php echo $image->url; ?>" alt="Min">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="assets/plugins/headers/slidebar.js"></script>
<script src="assets/plugins/headers/header.js"></script>
<script src="assets/plugins/jqBootstrapValidation.js"></script>
<script src="assets/plugins/contact_me.js"></script>
<script src="assets/plugins/scrollreveal/scrollreveal.min.js"></script>
<script src="assets/plugins/ofi.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
(function () {
  const total = <?php echo count($imagenes) ?: 1; ?>;
  let current = 0;

  function setSlide(index) {
    current = (index + total) % total;

    // main
    const track = document.getElementById('galleryTrack');
    if (track) track.style.transform = `translateX(-${current * 100}%)`;
    const counter = document.getElementById('gCounter');
    if (counter) counter.textContent = `${current + 1} / ${total}`;

    // main thumbs
    document.querySelectorAll('.g-thumb').forEach((t, i) => t.classList.toggle('active', i === current));
    const at = document.querySelector('.g-thumb.active');
    if (at) at.scrollIntoView({ inline: 'center', behavior: 'smooth', block: 'nearest' });

    // lightbox
    const lbTrack = document.getElementById('lbTrack');
    if (lbTrack) lbTrack.style.transform = `translateX(-${current * 100}%)`;
    const lbCounter = document.getElementById('lbCounter');
    if (lbCounter) lbCounter.textContent = `${current + 1} / ${total}`;

    // lb thumbs
    document.querySelectorAll('.lb-thumb').forEach((t, i) => t.classList.toggle('active', i === current));
    const alt = document.querySelector('.lb-thumb.active');
    if (alt) alt.scrollIntoView({ inline: 'center', behavior: 'smooth', block: 'nearest' });
  }

  // Main controls
  document.getElementById('gPrev')?.addEventListener('click', e => { e.stopPropagation(); setSlide(current - 1); });
  document.getElementById('gNext')?.addEventListener('click', e => { e.stopPropagation(); setSlide(current + 1); });
  document.querySelectorAll('.g-thumb').forEach(t =>
    t.addEventListener('click', () => setSlide(parseInt(t.dataset.index)))
  );

  // Touch swipe — main
  let tx = 0;
  const gMain = document.getElementById('galleryMain');
  if (gMain) {
    gMain.addEventListener('touchstart', e => { tx = e.changedTouches[0].clientX; }, { passive: true });
    gMain.addEventListener('touchend',   e => {
      const dx = e.changedTouches[0].clientX - tx;
      if (Math.abs(dx) > 40) setSlide(current + (dx < 0 ? 1 : -1));
    });
    gMain.addEventListener('click', openLightbox);
  }

  // Lightbox
  const lb = document.getElementById('lightbox');
  function openLightbox()  { lb.classList.add('open');    document.body.style.overflow = 'hidden'; }
  function closeLightbox() { lb.classList.remove('open'); document.body.style.overflow = ''; }

  document.getElementById('lbClose')?.addEventListener('click', closeLightbox);
  document.getElementById('lbPrev') ?.addEventListener('click', () => setSlide(current - 1));
  document.getElementById('lbNext') ?.addEventListener('click', () => setSlide(current + 1));
  document.querySelectorAll('.lb-thumb').forEach(t =>
    t.addEventListener('click', () => setSlide(parseInt(t.dataset.index)))
  );
  lb?.addEventListener('click', e => { if (e.target === lb) closeLightbox(); });

  // Touch swipe — lightbox
  let lx = 0;
  lb?.addEventListener('touchstart', e => { lx = e.changedTouches[0].clientX; }, { passive: true });
  lb?.addEventListener('touchend',   e => {
    const dx = e.changedTouches[0].clientX - lx;
    if (Math.abs(dx) > 40) setSlide(current + (dx < 0 ? 1 : -1));
  });

  // Keyboard
  document.addEventListener('keydown', e => {
    if (!lb?.classList.contains('open')) return;
    if (e.key === 'Escape')     closeLightbox();
    if (e.key === 'ArrowLeft')  setSlide(current - 1);
    if (e.key === 'ArrowRight') setSlide(current + 1);
  });
})();
</script>

</body>
</html>
