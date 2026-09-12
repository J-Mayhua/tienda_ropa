<?php

function guardar_imagen_subida(array $archivo, string $directorio): string
{
    $tamanioMaximo = 5 * 1024 * 1024;
    $tiposPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    if (
        ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK ||
        !isset($archivo['tmp_name'], $archivo['size']) ||
        !is_uploaded_file($archivo['tmp_name']) ||
        $archivo['size'] > $tamanioMaximo
    ) {
        throw new RuntimeException('El archivo no es válido o supera el tamaño máximo permitido.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($archivo['tmp_name']);
    if (!isset($tiposPermitidos[$mime])) {
        throw new RuntimeException('El tipo de imagen no está permitido.');
    }

    if (!is_dir($directorio) && !mkdir($directorio, 0755, true) && !is_dir($directorio)) {
        throw new RuntimeException('No se pudo preparar el directorio de almacenamiento.');
    }

    $nombre = bin2hex(random_bytes(16)) . '.' . $tiposPermitidos[$mime];
    $ruta = rtrim($directorio, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $nombre;
    if (!move_uploaded_file($archivo['tmp_name'], $ruta)) {
        throw new RuntimeException('No se pudo guardar la imagen.');
    }

    return $nombre;
}
