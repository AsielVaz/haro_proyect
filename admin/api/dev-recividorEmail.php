<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once 'conectorBD.php';

function guardarImagenesDeCorreos($servidor, $usuario, $contrasena, $directorio = '/PruebasIMG/') {
    // Conectar al servidor IMAP
    $conector = new Conector();
    echo "Guardando en " . $directorio . "\n";
    $conexion = imap_open($servidor, $usuario, $contrasena);
    if (!$conexion) {
        die("Error al conectarse al servidor IMAP: " . imap_last_error());
    }

    // Buscar correos no leídos
    $emails = imap_search($conexion, 'UNSEEN');
    if (!$emails) {
        echo "No hay correos no leídos.\n";
        imap_close($conexion);
        return;
    }

    // Asegurarse de que el directorio existe
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
        echo "Directorio creado: $directorio\n";
    }

    foreach ($emails as $email_id) {
        $estructura = imap_fetchstructure($conexion, $email_id);
        if (isset($estructura->parts)) {
            procesarPartes($estructura->parts, $conexion, $email_id, $directorio, $conector);
        } else {
            echo "El correo no tiene partes MIME.\n";
        }
    }

    // Cerrar la conexión
    imap_close($conexion);
}

function optimizeImage($filePath, $quality = 75) {
    // Verificar si el archivo existe
    if (!file_exists($filePath)) {
        return "El archivo no existe.";
    }

    // Obtener la información del archivo
    $imageInfo = getimagesize($filePath);
    if ($imageInfo === false) {
        return "El archivo no es una imagen válida.";
    }

    // Determinar el tipo de imagen
    $mimeType = $imageInfo['mime'];
    $optimized = false;

    // Crear una copia de la imagen según su tipo
    switch ($mimeType) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($filePath);
            $optimized = imagejpeg($image, $filePath, $quality);
            break;
        case 'image/png':
            $image = imagecreatefrompng($filePath);
            // Ajustar calidad de PNG (0 = sin compresión, 9 = máxima compresión)
            $pngQuality = round($quality / 10); // Convertir 75 en 7, por ejemplo
            $optimized = imagepng($image, $filePath, $pngQuality);
            break;
        case 'image/gif':
            // Para GIF, solo reescribimos la imagen (sin pérdida de calidad)
            $image = imagecreatefromgif($filePath);
            $optimized = imagegif($image, $filePath);
            break;
        default:
            return "Tipo de imagen no soportado: $mimeType.";
    }

    // Liberar memoria
    if (isset($image)) {
        imagedestroy($image);
    }

    // Retornar el resultado
    if ($optimized) {
        return "Imagen optimizada correctamente.";
    } else {
        return "Error al optimizar la imagen.";
    }
}

function procesarPartes($partes, $conexion, $email_id, $directorio, $conector, $prefix = '') {
    foreach ($partes as $index => $parte) {
        $partNumber = $prefix ? $prefix . '.' . ($index + 1) : (string)($index + 1);

        // Verificar si es una imagen
        if (isset($parte->type) && $parte->type == 5) { // 5 = Tipo MIME "image"
            $datos = imap_fetchbody($conexion, $email_id, $partNumber);
            if (isset($parte->encoding)) {
                switch ($parte->encoding) {
                    case 3: // BASE64
                        $datos = base64_decode($datos);
                        break;
                    case 4: // QUOTED-PRINTABLE
                        $datos = quoted_printable_decode($datos);
                        break;
                }
            }

            // Guardar la imagen
            $extension = isset($parte->subtype) ? strtolower($parte->subtype) : 'jpg';
            $nombreRandom = uniqid() . '.' . $extension;
            $rutaArchivo = $directorio . $nombreRandom;
            file_put_contents($rutaArchivo, $datos);
            echo "Imagen guardada: $rutaArchivo\n";
            // Comprimir archivo 
            optimizeImage($rutaArchivo,80);
            // Insertar en la base de datos
            $rutaLimpia = str_replace("/var/www/seminuevosha_usr/data/www/seminuevosharo.mx", "", $rutaArchivo);
            $conector->ejecutar("INSERT INTO `imagen`(`id_auto`, `url`) VALUES ('0','$rutaLimpia')");
        }

        // Verificar si tiene subpartes (ej., multipart/mixed)
        if (isset($parte->parts)) {
            procesarPartes($parte->parts, $conexion, $email_id, $directorio, $conector, $partNumber);
        }
    }
}


// $servidor = '{seminuevosharo.mx:993/imap/ssl}INBOX';
// $usuario = 'galeria@seminuevosharo.mx';
// $contrasena = 'T}jCTBD92RiH';
// $directorioDestino =  '/var/www/seminuevosha_usr/data/www/seminuevosharo.mx/dev_cat_autos_img/';


$servidor = '{seminuevosharo.mx:993/imap/ssl}INBOX';
$usuario = 'galeria@seminuevosharo.mx';
$contrasena = 'T}jCTBD92RiH';
$directorioDestino =  '/var/www/seminuevosha_usr/data/www/seminuevosharo.mx/cat_autos_img/';

guardarImagenesDeCorreos($servidor, $usuario, $contrasena, $directorioDestino);