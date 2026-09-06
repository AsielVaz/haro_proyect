
<?php

// ============================================================
// CONFIGURACIÓN GENERAL
// ============================================================

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'conectorBD.php';


// ============================================================
// CONFIGURACIÓN DE OPTIMIZACIÓN
// ============================================================

define('IMAGEN_MAX_ANCHO', 2000);
define('IMAGEN_MAX_ALTO', 2000);

/*
 * 85 = excelente equilibrio para fotografía web.
 * Normalmente la pérdida visual es prácticamente imperceptible.
 */
define('CALIDAD_JPEG', 85);

/*
 * Para archivos WebP que ya lleguen en este formato.
 */
define('CALIDAD_WEBP', 84);

/*
 * PNG es sin pérdida.
 * 9 = máxima compresión sin reducir calidad visual.
 */
define('COMPRESION_PNG', 9);


// ============================================================
// FUNCIÓN PRINCIPAL
// ============================================================

function guardarImagenesDeCorreos(
    $servidor,
    $usuario,
    $contrasena,
    $directorio
) {

    echo "============================================\n";
    echo " RECEPTOR DE IMÁGENES\n";
    echo "============================================\n";

    $directorio = rtrim($directorio, '/') . '/';

    echo "Directorio destino: " . $directorio . "\n";


    // --------------------------------------------------------
    // VERIFICAR DIRECTORIO
    // --------------------------------------------------------

    if (!is_dir($directorio)) {

        if (!@mkdir($directorio, 0775, true)) {

            die(
                "ERROR: No fue posible crear el directorio:\n" .
                $directorio .
                "\n"
            );
        }
    }


    if (!is_writable($directorio)) {

        die(
            "ERROR: PHP no tiene permisos de escritura en:\n" .
            $directorio .
            "\n"
        );
    }


    // --------------------------------------------------------
    // BASE DE DATOS
    // --------------------------------------------------------

    $conector = new Conector();


    // --------------------------------------------------------
    // IMAP
    // --------------------------------------------------------

    $conexion = @imap_open(
        $servidor,
        $usuario,
        $contrasena
    );


    if (!$conexion) {

        die(
            "ERROR IMAP: " .
            imap_last_error() .
            "\n"
        );
    }


    // --------------------------------------------------------
    // BUSCAR CORREOS NO LEÍDOS
    // --------------------------------------------------------

    $emails = imap_search(
        $conexion,
        'UNSEEN'
    );


    if (!$emails) {

        echo "No hay correos no leídos.\n";

        imap_close($conexion);

        return;
    }


    sort($emails);

    echo "Correos encontrados: " . count($emails) . "\n";


    // --------------------------------------------------------
    // PROCESAR CORREOS
    // --------------------------------------------------------

    foreach ($emails as $email_id) {

        echo "\n";
        echo "--------------------------------------------\n";
        echo "Procesando correo ID: " . $email_id . "\n";
        echo "--------------------------------------------\n";


        $estructura = @imap_fetchstructure(
            $conexion,
            $email_id
        );


        if (!$estructura) {

            echo "No se pudo leer la estructura MIME.\n";

            continue;
        }


        if (
            isset($estructura->parts) &&
            is_array($estructura->parts)
        ) {

            procesarPartes(
                $estructura->parts,
                $conexion,
                $email_id,
                $directorio,
                $conector,
                ''
            );

        } else {

            /*
             * Algunos correos pueden tener directamente
             * una imagen sin estructura multipart.
             *
             * Conservamos el flujo actual y simplemente
             * informamos el caso.
             */

            echo "El correo no contiene partes MIME procesables.\n";
        }
    }


    imap_close($conexion);


    echo "\n";
    echo "============================================\n";
    echo " PROCESO FINALIZADO\n";
    echo "============================================\n";
}


// ============================================================
// RECORRER PARTES MIME
// ============================================================

