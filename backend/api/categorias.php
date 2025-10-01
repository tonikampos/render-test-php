<?php
/**
 * Endpoints de Categorías de Habilidades
 * GET /api/categorias - Listar todas las categorías
 */

require_once __DIR__ . '/../config/database.php';

function handleCategoriasRoutes($method, $id, $action, $input) {
    
    // GET /api/categorias
    if ($method === 'GET') {
        listarCategorias();
    }
    
    Response::methodNotAllowed(['GET']);
}

/**
 * Listar todas las categorías
 */
function listarCategorias() {
    try {
        $db = Database::getConnection();
        
        $sql = "
            SELECT id, nombre, descripcion, icono
            FROM categorias_habilidades
            ORDER BY nombre ASC
        ";
        
        $stmt = $db->query($sql);
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        Response::success($categorias);
        
    } catch (Exception $e) {
        Response::serverError('Error al listar categorías', $e->getMessage());
    }
}
