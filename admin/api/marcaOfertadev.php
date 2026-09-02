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

    // Obtener dimensiones de la imagen receptora
    $anchoReceptora = imagesx($imgReceptora);
    $altoReceptora = imagesy($imgReceptora);

    // Obtener dimensiones de la imagen superpuesta
    $anchoSuperpuesta = imagesx($imgSuperpuesta);
    $altoSuperpuesta = imagesy($imgSuperpuesta);

    // Calcular las nuevas dimensiones de la imagen superpuesta como un octavo del tamaño de la imagen receptora
    $anchoSuperpuestaNuevo = $anchoReceptora / 5;
    $factorEscala = $anchoSuperpuestaNuevo / $anchoSuperpuesta;
    $altoSuperpuestaNuevo = $altoSuperpuesta * $factorEscala;

    // Crear una nueva imagen con las dimensiones calculadas para la imagen superpuesta
    $imgSuperpuestaEscalada = imagecreatetruecolor($anchoSuperpuestaNuevo, $altoSuperpuestaNuevo);
    imagealphablending($imgSuperpuestaEscalada, false);
    imagesavealpha($imgSuperpuestaEscalada, true);
    $transparente = imagecolorallocatealpha($imgSuperpuestaEscalada, 0, 0, 0, 127);
    imagefill($imgSuperpuestaEscalada, 0, 0, $transparente);
    imagecopyresampled($imgSuperpuestaEscalada, $imgSuperpuesta, 0, 0, 0, 0, $anchoSuperpuestaNuevo, $altoSuperpuestaNuevo, $anchoSuperpuesta, $altoSuperpuesta);

    // Rotar la imagen superpuesta 45 grados
    $imgSuperpuestaRotada = imagerotate($imgSuperpuestaEscalada, 0, $transparente);
    imagealphablending($imgSuperpuestaRotada, false);
    imagesavealpha($imgSuperpuestaRotada, true);

    // Obtener dimensiones de la imagen rotada
    $anchoSuperpuestaRotada = imagesx($imgSuperpuestaRotada);
    $altoSuperpuestaRotada = imagesy($imgSuperpuestaRotada);

    // Calcular posición para la esquina inferior izquierda
    $x = ($anchoReceptora - $anchoSuperpuestaRotada) -20;
    $y = ($altoReceptora - $altoSuperpuestaRotada)-20;

    // Superponer la imagen rotada en la esquina inferior izquierda con transparencia
    imagecopy($imgReceptora, $imgSuperpuestaRotada, $x, $y, 0, 0, $anchoSuperpuestaRotada, $altoSuperpuestaRotada);

    // Guardar la imagen resultante
    $resultado = imagepng($imgReceptora, $rutaSalida);
    if (!$resultado) {
        imagedestroy($imgReceptora);
        imagedestroy($imgSuperpuesta);
        imagedestroy($imgSuperpuestaEscalada);
        imagedestroy($imgSuperpuestaRotada);
        throw new Exception("No se pudo guardar la imagen resultante en $rutaSalida");
    }

    // Liberar memoria
    imagedestroy($imgReceptora);
    imagedestroy($imgSuperpuesta);
    imagedestroy($imgSuperpuestaEscalada);
    imagedestroy($imgSuperpuestaRotada);

    return true;
}

$raiz = $_SERVER['DOCUMENT_ROOT'];
$imagen = $raiz . '/logoO.png';
	
$rutaSalita = $raiz . '/admin/api/Imagenes/DEMO.png';
$imagenTrasa = $raiz . '/Imagenes/1565-IMG_0900.jpg';

superponerImagen($imagenTrasa, $imagen ,$rutaSalita);


?>