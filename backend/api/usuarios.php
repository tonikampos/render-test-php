<?php
/**
 * Endpoints de Usuarios
 * GET /api/usuarios - Listar usuarios (ADMINISTRADOR ONLY)
 * GET /api/usuarios/:id - Ver perfil de usuario
 * GET /api/usuarios/:id/estadisticas - Estadísticas del usuario
 * PUT /api/usuarios/:id - Actualizar perfil
 * GET /api/usuarios/:id/habilidades - Habilidades del usuario
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/Auth.php'; // Asegúrate de que Auth está incluído
require_once __DIR__ . '/../utils/Response.php'; // Incluir Response

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
     // GET /api/usuarios/:id/valoraciones
    if ($method === 'GET' && $id && $action === 'valoraciones') {
        obtenerValoracionesUsuario($id);
    }

    // PUT /api/usuarios/:id (actualizar)
    if ($method === 'PUT' && $id) {
        Auth::requireAuth(); // Require estar logueado
        actualizarUsuario($id, $input);
    }

    // Si no coincide ninguna ruta, método no permitido
    Response::methodNotAllowed(['GET', 'PUT']);
}

/**
 * Listar usuarios (Sólo administradores)
 */
function listarUsuarios() {
    // ===== CAMBIO AQUÍ =====
Auth::requireAdmin();    // =======================

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
        $where = [];
        $params = [];

        if ($ubicacion) {
            $where[] = 'ubicacion ILIKE :ubicacion';
            $params['ubicacion'] = '%' . $ubicacion . '%';
        }

        if ($search) {
            $where[] = '(nombre_usuario ILIKE :search OR email ILIKE :search)';
            $params['search'] = '%' . $search . '%';
        }

        if (isset($_GET['activo'])) {
             $activoParam = filter_var($_GET['activo'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
             if ($activoParam !== null) {
                 $where[] = 'activo = :activo';
                 $params['activo'] = $activoParam;
             }
        }


        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Contar total
        $countSql = "SELECT COUNT(*) FROM usuarios $whereClause";
        $stmt = $db->prepare($countSql);
        $stmt->execute($params);
        $total = $stmt->fetchColumn();

        // Obtener usuarios
        $sql = "
            SELECT
                id, nombre_usuario, email, ubicacion, biografia, foto_url,
                activo, rol, fecha_registro, ultima_conexion
            FROM usuarios
            $whereClause
            ORDER BY fecha_registro DESC
            LIMIT :limit OFFSET :offset
        ";

        $params['limit'] = (int)$per_page;
        $params['offset'] = (int)$offset;

        $stmt = $db->prepare($sql);

        // Bind de parámetros
        foreach ($params as $key => &$val) {
             if ($key === 'limit' || $key === 'offset') {
                $stmt->bindParam(":$key", $val, PDO::PARAM_INT);
            } else {
                 $stmt->bindParam(":$key", $val);
             }
        }
        unset($val);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Response::paginated($usuarios, $total, $page, $per_page);

    } catch (Exception $e) {
        Response::serverError('Error al listar usuarios', $e->getMessage());
    }
}

/**
 * Obtener perfil de usuario público (o completo si es admin/propio)
 */
function obtenerUsuario($id) {
    try {
        $db = Database::getConnection();

        $sql = "
            SELECT
                id, nombre_usuario, email, ubicacion, biografia,
                foto_url, activo, rol, fecha_registro, ultima_conexion
            FROM usuarios
            WHERE id = :id
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            Response::notFound('Usuario no encontrado');
        }

        // Verificar si el usuario que hace la petición es el mismo o es admin
        $is_same_user = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;
        // ===== CAMBIO AQUÍ =====
        $is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador';
        // =======================

        // Si el usuario está inactivo y NO es admin, devolvemos 404
        if ($usuario['activo'] == false && !$is_admin) {
             Response::notFound('Usuario no encontrado');
        }

        // Si NO es el mismo usuario NI admin, ocultar datos sensibles
        if (!$is_same_user && !$is_admin) {
            unset($usuario['email']);
            unset($usuario['activo']);
            unset($usuario['rol']);
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

        $stmtUser = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id]);
        if (!$stmtUser->fetch()) {
             Response::notFound('Usuario no encontrado');
        }

        $sql = "SELECT * FROM estadisticas_usuarios WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$stats) {
            $stats = [
                'id' => $id, 'total_habilidades' => 0, 'ofertas_activas' => 0,
                'demandas_activas' => 0, 'total_intercambios' => 0, 'intercambios_completados' => 0,
                'valoracion_promedio' => null, 'total_valoraciones' => 0
            ];
        } else {
             if ($stats['total_valoraciones'] == 0) $stats['valoracion_promedio'] = null;
             else $stats['valoracion_promedio'] = (float)$stats['valoracion_promedio'];
        }

        Response::success($stats);

    } catch (Exception $e) {
        Response::serverError('Error al obtener estadísticas', $e->getMessage());
    }
}

