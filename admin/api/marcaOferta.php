<?php

function superponerImagen($rutaReceptora, $rutaSuperpuesta, $rutaSalida) {
    // Cargar la imagen receptora
    $imgReceptora = imagecreatefromstring(file_get_contents($rutaReceptora));
    if (!$imgReceptora) {
        throw new Exception("No se pudo cargar la imagen receptora desde $rutaReceptora");
    }

    // Cargar la imagen superpuesta
    $imgSuperpuesta = imagecreatefromstring(file_get_contents($rutaSuperpuesta));
    if (!$imgSuperpuesta) {
        imagedestroy($imgReceptora);
        throw new Exception("No se pudo cargar la imagen superpuesta desde $rutaSuperpuesta");
    }

    // Obtener dimensiones de las imágenes
    $anchoReceptora = imagesx($imgReceptora);
    $altoReceptora = imagesy($imgReceptora);
    $anchoSuperpuesta = imagesx($imgSuperpuesta);
    $altoSuperpuesta = imagesy($imgSuperpuesta);

    // Calcular posiciones para centrar la imagen superpuesta
    $x = 0;
    $y = 0;
    echo $y;

    // Superponer la imagen superpuesta sobre la receptora
    imagecopy($imgReceptora, $imgSuperpuesta, $x, $y, 0, 0, $anchoSuperpuesta, $altoSuperpuesta);

    // Guardar la imagen resultante
    $resultado = imagepng($imgReceptora, $rutaSalida);
    if (!$resultado) {
        imagedestroy($imgReceptora);
        imagedestroy($imgSuperpuesta);
        throw new Exception("No se pudo guardar la imagen resultante en $rutaSalida");
    }

    // Liberar memoria
    imagedestroy($imgReceptora);
    imagedestroy($imgSuperpuesta);

    return true;
}


?>