    // Log de depuración para ver los valores que llegan
    error_log('[DEBUG][handleConversacionesRoutes] method=' . var_export($method, true) . ' id=' . var_export($id, true) . ' action=' . var_export($action, true));
<?php
/**
 * Endpoints de Conversaciones y Mensajes
 * GET /api/conversaciones - Listar mis conversaciones
 * GET /api/conversaciones/:id/mensajes - Obtener mensajes de una conversación
 * POST /api/conversaciones - Crear nueva conversación
 * POST /api/conversaciones/:id/mensaje - Enviar mensaje
 * PUT /api/conversaciones/:id/marcar-leido - Marcar mensajes como leídos
 */

require_once __DIR__ . '/../config/database.php';

function handleConversacionesRoutes($method, $id, $action, $input) {
    
    // GET /api/conversaciones (listar mis conversaciones)
    if ($method === 'GET' && !$id) {
        Auth::requireAuth();
        listarConversaciones();
    }
    
    // GET /api/conversaciones/:id/mensajes (obtener mensajes)
    if ($method === 'GET' && $id && $action === 'mensajes') {
        Auth::requireAuth();
        obtenerMensajes($id);
    }
    
    // POST /api/conversaciones (crear nueva conversación)
    if ($method === 'POST' && is_null($id)) {
        Auth::requireAuth();
        crearConversacion($input);
    }
    
    // POST /api/conversaciones/:id/mensaje (enviar mensaje)
    if ($method === 'POST' && is_numeric($id) && intval($id) > 0 && $action === 'mensaje') {
        Auth::requireAuth();
        enviarMensaje($id, $input);
    }
    
    // PUT /api/conversaciones/:id/marcar-leido (marcar como leído)
    if ($method === 'PUT' && $id && $action === 'marcar-leido') {
        Auth::requireAuth();
        marcarComoLeido($id);
    }
    
    Response::methodNotAllowed(['GET', 'POST', 'PUT']);
}

/**
 * Listar todas mis conversaciones
 * GET /api/conversaciones
 */
function listarConversaciones() {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        $sql = "
            SELECT 
                c.id,
                c.intercambio_id,
                c.fecha_creacion,
                c.ultima_actualizacion,
                -- Datos del otro usuario (el que NO soy yo)
                CASE 
                    WHEN pc1.usuario_id = :usuario_id THEN pc2.usuario_id
                    ELSE pc1.usuario_id
                END as otro_usuario_id,
                CASE 
                    WHEN pc1.usuario_id = :usuario_id THEN u2.nombre_usuario
                    ELSE u1.nombre_usuario
                END as otro_usuario_nombre,
                CASE 
                    WHEN pc1.usuario_id = :usuario_id THEN u2.foto_url
                    ELSE u1.foto_url
                END as otro_usuario_foto,
                -- Último mensaje
                (
                    SELECT contenido 
                    FROM mensajes 
                    WHERE conversacion_id = c.id 
                    ORDER BY fecha_envio DESC 
                    LIMIT 1
                ) as ultimo_mensaje,
                (
                    SELECT fecha_envio 
                    FROM mensajes 
                    WHERE conversacion_id = c.id 
                    ORDER BY fecha_envio DESC 
                    LIMIT 1
                ) as fecha_ultimo_mensaje,
                -- Mensajes no leídos
                (
                    SELECT COUNT(*) 
                    FROM mensajes 
                    WHERE conversacion_id = c.id 
                    AND emisor_id != :usuario_id 
                    AND leido = false
                ) as mensajes_no_leidos
            FROM conversaciones c
            INNER JOIN participantes_conversacion pc1 ON c.id = pc1.conversacion_id
            INNER JOIN participantes_conversacion pc2 ON c.id = pc2.conversacion_id AND pc2.usuario_id != pc1.usuario_id
            INNER JOIN usuarios u1 ON pc1.usuario_id = u1.id
            INNER JOIN usuarios u2 ON pc2.usuario_id = u2.id
            WHERE pc1.usuario_id = :usuario_id OR pc2.usuario_id = :usuario_id
            GROUP BY c.id, pc1.usuario_id, pc2.usuario_id, u1.nombre_usuario, u2.nombre_usuario, u1.foto_url, u2.foto_url
            ORDER BY c.ultima_actualizacion DESC
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        $conversaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($conversaciones);
        
    } catch (Exception $e) {
        error_log('Error en listarConversaciones: ' . $e->getMessage());
        Response::error('Error al obtener conversaciones', 500);
    }
}

