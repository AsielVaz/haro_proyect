<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Seminuevos Haro</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="telephone=no" name="format-detection">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="assets/css/master.css">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
      --ink:     #0d0f14;
      --surface: #f5f4f0;
      --card:    #ffffff;
      --accent:  #c8102e;
      --accent2: #ff3d5a;
      --gold:    #d4a843;
      --muted:   #8a8d99;
      --border:  #e4e3de;
      --text:    #1a1d26;
      --text-lt: #5a5d6b;
      --radius:  14px;
      --trans:   0.28s cubic-bezier(.4,0,.2,1);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--surface);
      color: var(--text);
      -webkit-font-smoothing: antialiased;
      margin: 0;
    }

    .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

    /* ═══════════════════════════════════════════════
       HERO SLIDER
    ═══════════════════════════════════════════════ */
    #main-slider { position: relative; }

    /* overlay on each slide */
    .sp-slide { position: relative; }
    .sp-slide::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(
        100deg,
        rgba(13,15,20,.82) 0%,
        rgba(13,15,20,.45) 55%,
        rgba(13,15,20,.15) 100%
      );
      pointer-events: none; z-index: 1;
    }

    .main-slider__wrap {
      position: relative; z-index: 2;
      max-width: 600px; padding: 0 40px;
    }
    .main-slider__slogan {
      font-size: .72rem; font-weight: 700; letter-spacing: .2em;
      text-transform: uppercase; color: var(--gold);
      margin-bottom: 12px;
    }
    .main-slider__title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2.5rem, 6vw, 5rem);
      color: #fff; line-height: 1; letter-spacing: .04em;
      margin-bottom: 16px;
    }
    .main-slider__title_lg {
      display: block; color: rgba(255,255,255,.75);
      font-size: .65em;
    }
    .main-slider__price {
      display: inline-flex; align-items: baseline; gap: 3px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2rem, 4vw, 3.2rem);
      color: var(--gold); margin-bottom: 24px; letter-spacing: .02em;
    }
    .main-slider__price_up  { font-size: .55em; color: rgba(212,168,67,.8); }
    .main-slider__price_down { font-size: .45em; color: rgba(212,168,67,.7); }

    .main-slider__link {
      display: inline-flex; align-items: center; gap: 10px;
      background: var(--accent); color: #fff;
      padding: 13px 28px; border-radius: 10px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1rem; letter-spacing: .1em; text-decoration: none;
      transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
    }
    .main-slider__link::after { content: '→'; }
    .main-slider__link:hover {
      background: var(--accent2); transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(200,16,46,.3);
    }

    /* ═══════════════════════════════════════════════
       BRAND CAROUSEL
    ═══════════════════════════════════════════════ */
    .brands-section {
      background: var(--card);
      padding: 28px 0;
      border-bottom: 1px solid var(--border);
      border-top: 1px solid var(--border);
    }
    .brand-item {
      display: flex !important;
      align-items: center; justify-content: center;
      padding: 10px 24px; opacity: .75;
      transition: opacity var(--trans), transform var(--trans);
    }
    .brand-item:hover { opacity: 1; transform: scale(1.08); }
    .brand-item img {
      width: 130px; height: 72px;
      object-fit: contain; display: block;
    }

    /* ═══════════════════════════════════════════════
       PRICE SEARCH BAND
    ═══════════════════════════════════════════════ */
    .price-band {
      background: var(--card);
      border-bottom: 1px solid var(--border);
      padding: 32px 0;
    }
    .price-band-inner {
      display: flex; align-items: center; flex-wrap: wrap;
      gap: 24px;
    }
    .price-band-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem; letter-spacing: .06em; color: var(--ink);
      white-space: nowrap;
      display: flex; align-items: center; gap: 10px;
    }
    .price-band-title i { color: var(--accent); }
    .price-band-form {
      flex: 1; display: flex; align-items: center;
      gap: 16px; flex-wrap: wrap; min-width: 280px;
    }
    .price-display {
      display: flex; align-items: center; gap: 8px;
      white-space: nowrap;
    }
    .price-val-badge {
      background: var(--surface); border: 1.5px solid var(--border);
      border-radius: 8px; padding: 7px 14px;
      font-size: .9rem; font-weight: 600; color: var(--text);
      min-width: 110px; text-align: center;
    }
    .price-sep { color: var(--muted); }

    /* range track */
    .price-range-wrap {
      flex: 1; min-width: 180px;
      position: relative; height: 24px;
    }
    .price-range-track {
      position: absolute; top: 50%; transform: translateY(-50%);
      left: 0; right: 0; height: 4px;
      background: var(--border); border-radius: 4px;
    }
    .price-range-fill {
      position: absolute; height: 100%;
      background: var(--accent); border-radius: 4px;
    }
    input[type="range"].hp-range {
      -webkit-appearance: none; appearance: none;
      position: absolute; top: 50%; transform: translateY(-50%);
      width: 100%; height: 4px; background: transparent;
      pointer-events: none; outline: none;
    }
    input[type="range"].hp-range::-webkit-slider-thumb {
      -webkit-appearance: none; pointer-events: all;
      width: 20px; height: 20px;
      background: var(--card); border-radius: 50%;
      border: 2px solid var(--accent);
      box-shadow: 0 2px 6px rgba(0,0,0,.15);
      cursor: pointer; transition: transform var(--trans);
    }
    input[type="range"].hp-range::-webkit-slider-thumb:hover { transform: scale(1.2); }
    input[type="range"].hp-range::-moz-range-thumb {
      pointer-events: all; width: 20px; height: 20px;
      background: var(--card); border-radius: 50%;
      border: 2px solid var(--accent); cursor: pointer;
    }
    #hp-fromSlider { z-index: 1; }
    #hp-toSlider   { z-index: 2; }

    .btn-search {
      background: var(--accent); color: #fff; border: none;
      padding: 11px 24px; border-radius: 9px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1rem; letter-spacing: .1em; cursor: pointer;
      display: inline-flex; align-items: center; gap: 8px;
      transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
      text-decoration: none; white-space: nowrap;
    }
    .btn-search:hover {
      background: var(--accent2); transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(200,16,46,.25);
    }

    /* ═══════════════════════════════════════════════
       WELCOME SECTION
    ═══════════════════════════════════════════════ */
    .welcome-section {
      padding: 80px 0;
      background: var(--surface);
    }
    .section-eyebrow {
      font-size: .7rem; font-weight: 700; letter-spacing: .2em;
      text-transform: uppercase; color: var(--accent); margin-bottom: 10px;
    }
    .section-heading {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2rem, 4vw, 3rem);
      letter-spacing: .04em; color: var(--ink);
      margin-bottom: 0; line-height: 1.05;
    }
    .section-heading span { color: var(--accent); }

    .welcome-pillars {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px; margin-top: 40px;
    }
    .pillar {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 28px 24px;
      display: flex; flex-direction: column; align-items: flex-start; gap: 14px;
      transition: box-shadow var(--trans), transform var(--trans);
    }
    .pillar:hover { box-shadow: 0 8px 28px rgba(13,15,20,.1); transform: translateY(-3px); }
    .pillar-icon {
      width: 48px; height: 48px; border-radius: 12px;
      background: rgba(200,16,46,.08);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; color: var(--accent);
    }
    .pillar-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.1rem; letter-spacing: .06em; color: var(--ink);
    }
    .pillar-text { font-size: .86rem; color: var(--text-lt); line-height: 1.6; }

    /* ═══════════════════════════════════════════════
       VEHICLE CAROUSEL
    ═══════════════════════════════════════════════ */
    .carousel-section {
      background: var(--ink);
      padding: 64px 0 0;
    }
    .carousel-section .section-eyebrow { color: var(--gold); }
    .carousel-section .section-heading { color: #fff; }
    .carousel-section .section-heading span { color: var(--accent); }

    .carousel-header {
      display: flex; align-items: flex-end; justify-content: space-between;
      flex-wrap: wrap; gap: 16px;
      padding: 0 24px 32px;
      max-width: 1200px; margin: 0 auto;
    }

    .carousel-track-wrap { padding: 0 0 40px; }

    /* slick car card */
    .car-slide { padding: 0 10px; }
    .car-card {
      background: #1a1d26;
      border: 1px solid rgba(255,255,255,.07);
      border-radius: var(--radius);
      overflow: hidden;
      transition: transform var(--trans), box-shadow var(--trans);
    }
    .car-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.4); }

    .car-card-img {
      height: 200px; overflow: hidden; position: relative;
      background: #111;
    }
    .car-card-img img {
      width: 100%; height: 100%; object-fit: cover;
      display: block; transition: transform .5s ease;
    }
    .car-card:hover .car-card-img img { transform: scale(1.06); }
    .car-card-overlay {
      position: absolute; inset: 0;
      background: rgba(13,15,20,0);
      display: flex; align-items: center; justify-content: center;
      transition: background var(--trans);
    }
    .car-card:hover .car-card-overlay { background: rgba(13,15,20,.4); }
    .car-card-overlay-icon {
      width: 42px; height: 42px; border-radius: 50%;
      background: #fff; color: var(--accent);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transform: scale(.7);
      transition: opacity var(--trans), transform var(--trans);
    }
    .car-card:hover .car-card-overlay-icon { opacity: 1; transform: scale(1); }

    .car-card-body { padding: 16px 18px 18px; }
    .car-card-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.15rem; letter-spacing: .04em;
      color: #fff; margin-bottom: 10px; line-height: 1.1;
    }
    .car-card-specs {
      display: flex; flex-wrap: wrap; gap: 6px;
      list-style: none; padding: 0; margin: 0 0 14px;
    }
    .car-card-spec {
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 5px; padding: 3px 9px;
      font-size: .72rem; color: rgba(255,255,255,.6);
      display: flex; align-items: center; gap: 5px;
    }
    .car-card-spec i { color: var(--accent); font-size: .65rem; }
    .car-card-footer {
      display: flex; align-items: center; justify-content: space-between;
      padding-top: 12px; border-top: 1px solid rgba(255,255,255,.07);
    }
    .car-card-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem; color: var(--gold); letter-spacing: .02em;
    }
    .car-card-price-lbl { font-size: .62rem; color: var(--muted); margin-bottom: 1px; }
    .car-card-link {
      font-size: .75rem; color: var(--accent); font-weight: 600;
      text-decoration: none; display: flex; align-items: center; gap: 4px;
      transition: color var(--trans);
    }
    .car-card-link:hover { color: var(--accent2); }

    /* slick nav override */
    .slick-prev, .slick-next {
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(255,255,255,.1) !important;
      border: 1px solid rgba(255,255,255,.15) !important;
      z-index: 10;
    }
    .slick-prev:hover, .slick-next:hover { background: var(--accent) !important; }
    .slick-prev { left: -50px; }
    .slick-next { right: -50px; }
    .slick-prev:before, .slick-next:before { font-family: 'Font Awesome 6 Free'; font-weight: 900; }
    .slick-prev:before { content: '\f053'; }
    .slick-next:before { content: '\f054'; }

    .carousel-cta-bar {
      background: rgba(0,0,0,.3);
      border-top: 1px solid rgba(255,255,255,.06);
      padding: 20px 24px;
      display: flex; justify-content: center;
    }

    /* ═══════════════════════════════════════════════
       CTA BANNER
    ═══════════════════════════════════════════════ */
    .cta-banner {
      background: var(--ink);
      padding: 60px 0;
      position: relative; overflow: hidden;
    }
    .cta-banner::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 50% 80% at 100% 50%, rgba(200,16,46,.2) 0%, transparent 65%),
        radial-gradient(ellipse 30% 60% at 0% 50%, rgba(212,168,67,.08) 0%, transparent 60%);
    }
    .cta-banner .container { position: relative; z-index: 1; }
    .cta-grid {
      display: grid; grid-template-columns: 1fr auto;
      gap: 40px; align-items: center;
    }
    @media (max-width: 700px) { .cta-grid { grid-template-columns: 1fr; gap: 24px; } }
    .cta-tag {
      font-size: .7rem; font-weight: 700; letter-spacing: .18em;
      text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
    }
    .cta-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2rem, 4vw, 3rem);
      color: #fff; letter-spacing: .04em; line-height: 1; margin-bottom: 10px;
    }
    .cta-sub { font-size: .92rem; color: rgba(255,255,255,.55); line-height: 1.6; }
    .cta-actions {
      display: flex; flex-direction: column; align-items: flex-end; gap: 14px;
    }
    @media (max-width: 700px) { .cta-actions { align-items: flex-start; flex-direction: row; flex-wrap: wrap; } }
    .cta-phone {
      display: flex; align-items: center; gap: 10px;
      text-decoration: none;
    }
    .cta-phone-icon {
      width: 44px; height: 44px; border-radius: 50%;
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
      display: flex; align-items: center; justify-content: center;
      color: var(--gold); font-size: 1rem;
    }
    .cta-phone-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.5rem; color: #fff; letter-spacing: .06em;
    }
    .cta-phone-lbl { font-size: .72rem; color: var(--muted); }

    /* ═══════════════════════════════════════════════
       STATS SECTION
    ═══════════════════════════════════════════════ */
    .stats-section {
      background: var(--surface);
      padding: 64px 0;
      border-top: 1px solid var(--border);
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 24px;
    }
    .stat-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 32px 24px;
      text-align: center;
      display: flex; flex-direction: column; align-items: center; gap: 14px;
      transition: box-shadow var(--trans);
    }
    .stat-card:hover { box-shadow: 0 8px 24px rgba(13,15,20,.09); }
    .stat-canvas-wrap { position: relative; }
    .stat-canvas-wrap canvas { display: block; }
    .stat-num {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.5rem; color: var(--ink); letter-spacing: .04em;
      white-space: nowrap;
    }
    .stat-label {
      font-size: .82rem; font-weight: 600; color: var(--text-lt);
      letter-spacing: .04em;
    }

    /* ═══════════════════════════════════════════════
       ISOTOPE GRID
    ═══════════════════════════════════════════════ */
    .iso-section {
      padding: 72px 0 80px;
      background: var(--surface);
    }
    .iso-header { text-align: center; margin-bottom: 36px; }

    /* filter tabs */
    .iso-filters {
      display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;
      margin-top: 24px; list-style: none; padding: 0;
    }
    .iso-filters li a {
      display: inline-block;
      padding: 7px 18px; border-radius: 30px;
      border: 1.5px solid var(--border);
      background: var(--card); color: var(--text-lt);
      font-size: .82rem; font-weight: 600; text-decoration: none;
      transition: all var(--trans); letter-spacing: .04em;
      text-transform: uppercase;
    }
    .iso-filters li a:hover,
    .iso-filters li a.is-checked {
      background: var(--accent); border-color: var(--accent);
      color: #fff;
    }

    /* iso cards */
    .b-isotope-grid { margin: 0; padding: 0; }
    .b-isotope-grid__item { padding: 10px; }
    .iso-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      transition: transform var(--trans), box-shadow var(--trans);
    }
    .iso-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(13,15,20,.1); }

    .iso-card-img {
      height: 200px; overflow: hidden; position: relative;
      background: #eee;
    }
    .iso-card-img img {
      width: 100%; height: 100%; object-fit: cover;
      display: block; transition: transform .5s ease;
    }
    .iso-card:hover .iso-card-img img { transform: scale(1.06); }

    .iso-card-body { padding: 16px 18px 18px; }
    .iso-card-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.15rem; letter-spacing: .04em; color: var(--ink);
      margin-bottom: 8px; line-height: 1.1;
    }
    .iso-card-specs {
      display: flex; flex-wrap: wrap; gap: 6px;
      list-style: none; padding: 0; margin: 0 0 12px;
    }
    .iso-card-spec {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 5px; padding: 3px 9px;
      font-size: .72rem; color: var(--text-lt);
      display: flex; align-items: center; gap: 4px;
    }
    .iso-card-spec i { color: var(--accent); font-size: .65rem; }
    .iso-card-footer {
      display: flex; align-items: center; justify-content: space-between;
      padding-top: 10px; border-top: 1px solid var(--border);
    }
    .iso-card-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.35rem; color: var(--accent); letter-spacing: .02em;
    }
    .iso-card-price-lbl { font-size: .62rem; color: var(--muted); margin-bottom: 1px; }
    .iso-card-cta {
      font-size: .78rem; color: var(--ink); font-weight: 600;
      text-decoration: none; display: flex; align-items: center; gap: 4px;
      padding: 7px 14px; border-radius: 8px;
      border: 1.5px solid var(--border);
      transition: all var(--trans);
    }
    .iso-card-cta:hover { background: var(--ink); color: #fff; border-color: var(--ink); }

    /* brand carousel light override */
    .brands-section .js-slider { padding: 0 10px; }
  </style>
</head>

<?php
include_once("admin/api/adminAutos.php");
include_once("admin/api/adminEditor.php");
$adminEditor = new AdministradorEditor();
$adminAutos  = new AdministradorAutos();
$ultimos     = $adminAutos->dameUltimosAutos();
$marcas      = $adminEditor->dameMarcas();

function haroFormatoNumero(mixed $valor): string
{
  return is_numeric($valor) ? number_format((float) $valor) : 'N/E';
}
?>

<body class="page">
<?php include_once 'template/header.php'; ?>

<!-- ═══════════════════════════════════════════
     HERO SLIDER
═══════════════════════════════════════════ -->
<?php if (count($ultimos) > 0): ?>
<div class="main-slider slider-pro" id="main-slider"
     data-slider-width="100%" data-slider-height="680px"
     data-slider-arrows="true" data-slider-buttons="false">
  <div class="sp-slides">
    <?php foreach ($ultimos as $autos): ?>
      <?php if (!$autos->pausado): ?>
       
        <a href="vehicle-details.php?auto=<?php echo $autos->id; ?>">
        <div class="main-slider__slide sp-slide">
          <?php if (!empty($autos->imagen)): ?>
            <img class="sp-image" src="<?php echo $autos->imagen; ?>" alt="slider"
                 style="width:100%;height:680px;object-fit:cover">
          <?php else: ?>
            <img class="sp-image" src="<?php echo $autos->imagenes[0]->url ?? 'assets/media/content/b-goods/main-slider/main/1.jpg'; ?>" alt="slider"
                 style="width:100%;height:680px;object-fit:cover">
          <?php endif; ?>
          <div class="sp-layer" data-width="100%"
               data-show-transition="left" data-hide-transition="left"
               data-show-duration="800" data-show-delay="400" data-hide-delay="400">
            <div class="main-slider__wrap">
              <div class="main-slider__slogan">Aprovecha</div>
              <div class="main-slider__title">
                <?php echo strtoupper($autos->marca->marca); ?>
                <span class="main-slider__title_lg"><?php echo $autos->modelo->modelo; ?></span>
              </div>
              <div class="main-slider__price">
                <span class="main-slider__price_up">$</span>
                <?php echo number_format($autos->precio); ?>
                <span class="main-slider__price_down">.00</span>
              </div>
              <a class="main-slider__link" href="vehicle-details.php?auto=<?php echo $autos->id; ?>">
                Ver Más
              </a>
            </div>
          </div>
        </div>
        </a>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>

<?php else: ?>

<div class="main-slider slider-pro" id="main-slider"
     data-slider-width="100%" data-slider-height="680px"
     data-slider-arrows="false" data-slider-buttons="false">
  <div class="sp-slides">
    <div class="main-slider__slide sp-slide">
      <img class="sp-image" src="assets/media/content/b-main-slider/bg-1.jpg" alt="slider"
           style="width:100%;height:680px;object-fit:cover">
      <div class="sp-layer" data-width="100%"
           data-show-transition="left" data-hide-transition="left"
           data-show-duration="800" data-show-delay="400" data-hide-delay="400">
        <div class="main-slider__wrap">
          <div class="main-slider__slogan">Expertos en ventas de autos</div>
          <div class="main-slider__title">HARO
            <span class="main-slider__title_lg">Seminuevos</span>
          </div>
          <a class="main-slider__link" href="inventory-list.php">Ver Catálogo</a>
        </div>
      </div>
    </div>
    <div class="main-slider__slide-2 sp-slide">
      <img class="sp-image" src="assets/media/content/b-main-slider/bg-2.jpg" alt="slider"
           style="width:100%;height:680px;object-fit:cover">
      <div class="sp-layer" data-width="100%"
           data-show-transition="left" data-hide-transition="left"
           data-show-duration="800" data-show-delay="400" data-hide-delay="400">
        <div class="main-slider__wrap">
          <div class="main-slider__slogan">Vende con nosotros</div>
          <div class="main-slider__title">Haro<br>Semi Nuevos</div>
          <a class="main-slider__link" href="contacts.php">Contáctanos</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ═══════════════════════════════════════════
     BRAND CAROUSEL
═══════════════════════════════════════════ -->
<section class="brands-section">
  <div class="js-slider"
    data-slick='{"slidesToShow":6,"slidesToScroll":1,"infinite":true,"autoplay":true,"autoplaySpeed":2000,"arrows":false,"responsive":[{"breakpoint":1400,"settings":{"slidesToShow":5}},{"breakpoint":1040,"settings":{"slidesToShow":4}},{"breakpoint":767,"settings":{"slidesToShow":3}},{"breakpoint":480,"settings":{"slidesToShow":2}}]}'>
    <?php foreach ($marcas as $mar): ?>
      <?php if ($mar->autos > 0): ?>
      <div class="brand-item">
        <a href="inventory-list.php?marca=<?php echo $mar->id; ?>">
          <img src="<?php echo $mar->imagen; ?>" alt="<?php echo $mar->marca; ?>">
        </a>
      </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     PRICE SEARCH BAND
═══════════════════════════════════════════ -->
<?php
[$priceMax, $priceMin] = $adminAutos->dameMaximoMinimo();
$priceMin = str_replace(',', '', $priceMin);
$priceMax = str_replace(',', '', $priceMax);
?>
<section class="price-band">
  <div class="container">
    <form method="get" action="inventory-list.php">
      <div class="price-band-inner">
        <div class="price-band-title">
          <i class="fas fa-tag"></i> Buscar por Precio
        </div>
        <div class="price-display">
          <div class="price-val-badge" id="hp-display-min">$<?php echo number_format($priceMin); ?></div>
          <span class="price-sep">—</span>
          <div class="price-val-badge" id="hp-display-max">$<?php echo number_format($priceMax); ?></div>
        </div>
        <div class="price-range-wrap">
          <div class="price-range-track">
            <div class="price-range-fill" id="hp-fill"></div>
          </div>
          <input type="range" class="hp-range" id="hp-fromSlider" name="min"
                 min="<?php echo $priceMin; ?>" max="<?php echo $priceMax; ?>"
                 value="<?php echo $priceMin; ?>">
          <input type="range" class="hp-range" id="hp-toSlider" name="max"
                 min="<?php echo $priceMin; ?>" max="<?php echo $priceMax; ?>"
                 value="<?php echo $priceMax; ?>">
        </div>
        <button type="submit" class="btn-search">
          <i class="fas fa-search"></i> Ver Resultados
        </button>
      </div>
    </form>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     WELCOME
═══════════════════════════════════════════ -->
<section class="welcome-section">
  <div class="container">
    <div class="section-eyebrow">Te ayudamos a encontrar tu próximo coche</div>
    <h2 class="section-heading">Bienvenido a <span>Haro Seminuevos</span></h2>
    <div class="welcome-pillars">
      <div class="pillar">
        <div class="pillar-icon"><i class="fas fa-car"></i></div>
        <div class="pillar-title">Calidad Garantizada</div>
        <p class="pillar-text">Autos de primera calidad, seleccionados cuidadosamente para tu tranquilidad.</p>
      </div>
      <div class="pillar">
        <div class="pillar-icon"><i class="fas fa-shield-halved"></i></div>
        <div class="pillar-title">Seguridad y Comodidad</div>
        <p class="pillar-text">Cada vehículo pasa por una revisión exhaustiva antes de ser puesto en venta.</p>
      </div>
      <div class="pillar">
        <div class="pillar-icon"><i class="fas fa-star"></i></div>
        <div class="pillar-title">Modelos Exclusivos</div>
        <p class="pillar-text">Autos de lujo y modelos exclusivos al mejor precio del mercado.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     VEHICLE CAROUSEL
═══════════════════════════════════════════ -->
<section class="carousel-section">
  <div class="carousel-header">
    <div>
      <div class="section-eyebrow">Encuentra tu auto ideal</div>
      <h2 class="section-heading">Nuestros <span>Vehículos</span></h2>
    </div>
    <a href="inventory-list.php" class="btn-search">
      <i class="fas fa-list"></i> Ver Inventario
    </a>
  </div>

  <div class="carousel-track-wrap">
    <div style="padding: 0 40px;">
      <?php $autosTodos = $adminAutos->dameAutosSinPausar(); ?>
      <div class="js-slider"
        data-slick='{"slidesToShow":4,"slidesToScroll":1,"infinite":true,"arrows":true,"dots":false,"responsive":[{"breakpoint":1400,"settings":{"slidesToShow":3}},{"breakpoint":1040,"settings":{"slidesToShow":2}},{"breakpoint":640,"settings":{"slidesToShow":1}}]}'>
        <?php foreach ($autosTodos as $autos): ?>
          <?php if (!$autos->pausado): ?>
          <div class="car-slide">
            <div class="car-card">
              <a href="vehicle-details.php?auto=<?php echo $autos->id; ?>" style="display:block;text-decoration:none">
              <div class="car-card-img">
                <?php if (!empty($autos->imagen)): ?>
                  <img src="<?php echo $autos->imagen; ?>" alt="<?php echo $autos->marca->marca; ?>" loading="lazy">
                <?php else: ?>
                  <img src="<?php echo $autos->imagenes[0]->url ?? 'assets/media/content/b-goods/main-slider/main/1.jpg'; ?>" alt="<?php echo $autos->marca->marca; ?>" loading="lazy">
                <?php endif; ?>
                <div class="car-card-overlay">
                  <div class="car-card-overlay-icon"><i class="fas fa-eye"></i></div>
                </div>
              </div>
              </a>
              <div class="car-card-body">
                <div class="car-card-title">
                  <?php echo strtoupper($autos->marca->marca) . ' ' . strtoupper($autos->modelo->modelo); ?>
                </div>
                <ul class="car-card-specs">
                  <li class="car-card-spec"><i class="fas fa-gas-pump"></i><?php echo $autos->combustible; ?></li>
                  <li class="car-card-spec"><i class="fas fa-calendar-alt"></i><?php echo $autos->anio; ?></li>
                  <li class="car-card-spec"><i class="fas fa-cog"></i><?php echo $autos->transmicion->transmicion; ?></li>
                  <li class="car-card-spec"><i class="fas fa-road"></i><?php echo haroFormatoNumero($autos->kilometrage); ?> km</li>
                </ul>
                <div class="car-card-footer">
                  <div>
                    <?php if ($autos->precio): ?>
                    <div class="car-card-price-lbl">PRECIO</div>
                    <div class="car-card-price">$<?php echo number_format($autos->precio); ?></div>
                    <?php endif; ?>
                  </div>
                  <a href="vehicle-details.php?auto=<?php echo $autos->id; ?>" class="car-card-link">
                    Ver más <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="carousel-cta-bar">
    <a href="inventory-list.php" class="btn-search">
      <i class="fas fa-th-list"></i> Ver Todos Los Vehículos
    </a>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════ -->
<section class="cta-banner">
  <div class="container">
    <div class="cta-grid">
      <div>
        <div class="cta-tag">Únete a nosotros</div>
        <h2 class="cta-title">¿Quieres vender tu auto?</h2>
        <p class="cta-sub">Te ofrecemos el mejor precio para tu auto. ¡Hazlo con nosotros y vende rápido y seguro!</p>
      </div>
      <div class="cta-actions">
        <a href="contacts.php" class="btn-search">
          <i class="fas fa-envelope"></i> Contáctanos
        </a>
        <a href="https://api.whatsapp.com/send?phone=523336368433" class="cta-phone" target="_blank" rel="noopener">
          <div class="cta-phone-icon"><i class="fab fa-whatsapp"></i></div>
          <div>
            <div class="cta-phone-lbl">Llámanos hoy</div>
            <div class="cta-phone-num">33 38 08 29 13</div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     STATS
═══════════════════════════════════════════ -->
<section class="stats-section">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px">
      <div class="section-eyebrow">Nuestros números</div>
      <h2 class="section-heading">Haro en <span style="color:var(--accent)">Cifras</span></h2>
    </div>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-canvas-wrap">
          <span class="b-progress-list__percent js-chart"
                data-percent="<?php echo count($autosTodos); ?>">
            <span class="js-percent"></span>
          </span>
        </div>
        <div class="stat-label">Vehículos en Línea</div>
      </div>
      <div class="stat-card">
        <div class="stat-canvas-wrap">
          <span class="b-progress-list__percent js-chart"
                data-percent="<?php echo $adminAutos->cuentaAutosHistorico() + 2400; ?>">
            <span class="js-percent"></span>
          </span>
        </div>
        <div class="stat-label">Clientes Satisfechos</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     ISOTOPE GRID
═══════════════════════════════════════════ -->
<section class="iso-section">
  <div class="container">
    <div class="iso-header">
      <div class="section-eyebrow">Te ayudamos a encontrar tu auto perfecto</div>
      <h2 class="section-heading">Nuestros Vehículos <span style="color:var(--accent)">Haro Seminuevos</span></h2>

      <ul class="iso-filters b-isotope-filter list-unstyled" id="iso-filters">
        <li><a href="#" data-filter="*" class="is-checked">Todos</a></li>
        <?php foreach ($marcas as $marcas): ?>
          <?php if ($marcas->autos > 0): ?>
          <li><a href="#" data-filter=".<?php echo $marcas->id; ?>"><?php echo strtoupper($marcas->marca); ?></a></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>

    <ul class="b-isotope-grid grid list-unstyled row">
      <li class="grid-sizer col-lg-4 col-md-6"></li>
      <?php foreach ($autosTodos as $aut): ?>
        <?php if (!$aut->pausado): ?>
        <li class="b-isotope-grid__item grid-item col-lg-4 col-md-6 web <?php echo $aut->marca->id; ?>">
          <div class="iso-card">
            <a href="vehicle-details.php?auto=<?php echo $aut->id; ?>">
            <div class="iso-card-img">
              <?php if (!empty($aut->imagen)): ?>
                <img src="<?php echo $aut->imagen; ?>" alt="<?php echo $aut->marca->marca; ?>" loading="lazy">
              <?php else: ?>
                <img src="<?php echo $aut->imagenes[0]->url ?? 'assets/media/content/b-goods/main-slider/main/1.jpg'; ?>" alt="<?php echo $aut->marca->marca; ?>" loading="lazy">
              <?php endif; ?>
            </div>
            </a>
            <div class="iso-card-body">
              <div class="iso-card-title">
                <?php echo strtoupper($aut->marca->marca) . ' ' . strtoupper($aut->modelo->modelo); ?>
              </div>
              <ul class="iso-card-specs">
                <li class="iso-card-spec"><i class="fas fa-calendar-alt"></i><?php echo $aut->anio; ?></li>
                <li class="iso-card-spec"><i class="fas fa-cog"></i><?php echo $aut->transmicion->transmicion; ?></li>
                <li class="iso-card-spec"><i class="fas fa-gas-pump"></i><?php echo $aut->combustible; ?></li>
                <li class="iso-card-spec"><i class="fas fa-road"></i><?php echo haroFormatoNumero($aut->kilometrage); ?> km</li>
              </ul>
              <div class="iso-card-footer">
                <?php if ($aut->precio): ?>
                <div>
                  <div class="iso-card-price-lbl">PRECIO</div>
                  <div class="iso-card-price">$<?php echo number_format($aut->precio); ?></div>
                </div>
                <?php else: ?>
                <div></div>
                <?php endif; ?>
                <a href="vehicle-details.php?auto=<?php echo $aut->id; ?>" class="iso-card-cta">
                  Ver más <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php include 'template/footer.php'; ?>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="assets/plugins/switcher/js/dmss.js"></script>
<script src="assets/libs/bootstrap-select.min.js"></script>
<script src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="assets/plugins/headers/slidebar.js"></script>
<script src="assets/plugins/headers/header.js"></script>
<script src="assets/plugins/jqBootstrapValidation.js"></script>
<script src="assets/plugins/flowplayer/flowplayer.min.js"></script>
<script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
<script src="assets/plugins/isotope/imagesLoaded.js"></script>
<script src="assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/plugins/rendro-easy-pie-chart/jquery.waypoints.min.js"></script>
<script src="assets/plugins/scrollreveal/scrollreveal.min.js"></script>
<script src="assets/plugins/ofi.min.js"></script>
<script src="assets/plugins/slider-pro/jquery.sliderPro.min.js"></script>
<script src="assets/plugins/slick/slick.js"></script>
<script src="assets/js/custom.js"></script>

<script>
/* ── Price range slider ─────────────────────── */
(function () {
  var fromS = document.getElementById('hp-fromSlider');
  var toS   = document.getElementById('hp-toSlider');
  var fill  = document.getElementById('hp-fill');
  var dMin  = document.getElementById('hp-display-min');
  var dMax  = document.getElementById('hp-display-max');
  if (!fromS || !toS) return;

  function fmt(n) { return '$' + parseInt(n).toLocaleString('es-MX'); }

  function update() {
    var mn  = parseInt(fromS.min), mx = parseInt(fromS.max);
    var fr  = parseInt(fromS.value), to = parseInt(toS.value);
    var l   = ((fr - mn) / (mx - mn)) * 100;
    var r   = ((to - mn) / (mx - mn)) * 100;
    fill.style.left  = l + '%';
    fill.style.width = (r - l) + '%';
    dMin.textContent = fmt(fr);
    dMax.textContent = fmt(to);
  }

  fromS.addEventListener('input', function () {
    if (parseInt(fromS.value) > parseInt(toS.value)) fromS.value = toS.value;
    update();
  });
  toS.addEventListener('input', function () {
    if (parseInt(toS.value) < parseInt(fromS.value)) toS.value = fromS.value;
    update();
  });
  update();
})();

/* ── sp-image width fix ─────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var els = document.querySelectorAll('.sp-image');
    for (var i = 0; i < els.length; i++) {
      els[i].style.width = '100%';
    }
  }, 150);
});

/* ── Isotope grid + filter ──────────────────── */
$(document).ready(function () {
  var $grid = $('.b-isotope-grid').isotope({
    itemSelector: '.b-isotope-grid__item',
    layoutMode: 'fitRows',
    masonry: { columnWidth: '.grid-sizer' }
  });

  /* filter button clicks */
  $('#iso-filters').on('click', 'a', function (e) {
    e.preventDefault();
    var filterVal = $(this).attr('data-filter');
    $grid.isotope({ filter: filterVal });
    /* active state */
    $('#iso-filters a').removeClass('is-checked');
    $(this).addClass('is-checked');
  });

  /* re-layout after images load */
  $grid.imagesLoaded(function () { $grid.isotope('layout'); });
});

/* ── Media query helpers (kept for compatibility) */
var mq = window.matchMedia('(max-width: 512px)');
var dNone = document.getElementsByClassName('d-none-mobile');
function WidthChange(mq) {
  for (var i = 0; i < dNone.length; i++) {
    dNone[i].style.display = mq.matches ? 'none' : 'block';
  }
}
mq.addListener(WidthChange);
WidthChange(mq);
</script>
</body>
</html>
