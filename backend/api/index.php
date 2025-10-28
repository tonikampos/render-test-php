<?php
// Headers y configuración inicial
require_once __DIR__ . '/../config/cors.php';
setupCORS();

require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../utils/Auth.php';

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener método HTTP y ruta
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Si viene por query string (cuando no hay mod_rewrite o .htaccess no funciona)
if (isset($_GET['resource'])) {
    $path = $_GET['resource'];
} else {
    // Remover query string y obtener ruta limpia
    $path = parse_url($uri, PHP_URL_PATH);
    
    // Remover todos los posibles prefijos
    $path = str_replace('/probatfm/backend/api/', '', $path);
    $path = str_replace('/backend/api/', '', $path);
    $path = str_replace('/api/', '', $path);
    $path = str_replace('/index.php', '', $path);
    $path = trim($path, '/');
}

// Dividir ruta en segmentos
$segments = explode('/', $path);
$resource = $segments[0] ?? '';

// Obtener ID: primero de los segmentos de URL, luego de query params
$id = $segments[1] ?? $_GET['id'] ?? null;
$action = $segments[2] ?? $_GET['action'] ?? null;

// Obtener body de la petición (para POST/PUT)
$input = json_decode(file_get_contents('php://input'), true) ?? [];

/**
 * ROUTING
 */

try {
    
    // ============================================
    // AUTENTICACIÓN
    // ============================================
    
    if ($resource === 'auth') {
        require_once __DIR__ . '/auth.php';
        handleAuthRoutes($method, $id, $input);
        exit();
    }
    
    // ============================================
    // USUARIOS
    // ============================================
    
    if ($resource === 'usuarios' || $resource === 'users') {
        require_once __DIR__ . '/usuarios.php';
        handleUsuariosRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // HABILIDADES
    // ============================================
    
    if ($resource === 'habilidades' || $resource === 'skills') {
        require_once __DIR__ . '/habilidades.php';
        handleHabilidadesRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // INTERCAMBIOS
    // ============================================
    
    if ($resource === 'intercambios' || $resource === 'exchanges') {
        require_once __DIR__ . '/intercambios.php';
        handleIntercambiosRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // CONVERSACIONES Y MENSAJES
    // ============================================
    
    if ($resource === 'conversaciones' || $resource === 'conversations') {
        require_once __DIR__ . '/conversaciones.php';
        handleConversacionesRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // VALORACIONES
    // ============================================
    
    if ($resource === 'valoraciones' || $resource === 'ratings') {
        require_once __DIR__ . '/valoraciones.php';
        handleValoracionesRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // NOTIFICACIONES
    // ============================================
    
    if ($resource === 'notificaciones' || $resource === 'notifications') {
        require_once __DIR__ . '/notificaciones.php';
        handleNotificacionesRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // REPORTES (Admin only)
    // ============================================
    
    if ($resource === 'reportes' || $resource === 'reports') {
        require_once __DIR__ . '/reportes.php';
        handleReportesRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // CATEGORÍAS
    // ============================================
    
    if ($resource === 'categorias' || $resource === 'categories') {
        require_once __DIR__ . '/categorias.php';
        handleCategoriasRoutes($method, $id, $action, $input);
        exit();
    }
    
    // ============================================
    // HEALTHCHECK
    // ============================================
    
    if ($resource === 'health' || $resource === 'ping') {
        Response::success([
            'status' => 'healthy',
            'timestamp' => date('Y-m-d H:i:s'),
            'database' => 'connected'
        ], 'API funcionando correctamente');
    }
    
    // ============================================
    // RUTA NO ENCONTRADA
    // ============================================
    
    Response::notFound("Ruta no encontrada: /$path");
    
} catch (Exception $e) {
    // Capturar cualquier error no manejado
    Response::serverError('Error interno del servidor', [
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}