function procesarPartes(
    $partes,
    $conexion,
    $email_id,
    $directorio,
    $conector,
    $prefix
) {

    if (!is_array($partes)) {
        return;
    }


    foreach ($partes as $index => $parte) {

        $numero = $index + 1;


        if ($prefix != '') {

            $partNumber =
                $prefix .
                '.' .
                $numero;

        } else {

            $partNumber = (string)$numero;
        }


        // ----------------------------------------------------
        // MIME TYPE 5 = IMAGE
        // ----------------------------------------------------

        if (
            isset($parte->type) &&
            (int)$parte->type === 5
        ) {

            guardarParteImagen(
                $parte,
                $conexion,
                $email_id,
                $partNumber,
                $directorio,
                $conector
            );
        }


        // ----------------------------------------------------
        // BUSCAR SUBPARTES
        // ----------------------------------------------------

        if (
            isset($parte->parts) &&
            is_array($parte->parts)
        ) {

            procesarPartes(
                $parte->parts,
                $conexion,
                $email_id,
                $directorio,
                $conector,
                $partNumber
            );
        }
    }
}


// ============================================================
// GUARDAR UNA IMAGEN DEL CORREO
// ============================================================

function guardarParteImagen(
    $parte,
    $conexion,
    $email_id,
    $partNumber,
    $directorio,
    $conector
) {

    echo "Imagen encontrada en MIME: " . $partNumber . "\n";


    // --------------------------------------------------------
    // LEER DATOS
    // --------------------------------------------------------

    $datos = @imap_fetchbody(
        $conexion,
        $email_id,
        $partNumber
    );


    if (
        $datos === false ||
        $datos === ''
    ) {

        echo "No fue posible descargar esta imagen.\n";

        return;
    }


    // --------------------------------------------------------
    // DECODIFICAR MIME
    // --------------------------------------------------------

    if (isset($parte->encoding)) {

        switch ((int)$parte->encoding) {

            // BASE64
            case 3:

                $decodificado = base64_decode(
                    $datos,
                    true
                );

                if ($decodificado !== false) {
                    $datos = $decodificado;
                }

                break;


            // QUOTED PRINTABLE
            case 4:

                $datos = quoted_printable_decode(
                    $datos
                );

                break;
        }
    }


    // --------------------------------------------------------
    // EXTENSIÓN
    // --------------------------------------------------------

    $subtype = 'jpeg';


    if (
        isset($parte->subtype) &&
        trim($parte->subtype) != ''
    ) {

        $subtype = strtolower(
            trim($parte->subtype)
        );
    }


    $extension = obtenerExtensionImagen(
        $subtype
    );


    if ($extension == '') {
        $extension = 'jpg';
    }


    // --------------------------------------------------------
    // NOMBRE
    // --------------------------------------------------------

    $nombreRandom = generarNombreImagen(
        $extension
    );


    $rutaArchivo =
        $directorio .
        $nombreRandom;


    // --------------------------------------------------------
    // GUARDAR ORIGINAL
    // --------------------------------------------------------

    $resultado = @file_put_contents(
        $rutaArchivo,
        $datos,
        LOCK_EX
    );


    unset($datos);


    if ($resultado === false) {

        echo "ERROR: No se pudo guardar:\n";
        echo $rutaArchivo . "\n";

        return;
    }


    @chmod(
        $rutaArchivo,
        0644
    );


    echo "Imagen guardada: " . $rutaArchivo . "\n";


    // --------------------------------------------------------
    // INFORMACIÓN ORIGINAL
    // --------------------------------------------------------

    $pesoOriginal = @filesize(
        $rutaArchivo
    );


    if ($pesoOriginal === false) {
        $pesoOriginal = 0;
    }


    // --------------------------------------------------------
    // OPTIMIZAR
    // --------------------------------------------------------

    $resultadoOptimizacion = optimizarImagenInteligente(
        $rutaArchivo
    );


    echo $resultadoOptimizacion . "\n";


    clearstatcache(
        true,
        $rutaArchivo
    );


    $pesoFinal = @filesize(
        $rutaArchivo
    );


    if ($pesoFinal === false) {
        $pesoFinal = $pesoOriginal;
    }


    // --------------------------------------------------------
    // MOSTRAR REDUCCIÓN
    // --------------------------------------------------------

    if (
        $pesoOriginal > 0 &&
        $pesoFinal > 0
    ) {

        $reduccion =
            (($pesoOriginal - $pesoFinal) / $pesoOriginal) *
            100;


        echo "Peso original: " .
             formatearBytes($pesoOriginal) .
             "\n";


        echo "Peso final: " .
             formatearBytes($pesoFinal) .
             "\n";


        if ($pesoFinal < $pesoOriginal) {

            echo "Reducción: " .
                 round($reduccion, 2) .
                 "%\n";

        } else {

            echo "Se conservó el peso original.\n";
        }
    }


    // --------------------------------------------------------
    // GUARDAR RUTA EN BD
    // --------------------------------------------------------

    $rutaLimpia =
        '/cat_autos_img/' .
        $nombreRandom;


    $rutaSQL = addslashes(
        $rutaLimpia
    );


    $sql = "
        INSERT INTO imagen
        (
            id_auto,
            url
        )
        VALUES
        (
            '0',
            '" . $rutaSQL . "'
        )
    ";


    $conector->ejecutar(
        $sql
    );


    echo "Registrada en BD: " .
         $rutaLimpia .
         "\n";
}


