<?php
/**
 * Endpoints de Intercambios
 * GET /api/intercambios - Listar mis intercambios
 * GET /api/intercambios/:id - Obtener un intercambio específico
 * POST /api/intercambios - Proponer nuevo intercambio
 * PUT /api/intercambios/:id - Aceptar/Rechazar intercambio
 * PUT /api/intercambios/:id/completar - Marcar como completado
 */

require_once __DIR__ . '/../config/database.php';

function handleIntercambiosRoutes($method, $id, $action, $input) {
    
    // GET /api/intercambios (listar mis intercambios)
    if ($method === 'GET' && !$id) {
        Auth::requireAuth();
        listarIntercambios();
    }
    
    // GET /api/intercambios/:id (obtener uno específico)
    if ($method === 'GET' && $id) {
        Auth::requireAuth();
        obtenerIntercambio($id);
    }
    
    // POST /api/intercambios (proponer intercambio)
    if ($method === 'POST' && !$id) {
        Auth::requireAuth();
        proponerIntercambio($input);
    }
    
    // PUT /api/intercambios/:id (aceptar/rechazar)
    if ($method === 'PUT' && $id && !$action) {
        Auth::requireAuth();
        actualizarIntercambio($id, $input);
    }
    
    // PUT /api/intercambios/:id/completar (marcar como completado)
    if ($method === 'PUT' && $id && $action === 'completar') {
        Auth::requireAuth();
        completarIntercambio($id);
    }
    
    Response::methodNotAllowed(['GET', 'POST', 'PUT']);
}

/**
 * Listar mis intercambios (como proponente o receptor)
 * GET /api/intercambios?estado=propuesto
 */
function listarIntercambios() {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Filtros
        $estado = $_GET['estado'] ?? null;
        
        $where = ["(i.proponente_id = :usuario_id OR i.receptor_id = :usuario_id)"];
        $params = ['usuario_id' => $usuario_id];
        
        if ($estado) {
            $where[] = 'i.estado = :estado';
            $params['estado'] = $estado;
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "
            SELECT 
                i.id,
                i.estado,
                i.mensaje_propuesta,
                i.fecha_propuesta,
                i.fecha_actualizacion,
                i.fecha_completado,
                -- Habilidad ofrecida
                h1.id as habilidad_ofrecida_id,
                h1.titulo as habilidad_ofrecida_titulo,
                h1.descripcion as habilidad_ofrecida_descripcion,
                h1.duracion_estimada as habilidad_ofrecida_duracion,
                c1.nombre as habilidad_ofrecida_categoria,
                -- Habilidad solicitada
                h2.id as habilidad_solicitada_id,
                h2.titulo as habilidad_solicitada_titulo,
                h2.descripcion as habilidad_solicitada_descripcion,
                h2.duracion_estimada as habilidad_solicitada_duracion,
                c2.nombre as habilidad_solicitada_categoria,
                -- Proponente
                u1.id as proponente_id,
                u1.nombre_usuario as proponente_nombre,
                u1.foto_url as proponente_foto,
                -- Receptor
                u2.id as receptor_id,
                u2.nombre_usuario as receptor_nombre,
                u2.foto_url as receptor_foto
            FROM intercambios i
            INNER JOIN habilidades h1 ON i.habilidad_ofrecida_id = h1.id
            INNER JOIN habilidades h2 ON i.habilidad_solicitada_id = h2.id
            INNER JOIN categorias_habilidades c1 ON h1.categoria_id = c1.id
            INNER JOIN categorias_habilidades c2 ON h2.categoria_id = c2.id
            INNER JOIN usuarios u1 ON i.proponente_id = u1.id
            INNER JOIN usuarios u2 ON i.receptor_id = u2.id
            WHERE $whereClause
            ORDER BY i.fecha_propuesta DESC
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $intercambios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($intercambios);
        
    } catch (Exception $e) {
        error_log('Error en listarIntercambios: ' . $e->getMessage());
        Response::error('Error al obtener intercambios', 500);
    }
}

/**
 * Obtener un intercambio específico
 * GET /api/intercambios/:id
 */
