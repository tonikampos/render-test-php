<?php
/**
 * Endpoints de Notificacións
 * GET    /api/notificaciones                  - Listar as miñas notificacións
 * PUT    /api/notificaciones/:id/leida        - Marcar unha notificación como lida
 * PUT    /api/notificaciones/marcar-todas-leidas - Marcar todas como lidas
 */

require_once __DIR__ . '/../config/database.php';

function handleNotificacionesRoutes($method, $id, $action, $input) {
    
    // GET /api/notificaciones (listar)
    if ($method === 'GET' && is_null($id)) {
        Auth::requireAuth();
        listarNotificaciones();
    }
    
    // PUT /api/notificaciones/:id/leida (marcar unha como lida)
    if ($method === 'PUT' && is_numeric($id) && $action === 'leida') {
        Auth::requireAuth();
        marcarComoLeida($id);
    }

    // PUT /api/notificaciones/marcar-todas-leidas (marcar todas como lidas)
    if ($method === 'PUT' && $id === 'marcar-todas-leidas') {
        Auth::requireAuth();
        marcarTodasComoLeidas();
    }
    
    Response::methodNotAllowed(['GET', 'PUT']);
}

/**
 * Listar as notificacións do usuario con sesión iniciada
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
        Response::serverError('Erro ao listar as notificacións', $e->getMessage());
    }
}

/**
 * Marcar unha notificación específica como lida
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
            Response::notFound('Non se atopou a notificación ou non che pertence');
        }
        
        $notificacion = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::success($notificacion, 'Notificación marcada como lida');
        
    } catch (Exception $e) {
        Response::serverError('Erro ao marcar a notificación como lida', $e->getMessage());
    }
}

/**
 * Marcar todas as notificacións do usuario como lidas
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