/**
 * Obtener mensajes de una conversación
 * GET /api/conversaciones/:id/mensajes
 */
function obtenerMensajes($conversacion_id) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Verificar que el usuario es participante de la conversación
        $sqlCheck = "
            SELECT COUNT(*) 
            FROM participantes_conversacion 
            WHERE conversacion_id = :conversacion_id 
            AND usuario_id = :usuario_id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute([
            'conversacion_id' => $conversacion_id,
            'usuario_id' => $usuario_id
        ]);
        
        if ($stmtCheck->fetchColumn() == 0) {
            Response::error('No tienes acceso a esta conversación', 403);
        }
        
        // Obtener mensajes
        $sql = "
            SELECT 
                m.id,
                m.emisor_id,
                u.nombre_usuario as emisor_nombre,
                u.foto_url as emisor_foto,
                m.contenido,
                m.fecha_envio,
                m.leido,
                m.fecha_lectura
            FROM mensajes m
            INNER JOIN usuarios u ON m.emisor_id = u.id
            WHERE m.conversacion_id = :conversacion_id
            ORDER BY m.fecha_envio ASC
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['conversacion_id' => $conversacion_id]);
        $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($mensajes);
        
    } catch (Exception $e) {
        error_log('Error en obtenerMensajes: ' . $e->getMessage());
        Response::error('Error al obtener mensajes', 500);
    }
}

/**
 * Crear nueva conversación
 * POST /api/conversaciones
 * Body: { "receptor_id": 5, "mensaje_inicial": "Hola..." }
 */
