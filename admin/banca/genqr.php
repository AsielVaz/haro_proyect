<?php

/**
 * generar_qr_auto.php
 *
 * Función aislada para generar la imagen/etiqueta QR de un auto.
 * Uso mínimo:
 *
 *   require_once 'generar_qr_auto.php';
 *   $resultado = generarImagenQRAuto(123);
 *
 * La imagen se guarda por defecto en:
 *   carpeta_actual/qr_autos/etiqueta-qr-auto-123.png
 */

if (!function_exists('qr_auto_resolver_archivo')) {
    function qr_auto_resolver_archivo($rutas)
    {
        foreach ($rutas as $ruta) {
            if (file_exists($ruta)) {
                return $ruta;
            }
        }

        return null;
    }
}

if (!function_exists('qr_auto_leer_binario')) {
    function qr_auto_leer_binario($url)
    {
        $contenido = false;

        if (function_exists('file_get_contents')) {
            $contenido = @file_get_contents($url);
            if ($contenido !== false) {
                return $contenido;
            }
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $contenido = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($contenido !== false && $httpCode >= 200 && $httpCode < 300) {
                return $contenido;
            }
        }

        return false;
    }
}

if (!function_exists('qr_auto_buscar_ttf')) {
    function qr_auto_buscar_ttf()
    {
        $rutas = array(
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
            '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
            '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf',
            '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/liberation/LiberationSans-Bold.ttf',
        );

        foreach ($rutas as $ruta) {
            if (file_exists($ruta)) {
                return $ruta;
            }
        }

        return null;
    }
}

