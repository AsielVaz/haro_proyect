<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Autos Haro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        body {
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
            background: #f2f2f7;
            padding: 0 0 48px 0;
            overflow-x: hidden;
        }

        /* ── HEADER ── */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 52px 20px 0;
            background: rgba(242, 242, 247, 0.82);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .header-top {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .app-header h1 {
            font-size: 30px;
            font-weight: 700;
            color: #1c1c1e;
            letter-spacing: -0.6px;
        }

        .header-count {
            font-size: 13px;
            color: #8e8e93;
            font-weight: 400;
        }

        /* ── BUSCADOR ── */
        .search-wrap {
            padding: 12px 0 14px;
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e8e93;
            pointer-events: none;
            display: flex;
        }

        .search-input {
            width: 100%;
            padding: 10px 38px 10px 38px;
            border-radius: 12px;
            border: none;
            background: rgba(118, 118, 128, 0.12);
            color: #1c1c1e;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: background 0.18s, box-shadow 0.18s;
        }

        .search-input::placeholder {
            color: #8e8e93;
        }

        .search-input:focus {
            background: rgba(118, 118, 128, 0.16);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
        }

        .search-clear {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: #aeaeb2;
            border: none;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ffffff;
            padding: 0;
        }

        .search-clear.visible {
            display: flex;
        }

        /* ── LISTA ── */
        .cars-list {
            padding: 16px 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        /* ── TARJETA ── */
        .car-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.05);
            transition: transform 0.18s ease, opacity 0.2s ease;
        }

        .car-card.hidden {
            display: none;
        }

        .car-card:active {
            transform: scale(0.988);
        }

        /* ── IMAGEN ── */
        .car-image-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #f2f2f7;
            overflow: hidden;
        }

        .car-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .car-card:hover .car-image-wrap img {
            transform: scale(1.03);
        }

        .car-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c7c7cc;
        }

        .car-image-placeholder svg {
            width: 44px;
            height: 44px;
        }

        /* Gradiente sobre imagen */
        .car-image-wrap::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 55%;
            background: linear-gradient(to top, rgba(0,0,0,0.42) 0%, transparent 100%);
        }

        /* ── BADGES ── */
        .image-badges {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 5px;
            z-index: 2;
        }

        .badge {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 20px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .badge-visible {
            background: rgba(255, 255, 255, 0.82);
            color: #1c1c1e;
        }

        .badge-hidden {
            background: rgba(60, 60, 67, 0.65);
            color: #ffffff;
        }

        .badge-banner {
            background: rgba(255, 204, 0, 0.88);
            color: #3d2c00;
        }

        /* Precio */
        .image-price {
            position: absolute;
            bottom: 12px;
            right: 14px;
            z-index: 2;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 1px 6px rgba(0,0,0,0.45);
            letter-spacing: -0.5px;
        }

        /* ── CUERPO ── */
        .car-body {
            padding: 14px 16px 16px;
        }

        .car-name {
            font-size: 17px;
            font-weight: 600;
            color: #1c1c1e;
            letter-spacing: -0.2px;
            line-height: 1.25;
        }

        .car-year {
            font-size: 13px;
            color: #8e8e93;
            margin-top: 2px;
            font-weight: 400;
        }

        .card-divider {
            height: 1px;
            background: rgba(60, 60, 67, 0.1);
            margin: 12px 0;
        }

        /* ── BOTÓN ── */
        .btn-location {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #1c1c1e;
            text-decoration: none;
            background: rgba(118, 118, 128, 0.1);
            border: none;
            transition: background 0.18s ease;
            cursor: default;
            letter-spacing: 0;
        }

        .btn-location:hover {
            background: rgba(118, 118, 128, 0.16);
        }

        .btn-location svg {
            flex-shrink: 0;
            color: #8e8e93;
        }

        /* ── SIN RESULTADOS ── */
        .no-results {
            display: none;
            text-align: center;
            padding: 48px 20px;
            color: #8e8e93;
        }

        .no-results.visible {
            display: block;
        }

        .no-results svg {
            width: 44px;
            height: 44px;
            margin-bottom: 12px;
            color: #c7c7cc;
        }

        .no-results p {
            font-size: 15px;
            font-weight: 500;
            color: #3c3c43;
        }

        .no-results span {
            display: block;
            font-size: 13px;
            margin-top: 3px;
            color: #8e8e93;
        }

        /* ── ESTADO VACÍO ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #8e8e93;
        }

        .empty-state svg {
            width: 52px;
            height: 52px;
            margin-bottom: 14px;
            color: #c7c7cc;
        }

        .empty-state p {
            font-size: 15px;
            color: #3c3c43;
        }
    </style>
</head>

<body>
    <?php
    include_once("../api/adminAutos.php");
    $adminAutos = new AdministradorAutos();
    $autos = $adminAutos->dameAutos();
    ?>

    <div class="app-header">
        <div class="header-top">
            <h1>Autos Haro</h1>
            <span class="header-count"><?php echo count($autos) ?> vehículos</span>
        </div>

        <div class="search-wrap">
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>
            <input
                type="search"
                class="search-input"
                id="searchInput"
                placeholder="Buscar por marca, modelo o año…"
                autocomplete="off"
                spellcheck="false"
            >
            <button class="search-clear" id="searchClear" aria-label="Limpiar">
                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="cars-list" id="carsList">

        <div class="no-results" id="noResults">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <p>Sin resultados</p>
            <span>Intenta con otra búsqueda</span>
        </div>

        <?php if (empty($autos)): ?>
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
                <p>No hay autos registrados</p>
            </div>
        <?php else: ?>
            <?php foreach ($autos as $auto):
                $imagen    = ($auto->imagen != "") ? $auto->imagen : (isset($auto->imagenes[0]) ? $auto->imagenes[0]->url : '');
                $isHidden  = $auto->pausado;
                $hasBanner = !$isHidden && $auto->banner;
                $searchKey = strtolower($auto->marca->marca . ' ' . $auto->modelo->modelo . ' ' . $auto->anio);
            ?>
                <div class="car-card" data-search="<?php echo htmlspecialchars($searchKey) ?>">

                    <div class="car-image-wrap">
                        <?php if ($imagen): ?>
                            <img src="<?php echo htmlspecialchars($imagen) ?>"
                                 alt="<?php echo htmlspecialchars($auto->marca->marca . ' ' . $auto->modelo->modelo) ?>"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="car-image-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="image-badges">
                            <?php if ($isHidden): ?>
                                <span class="badge badge-hidden">Oculto</span>
                            <?php else: ?>
                                <span class="badge badge-visible">Visible</span>
                            <?php endif; ?>
                            <?php if ($hasBanner): ?>
                                <span class="badge badge-banner">Banner</span>
                            <?php endif; ?>
                        </div>

                        <div class="image-price">$<?php echo number_format($auto->precio, 0) ?></div>
                    </div>

                    <div class="car-body">
                        <div class="car-name"><?php echo htmlspecialchars($auto->marca->marca . ' ' . $auto->modelo->modelo) ?></div>
                        <div class="car-year"><?php echo htmlspecialchars($auto->anio) ?></div>

                        <div class="card-divider"></div>

                        <a class="btn-location" href="auto-mod.php?id=<?php echo urlencode($auto->id) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            Cambiar localización del auto
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        const input     = document.getElementById('searchInput');
        const clearBtn  = document.getElementById('searchClear');
        const noResults = document.getElementById('noResults');
        const cards     = document.querySelectorAll('.car-card');

        function filterCards(query) {
            const q = query.trim().toLowerCase();
            let visible = 0;
            cards.forEach(card => {
                const match = !q || (card.dataset.search || '').includes(q);
                card.classList.toggle('hidden', !match);
                if (match) visible++;
            });
            noResults.classList.toggle('visible', visible === 0 && q.length > 0);
            clearBtn.classList.toggle('visible', q.length > 0);
        }

        input.addEventListener('input', () => filterCards(input.value));
        clearBtn.addEventListener('click', () => { input.value = ''; filterCards(''); input.focus(); });
    </script>

</body>

</html>
