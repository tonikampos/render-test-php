<?php
/**
 * Endpoints de Reportes (Moderación)
 * POST   /api/reportes      - Crear un novo reporte (usuarios)
 * GET    /api/reportes      - Listar reportes (só admin)
 * PUT    /api/reportes/:id  - Actualizar/Resolver un reporte (só admin)
 */

require_once __DIR__ . '/../config/database.php';

function handleReportesRoutes($method, $id, $action, $input) {
    
    // POST /api/reportes (crear un reporte)
    if ($method === 'POST' && is_null($id)) {
        Auth::requireAuth();
        crearReporte($input);
    }
    
    // GET /api/reportes (listar para admin)
    if ($method === 'GET' && is_null($id)) {
        Auth::requireAdmin();
        listarReportes();
    }
    
    // PUT /api/reportes/:id (actualizar/resolver)
    if ($method === 'PUT' && is_numeric($id)) {
        Auth::requireAdmin();
        actualizarReporte($id, $input);
    }
    
    Response::methodNotAllowed(['POST', 'GET', 'PUT']);
}

/**
 * Crear un novo reporte
 * Body: { "tipo_contenido": "habilidad", "contenido_id": 20, "motivo": "Contido inapropiado..." }
 */
function crearReporte($input) {
    try {
        $db = Database::getConnection();
        $reportador_id = $_SESSION['user_id'];
        
        $tipo_contenido = $input['tipo_contenido'] ?? null;
        $contenido_id = $input['contenido_id'] ?? null;
        $motivo = $input['motivo'] ?? null;
        
        if (empty($tipo_contenido) || empty($contenido_id) || empty($motivo)) {
            Response::error('Faltan campos requiridos: tipo_contenido, contenido_id e motivo', 400);
        }
        
        $tipos_validos = ['usuario', 'habilidad', 'valoracion'];
        if (!in_array($tipo_contenido, $tipos_validos)) {
            Response::error("O tipo de contido non é válido. Debe ser: " . implode(', ', $tipos_validos), 400);
        }
        
        // 2. Inserir o reporte na base de datos
        $sql = "
            INSERT INTO reportes (reportador_id, tipo_contenido, contenido_id, motivo)
            VALUES (:reportador_id, :tipo_contenido, :contenido_id, :motivo)
            RETURNING id, estado, fecha_reporte
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'reportador_id' => $reportador_id,
            'tipo_contenido' => $tipo_contenido,
            'contenido_id' => $contenido_id,
            'motivo' => $motivo
        ]);
        
        $novoReporte = $stmt->fetch(PDO::FETCH_ASSOC);
        
        Response::created($novoReporte, 'Reporte enviado correctamente. O equipo de moderación revisarano pronto.');
        
    } catch (Exception $e) {
        error_log('Error en crearReporte: ' . $e->getMessage());
        Response::serverError('Error al enviar el reporte', $e->getMessage());
    }
}

/**
 * Listar todos os reportes (só para administradores)
 * Filtro opcional: GET /api/reportes?estado=pendiente
 */
function listarReportes() {
    try {
        $db = Database::getConnection();
        
        $estado = $_GET['estado'] ?? 'pendiente'; // Por defecto, mostramos os pendentes
        
        $sql = "SELECT * FROM reportes WHERE estado = :estado ORDER BY fecha_reporte ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute(['estado' => $estado]);
        $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($reportes);
        
    } catch (Exception $e) {
        Response::serverError('Erro ao listar os reportes', $e->getMessage());
    }
}

/**
 * Actualizar o estado dun reporte (só para administradores)
 * Body: { "estado": "revisado", "notas_revision": "O contido foi eliminado." }
 */
function actualizarReporte($id, $input) {
    try {
        $db = Database::getConnection();
        $revisor_id = $_SESSION['user_id'];
        
        // 1. Validar datos de entrada
        $novo_estado = $input['estado'] ?? null;
        $notas_revision = $input['notas_revision'] ?? '';
        
        if (empty($novo_estado)) {
            Response::error('O campo estado é requirido', 400);
        }
        
        $estados_validos = ['revisado', 'desestimado', 'accion_tomada'];
        if (!in_array($novo_estado, $estados_validos)) {
            Response::error("O estado non é válido. Debe ser: " . implode(', ', $estados_validos), 400);
        }
        
        // 2. Actualizar o reporte
        $sql = "
            UPDATE reportes
            SET estado = :estado, 
                revisor_id = :revisor_id, 
                notas_revision = :notas_revision,
                fecha_revision = NOW()
            WHERE id = :id AND estado = 'pendiente'
            RETURNING *
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'estado' => $novo_estado,
            'revisor_id' => $revisor_id,
            'notas_revision' => $notas_revision
        ]);
        
        if ($stmt->rowCount() === 0) {
            Response::notFound('Non se atopou ningún reporte pendente con ese ID');
        }
        
        $reporteActualizado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 3. Crear notificación para el usuario que reportó
        $reportador_id = $reporteActualizado['reportador_id'];
        
        // Generar mensaje según el estado
        $mensajes = [
            'desestimado' => 'Tu reporte ha sido revisado y desestimado.',
            'revisado' => 'Tu reporte ha sido revisado por el equipo de moderación.',
            'accion_tomada' => 'Tu reporte ha sido revisado y se ha tomado acción sobre el contenido reportado.'
        ];
        
        $mensaje = $mensajes[$novo_estado] ?? 'Tu reporte ha sido revisado.';
        

        if (!empty($notas_revision)) {
            $mensaje .= ' Nota: ' . $notas_revision;
        }
        

        try {
            $sqlNotificacion = "
                INSERT INTO notificaciones (
                    usuario_id,
                    tipo,
                    titulo,
                    mensaje,
                    fecha_creacion
                )
                VALUES (
                    :usuario_id,
                    'nueva_valoracion',
                    :titulo,
                    :mensaje,
                    NOW()
                )
            ";
            
            $stmtNotif = $db->prepare($sqlNotificacion);
            $stmtNotif->execute([
                'usuario_id' => $reportador_id,
                'titulo' => 'Tu reporte ha sido revisado',
                'mensaje' => $mensaje
            ]);
        } catch (Exception $eNotif) {

            error_log("Error al crear notificación de reporte: " . $eNotif->getMessage());
        }
        
        Response::success($reporteActualizado, 'El reporte fue actualizado correctamente');
        
    } catch (Exception $e) {
        Response::serverError('Error al actualizar el reporte', $e->getMessage());
    }
}