<?php
// Router simple para servidor PHP integrado
error_log("==> Petición recibida: " . $_SERVER['REQUEST_URI']);
error_log("==> Método: " . $_SERVER['REQUEST_METHOD']);

// Si es el index, cargar index.php
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') {
    require_once __DIR__ . '/index.php';
    exit;
}

// Para otros archivos, dejar que PHP los sirva
return false;
