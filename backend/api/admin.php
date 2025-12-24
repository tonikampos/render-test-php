<?php
/**
 * Endpoints de Administración
 * GET /api/admin/estadisticas - Obtener estadísticas globales del sistema
 */

require_once __DIR__ . '/../utils/Auth.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../config/database.php';

function handleAdminRoutes($method, $id, $action, $input) {
    
    // GET /api/admin/estadisticas
    if ($method === 'GET' && $id === 'estadisticas') {
        Auth::requireAdmin();
        getEstadisticas();
    }
    
    Response::methodNotAllowed(['GET']);
}

/**
 * Obtener estadísticas globales del sistema
 * Solo accesible para administradores
 */
function getEstadisticas() {
    try {
        $db = Database::getConnection();
        
   
        $query = "
            WITH stats_base AS (
                SELECT 
                    -- Usuarios
                    (SELECT COUNT(*) FROM usuarios WHERE activo = true) as total_usuarios,
                    (SELECT COUNT(*) FROM usuarios 
                     WHERE activo = true 
                     AND DATE_TRUNC('month', fecha_registro) = DATE_TRUNC('month', CURRENT_DATE)
                    ) as usuarios_mes,
                    
                    -- Habilidades
                    (SELECT COUNT(*) FROM habilidades WHERE estado = 'activa') as total_habilidades,
                    (SELECT COUNT(*) FROM habilidades WHERE estado = 'activa' AND tipo = 'oferta') as habilidades_oferta,
                    (SELECT COUNT(*) FROM habilidades WHERE estado = 'activa' AND tipo = 'demanda') as habilidades_demanda,
                    
                    -- Intercambios
                    (SELECT COUNT(*) FROM intercambios) as total_intercambios,
                    (SELECT COUNT(*) FROM intercambios WHERE estado = 'propuesto') as intercambios_propuestos,
                    (SELECT COUNT(*) FROM intercambios WHERE estado = 'aceptado') as intercambios_aceptados,
                    (SELECT COUNT(*) FROM intercambios WHERE estado = 'completado') as intercambios_completados,
                    (SELECT COUNT(*) FROM intercambios WHERE estado = 'rechazado') as intercambios_rechazados,
                    
                    -- Reportes
                    (SELECT COUNT(*) FROM reportes) as total_reportes,
                    (SELECT COUNT(*) FROM reportes WHERE estado = 'pendiente') as reportes_pendientes,
                    (SELECT COUNT(*) FROM reportes WHERE estado != 'pendiente') as reportes_resueltos,
                    
                    -- Valoraciones
                    (SELECT COUNT(*) FROM valoraciones) as total_valoraciones,
                    (SELECT COALESCE(ROUND(AVG(puntuacion)::numeric, 2), 0) FROM valoraciones) as valoracion_promedio,
                    
                    -- Conversaciones y mensajes
                    (SELECT COUNT(*) FROM conversaciones) as total_conversaciones,
                    (SELECT COUNT(*) FROM mensajes) as total_mensajes
            ),
            categoria_popular AS (
                SELECT c.nombre, COUNT(h.id) as total
                FROM categorias_habilidades c
                LEFT JOIN habilidades h ON c.id = h.categoria_id AND h.estado = 'activa'
                GROUP BY c.id, c.nombre
                ORDER BY total DESC
                LIMIT 1
            )
            SELECT 
                sb.*,
                COALESCE(cp.nombre, 'N/A') as categoria_mas_popular,
                COALESCE(cp.total, 0) as categoria_mas_popular_count
            FROM stats_base sb
            CROSS JOIN categoria_popular cp
        ";
        
        $stmt = $db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Convertir a enteros los valores numéricos
        $stats = [
            'total_usuarios' => (int) $result['total_usuarios'],
            'usuarios_mes' => (int) $result['usuarios_mes'],
            'total_habilidades' => (int) $result['total_habilidades'],
            'habilidades_oferta' => (int) $result['habilidades_oferta'],
            'habilidades_demanda' => (int) $result['habilidades_demanda'],
            'total_intercambios' => (int) $result['total_intercambios'],
            'intercambios_propuestos' => (int) $result['intercambios_propuestos'],
            'intercambios_aceptados' => (int) $result['intercambios_aceptados'],
            'intercambios_completados' => (int) $result['intercambios_completados'],
            'intercambios_rechazados' => (int) $result['intercambios_rechazados'],
            'total_reportes' => (int) $result['total_reportes'],
            'reportes_pendientes' => (int) $result['reportes_pendientes'],
            'reportes_resueltos' => (int) $result['reportes_resueltos'],
            'total_valoraciones' => (int) $result['total_valoraciones'],
            'valoracion_promedio' => (float) $result['valoracion_promedio'],
            'total_conversaciones' => (int) $result['total_conversaciones'],
            'total_mensajes' => (int) $result['total_mensajes'],
            'categoria_mas_popular' => $result['categoria_mas_popular'],
            'categoria_mas_popular_count' => (int) $result['categoria_mas_popular_count']
        ];
        
        Response::success($stats, 'Estadísticas obtenidas correctamente');
        
    } catch (Exception $e) {
        error_log("Error obteniendo estadísticas: " . $e->getMessage());
        Response::serverError('Error al obtener estadísticas', $e->getMessage());
    }
}
