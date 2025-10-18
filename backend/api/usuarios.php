<?php
/**
 * Endpoints de Usuarios
 * GET /api/usuarios - Listar usuarios (ADMIN ONLY) <--- Actualizado comentario
 * GET /api/usuarios/:id - Ver perfil de usuario
 * GET /api/usuarios/:id/estadisticas - Estadísticas del usuario
 * PUT /api/usuarios/:id - Actualizar perfil
 * GET /api/usuarios/:id/habilidades - Habilidades del usuario
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php'; // Asegúrate de que Auth está incluído

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
    
    // Se non coincide ningunha ruta, método non permitido
    Response::methodNotAllowed(['GET', 'PUT']);
}

/**
 * Listar usuarios (Sólo administradores)
 */
function listarUsuarios() {
    // ===== ENGADIR ESTA COMPROBACIÓN DE ROL =====
    Auth::requireRole('admin'); 
    // ============================================

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
        // Modificado para poder incluír usuarios non activos se é necesario (para admin)
        // Se queres que o admin só vexa activos, mantén 'activo = true'
        $where = []; // Empezamos sen condicións
        $params = [];
        
        if ($ubicacion) {
            $where[] = 'ubicacion ILIKE :ubicacion';
            $params['ubicacion'] = '%' . $ubicacion . '%';
        }
        
        if ($search) {
            $where[] = '(nombre_usuario ILIKE :search OR email ILIKE :search)'; // Engadir email á busca para admin
            $params['search'] = '%' . $search . '%';
        }

        // Condición para filtrar por activo/inactivo (opcional para admin)
        // if (isset($_GET['activo'])) {
        //     $where[] = 'activo = :activo';
        //     $params['activo'] = filter_var($_GET['activo'], FILTER_VALIDATE_BOOLEAN);
        // }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        // Contar total
        $countSql = "SELECT COUNT(*) FROM usuarios $whereClause";
        $stmt = $db->prepare($countSql);
        $stmt->execute($params);
        $total = $stmt->fetchColumn();
        
        // Obtener usuarios - Engadir máis campos para o admin (email, activo, rol)
        $sql = "
            SELECT 
                id, nombre_usuario, email, ubicacion, biografia, foto_url,
                activo, rol, fecha_registro, ultima_conexion
            FROM usuarios
            $whereClause
            ORDER BY fecha_registro DESC -- Ordenar por rexistro quizais sexa máis útil para admin
            LIMIT :limit OFFSET :offset
        ";
        
        // PDO require que os parámetros de LIMIT/OFFSET sexan integer
        $params['limit'] = (int)$per_page;
        $params['offset'] = (int)$offset;
        
        $stmt = $db->prepare($sql);
        
        // Bind dos parámetros explicitamente para LIMIT/OFFSET
        foreach ($params as $key => &$val) {
             if ($key === 'limit' || $key === 'offset') {
                $stmt->bindParam($key, $val, PDO::PARAM_INT);
            } else {
                 $stmt->bindParam($key, $val);
             }
        }
        unset($val); // Romper referencia

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::paginated($usuarios, $total, $page, $per_page);
        
    } catch (Exception $e) {
        Response::serverError('Error al listar usuarios', $e->getMessage());
    }
}

/**
 * Obtener perfil de usuario público (ou completo se é admin/propio)
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
            -- Quitamos AND activo = true para que admin poida ver inactivos
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            Response::notFound('Usuario no encontrado');
        }
        
        // Verificar se o usuario que fai a petición é o mesmo ou é admin
        $is_same_user = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;
        $is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
        
        // Se NON é o mesmo usuario NIN admin, ocultar datos sensibles
        if (!$is_same_user && !$is_admin) {
            unset($usuario['email']);
            unset($usuario['activo']); // Ocultar estado
            unset($usuario['rol']);    // Ocultar rol
        }
        
        // Se o usuario está inactivo e NON é admin, devolvemos 404
        if (!$usuario['activo'] && !$is_admin) {
             Response::notFound('Usuario no encontrado');
        }

        Response::success($usuario);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener usuario', $e->getMessage());
    }
}

// ... (resto das funcións: obtenerEstadisticasUsuario, obtenerHabilidadesUsuario, actualizarUsuario, obtenerValoracionesUsuario non cambian) ...

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
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE id = :id"); // Comprobar se existe, activo ou non
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
                'valoracion_promedio' => null, // Usar null se non hai valoracións
                'total_valoraciones' => 0
            ];
        } else {
             // Asegurarse de que valoracion_promedio sexa null se non hai valoracións
             if ($stats['total_valoraciones'] == 0) {
                 $stats['valoracion_promedio'] = null;
             }
        }
        
        Response::success($stats);
        
    } catch (Exception $e) {
        Response::serverError('Error al obtener estadísticas', $e->getMessage());
    }
}

/**
 * Obtener habilidades de un usuario (só activas)
 */
