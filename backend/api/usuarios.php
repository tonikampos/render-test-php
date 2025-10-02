<?php
/**
 * Endpoints de Usuarios
 * GET /api/usuarios - Listar usuarios
 * GET /api/usuarios/:id - Ver perfil de usuario
 * GET /api/usuarios/:id/estadisticas - Estadísticas del usuario
 * PUT /api/usuarios/:id - Actualizar perfil
 * GET /api/usuarios/:id/habilidades - Habilidades del usuario
 */

require_once __DIR__ . '/../config/database.php';

function handleUsuariosRoutes($method, $id, $action, $input) {
    
    // GET /api/usuarios (listar)
    if ($method === 'GET' && !$id) {
        listarUsuarios();
    }
    
    // GET /api/usuarios/:id (perfil)
    if ($method === 'GET' && $id && !$action) {
        obtenerUsuario($id);
    }
    
    // GET /api/usuarios/:id/estadisticas
    if ($method === 'GET' && $id && $action === 'estadisticas') {
        obtenerEstadisticasUsuario($id);
    }
    
    // GET /api/usuarios/:id/habilidades
    if ($method === 'GET' && $id && $action === 'habilidades') {
        obtenerHabilidadesUsuario($id);
    }
    
    // PUT /api/usuarios/:id (actualizar)
    if ($method === 'PUT' && $id) {
        Auth::requireAuth();
        actualizarUsuario($id, $input);
    }
    
    Response::methodNotAllowed(['GET', 'PUT']);
}

/**
 * Listar usuarios
 */
function listarUsuarios() {
    try {
        $db = Database::getConnection();
        
        // Filtros
        $ubicacion = $_GET['ubicacion'] ?? null;
        $search = $_GET['search'] ?? null;
        
        // Paginación
        $page = max(1, intval($_GET['page'] ?? 1));
        $per_page = min(50, max(1, intval($_GET['per_page'] ?? 20)));
        $offset = ($page - 1) * $per_page;
        
        // Construcción de query
        $where = ['activo = true'];
        $params = [];
        
        if ($ubicacion) {
            $where[] = 'ubicacion ILIKE :ubicacion';
            $params['ubicacion'] = '%' . $ubicacion . '%';
        }
        
        if ($search) {
            $where[] = '(nombre_usuario ILIKE :search OR biografia ILIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        // Contar total
        $countSql = "SELECT COUNT(*) FROM usuarios WHERE $whereClause";
        $stmt = $db->prepare($countSql);
        $stmt->execute($params);
        $total = $stmt->fetchColumn();
        
        // Obtener usuarios
        $sql = "
            SELECT 
                id, nombre_usuario, ubicacion, biografia, foto_url,
                fecha_registro, ultima_conexion
            FROM usuarios
            WHERE $whereClause
            ORDER BY ultima_conexion DESC NULLS LAST
            LIMIT :limit OFFSET :offset
        ";
        
        $params['limit'] = $per_page;
        $params['offset'] = $offset;
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::paginated($usuarios, $total, $page, $per_page);
        
    } catch (Exception $e) {
        Response::serverError('Error al listar usuarios', $e->getMessage());
    }
}

/**
 * Obtener perfil de usuario
 */
function obtenerUsuario($id) {
    try {
        $db = Database::getConnection();
        
        $sql = "
            SELECT 
                id, nombre_usuario, email, ubicacion, biografia,
                foto_url, activo, fecha_registro, ultima_conexion
            FROM usuarios
            WHERE id = :id AND activo = true
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            Response::notFound('Usuario no encontrado');
        }
        
        // Si no es el mismo usuario o admin, ocultar email
        $is_same_user = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;
        $is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador';
        
        if (!$is_same_user && !$is_admin) {
            unset($usuario['email']);
        }
        
        Response::success($usuario);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener usuario', $e->getMessage());
    }
}

/**
 * Obtener estadísticas de un usuario
 */
function obtenerEstadisticasUsuario($id) {
    try {
        $db = Database::getConnection();
        
        // Usar la vista estadisticas_usuarios
        $sql = "SELECT * FROM estadisticas_usuarios WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$stats) {
            // Usuario existe pero no tiene estadísticas aún
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE id = :id AND activo = true");
            $stmt->execute(['id' => $id]);
            
            if (!$stmt->fetch()) {
                Response::notFound('Usuario no encontrado');
            }
            
            // Devolver estadísticas vacías
            $stats = [
                'id' => $id,
                'total_habilidades' => 0,
                'ofertas_activas' => 0,
                'demandas_activas' => 0,
                'total_intercambios' => 0,
                'intercambios_completados' => 0,
                'valoracion_promedio' => 0,
                'total_valoraciones' => 0
            ];
        }
        
        Response::success($stats);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener estadísticas', $e->getMessage());
    }
}

/**
 * Obtener habilidades de un usuario
 */
function obtenerHabilidadesUsuario($id) {
    try {
        $db = Database::getConnection();
        
        $sql = "
            SELECT 
                h.id, h.titulo, h.descripcion, h.tipo, h.duracion_estimada,
                h.fecha_publicacion, h.estado,
                c.nombre as categoria, c.icono as categoria_icono
            FROM habilidades h
            INNER JOIN categorias_habilidades c ON h.categoria_id = c.id
            WHERE h.usuario_id = :usuario_id AND h.estado = 'activa'
            ORDER BY h.fecha_publicacion DESC
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['usuario_id' => $id]);
        $habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($habilidades);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener habilidades del usuario', $e->getMessage());
    }
}

/**
 * Actualizar perfil de usuario
 */
function actualizarUsuario($id, $data) {
    try {
        $db = Database::getConnection();
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
        
        // Verificar permisos (solo el mismo usuario o admin)
        if ($user_id != $id && $user_role !== 'admin') {
            Response::forbidden('No tienes permisos para editar este usuario');
        }
        
        // Verificar que el usuario existe
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if (!$stmt->fetch()) {
            Response::notFound('Usuario no encontrado');
        }
        
        // Construir UPDATE dinámico
        $fields = [];
        $params = ['id' => $id];
        
        $allowedFields = ['nombre_usuario', 'ubicacion', 'biografia', 'foto_url'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            Response::error('No hay campos para actualizar');
        }
        
        $sql = "
            UPDATE usuarios 
            SET " . implode(', ', $fields) . "
            WHERE id = :id
            RETURNING id, nombre_usuario, email, ubicacion, biografia, foto_url
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $updated = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::success($updated, 'Perfil actualizado exitosamente');
        
    } catch (Exception $e) {
        Response::serverError('Error al actualizar usuario', $e->getMessage());
    }
}
