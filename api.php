<?php
/**
 * API Router Principal (Versión Definitiva e Corrixida)
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

// Primeiro, tentamos obter a ruta do parámetro GET (para probas)
$resource = $_GET['resource'] ?? null;

if (empty($resource)) {
    // Se non existe, obtemos a ruta do camiño da URL (para o proxy de Render)
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // Eliminamos o prefixo /api/ que engade o proxy
    if (strpos($path, '/api/') === 0) {
        $resource = substr($path, strlen('/api/'));
    } else {
        $resource = ltrim($path, '/');
    }
}

$segments = explode('/', $resource);
$main_resource = $segments[0] ?? '';
$id = $segments[1] ?? null;
$action = $segments[2] ?? null;

$input = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    // O resto do switch queda exactamente igual que antes
    switch ($main_resource) {
        case 'auth':
            require_once __DIR__ . '/backend/api/auth.php';
            handleAuthRoutes($_SERVER['REQUEST_METHOD'], $id, $input);
            break;
        // ... (todos os teus outros cases) ...
        case 'usuarios':
        case 'users':
            require_once __DIR__ . '/backend/api/usuarios.php';
            handleUsuariosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'habilidades':
        case 'skills':
            require_once __DIR__ . '/backend/api/habilidades.php';
            handleHabilidadesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'intercambios':
        case 'exchanges':
            require_once __DIR__ . '/backend/api/intercambios.php';
            handleIntercambiosRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'conversaciones':
        case 'conversations':
            require_once __DIR__ . '/backend/api/conversaciones.php';
            handleConversacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'valoraciones':
        case 'ratings':
            require_once __DIR__ . '/backend/api/valoraciones.php';
            handleValoracionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'notificaciones':
        case 'notifications':
            require_once __DIR__ . '/backend/api/notificaciones.php';
            handleNotificacionesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'reportes':
        case 'reports':
            require_once __DIR__ . '/backend/api/reportes.php';
            handleReportesRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'categorias':
        case 'categories':
            require_once __DIR__ . '/backend/api/categorias.php';
            handleCategoriasRoutes($_SERVER['REQUEST_METHOD'], $id, $action, $input);
            break;
        case 'health':
            Response::success(['status' => 'healthy', 'timestamp' => date('Y-m-d H:i:s')]);
            break;
        default:
            Response::notFound("Ruta non atopada: /$resource");
    }
} catch (Exception $e) {
    Response::serverError('Erro interno do servidor', ['error' => $e->getMessage()]);
}