// ============================================================
// OPTIMIZACIÓN INTELIGENTE
// ============================================================

function optimizarImagenInteligente(
    $filePath
) {

    if (!file_exists($filePath)) {

        return "No existe el archivo para optimizar.";
    }


    /*
     * Primero intentamos Imagick.
     *
     * Imagick suele producir mejores resultados,
     * especialmente con JPEG grandes.
     */

    if (
        class_exists('Imagick')
    ) {

        $resultado = optimizarConImagick(
            $filePath
        );


        if ($resultado === true) {

            return "Optimización realizada con Imagick.";
        }
    }


    /*
     * Fallback automático a GD.
     */

    $resultadoGD = optimizarConGD(
        $filePath
    );


    if ($resultadoGD === true) {

        return "Optimización realizada con GD.";
    }


    /*
     * Si ninguna biblioteca puede procesarlo,
     * conservamos el archivo original.
     */

    return "La imagen se conservó en su formato original.";
}


// ============================================================
// OPTIMIZAR CON IMAGICK
// ============================================================

function optimizarConImagick(
    $filePath
) {

    if (!class_exists('Imagick')) {
        return false;
    }


    $pesoOriginal = @filesize(
        $filePath
    );


    if (!$pesoOriginal) {
        return false;
    }


    $directorio = dirname(
        $filePath
    );


    $temporal = @tempnam(
        $directorio,
        'img_opt_'
    );


    if (!$temporal) {
        return false;
    }


    try {

        $image = new Imagick();


        $image->readImage(
            $filePath
        );


        /*
         * No procesar GIF animado agresivamente.
         *
         * Redimensionarlo de forma incorrecta podría
         * eliminar frames.
         */

        $formato = strtolower(
            $image->getImageFormat()
        );


        if (
            $formato == 'gif' &&
            $image->getNumberImages() > 1
        ) {

            $image->clear();
            $image->destroy();

            @unlink($temporal);

            return false;
        }


        // ----------------------------------------------------
        // CORREGIR ORIENTACIÓN
        // ----------------------------------------------------

        if (
            method_exists(
                $image,
                'autoOrientImage'
            )
        ) {

            @$image->autoOrientImage();
        }


        // ----------------------------------------------------
        // PRESERVAR PERFIL ICC
        // ----------------------------------------------------

        $perfilICC = null;


        try {

            $profiles = $image->getImageProfiles(
                'icc',
                true
            );


            if (
                is_array($profiles) &&
                isset($profiles['icc'])
            ) {

                $perfilICC = $profiles['icc'];
            }

        } catch (Exception $e) {

            $perfilICC = null;
        }


        // ----------------------------------------------------
        // QUITAR METADATOS EXIF / GPS / MINIATURAS
        // ----------------------------------------------------

        @$image->stripImage();


        /*
         * Volvemos a colocar solamente el perfil de color
         * para evitar cambios visibles en fotografías que
         * utilizan un perfil ICC.
         */

        if ($perfilICC !== null) {

            try {

                $image->profileImage(
                    'icc',
                    $perfilICC
                );

            } catch (Exception $e) {
                // No es crítico.
            }
        }


        // ----------------------------------------------------
        // DIMENSIONES
        // ----------------------------------------------------

        $width = $image->getImageWidth();
        $height = $image->getImageHeight();


        list(
            $nuevoAncho,
            $nuevoAlto
        ) = calcularNuevoTamano(
            $width,
            $height,
            IMAGEN_MAX_ANCHO,
            IMAGEN_MAX_ALTO
        );


        // ----------------------------------------------------
        // REDIMENSIONAR SOLAMENTE SI ES NECESARIO
        // ----------------------------------------------------

        if (
            $nuevoAncho < $width ||
            $nuevoAlto < $height
        ) {

            $image->resizeImage(
                $nuevoAncho,
                $nuevoAlto,
                Imagick::FILTER_LANCZOS,
                1,
                true
            );
        }


        // ----------------------------------------------------
        // JPEG
        // ----------------------------------------------------

        if (
            $formato == 'jpeg' ||
            $formato == 'jpg'
        ) {

            $image->setImageFormat(
                'jpeg'
            );


            $image->setImageCompression(
                Imagick::COMPRESSION_JPEG
            );


            $image->setImageCompressionQuality(
                CALIDAD_JPEG
            );


            /*
             * 4:2:0
             *
             * Excelente reducción de peso para fotografías,
             * prácticamente imperceptible en una web.
             */

            if (
                method_exists(
                    $image,
                    'setImageSamplingFactors'
                )
            ) {

                $image->setImageSamplingFactors(
                    array(
                        '2x2',
                        '1x1',
                        '1x1'
                    )
                );
            }


            /*
             * JPEG progresivo.
             *
             * Mejora la percepción de velocidad de carga.
             */

            if (
                method_exists(
                    $image,
                    'setInterlaceScheme'
                )
            ) {

                $image->setInterlaceScheme(
                    Imagick::INTERLACE_PLANE
                );
            }
        }


        // ----------------------------------------------------
        // PNG
        // ----------------------------------------------------

        else if ($formato == 'png') {

            $image->setImageFormat(
                'png'
            );


            $image->setImageCompression(
                Imagick::COMPRESSION_ZIP
            );


            $image->setImageCompressionQuality(
                95
            );
        }


        // ----------------------------------------------------
        // WEBP
        // ----------------------------------------------------

        else if ($formato == 'webp') {

            $image->setImageFormat(
                'webp'
            );


            $image->setImageCompressionQuality(
                CALIDAD_WEBP
            );
        }


        // ----------------------------------------------------
        // GIF ESTÁTICO
        // ----------------------------------------------------

        else if ($formato == 'gif') {

            $image->setImageFormat(
                'gif'
            );
        }


        else {

            $image->clear();
            $image->destroy();

            @unlink($temporal);

            return false;
        }


        // ----------------------------------------------------
        // ESCRIBIR TEMPORAL
        // ----------------------------------------------------

        $guardado = $image->writeImage(
            $temporal
        );


        $image->clear();
        $image->destroy();


        if (!$guardado) {

            @unlink($temporal);

            return false;
        }


        clearstatcache(
            true,
            $temporal
        );


        $pesoOptimizado = @filesize(
            $temporal
        );


        if (!$pesoOptimizado) {

            @unlink($temporal);

            return false;
        }


        // ----------------------------------------------------
        // SOLO REEMPLAZAR SI PESA MENOS
        // ----------------------------------------------------

        if ($pesoOptimizado < $pesoOriginal) {

            if (
                reemplazarArchivoSeguro(
                    $temporal,
                    $filePath
                )
            ) {

                return true;
            }
        }


        @unlink($temporal);

        return false;


    } catch (Exception $e) {

        if (isset($image)) {

            try {

                $image->clear();
                $image->destroy();

            } catch (Exception $e2) {
            }
        }


        @unlink($temporal);

        return false;
    }
}


