<?php
/**
 * API Router Principal (Versión Definitiva Compatible con Proxy)
 */

// 1. Cargar e executar a configuración de CORS e Cookies
require_once __DIR__ . '/backend/config/cors.php';
setupCORS();

// 2. Iniciar a sesión xusto despois da configuración
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Cargar as utilidades esenciais
require_once __DIR__ . '/backend/utils/Response.php';
require_once __DIR__ . '/backend/utils/Auth.php';

// --- LÓXICA DE ENRUTAMENTO CORRIXIDA ---
// Esta lóxica agora entende as rutas que veñen do proxy de Render.
$resource = $_GET['resource'] ?? null;
if (empty($resource)) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $resource = ltrim($path, '/');
}

$segments = explode('/', $resource);
$main_resource = $segments[0] ?? '';
$id = $segments[1] ?? null;
$action = $segments[2] ?? null;

$input = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    // O switch queda exactamente igual
    switch ($main_resource) {
        case 'auth': require_once __DIR__ . '/backend/api/auth.php'; handleAuthRoutes($_SERVER['REQUEST_METHOD'], $id, $input); break;
        case 'usuarios': require_once __DIR__ . '/backend/api/usuarios.php'; handleUsuariosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'habilidades': require_once __DIR__ . '/backend/api/habilidades.php'; handleHabilidadesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'intercambios': require_once __DIR__ . '/backend/api/intercambios.php'; handleIntercambiosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'conversaciones': require_once __DIR__ . '/backend/api/conversaciones.php'; handleConversacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'valoraciones': require_once __DIR__ . '/backend/api/valoraciones.php'; handleValoracionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'notificaciones': require_once __DIR__ . '/backend/api/notificaciones.php'; handleNotificacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'reportes': require_once __DIR__ . '/backend/api/reportes.php'; handleReportesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'categorias': require_once __DIR__ . '/backend/api/categorias.php'; handleCategoriasRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input); break;
        case 'health': Response::success(['status' => 'healthy']); break;
        default: Response::notFound("Ruta non atopada: /$resource");
    }
} catch (Exception $e) {
    Response::serverError('Erro interno do servidor', ['error' => $e->getMessage()]);
}