function obtenerIntercambio($id) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        $sql = "
            SELECT 
                i.id,
                i.estado,
                i.mensaje_propuesta,
                i.fecha_propuesta,
                i.fecha_actualizacion,
                i.fecha_completado,
                i.notas_adicionales,
                -- Habilidad ofrecida
                h1.id as habilidad_ofrecida_id,
                h1.titulo as habilidad_ofrecida_titulo,
                h1.descripcion as habilidad_ofrecida_descripcion,
                h1.duracion_estimada as habilidad_ofrecida_duracion,
                c1.nombre as habilidad_ofrecida_categoria,
                -- Habilidad solicitada
                h2.id as habilidad_solicitada_id,
                h2.titulo as habilidad_solicitada_titulo,
                h2.descripcion as habilidad_solicitada_descripcion,
                h2.duracion_estimada as habilidad_solicitada_duracion,
                c2.nombre as habilidad_solicitada_categoria,
                -- Proponente
                u1.id as proponente_id,
                u1.nombre_usuario as proponente_nombre,
                u1.email as proponente_email,
                u1.telefono as proponente_telefono,
                u1.foto_url as proponente_foto,
                -- Receptor
                u2.id as receptor_id,
                u2.nombre_usuario as receptor_nombre,
                u2.email as receptor_email,
                u2.telefono as receptor_telefono,
                u2.foto_url as receptor_foto
            FROM intercambios i
            INNER JOIN habilidades h1 ON i.habilidad_ofrecida_id = h1.id
            INNER JOIN habilidades h2 ON i.habilidad_solicitada_id = h2.id
            INNER JOIN categorias_habilidades c1 ON h1.categoria_id = c1.id
            INNER JOIN categorias_habilidades c2 ON h2.categoria_id = c2.id
            INNER JOIN usuarios u1 ON i.proponente_id = u1.id
            INNER JOIN usuarios u2 ON i.receptor_id = u2.id
            WHERE i.id = :id
            AND (i.proponente_id = :usuario_id OR i.receptor_id = :usuario_id)
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'usuario_id' => $usuario_id
        ]);
        $intercambio = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$intercambio) {
            Response::error('Intercambio no encontrado o no tienes acceso', 404);
        }
        
        Response::success($intercambio);
        
    } catch (Exception $e) {
        error_log('Error en obtenerIntercambio: ' . $e->getMessage());
        Response::error('Error al obtener intercambio', 500);
    }
}

/**
 * Proponer nuevo intercambio
 * POST /api/intercambios
 * Body: {
 *   "habilidad_ofrecida_id": 23,
 *   "habilidad_solicitada_id": 45,
 *   "mensaje_propuesta": "Me interesa..."
 * }
 */