// ============================================================
// OPTIMIZAR CON GD
// ============================================================

function optimizarConGD(
    $filePath
) {

    if (!function_exists('getimagesize')) {
        return false;
    }


    $info = @getimagesize(
        $filePath
    );


    if (
        !$info ||
        !isset($info['mime'])
    ) {

        return false;
    }


    $pesoOriginal = @filesize(
        $filePath
    );


    if (!$pesoOriginal) {
        return false;
    }


    $mime = strtolower(
        $info['mime']
    );


    $width = (int)$info[0];
    $height = (int)$info[1];


    // --------------------------------------------------------
    // ABRIR IMAGEN
    // --------------------------------------------------------

    $image = false;


    if (
        $mime == 'image/jpeg' ||
        $mime == 'image/jpg'
    ) {

        if (
            !function_exists(
                'imagecreatefromjpeg'
            )
        ) {
            return false;
        }


        $image = @imagecreatefromjpeg(
            $filePath
        );
    }


    else if ($mime == 'image/png') {

        if (
            !function_exists(
                'imagecreatefrompng'
            )
        ) {
            return false;
        }


        $image = @imagecreatefrompng(
            $filePath
        );
    }


    else if ($mime == 'image/webp') {

        if (
            !function_exists(
                'imagecreatefromwebp'
            )
        ) {
            return false;
        }


        $image = @imagecreatefromwebp(
            $filePath
        );
    }


    /*
     * No tocamos GIF con GD porque podríamos destruir
     * una posible animación.
     */

    else {

        return false;
    }


    if (!$image) {
        return false;
    }


    // --------------------------------------------------------
    // CORREGIR ORIENTACIÓN EXIF JPEG
    // --------------------------------------------------------

    if (
        $mime == 'image/jpeg' &&
        function_exists('exif_read_data')
    ) {

        $image = corregirOrientacionJPEG(
            $image,
            $filePath
        );


        $width = imagesx(
            $image
        );


        $height = imagesy(
            $image
        );
    }


    // --------------------------------------------------------
    // CALCULAR RESOLUCIÓN
    // --------------------------------------------------------

    list(
        $nuevoAncho,
        $nuevoAlto
    ) = calcularNuevoTamano(
        $width,
        $height,
        IMAGEN_MAX_ANCHO,
        IMAGEN_MAX_ALTO
    );


    // --------------------------------------------------------
    // REDIMENSIONAR
    // --------------------------------------------------------

    if (
        $nuevoAncho < $width ||
        $nuevoAlto < $height
    ) {

        $nuevo = imagecreatetruecolor(
            $nuevoAncho,
            $nuevoAlto
        );


        // PNG y WEBP con transparencia
        if (
            $mime == 'image/png' ||
            $mime == 'image/webp'
        ) {

            imagealphablending(
                $nuevo,
                false
            );


            imagesavealpha(
                $nuevo,
                true
            );


            $transparente = imagecolorallocatealpha(
                $nuevo,
                0,
                0,
                0,
                127
            );


            imagefilledrectangle(
                $nuevo,
                0,
                0,
                $nuevoAncho,
                $nuevoAlto,
                $transparente
            );
        }


        imagecopyresampled(
            $nuevo,
            $image,
            0,
            0,
            0,
            0,
            $nuevoAncho,
            $nuevoAlto,
            $width,
            $height
        );


        imagedestroy(
            $image
        );


        $image = $nuevo;
    }


    // --------------------------------------------------------
    // ARCHIVO TEMPORAL
    // --------------------------------------------------------

    $directorio = dirname(
        $filePath
    );


    $temporal = @tempnam(
        $directorio,
        'img_opt_'
    );


    if (!$temporal) {

        imagedestroy(
            $image
        );

        return false;
    }


    $guardado = false;


    // --------------------------------------------------------
    // JPEG
    // --------------------------------------------------------

    if (
        $mime == 'image/jpeg' ||
        $mime == 'image/jpg'
    ) {

        if (
            function_exists(
                'imageinterlace'
            )
        ) {

            imageinterlace(
                $image,
                true
            );
        }


        $guardado = @imagejpeg(
            $image,
            $temporal,
            CALIDAD_JPEG
        );
    }


    // --------------------------------------------------------
    // PNG
    // --------------------------------------------------------

    else if ($mime == 'image/png') {

        $guardado = @imagepng(
            $image,
            $temporal,
            COMPRESION_PNG
        );
    }


    // --------------------------------------------------------
    // WEBP
    // --------------------------------------------------------

    else if (
        $mime == 'image/webp' &&
        function_exists('imagewebp')
    ) {

        $guardado = @imagewebp(
            $image,
            $temporal,
            CALIDAD_WEBP
        );
    }


    imagedestroy(
        $image
    );


    if (!$guardado) {

        @unlink($temporal);

        return false;
    }


    clearstatcache(
        true,
        $temporal
    );


    $pesoOptimizado = @filesize(
        $temporal
    );


    if (!$pesoOptimizado) {

        @unlink($temporal);

        return false;
    }


    // --------------------------------------------------------
    // SOLO USAR NUEVA VERSIÓN SI REALMENTE ES MENOR
    // --------------------------------------------------------

    if ($pesoOptimizado < $pesoOriginal) {

        if (
            reemplazarArchivoSeguro(
                $temporal,
                $filePath
            )
        ) {

            return true;
        }
    }


    @unlink(
        $temporal
    );


    return false;
}


