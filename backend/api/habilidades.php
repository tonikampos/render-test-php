<?php
/**
 * Endpoints de Habilidades
 * GET /api/habilidades - Listar habilidades con filtros
 * GET /api/habilidades/:id - Obtener habilidad específica
 * POST /api/habilidades - Crear nueva habilidad
 * PUT /api/habilidades/:id - Actualizar habilidad
 * DELETE /api/habilidades/:id - Eliminar habilidad
 */

require_once __DIR__ . '/../config/database.php';

function handleHabilidadesRoutes($method, $id, $action, $input) {
    
    // GET /api/habilidades (listar con filtros)
    if ($method === 'GET' && !$id) {
        listarHabilidades();
    }
    
    // GET /api/habilidades/:id (obtener una)
    if ($method === 'GET' && $id) {
        obtenerHabilidad($id);
    }
    
    // POST /api/habilidades (crear)
    if ($method === 'POST') {
        Auth::requireAuth();
        crearHabilidad($input);
    }
    
    // PUT /api/habilidades/:id (actualizar)
    if ($method === 'PUT' && $id) {
        Auth::requireAuth();
        actualizarHabilidad($id, $input);
    }
    
    // DELETE /api/habilidades/:id (eliminar)
    if ($method === 'DELETE' && $id) {
        Auth::requireAuth();
        eliminarHabilidad($id);
    }
    
    Response::methodNotAllowed(['GET', 'POST', 'PUT', 'DELETE']);
}

/**
 * Listar habilidades con filtros
 */
function listarHabilidades() {
    try {
        $db = Database::getConnection();
        
        // Parámetros de filtrado
        $categoria = $_GET['categoria'] ?? null;
        $tipo = $_GET['tipo'] ?? null; // 'oferta' o 'demanda'
        $ubicacion = $_GET['ubicacion'] ?? null;
        $search = $_GET['search'] ?? null;
        $usuario_id = $_GET['usuario_id'] ?? null;
        
        // Paginación
        $page = max(1, intval($_GET['page'] ?? 1));
        $per_page = min(50, max(1, intval($_GET['per_page'] ?? 20)));
        $offset = ($page - 1) * $per_page;
        
        // Construcción de query
        $where = ["h.estado = 'activa'"];
        $params = [];
        
        if ($categoria) {
            $where[] = 'c.nombre = :categoria';
            $params['categoria'] = $categoria;
        }
        
        if ($tipo) {
            $where[] = 'h.tipo = :tipo';
            $params['tipo'] = $tipo;
        }
        
        if ($ubicacion) {
            $where[] = 'u.ubicacion ILIKE :ubicacion';
            $params['ubicacion'] = '%' . $ubicacion . '%';
        }
        
        if ($search) {
            $where[] = '(h.titulo ILIKE :search OR h.descripcion ILIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        
        if ($usuario_id) {
            $where[] = 'h.usuario_id = :usuario_id';
            $params['usuario_id'] = $usuario_id;
        }
        
        $whereClause = implode(' AND ', $where);
        
        // Contar total
        $countSql = "
            SELECT COUNT(*)
            FROM habilidades h
            INNER JOIN usuarios u ON h.usuario_id = u.id
            INNER JOIN categorias_habilidades c ON h.categoria_id = c.id
            WHERE $whereClause
        ";
        $stmt = $db->prepare($countSql);
        $stmt->execute($params);
        $total = $stmt->fetchColumn();
        
        // Obtener habilidades
        $sql = "
            SELECT 
                h.id, h.titulo, h.descripcion, h.tipo, h.duracion_estimada,
                h.fecha_publicacion, h.estado,
                c.nombre as categoria,
                u.id as usuario_id, u.nombre_usuario as usuario_nombre, 
                u.ubicacion as usuario_ubicacion, u.foto_url as usuario_foto
            FROM habilidades h
            INNER JOIN usuarios u ON h.usuario_id = u.id
            INNER JOIN categorias_habilidades c ON h.categoria_id = c.id
            WHERE $whereClause
            ORDER BY h.fecha_publicacion DESC
            LIMIT :limit OFFSET :offset
        ";
        
        $params['limit'] = $per_page;
        $params['offset'] = $offset;
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::paginated($habilidades, $total, $page, $per_page);
        
    } catch (Exception $e) {
        Response::serverError('Error al listar habilidades', $e->getMessage());
    }
}

/**
 * Obtener una habilidad específica
 */
function obtenerHabilidad($id) {
    try {
        $db = Database::getConnection();
        
        $sql = "
            SELECT 
                h.id, h.titulo, h.descripcion, h.tipo, h.duracion_estimada,
                h.fecha_publicacion, h.estado,
                c.id as categoria_id, c.nombre as categoria, c.icono as categoria_icono,
                u.id as usuario_id, u.nombre_usuario as usuario_nombre, 
                u.ubicacion as usuario_ubicacion, u.foto_url as usuario_foto,
                u.email as usuario_email
            FROM habilidades h
            INNER JOIN usuarios u ON h.usuario_id = u.id
            INNER JOIN categorias_habilidades c ON h.categoria_id = c.id
            WHERE h.id = :id
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $habilidad = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$habilidad) {
            Response::notFound('Habilidad no encontrada');
        }
        
        Response::success($habilidad);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener habilidad', $e->getMessage());
    }
}