function crearConversacion($input) {
    try {
        $db = Database::getConnection();
        
        // SAFETY: Si hay transacción activa fallida, hacer rollback
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        $usuario_id = $_SESSION['user_id'];
        
        // Validar entrada (aceptar tanto receptor_id como otro_usuario_id)
        $receptor_id = $input['receptor_id'] ?? $input['otro_usuario_id'] ?? null;
        $mensaje_inicial = $input['mensaje_inicial'] ?? null;
        
        if (empty($receptor_id) || empty($mensaje_inicial)) {
            Response::error('Faltan campos requeridos: receptor_id (o otro_usuario_id) y mensaje_inicial', 400);
        }
        
        $receptor_id = intval($receptor_id);
        $mensaje_inicial = trim($mensaje_inicial);
        
        if ($receptor_id === $usuario_id) {
            Response::error('No puedes crear una conversación contigo mismo', 400);
        }
        
        // Verificar que el receptor existe ANTES de iniciar transacción
        $sqlCheckUser = "SELECT id FROM usuarios WHERE id = :receptor_id AND activo = TRUE";
        $stmtCheckUser = $db->prepare($sqlCheckUser);
        $stmtCheckUser->execute(['receptor_id' => $receptor_id]);
        if (!$stmtCheckUser->fetch()) {
            Response::error('El usuario receptor no existe o no está activo', 404);
        }
        
        // Iniciar transacción después de validaciones básicas
    // Probar inserts fuera de la transacción para diagnóstico
    error_log('[DEBUG] Ejecutando inserts fuera de transacción');
        
        // Verificar si ya existe una conversación entre estos usuarios
        $sqlCheck = "
            SELECT c.id 
            FROM conversaciones c
            INNER JOIN participantes_conversacion pc1 ON c.id = pc1.conversacion_id AND pc1.usuario_id = :usuario_id
            INNER JOIN participantes_conversacion pc2 ON c.id = pc2.conversacion_id AND pc2.usuario_id = :receptor_id
            LIMIT 1
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute([
            'usuario_id' => $usuario_id,
            'receptor_id' => $receptor_id
        ]);
        $conversacion_existente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($conversacion_existente) {
            // Si ya existe, devolver su ID y enviar el mensaje ahí
            $conversacion_id = $conversacion_existente['id'];
            enviarMensajeInterno($db, $conversacion_id, $usuario_id, $mensaje_inicial);
            Response::success([
                'conversacion_id' => $conversacion_id,
                'mensaje' => 'Mensaje enviado en conversación existente'
            ], 200);
        }
        
        // Crear conversación
        $sqlConversacion = "
            INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion)
            VALUES (NULL, NOW(), NOW())
            RETURNING id
        ";
        $stmtConversacion = $db->prepare($sqlConversacion);
        $stmtConversacion->execute();
        $conversacion_id = $stmtConversacion->fetchColumn();
        error_log('[DEBUG] conversacion_id generado: ' . var_export($conversacion_id, true));
        if (!$conversacion_id) {
            throw new Exception("No se pudo obtener el ID de la conversación creada");
        }
        
    // Añadir participantes UNO POR UNO para identificar errores
        // Insert participante receptor primero (sin transacción)
        error_log('[DEBUG] Antes de insertar participante receptor (usuario_id=' . var_export($receptor_id, true) . ')');
        try {
            $sqlPartR = "INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES (:conversacion_id, :usuario_id, NOW())";
            $stmtPartR = $db->prepare($sqlPartR);
            $stmtPartR->execute(['conversacion_id' => $conversacion_id, 'usuario_id' => $receptor_id]);
            error_log('[DEBUG] Participante receptor insertado correctamente');
        } catch (Exception $e) {
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_RECEPTOR] ' . $e->getMessage());
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_RECEPTOR] Código: ' . ($e->getCode() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_RECEPTOR] Archivo: ' . ($e->getFile() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_RECEPTOR] Línea: ' . ($e->getLine() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_RECEPTOR] Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }

        // Insert participante emisor después (sin transacción)
        error_log('[DEBUG] Antes de insertar participante emisor (usuario_id=' . var_export($usuario_id, true) . ')');
        try {
            $sqlPartE = "INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES (:conversacion_id, :usuario_id, NOW())";
            $stmtPartE = $db->prepare($sqlPartE);
            $stmtPartE->execute(['conversacion_id' => $conversacion_id, 'usuario_id' => $usuario_id]);
            error_log('[DEBUG] Participante emisor insertado correctamente');
        } catch (Exception $e) {
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_EMISOR] ' . $e->getMessage());
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_EMISOR] Código: ' . ($e->getCode() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_EMISOR] Archivo: ' . ($e->getFile() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_EMISOR] Línea: ' . ($e->getLine() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][PARTICIPANTE_EMISOR] Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }

        // Enviar mensaje inicial con try/catch
        try {
            enviarMensajeInterno($db, $conversacion_id, $usuario_id, $mensaje_inicial);
        } catch (Exception $e) {
            error_log('[DEBUG][EXCEPTION][MENSAJE] ' . $e->getMessage());
            error_log('[DEBUG][EXCEPTION][MENSAJE] Código: ' . ($e->getCode() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][MENSAJE] Archivo: ' . ($e->getFile() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][MENSAJE] Línea: ' . ($e->getLine() ?? 'N/A'));
            error_log('[DEBUG][EXCEPTION][MENSAJE] Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
        
    // $db->commit(); // No hay transacción activa, no llamar a commit
        
        Response::success([
            'conversacion_id' => $conversacion_id,
            'mensaje' => 'Conversación creada exitosamente'
        ], 201);
        
    } catch (Exception $e) {
        if ($db && $db->inTransaction()) {
            $db->rollBack();
        }
        error_log('[DEBUG][EXCEPTION] Error en crearConversacion: ' . $e->getMessage());
        error_log('[DEBUG][EXCEPTION] Código: ' . ($e->getCode() ?? 'N/A'));
        error_log('[DEBUG][EXCEPTION] Archivo: ' . ($e->getFile() ?? 'N/A'));
        error_log('[DEBUG][EXCEPTION] Línea: ' . ($e->getLine() ?? 'N/A'));
        error_log('[DEBUG][EXCEPTION] Stack trace: ' . $e->getTraceAsString());
        // Temporalmente devolver error detallado para debugging
        Response::error('Error al crear conversación: ' . $e->getMessage(), 500);
    }
}