function proponerIntercambio($input) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Validar entrada
        if (empty($input['habilidad_ofrecida_id']) || empty($input['habilidad_solicitada_id'])) {
            Response::error('Faltan campos requeridos: habilidad_ofrecida_id, habilidad_solicitada_id', 400);
        }
        
        $habilidad_ofrecida_id = intval($input['habilidad_ofrecida_id']);
        $habilidad_solicitada_id = intval($input['habilidad_solicitada_id']);
        $mensaje_propuesta = trim($input['mensaje_propuesta'] ?? '');
        
        // Verificar que la habilidad ofrecida es mía
        $sqlCheckOfrecida = "
            SELECT usuario_id 
            FROM habilidades 
            WHERE id = :habilidad_id AND estado = 'activa'
        ";
        $stmtCheckOfrecida = $db->prepare($sqlCheckOfrecida);
        $stmtCheckOfrecida->execute(['habilidad_id' => $habilidad_ofrecida_id]);
        $owner_ofrecida = $stmtCheckOfrecida->fetchColumn();
        
        if ($owner_ofrecida != $usuario_id) {
            Response::error('Solo puedes ofrecer tus propias habilidades', 403);
        }
        
        // Obtener el dueño de la habilidad solicitada
        $sqlCheckSolicitada = "
            SELECT usuario_id 
            FROM habilidades 
            WHERE id = :habilidad_id AND estado = 'activa'
        ";
        $stmtCheckSolicitada = $db->prepare($sqlCheckSolicitada);
        $stmtCheckSolicitada->execute(['habilidad_id' => $habilidad_solicitada_id]);
        $receptor_id = $stmtCheckSolicitada->fetchColumn();
        
        if (!$receptor_id) {
            Response::error('La habilidad solicitada no existe o no está activa', 404);
        }
        
        if ($receptor_id == $usuario_id) {
            Response::error('No puedes proponer un intercambio contigo mismo', 400);
        }
        
        // Iniciar transacción
        $db->beginTransaction();
        
        // Crear intercambio
        $sql = "
            INSERT INTO intercambios (
                habilidad_ofrecida_id, 
                habilidad_solicitada_id, 
                proponente_id, 
                receptor_id, 
                estado, 
                mensaje_propuesta, 
                fecha_propuesta
            )
            VALUES (
                :habilidad_ofrecida_id,
                :habilidad_solicitada_id,
                :proponente_id,
                :receptor_id,
                'propuesto',
                :mensaje_propuesta,
                NOW()
            )
            RETURNING id
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'habilidad_ofrecida_id' => $habilidad_ofrecida_id,
            'habilidad_solicitada_id' => $habilidad_solicitada_id,
            'proponente_id' => $usuario_id,
            'receptor_id' => $receptor_id,
            'mensaje_propuesta' => $mensaje_propuesta
        ]);
        
        $intercambio_id = $stmt->fetchColumn();
        
        // Crear notificación para el receptor
        $sqlNotificacion = "
            INSERT INTO notificaciones (
                usuario_id,
                tipo,
                titulo,
                mensaje,
                enlace,
                referencia_id,
                fecha_creacion
            )
            VALUES (
                :usuario_id,
                'nuevo_intercambio',
                'Nueva propuesta de intercambio',
                :mensaje,
                :enlace,
                :referencia_id,
                NOW()
            )
        ";
        
        $stmtNotificacion = $db->prepare($sqlNotificacion);
        $stmtNotificacion->execute([
            'usuario_id' => $receptor_id,
            'mensaje' => 'Has recibido una nueva propuesta de intercambio',
            'enlace' => '/intercambios/' . $intercambio_id,
            'referencia_id' => $intercambio_id
        ]);
        
        $db->commit();
        
        Response::success([
            'intercambio_id' => $intercambio_id,
            'mensaje' => 'Intercambio propuesto exitosamente'
        ], 201);
        
    } catch (Exception $e) {
        if ($db && $db->inTransaction()) {
            $db->rollBack();
        }
        error_log('Error en proponerIntercambio: ' . $e->getMessage());
        Response::error('Error al proponer intercambio', 500);
    }
}

/**
 * Actualizar estado de intercambio (aceptar/rechazar)
 * PUT /api/intercambios/:id
 * Body: { "estado": "aceptado" } o { "estado": "rechazado" }
 */
