<?php
/**
 * MODO DE DIAGNÓSTICO ESTRICTO - CAJA NEGRA
 */

// Forza a que CUALQUERA erro se amose na resposta, evitando que sexa silencioso.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para enviar unha mensaxe de depuración e parar a execución.
function debug_response($step, $details = "") {
    http_response_code(200); // Enviamos 200 para que o navegador non bloquee a resposta.
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'diagnostic_step' => $step,
        'details' => $details,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    // Non paramos a execución para ver ata onde chega.
}

debug_response("Paso 1: Execución de api.php iniciada.");

try {
    debug_response("Paso 2: Intentando cargar cors.php.");
    require_once __DIR__ . '/backend/config/cors.php';
    setupCORS();
    debug_response("Paso 3: cors.php cargado e executado.");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        debug_response("Paso 4: Sesión iniciada.");
    }

    debug_response("Paso 5: Intentando cargar utilidades.");
    require_once __DIR__ . '/backend/utils/Response.php';
    require_once __DIR__ . '/backend/utils/Auth.php';
    debug_response("Paso 6: Utilidades cargadas.");

    // O resto do teu código de enrutamento orixinal...
    // ... (o teu switch completo con todos os cases)
    $resource = $_GET['resource'] ?? '';
    debug_response("Paso 7: Recurso solicitado: '$resource'");

    $segments = explode('/', $resource);
    $main_resource = $segments[0] ?? '';
    $id = $segments[1] ?? null;
    $action = $segments[2] ?? null;
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    debug_response("Paso 8: Entrando no enrutador para: '$main_resource'");

    switch ($main_resource) {
        case 'auth':
            require_once __DIR__ . '/backend/api/auth.php';
            handleAuthRoutes($_SERVER['REQUEST_METHOD'], $id, $input);
            break;
        // ... (o resto de cases)
        default:
            Response::notFound("Ruta non atopada: /$resource");
    }

} catch (Throwable $e) {
    // Se algo falla en calquera punto, esta "caixa negra" rexistrarao.
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'FATAL_ERROR' => true,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
    exit();
}