/**
 * Crear nueva habilidad
 */
function crearHabilidad($data) {
    try {
        $db = Database::getConnection();
        
        // Validar datos requeridos
        $required = ['titulo', 'descripcion', 'tipo', 'categoria_id'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "El campo '$field' es obligatorio";
            }
        }
        
        if (!empty($errors)) {
            Response::validationError($errors);
        }
        
        // Validar tipo
        if (!in_array($data['tipo'], ['oferta', 'demanda'])) {
            Response::validationError(['tipo' => 'El tipo debe ser "oferta" o "demanda"']);
        }
        
        // Obtener usuario actual
        $user_id = $_SESSION['user_id'];
        
        // Crear habilidad
        $sql = "
            INSERT INTO habilidades 
            (usuario_id, categoria_id, titulo, descripcion, tipo, duracion_estimada)
            VALUES 
            (:usuario_id, :categoria_id, :titulo, :descripcion, :tipo, :duracion_estimada)
            RETURNING id, titulo, descripcion, tipo, fecha_publicacion
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'usuario_id' => $user_id,
            'categoria_id' => $data['categoria_id'],
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'tipo' => $data['tipo'],
            'duracion_estimada' => $data['duracion_estimada'] ?? null
        ]);
        
        $habilidad = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::created($habilidad, 'Habilidad creada exitosamente');
        
    } catch (Exception $e) {
        Response::serverError('Error al crear habilidad', $e->getMessage());
    }
}

/**
 * Actualizar habilidad
 */
function actualizarHabilidad($id, $data) {
    try {
        $db = Database::getConnection();
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
        
        // Verificar que la habilidad existe y pertenece al usuario (o es admin)
        $stmt = $db->prepare("SELECT usuario_id FROM habilidades WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $habilidad = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$habilidad) {
            Response::notFound('Habilidad no encontrada');
        }
        
        if ($habilidad['usuario_id'] != $user_id && $user_role !== 'admin') {
            Response::forbidden('No tienes permisos para editar esta habilidad');
        }
        
        // Construir UPDATE dinámico
        $fields = [];
        $params = ['id' => $id];
        
        $allowedFields = ['titulo', 'descripcion', 'tipo', 'categoria_id', 'duracion_estimada', 'estado'];
        
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
            UPDATE habilidades 
            SET " . implode(', ', $fields) . ", ultima_actualizacion = CURRENT_TIMESTAMP
            WHERE id = :id
            RETURNING id, titulo, descripcion, tipo, fecha_publicacion, estado
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $updated = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::success($updated, 'Habilidad actualizada exitosamente');
        
    } catch (Exception $e) {
        Response::serverError('Error al actualizar habilidad', $e->getMessage());
    }
}

/**
 * Eliminar habilidad (soft delete)
 */
function eliminarHabilidad($id) {
    try {
        $db = Database::getConnection();
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
        
        // Verificar permisos
        $stmt = $db->prepare("SELECT usuario_id FROM habilidades WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $habilidad = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$habilidad) {
            Response::notFound('Habilidad no encontrada');
        }
        
        if ($habilidad['usuario_id'] != $user_id && $user_role !== 'admin') {
            Response::forbidden('No tienes permisos para eliminar esta habilidad');
        }
        
        // Soft delete (marcar como inactiva)
        $stmt = $db->prepare("UPDATE habilidades SET estado = 'inactiva' WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        Response::deleted('Habilidad eliminada exitosamente');
        
    } catch (Exception $e) {
        Response::serverError('Error al eliminar habilidad', $e->getMessage());
    }
}