function actualizarIntercambio($id, $input) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Validar entrada
        if (empty($input['estado'])) {
            Response::error('El estado es requerido', 400);
        }
        
        $nuevo_estado = $input['estado'];
        $estados_validos = ['aceptado', 'rechazado', 'cancelado'];
        
        if (!in_array($nuevo_estado, $estados_validos)) {
            Response::error('Estado no válido. Debe ser: aceptado, rechazado o cancelado', 400);
        }
        
        // Obtener intercambio y verificar permisos
        $sqlCheck = "
            SELECT proponente_id, receptor_id, estado
            FROM intercambios
            WHERE id = :id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute(['id' => $id]);
        $intercambio = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if (!$intercambio) {
            Response::error('Intercambio no encontrado', 404);
        }
        
        // Solo el receptor puede aceptar/rechazar, el proponente puede cancelar
        if ($nuevo_estado === 'aceptado' || $nuevo_estado === 'rechazado') {
            if ($intercambio['receptor_id'] != $usuario_id) {
                Response::error('Solo el receptor puede aceptar o rechazar', 403);
            }
        } elseif ($nuevo_estado === 'cancelado') {
            if ($intercambio['proponente_id'] != $usuario_id) {
                Response::error('Solo el proponente puede cancelar', 403);
            }
        }
        
        // Verificar que el estado actual sea 'propuesto'
        if ($intercambio['estado'] !== 'propuesto') {
            Response::error('Solo se pueden modificar intercambios en estado propuesto', 400);
        }
        
        // Actualizar estado
        $sql = "
            UPDATE intercambios
            SET estado = :estado, fecha_actualizacion = NOW()
            WHERE id = :id
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'estado' => $nuevo_estado,
            'id' => $id
        ]);
        
        // Crear notificación para el otro usuario
        $destinatario_id = ($intercambio['receptor_id'] == $usuario_id) 
            ? $intercambio['proponente_id'] 
            : $intercambio['receptor_id'];
        
        $tipo_notificacion = $nuevo_estado === 'aceptado' 
            ? 'intercambio_aceptado' 
            : 'intercambio_rechazado';
        
        $mensaje_notificacion = $nuevo_estado === 'aceptado'
            ? 'Tu propuesta de intercambio ha sido aceptada'
            : 'Tu propuesta de intercambio ha sido rechazada';
        
        $sqlNotificacion = "
            INSERT INTO notificaciones (
                usuario_id, tipo, titulo, mensaje, enlace, referencia_id, fecha_creacion
            )
            VALUES (
                :usuario_id,
                :tipo,
                :titulo,
                :mensaje,
                :enlace,
                :referencia_id,
                NOW()
            )
        ";
        
        $stmtNotificacion = $db->prepare($sqlNotificacion);
        $stmtNotificacion->execute([
            'usuario_id' => $destinatario_id,
            'tipo' => $tipo_notificacion,
            'titulo' => ucfirst($nuevo_estado),
            'mensaje' => $mensaje_notificacion,
            'enlace' => '/intercambios/' . $id,
            'referencia_id' => $id
        ]);
        
        Response::success([
            'mensaje' => 'Intercambio actualizado exitosamente',
            'nuevo_estado' => $nuevo_estado
        ]);
        
    } catch (Exception $e) {
        error_log('Error en actualizarIntercambio: ' . $e->getMessage());
        Response::error('Error al actualizar intercambio', 500);
    }
}

/**
 * Marcar intercambio como completado
 * PUT /api/intercambios/:id/completar
 */
function completarIntercambio($id) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Obtener intercambio y verificar permisos
        $sqlCheck = "
            SELECT proponente_id, receptor_id, estado
            FROM intercambios
            WHERE id = :id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute(['id' => $id]);
        $intercambio = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if (!$intercambio) {
            Response::error('Intercambio no encontrado', 404);
        }
        
        // Verificar que el usuario es participante
        if ($intercambio['proponente_id'] != $usuario_id && $intercambio['receptor_id'] != $usuario_id) {
            Response::error('No tienes acceso a este intercambio', 403);
        }
        
        // Verificar que el estado actual sea 'aceptado'
        if ($intercambio['estado'] !== 'aceptado') {
            Response::error('Solo se pueden completar intercambios aceptados', 400);
        }
        
        // Marcar como completado
        $sql = "
            UPDATE intercambios
            SET estado = 'completado', 
                fecha_completado = NOW(), 
                fecha_actualizacion = NOW()
            WHERE id = :id
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        // Notificar al otro usuario
        $destinatario_id = ($intercambio['receptor_id'] == $usuario_id) 
            ? $intercambio['proponente_id'] 
            : $intercambio['receptor_id'];
        
        $sqlNotificacion = "
            INSERT INTO notificaciones (
                usuario_id, tipo, titulo, mensaje, enlace, referencia_id, fecha_creacion
            )
            VALUES (
                :usuario_id,
                'intercambio_completado',
                'Intercambio completado',
                'El intercambio ha sido marcado como completado. ¡No olvides valorar!',
                :enlace,
                :referencia_id,
                NOW()
            )
        ";
        
        $stmtNotificacion = $db->prepare($sqlNotificacion);
        $stmtNotificacion->execute([
            'usuario_id' => $destinatario_id,
            'enlace' => '/intercambios/' . $id,
            'referencia_id' => $id
        ]);
        
        Response::success([
            'mensaje' => 'Intercambio marcado como completado. Ahora puedes dejar una valoración.'
        ]);
        
    } catch (Exception $e) {
        error_log('Error en completarIntercambio: ' . $e->getMessage());
        Response::error('Error al completar intercambio', 500);
    }
}

// Fix deployed
