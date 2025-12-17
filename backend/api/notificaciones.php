<?php
/**
 * Endpoints de Notificaciones
 * GET    /api/notificaciones                   - Listar mis notificaciones
 * PUT    /api/notificaciones/:id/leida        - Marcar una notificación como leída
 * PUT    /api/notificaciones/marcar-todas-leidas  - Marcar todas como leídas
 */

require_once __DIR__ . '/../config/database.php';

function handleNotificacionesRoutes($method, $id, $action, $input) {
    
    // GET /api/notificaciones (listar)
    if ($method === 'GET' && is_null($id)) {
        Auth::requireAuth();
        listarNotificaciones();
    }
    
    // GET /api/notificaciones/no-leidas (contar no leídas)
    if ($method === 'GET' && $id === 'no-leidas') {
        Auth::requireAuth();
        contarNoLeidas();
    }
    
    // PUT /api/notificaciones/:id/leida (marcar una como leída)
    if ($method === 'PUT' && is_numeric($id) && $action === 'leida') {
        Auth::requireAuth();
        marcarComoLeida($id);
    }

    // PUT /api/notificaciones/marcar-todas-leidas (marcar todas como leídas)
    if ($method === 'PUT' && $id === 'marcar-todas-leidas') {
        Auth::requireAuth();
        marcarTodasComoLeidas();
    }
    
    Response::methodNotAllowed(['GET', 'PUT']);
}

/**
 * Listar las notificaciones del usuario con sesión iniciada
 */
function listarNotificaciones() {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Filtro opcional por estado (leida=true, leida=false)
        $leida = $_GET['leida'] ?? null;
        
        $sql = "SELECT * FROM notificaciones WHERE usuario_id = :usuario_id";
        $params = ['usuario_id' => $usuario_id];
        
        if ($leida !== null) {
            $sql .= " AND leida = :leida";
            $params['leida'] = filter_var($leida, FILTER_VALIDATE_BOOLEAN);
        }
        
        $sql .= " ORDER BY fecha_creacion DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($notificaciones);
        
    } catch (Exception $e) {
        Response::serverError('Error al listar las notificaciones', $e->getMessage());
    }
}

/**
 * Contar notificaciones no leídas del usuario
 */
function contarNoLeidas() {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        $stmt = $db->prepare("
            SELECT COUNT(*) as total 
            FROM notificaciones 
            WHERE usuario_id = :usuario_id AND leida = false
        ");
        $stmt->execute(['usuario_id' => $usuario_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::success(['count' => (int) $result['total']]);
        
    } catch (Exception $e) {
        Response::serverError('Error al contar notificaciones no leídas', $e->getMessage());
    }
}

/**
 * Marcar una notificación específica como leída
 */
function marcarComoLeida($id) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        $sql = "
            UPDATE notificaciones
            SET leida = true, fecha_lectura = NOW()
            WHERE id = :id AND usuario_id = :usuario_id
            RETURNING *
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id, 'usuario_id' => $usuario_id]);
        
        if ($stmt->rowCount() === 0) {
            Response::notFound('No se encontró la notificación o no te pertenece');
        }
        
        $notificacion = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::success($notificacion, 'Notificación marcada como leída');
        
    } catch (Exception $e) {
        Response::serverError('Error al marcar la notificación como leída', $e->getMessage());
    }
}

/**
 * Marcar todas las notificaciones del usuario como leídas
 */
function marcarTodasComoLeidas() {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];

        $sql = "
            UPDATE notificaciones
            SET leida = true, fecha_lectura = NOW()
            WHERE usuario_id = :usuario_id AND leida = false
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);

        $count = $stmt->rowCount();

        Response::success(['notificaciones_marcadas' => $count], 'Todas as notificacións foron marcadas como lidas');

    } catch (Exception $e) {
        Response::serverError('Erro ao marcar todas as notificacións como lidas', $e->getMessage());
    }
}