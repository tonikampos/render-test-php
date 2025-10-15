<?php
/**
 * API Router Principal (VERSIÓN DE DIAGNÓSTICO)
 */

// LOG 1: O script comezou a executarse.
error_log("--- CAIXA NEGRA: api.php INICIADO ---");

// Cargamos a configuración de CORS e Cookies
require_once __DIR__ . '/backend/config/cors.php';
setupCORS();

// LOG 2: CORS configurado.
error_log("--- CAIXA NEGRA: CORS configurado ---");

// Iniciamos a sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// LOG 3: Sesión iniciada.
error_log("--- CAIXA NEGRA: Sesión iniciada ---");

// Cargamos as utilidades
require_once __DIR__ . '/backend/utils/Response.php';
require_once __DIR__ . '/backend/utils/Auth.php';

// LOG 4: Utilidades cargadas.
error_log("--- CAIXA NEGRA: Utilidades cargadas ---");

// Obtemos a ruta
$resource = $_GET['resource'] ?? null;
if (empty($resource)) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (strpos($path, '/api/') === 0) {
        $resource = substr($path, strlen('/api/'));
    } else {
        $resource = ltrim($path, '/');
    }
}

// LOG 5: A ruta solicitada é: "$resource"
error_log("--- CAIXA NEGRA: Ruta solicitada -> " . $resource);

$segments = explode('/', $resource);
$main_resource = $segments[0] ?? '';

// LOG 6: O recurso principal é: "$main_resource"
error_log("--- CAIXA NEGRA: Recurso principal -> " . $main_resource);

$id = $segments[1] ?? null;
$action = $segments[2] ?? null;
$input = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    error_log("--- CAIXA NEGRA: Entrando no switch para o recurso: " . $main_resource);

    switch ($main_resource) {
        case 'auth':
            require_once __DIR__ . '/backend/api/auth.php';
            handleAuthRoutes($_SERVER['REQUEST_METHOD'], $id, $input);
            break;
        // ... (o resto dos teus cases) ...
        case 'usuarios': require_once __DIR__ . '/backend/api/usuarios.php'; handleUsuariosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'habilidades': require_once __DIR__ . '/backend/api/habilidades.php'; handleHabilidadesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'intercambios': require_once __DIR__ . '/backend/api/intercambios.php'; handleIntercambiosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'conversaciones': require_once __DIR__ . '/backend/api/conversaciones.php'; handleConversacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'valoraciones': require_once __DIR__ . '/backend/api/valoraciones.php'; handleValoracionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'notificaciones': require_once __DIR__ . '/backend/api/notificaciones.php'; handleNotificacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'reportes': require_once __DIR__ . '/backend/api/reportes.php'; handleReportesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'categorias': require_once __DIR__ . '/backend/api/categorias.php'; handleCategoriasRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'health': Response::success(['status' => 'healthy']); break;
        default:
            error_log("--- CAIXA NEGRA: RUTA NON ATOPADA -> " . $resource);
            Response::notFound("Ruta non atopada: /$resource");
    }

    error_log("--- CAIXA NEGRA: Script rematado con éxito para: " . $resource);

} catch (Exception $e) {
    error_log("--- CAIXA NEGRA: EXCEPCIÓN CAPTURADA -> " . $e->getMessage());
    Response::serverError('Erro interno do servidor', ['error' => $e->getMessage()]);
}