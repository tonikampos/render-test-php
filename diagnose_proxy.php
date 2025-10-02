<?php
// Proxy para ejecutar diagnose.php desde la raíz
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Cambiar al directorio backend para que las rutas relativas funcionen
    chdir(__DIR__ . '/backend');
    
    // Incluir y ejecutar diagnose
    ob_start();
    include __DIR__ . '/backend/diagnose.php';
    $output = ob_get_clean();
    
    echo $output;
    
} catch (Throwable $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