if (!function_exists('generarImagenQRAuto')) {
    /**
     * Genera la etiqueta QR del auto y la guarda en carpeta_actual/qr_autos.
     *
     * @param int   $idAuto   ID del auto.
     * @param array $opciones Opcional:
     *                        - base_url: URL base del sitio.
     *                        - output_dir: carpeta donde guardar la imagen.
     *                        - devolver_base64: true/false.
     *
     * @return array Datos de la imagen generada.
     * @throws Exception Si falta una dependencia o no se puede generar/guardar.
     */
    function generarImagenQRAuto($idAuto, $opciones = array())
    {
        $idAuto = intval($idAuto);

        if ($idAuto <= 0) {
            throw new Exception('ID de auto inválido.');
        }

        if (!function_exists('imagecreatetruecolor')) {
            throw new Exception('La extensión GD de PHP no está disponible.');
        }

        $baseDir = dirname(__FILE__);

        /*
         * Rutas probables según el archivo original:
         * - qrlib.php estaba en: carpeta_actual/api/phpqrcode/qrlib.php
         * - adminAutos.php estaba en: ../api/adminAutos.php
         */
        $qrlibPath = qr_auto_resolver_archivo(array(
            $baseDir . '/api/phpqrcode/qrlib.php',
            $baseDir . '/../api/phpqrcode/qrlib.php',
            dirname($baseDir) . '/api/phpqrcode/qrlib.php',
        ));

        if (!$qrlibPath) {
            throw new Exception('No se encontró api/phpqrcode/qrlib.php.');
        }

        require_once $qrlibPath;

        if (!class_exists('AdministradorAutos')) {
            $adminAutosPath = qr_auto_resolver_archivo(array(
                $baseDir . '/../api/adminAutos.php',
                $baseDir . '/api/adminAutos.php',
                dirname($baseDir) . '/api/adminAutos.php',
            ));

            if (!$adminAutosPath) {
                throw new Exception('No se encontró adminAutos.php.');
            }

            require_once $adminAutosPath;
        }

        if (!class_exists('AdministradorAutos')) {
            throw new Exception('La clase AdministradorAutos no está disponible.');
        }

        $baseUrl = isset($opciones['base_url']) ? rtrim($opciones['base_url'], '/') : 'https://seminuevosharo.mx';
        $outputDir = isset($opciones['output_dir']) ? rtrim($opciones['output_dir'], '/\\') : $baseDir . '/qr_autos';

        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0755, true)) {
                throw new Exception('No se pudo crear la carpeta qr_autos.');
            }
        }

        if (!is_writable($outputDir)) {
            throw new Exception('La carpeta qr_autos no tiene permisos de escritura.');
        }

        $adminAuto = new AdministradorAutos();
        $auto = $adminAuto->dameAuto($idAuto);

        if (!$auto) {
            throw new Exception('No se encontró el auto con ID ' . $idAuto . '.');
        }

        $qrUrl = $baseUrl . '/vehicle-details.php?auto=' . $idAuto;

        /*
         * Generar QR crudo con la misma configuración del archivo original.
         */
        ob_start();
        QRcode::png($qrUrl, false, QR_ECLEVEL_M, 8, 2);
        $qrRaw = ob_get_clean();

        if (!$qrRaw) {
            throw new Exception('No se pudo generar el QR.');
        }

        /*
         * Imagen compuesta 500 x 300 px.
         */
        $imgW = 500;
        $imgH = 300;
        $mid  = 250;

        $canvas  = imagecreatetruecolor($imgW, $imgH);
        $cWhite  = imagecolorallocate($canvas, 255, 255, 255);
        $cBlack  = imagecolorallocate($canvas, 30, 30, 30);
        $cGray   = imagecolorallocate($canvas, 110, 110, 110);

        imagefill($canvas, 0, 0, $cWhite);

        /*
         * QR en lado izquierdo.
         */
        $qrSrc = imagecreatefromstring($qrRaw);
        if (!$qrSrc) {
            imagedestroy($canvas);
            throw new Exception('No se pudo leer la imagen del QR.');
        }

        $qrSz  = $imgH - 20;
        $qrTmp = imagecreatetruecolor($qrSz, $qrSz);
        $bgQR  = imagecolorallocate($qrTmp, 255, 255, 255);
        imagefill($qrTmp, 0, 0, $bgQR);

        imagecopyresampled(
            $qrTmp,
            $qrSrc,
            0,
            0,
            0,
            0,
            $qrSz,
            $qrSz,
            imagesx($qrSrc),
            imagesy($qrSrc)
        );

        imagecopy($canvas, $qrTmp, 10, 10, 0, 0, $qrSz, $qrSz);
        imagedestroy($qrSrc);
        imagedestroy($qrTmp);

        /*
         * Lado derecho: logo principal.
         */
        $rX = $mid + 10;
        $rW = $imgW - $rX - 10;

        $logoRaw = qr_auto_leer_binario($baseUrl . '/assets/media/general/logo_bn.png');
        $logoBottomY = 20;

        if ($logoRaw !== false) {
            $logoSrc = @imagecreatefromstring($logoRaw);

            if ($logoSrc) {
                $sW = imagesx($logoSrc);
                $sH = imagesy($logoSrc);

                if ($sW > 0 && $sH > 0) {
                    $sc = min($rW / $sW, 143 / $sH);
                    $lW = (int)($sW * $sc);
                    $lH = (int)($sH * $sc);

                    if ($lW > 0 && $lH > 0) {
                        $logoTmp = imagecreatetruecolor($lW, $lH);
                        $bgTmp   = imagecolorallocate($logoTmp, 255, 255, 255);
                        imagefill($logoTmp, 0, 0, $bgTmp);
                        imagealphablending($logoTmp, true);

                        imagecopyresampled($logoTmp, $logoSrc, 0, 0, 0, 0, $lW, $lH, $sW, $sH);
                        imagecopy($canvas, $logoTmp, $imgW - $lW, 10, 0, 0, $lW, $lH);

                        $logoBottomY = 20 + $lH;
                        imagedestroy($logoTmp);
                    }
                }

                imagedestroy($logoSrc);
            }
        }

        /*
         * Modelo / año como texto; marca como imagen.
         */
        $modeloTxt = (isset($auto->modelo) && isset($auto->modelo->modelo)) ? $auto->modelo->modelo : '';
        $anioTxt   = isset($auto->anio) ? (string)$auto->anio : '';


        if (isset($auto->marca) && isset($auto->marca->imagen)) {
            $marcaImagenOriginal = $auto->marca->imagen;

            $extension = pathinfo($marcaImagenOriginal, PATHINFO_EXTENSION);
            $nombreSinExtension = substr(
                $marcaImagenOriginal,
                0,
                -strlen($extension) - 1
            );

            $marcaImagen = $nombreSinExtension . '_b.' . $extension;
        }

        $cx   = $rX + (int)($rW / 2);
        $fitW = $rW - 24;

        $textStartY = $logoBottomY + 12;
        $textAreaH  = $imgH - $textStartY - 10;
        $lineH      = (int)($textAreaH / 3);

        if ($lineH < 20) {
            $lineH = 20;
        }

        /*
         * Slot 0: logo de la marca.
         */
        if ($marcaImagen !== '') {
            $marcaUrl = $marcaImagen;

            if (strpos($marcaUrl, 'http://') !== 0 && strpos($marcaUrl, 'https://') !== 0) {
                $marcaUrl = $baseUrl . '/' . ltrim($marcaUrl, '/');
            }

            $marcaRaw = qr_auto_leer_binario($marcaUrl);

            if ($marcaRaw !== false) {
                $marcaSrc = @imagecreatefromstring($marcaRaw);

                if ($marcaSrc) {
                    $mSW = imagesx($marcaSrc);
                    $mSH = imagesy($marcaSrc);

                    if ($mSW > 0 && $mSH > 0) {
                        $mSc = min($fitW / $mSW, ($lineH * 1.6) / $mSH);
                        $mDW = (int)($mSW * $mSc);
                        $mDH = (int)($mSH * $mSc);

                        if ($mDW > 0 && $mDH > 0) {
                            $marcaTmp = imagecreatetruecolor($mDW, $mDH);
                            $bgM = imagecolorallocate($marcaTmp, 255, 255, 255);
                            imagefill($marcaTmp, 0, 0, $bgM);
                            imagealphablending($marcaTmp, true);

                            imagecopyresampled($marcaTmp, $marcaSrc, 0, 0, 0, 0, $mDW, $mDH, $mSW, $mSH);

                            imagecopy(
                                $canvas,
                                $marcaTmp,
                                (int)($rX + ($rW - $mDW) / 2),
                                $textStartY + (int)(($lineH - $mDH) / 2),
                                0,
                                0,
                                $mDW,
                                $mDH
                            );

                            imagedestroy($marcaTmp);
                        }
                    }

                    imagedestroy($marcaSrc);
                }
            }
        }

        /*
         * Slots 1 y 2: modelo y año.
         */
        $ttfFont = qr_auto_buscar_ttf();

        if ($ttfFont && function_exists('imagettfbbox') && function_exists('imagettftext')) {
            $texts  = array($modeloTxt, $anioTxt);
            $colors = array($cBlack, $cGray);

            foreach ($texts as $i => $txt) {
                if ($txt === '') {
                    continue;
                }

                $slot  = $i + 1;
                $maxPt = min(42, (int)($lineH * 0.78));

                for ($pt = $maxPt; $pt >= 8; $pt--) {
                    $box = imagettfbbox($pt, 0, $ttfFont, $txt);
                    if (abs($box[4] - $box[0]) <= $fitW) {
                        break;
                    }
                }

                $box = imagettfbbox($pt, 0, $ttfFont, $txt);
                $tw  = abs($box[4] - $box[0]);
                $th  = abs($box[5] - $box[1]);

                $drawX = $imgW - $tw - 15;
                $drawY = $textStartY + $slot * $lineH + (int)(($lineH + $th) / 2);

                imagettftext($canvas, $pt, 0, $drawX, $drawY, $colors[$i], $ttfFont, $txt);
            }
        } else {
            $modeloX = $cx - (int)(strlen($modeloTxt) * imagefontwidth(5) / 2);
            $anioX   = $cx - (int)(strlen($anioTxt) * imagefontwidth(4) / 2);

            imagestring($canvas, 5, $modeloX, $textStartY + $lineH, $modeloTxt, $cBlack);
            imagestring($canvas, 4, $anioX, $textStartY + $lineH * 2, $anioTxt, $cGray);
        }

        $filename = 'etiqueta-qr-auto-' . $idAuto . '.png';
        $outputPath = $outputDir . '/' . $filename;

        if (!imagepng($canvas, $outputPath)) {
            imagedestroy($canvas);
            throw new Exception('No se pudo guardar la imagen QR.');
        }

        imagedestroy($canvas);

        $resultado = array(
            'id_auto' => $idAuto,
            'ruta' => $outputPath,
            'archivo' => $filename,
            'carpeta' => $outputDir,
            'qr_url' => $qrUrl,
            'ancho' => $imgW,
            'alto' => $imgH,
        );

        if (!empty($opciones['devolver_base64'])) {
            $resultado['base64'] = base64_encode(file_get_contents($outputPath));
        }

        if (empty($opciones['sin_descarga'])) {
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($outputPath));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            readfile($outputPath);
            exit;
        }

        return $resultado;
    }
}





try {
    $qr = generarImagenQRAuto($_GET['id_auto']);
    echo 'Imagen generada para auto ID ' . $_GET['id_auto'] . ': ' . $qr['ruta'] . "\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
