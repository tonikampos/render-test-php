<?php
/**
 * Endpoints de Valoraciones (Reputación)
 * POST /api/valoraciones - Crear una nueva valoración
 */

require_once __DIR__ . '/../config/database.php';

function handleValoracionesRoutes($method, $id, $action, $input) {
    
    // POST /api/valoraciones (crear)
    if ($method === 'POST' && is_null($id)) {
        Auth::requireAuth();
        crearValoracion($input);
    }
    
    Response::methodNotAllowed(['POST']);
}

/**
 * Crear una nueva valoración para un intercambio completado
 * Body: { "intercambio_id": 10, "puntuacion": 5, "comentario": "Todo perfecto!" }
 */
function crearValoracion($input) {
    try {
        $db = Database::getConnection();
        $evaluador_id = $_SESSION['user_id'];
        
        $intercambio_id = $input['intercambio_id'] ?? null;
        $puntuacion = $input['puntuacion'] ?? null;
        $comentario = $input['comentario'] ?? '';
        
        if (empty($intercambio_id) || empty($puntuacion)) {
            Response::error('Faltan campos requiridos: intercambio_id e puntuacion', 400);
        }
        
        if (!is_numeric($puntuacion) || $puntuacion < 1 || $puntuacion > 5) {
            Response::error('La puntuación debe ser un número entre 1 y 5', 400);
        }
        
        $sqlCheck = "
            SELECT proponente_id, receptor_id, estado 
            FROM intercambios 
            WHERE id = :intercambio_id
        ";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute(['intercambio_id' => $intercambio_id]);
        $intercambio = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if (!$intercambio) {
            Response::notFound('El intercambio especificado no existe');
        }
        
        if ($intercambio['estado'] !== 'completado') {
            Response::error('Solo se pueden valorar los intercambios completados', 400);
        }
        
        // Verificamos que o usuario que valora participou no intercambio
        if ($evaluador_id != $intercambio['proponente_id'] && $evaluador_id != $intercambio['receptor_id']) {
            Response::forbidden('No tienes permiso para valorar este intercambio');
        }
        
        // Determinamos a quen se está a valorar (ao outro participante)
        $evaluado_id = ($evaluador_id == $intercambio['proponente_id']) 
            ? $intercambio['receptor_id'] 
            : $intercambio['proponente_id'];
            
        $sqlExists = "
            SELECT id FROM valoraciones 
            WHERE intercambio_id = :intercambio_id AND evaluador_id = :evaluador_id
        ";
        $stmtExists = $db->prepare($sqlExists);
        $stmtExists->execute([
            'intercambio_id' => $intercambio_id,
            'evaluador_id' => $evaluador_id
        ]);
        
        if ($stmtExists->fetch()) {
            Response::error('Ya has valorado este intercambio previamente', 409); 
        }
        
        $sqlInsert = "
            INSERT INTO valoraciones (intercambio_id, evaluador_id, evaluado_id, puntuacion, comentario)
            VALUES (:intercambio_id, :evaluador_id, :evaluado_id, :puntuacion, :comentario)
            RETURNING id, puntuacion, comentario, fecha_valoracion
        ";
        
        $stmtInsert = $db->prepare($sqlInsert);
        $stmtInsert->execute([
            'intercambio_id' => $intercambio_id,
            'evaluador_id' => $evaluador_id,
            'evaluado_id' => $evaluado_id,
            'puntuacion' => $puntuacion,
            'comentario' => $comentario
        ]);
        
        $nuevaValoracion = $stmtInsert->fetch(PDO::FETCH_ASSOC);
        
        Response::created($nuevaValoracion, 'Valoración enviada correctamente');
        
    } catch (Exception $e) {
        error_log('Error en crearValoracion: ' . $e->getMessage());
        Response::serverError('Error al guardar la valoración', $e->getMessage());
    }
}