// ============================================================
// CORREGIR ORIENTACIÓN EXIF
// ============================================================

function corregirOrientacionJPEG(
    $image,
    $filePath
) {

    if (!function_exists('exif_read_data')) {
        return $image;
    }


    $exif = @exif_read_data(
        $filePath
    );


    if (
        !$exif ||
        !isset($exif['Orientation'])
    ) {

        return $image;
    }


    $orientation = (int)$exif['Orientation'];


    switch ($orientation) {

        // 180 grados
        case 3:

            $rotada = @imagerotate(
                $image,
                180,
                0
            );

            break;


        // 90 grados clockwise
        case 6:

            $rotada = @imagerotate(
                $image,
                -90,
                0
            );

            break;


        // 90 grados counterclockwise
        case 8:

            $rotada = @imagerotate(
                $image,
                90,
                0
            );

            break;


        default:

            $rotada = false;

            break;
    }


    if ($rotada !== false) {

        imagedestroy(
            $image
        );

        return $rotada;
    }


    return $image;
}


// ============================================================
// CALCULAR NUEVA RESOLUCIÓN
// ============================================================

function calcularNuevoTamano(
    $ancho,
    $alto,
    $maxAncho,
    $maxAlto
) {

    $ancho = (int)$ancho;
    $alto = (int)$alto;


    /*
     * Nunca ampliamos imágenes pequeñas.
     */

    if (
        $ancho <= $maxAncho &&
        $alto <= $maxAlto
    ) {

        return array(
            $ancho,
            $alto
        );
    }


    $ratioAncho =
        $maxAncho /
        $ancho;


    $ratioAlto =
        $maxAlto /
        $alto;


    $ratio = min(
        $ratioAncho,
        $ratioAlto
    );


    return array(

        max(
            1,
            (int)round(
                $ancho * $ratio
            )
        ),

        max(
            1,
            (int)round(
                $alto * $ratio
            )
        )
    );
}