/**
 * Enviar mensaje en conversación existente
 * POST /api/conversaciones/:id/mensaje
 * Body: { "contenido": "Hola, ¿cómo estás?" }
 */
function enviarMensaje($conversacion_id, $input) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Validar entrada
        if (empty($input['contenido'])) {
            Response::error('El contenido del mensaje es requerido', 400);
        }
        
        $contenido = trim($input['contenido']);
        
        // Verificar que el usuario es participante
        $sqlCheck = "
            SELECT COUNT(*) 
            FROM participantes_conversacion 
            WHERE conversacion_id = :conversacion_id 
            AND usuario_id = :usuario_id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute([
            'conversacion_id' => $conversacion_id,
            'usuario_id' => $usuario_id
        ]);
        
        if ($stmtCheck->fetchColumn() == 0) {
            Response::error('No tienes acceso a esta conversación', 403);
        }
        
        // Enviar mensaje
        enviarMensajeInterno($db, $conversacion_id, $usuario_id, $contenido);
        
        Response::success([
            'mensaje' => 'Mensaje enviado exitosamente'
        ], 201);
        
    } catch (Exception $e) {
        error_log('Error en enviarMensaje: ' . $e->getMessage());
        Response::error('Error al enviar mensaje', 500);
    }
}

/**
 * Función interna para enviar mensaje (reutilizable)
 */
function enviarMensajeInterno($db, $conversacion_id, $emisor_id, $contenido) {
    $sqlMensaje = "
        INSERT INTO mensajes (conversacion_id, emisor_id, contenido, fecha_envio, leido)
        VALUES (:conversacion_id, :emisor_id, :contenido, NOW(), false)
    ";
    $stmtMensaje = $db->prepare($sqlMensaje);
    $stmtMensaje->execute([
        'conversacion_id' => $conversacion_id,
        'emisor_id' => $emisor_id,
        'contenido' => $contenido
    ]);
    
    // Actualizar fecha de última actualización de la conversación
    $sqlUpdate = "
        UPDATE conversaciones 
        SET ultima_actualizacion = NOW() 
        WHERE id = :conversacion_id
    ";
    $stmtUpdate = $db->prepare($sqlUpdate);
    $stmtUpdate->execute(['conversacion_id' => $conversacion_id]);
}

/**
 * Marcar mensajes como leídos
 * PUT /api/conversaciones/:id/marcar-leido
 */
function marcarComoLeido($conversacion_id) {
    try {
        $db = Database::getConnection();
        $usuario_id = $_SESSION['user_id'];
        
        // Verificar que el usuario es participante
        $sqlCheck = "
            SELECT COUNT(*) 
            FROM participantes_conversacion 
            WHERE conversacion_id = :conversacion_id 
            AND usuario_id = :usuario_id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute([
            'conversacion_id' => $conversacion_id,
            'usuario_id' => $usuario_id
        ]);
        
        if ($stmtCheck->fetchColumn() == 0) {
            Response::error('No tienes acceso a esta conversación', 403);
        }
        
        // Marcar como leídos todos los mensajes que NO son míos
        $sql = "
            UPDATE mensajes 
            SET leido = true, fecha_lectura = NOW()
            WHERE conversacion_id = :conversacion_id 
            AND emisor_id != :usuario_id
            AND leido = false
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'conversacion_id' => $conversacion_id,
            'usuario_id' => $usuario_id
        ]);
        
        $mensajes_marcados = $stmt->rowCount();
        
        Response::success([
            'mensaje' => 'Mensajes marcados como leídos',
            'mensajes_marcados' => $mensajes_marcados
        ]);
        
    } catch (Exception $e) {
        error_log('Error en marcarComoLeido: ' . $e->getMessage());
        Response::error('Error al marcar mensajes como leídos', 500);
    }
}
