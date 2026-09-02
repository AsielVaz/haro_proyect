<?php
function encriptar($cadena) {
    $clave = "Encr10h-.$=2023SecretoMuajaaja";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encriptado = openssl_encrypt($cadena, 'aes-256-cbc', $clave, 0, $iv);
    return base64_encode($iv . $encriptado);
}

function desencriptar($cadenaEncriptada) {
    $clave = "Encr10h-.$=2023SecretoMuajaaja";
    $cadenaEncriptada = base64_decode($cadenaEncriptada);
    $iv = substr($cadenaEncriptada, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encriptado = substr($cadenaEncriptada, openssl_cipher_iv_length('aes-256-cbc'));
    return openssl_decrypt($encriptado, 'aes-256-cbc', $clave, 0, $iv);
}