// ============================================================
// REEMPLAZAR ARCHIVO DE MANERA SEGURA
// ============================================================

function reemplazarArchivoSeguro(
    $temporal,
    $destino
) {

    if (
        !file_exists($temporal) ||
        !file_exists($destino)
    ) {

        return false;
    }


    /*
     * Intentar rename primero.
     *
     * Al encontrarse en la misma carpeta es una operación
     * muy rápida y segura.
     */

    if (@rename($temporal, $destino)) {

        @chmod(
            $destino,
            0644
        );

        return true;
    }


    /*
     * Fallback en caso de que el sistema no permita rename.
     */

    if (@copy($temporal, $destino)) {

        @unlink(
            $temporal
        );


        @chmod(
            $destino,
            0644
        );


        return true;
    }


    return false;
}


// ============================================================
// EXTENSIÓN DESDE MIME
// ============================================================

function obtenerExtensionImagen(
    $subtype
) {

    $subtype = strtolower(
        trim($subtype)
    );


    switch ($subtype) {

        case 'jpeg':
        case 'jpg':
        case 'pjpeg':
        case 'jfif':

            return 'jpg';


        case 'png':
        case 'x-png':

            return 'png';


        case 'gif':

            return 'gif';


        case 'webp':

            return 'webp';


        case 'bmp':

            return 'bmp';


        case 'heic':
        case 'heif':

            return $subtype;
    }


    return preg_replace(
        '/[^a-z0-9]/',
        '',
        $subtype
    );
}