/**
 * Obtener habilidades ACTIVAS de un usuario
 */
function obtenerHabilidadesUsuario($id) {
    try {
        $db = Database::getConnection();

        $stmtUser = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id]);
        if (!$stmtUser->fetch()) {
             Response::notFound('Usuario no encontrado');
        }

        $sql = "
            SELECT h.id, h.titulo, h.descripcion, h.tipo, h.duracion_estimada,
                   h.fecha_publicacion, h.estado, c.nombre as categoria, c.icono as categoria_icono
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
        $user_id = $_SESSION['user_id'] ?? null;
        $user_role = $_SESSION['user_role'] ?? null;

        // Verificar permisos (solo el mismo usuario o admin)
        // ===== CAMBIO AQUÍ =====
        if ($user_id != $id && $user_role !== 'admin') {
            Response::forbidden('No tienes permisos para editar este usuario');
        }
        // =======================

        $stmt = $db->prepare("SELECT id, email FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$currentUser) {
            Response::notFound('Usuario no encontrado');
        }

        // Construir UPDATE dinámico
        $fields = [];
        $params = ['id' => $id];
        $allowedFieldsUser = ['nombre_usuario', 'ubicacion', 'biografia', 'foto_url'];
        $allowedFieldsAdmin = ['activo', 'rol'];

        foreach ($allowedFieldsUser as $field) {
            if (isset($data[$field])) {
                if ($field === 'nombre_usuario' && mb_strlen(trim($data[$field])) < 3) {
                     Response::badRequest('El nombre de usuario debe tener al menos 3 caracteres.');
                }
                $fields[] = "$field = :$field";
                $params[$field] = trim($data[$field]);
            }
        }

        // Si es admin, permitir actualizar campos adicionales
        // ===== CAMBIO AQUÍ =====
        if ($user_role === 'admin') {
            foreach ($allowedFieldsAdmin as $field) {
                 if (isset($data[$field])) {
                     if ($field === 'activo') {
                         $params[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
                     }
                     // ===== CAMBIO AQUÍ (na validación do rol) =====
                     elseif ($field === 'rol' && !in_array($data[$field], ['usuario', 'admin'])) {
                         Response::badRequest('Rol inválido. Debe ser "usuario" o "admin".');
                     }
                     // ===========================================
                     else {
                         $params[$field] = $data[$field];
                     }
                     $fields[] = "$field = :$field";
                 }
            }
        }
        // =======================

        if (empty($fields)) {
            Response::badRequest('No hay campos válidos para actualizar.');
        }

        $sql = "
            UPDATE usuarios
            SET " . implode(', ', $fields) . "
            WHERE id = :id
            RETURNING id, nombre_usuario, email, ubicacion, biografia, foto_url, activo, rol, fecha_registro, ultima_conexion
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $updated = $stmt->fetch(PDO::FETCH_ASSOC);

        // Actualizar sesión si es el mismo usuario
        if ($user_id == $id) {
             $_SESSION['user_name'] = $updated['nombre_usuario'];
             if (isset($updated['rol'])) $_SESSION['user_role'] = $updated['rol'];
        }

        Response::success($updated, 'Perfil actualizado exitosamente');

    } catch (PDOException $e) {
         if ($e->getCode() == 23505) {
              if (strpos($e->getMessage(), 'usuarios_nombre_usuario_key') !== false) {
                   Response::conflict('El nombre de usuario ya está en uso.');
              } else {
                   Response::serverError('Error de base de datos.', $e->getMessage());
              }
         } else {
              Response::serverError('Error al actualizar usuario', $e->getMessage());
         }
    } catch (Exception $e) {
        Response::serverError('Error al actualizar usuario', $e->getMessage());
    }
}

/**
 * Obtener las valoraciones recibidas por un usuario
 */
function obtenerValoracionesUsuario($id) {
    try {
        $db = Database::getConnection();

        $stmtUser = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id]);
        if (!$stmtUser->fetch()) {
            Response::notFound('Usuario no encontrado');
        }

        $sql = "
            SELECT v.id, v.puntuacion, v.comentario, v.fecha_valoracion,
                   u.id AS evaluador_id, u.nombre_usuario AS evaluador_nombre, u.foto_url AS evaluador_foto
            FROM valoraciones v
            INNER JOIN usuarios u ON v.evaluador_id = u.id
            WHERE v.evaluado_id = :evaluado_id
            ORDER BY v.fecha_valoracion DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['evaluado_id' => $id]);
        $valoraciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Response::success($valoraciones);

    } catch (Exception $e) {
        Response::serverError('Error al obtener las valoraciones del usuario', $e->getMessage());
    }
}

?>