function obtenerHabilidadesUsuario($id) {
    try {
        $db = Database::getConnection();
        
        // Primeiro, verificar que o usuario existe (non necesariamente activo)
        $stmtUser = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id]);
        if (!$stmtUser->fetch()) {
             Response::notFound('Usuario no encontrado');
        }

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
        $user_id = $_SESSION['user_id'] ?? null;
        $user_role = $_SESSION['user_role'] ?? null;
        
        // Verificar permisos (só o mesmo usuario ou admin)
        if ($user_id != $id && $user_role !== 'admin') {
            Response::forbidden('No tienes permisos para editar este usuario');
        }
        
        // Verificar que o usuario existe
        $stmt = $db->prepare("SELECT id, email FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$currentUser) {
            Response::notFound('Usuario no encontrado');
        }
        
        // Construír UPDATE dinámico
        $fields = [];
        $params = ['id' => $id];
        
        // Campos que pode actualizar un usuario normal ou admin
        $allowedFieldsUser = ['nombre_usuario', 'ubicacion', 'biografia', 'foto_url'];
        // Campos que SÓ pode actualizar un admin
        $allowedFieldsAdmin = ['activo', 'rol']; // Email e password terían endpoints separados

        foreach ($allowedFieldsUser as $field) {
            if (isset($data[$field])) {
                // Validación básica (podería ser máis complexa)
                if ($field === 'nombre_usuario' && strlen($data[$field]) < 3) {
                     Response::error('El nombre de usuario debe tener al menos 3 caracteres.');
                }
                 // Engadir máis validacións se fose necesario...

                $fields[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }
        
        // Se é admin, permitir actualizar campos adicionais
        if ($user_role === 'admin') {
            foreach ($allowedFieldsAdmin as $field) {
                 if (isset($data[$field])) {
                     // Validación para 'activo' (boolean)
                     if ($field === 'activo') {
                         $params[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
                     } 
                     // Validación para 'rol' (enum)
                     elseif ($field === 'rol' && !in_array($data[$field], ['usuario', 'admin'])) {
                         Response::error('Rol inválido. Debe ser "usuario" o "admin".');
                     } else {
                         $params[$field] = $data[$field];
                     }
                     $fields[] = "$field = :$field";
                 }
            }
        }

        if (empty($fields)) {
            Response::error('No hay campos válidos para actualizar.');
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

        // Se o usuario actualizado é o mesmo que está logueado, actualizar a sesión
        if ($user_id == $id) {
             $_SESSION['user_name'] = $updated['nombre_usuario'];
             // Actualizar rol se cambiou (IMPORTANTE para permisos)
             if (isset($updated['rol'])) $_SESSION['user_role'] = $updated['rol']; 
        }

        Response::success($updated, 'Perfil actualizado exitosamente');
        
    } catch (PDOException $e) {
         // Capturar erro específico de chave única (ex: nome_usuario ou email xa existe)
         if ($e->getCode() == 23505) { 
              if (strpos($e->getMessage(), 'usuarios_nombre_usuario_key') !== false) {
                   Response::error('El nombre de usuario ya está en uso.');
              } elseif (strpos($e->getMessage(), 'usuarios_email_key') !== false) {
                    Response::error('El email ya está registrado.'); // Aínda que non permitamos cambialo aquí
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
 * Obter as valoracións recibidas por un usuario
 */
function obtenerValoracionesUsuario($id) {
    try {
        $db = Database::getConnection();

        // Verificamos primeiro que o usuario existe (non necesariamente activo)
        $stmtUser = $db->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id]);
        if (!$stmtUser->fetch()) {
            Response::notFound('Usuario no encontrado');
        }

        // Facemos un JOIN para obter tamén os datos de quen escribiu a valoración
        $sql = "
            SELECT 
                v.id,
                v.puntuacion,
                v.comentario,
                v.fecha_valoracion,
                u.id AS evaluador_id, -- Engadir ID do evaluador
                u.nombre_usuario AS evaluador_nombre,
                u.foto_url AS evaluador_foto
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