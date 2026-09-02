<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$_SESSION['sesionUsuario']['temporal'] = $_SESSION['sesionUsuario']['id'] ?? 0;
$_SESSION['sesionUsuario']['id'] = (int) ($_POST['id'] ?? 0);
$_SESSION['sesionUsuario']['permisos'] = (int) ($_POST['permiso'] ?? 0);
$_SESSION['sesionUsuario']['permiso_banca'] = (string) ($_POST['permiso_banca'] ?? '');

echo "1";