// ============================================================
// GENERAR NOMBRE ÚNICO
// ============================================================

function generarNombreImagen(
    $extension
) {

    /*
     * uniqid(..., true) agrega un punto.
     * Lo quitamos para mantener nombres más limpios.
     */

    $id = uniqid(
        'mail_',
        true
    );


    $id = str_replace(
        '.',
        '',
        $id
    );


    return
        $id .
        '.' .
        $extension;
}


// ============================================================
// FORMATEAR BYTES
// ============================================================

function formatearBytes(
    $bytes
) {

    $bytes = (float)$bytes;


    if ($bytes >= 1073741824) {

        return round(
            $bytes / 1073741824,
            2
        ) . ' GB';
    }


    if ($bytes >= 1048576) {

        return round(
            $bytes / 1048576,
            2
        ) . ' MB';
    }


    if ($bytes >= 1024) {

        return round(
            $bytes / 1024,
            2
        ) . ' KB';
    }


    return round(
        $bytes,
        0
    ) . ' B';
}


// ============================================================
// CONFIGURACIÓN IMAP
// ============================================================

$servidor =
    '{10h.io:993/imap/ssl}INBOX';


$usuario =
    'galeria@seminuevosharo.mx';


/*
 * Coloca aquí tu contraseña real.
 *
 * Preferentemente muévela posteriormente a un archivo de
 * configuración que no esté versionado en Git.
 */
$contrasena =
    'T}jCTBD92RiH';


// ============================================================
// DIRECTORIO DESTINO
// ============================================================

/*
 * recividorEmail.php está en:
 *
 * /home/d4537/public_html/haro_page_git/admin/api/
 *
 * dirname(dirname(__DIR__)) devuelve:
 *
 * /home/d4537/public_html/haro_page_git
 *
 * Resultado:
 *
 * /home/d4537/public_html/haro_page_git/cat_autos_img/
 */

$directorioDestino =
    dirname(
        dirname(
            __DIR__
        )
    ) .
    '/cat_autos_img/';


// ============================================================
// EJECUTAR
// ============================================================

guardarImagenesDeCorreos(
    $servidor,
    $usuario,
    $contrasena,
    $directorioDestino
);
