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
        
        $stats = [];
        
        // Total usuarios activos
        $stmt = $db->query("SELECT COUNT(*) as total FROM usuarios WHERE activo = true");
        $stats['total_usuarios'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total usuarios registrados este mes
        $stmt = $db->query("
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE DATE_TRUNC('month', fecha_registro) = DATE_TRUNC('month', CURRENT_DATE)
        ");
        $stats['usuarios_mes'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total habilidades activas
        $stmt = $db->query("SELECT COUNT(*) as total FROM habilidades WHERE activo = true");
        $stats['total_habilidades'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Habilidades por tipo
        $stmt = $db->query("
            SELECT tipo, COUNT(*) as total 
            FROM habilidades 
            WHERE activo = true 
            GROUP BY tipo
        ");
        $habilidades_tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stats['habilidades_oferta'] = 0;
        $stats['habilidades_demanda'] = 0;
        foreach ($habilidades_tipo as $row) {
            if ($row['tipo'] === 'oferta') {
                $stats['habilidades_oferta'] = (int) $row['total'];
            } elseif ($row['tipo'] === 'demanda') {
                $stats['habilidades_demanda'] = (int) $row['total'];
            }
        }
        
        // Total intercambios
        $stmt = $db->query("SELECT COUNT(*) as total FROM intercambios");
        $stats['total_intercambios'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Intercambios por estado
        $stmt = $db->query("
            SELECT estado, COUNT(*) as total 
            FROM intercambios 
            GROUP BY estado
        ");
        $intercambios_estado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stats['intercambios_propuestos'] = 0;
        $stats['intercambios_aceptados'] = 0;
        $stats['intercambios_completados'] = 0;
        $stats['intercambios_rechazados'] = 0;
        foreach ($intercambios_estado as $row) {
            $key = 'intercambios_' . $row['estado'] . 's';
            $stats[$key] = (int) $row['total'];
        }
        
        // Total reportes
        $stmt = $db->query("SELECT COUNT(*) as total FROM reportes");
        $stats['total_reportes'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Reportes pendientes
        $stmt = $db->query("SELECT COUNT(*) as total FROM reportes WHERE estado = 'pendiente'");
        $stats['reportes_pendientes'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Reportes resueltos
        $stmt = $db->query("SELECT COUNT(*) as total FROM reportes WHERE estado != 'pendiente'");
        $stats['reportes_resueltos'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total valoraciones
        $stmt = $db->query("SELECT COUNT(*) as total FROM valoraciones");
        $stats['total_valoraciones'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Valoración promedio global
        $stmt = $db->query("SELECT AVG(puntuacion) as promedio FROM valoraciones");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['valoracion_promedio'] = $result['promedio'] ? round((float) $result['promedio'], 2) : 0;
        
        // Total conversaciones
        $stmt = $db->query("SELECT COUNT(*) as total FROM conversaciones");
        $stats['total_conversaciones'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total mensajes
        $stmt = $db->query("SELECT COUNT(*) as total FROM mensajes");
        $stats['total_mensajes'] = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Categoría más popular
        $stmt = $db->query("
            SELECT c.nombre, COUNT(h.id) as total
            FROM categorias c
            LEFT JOIN habilidades h ON c.id = h.categoria_id AND h.activo = true
            GROUP BY c.id, c.nombre
            ORDER BY total DESC
            LIMIT 1
        ");
        $categoria_popular = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['categoria_mas_popular'] = $categoria_popular['nombre'] ?? 'N/A';
        $stats['categoria_mas_popular_count'] = (int) ($categoria_popular['total'] ?? 0);
        
        Response::success($stats, 'Estadísticas obtenidas correctamente');
        
    } catch (Exception $e) {
        error_log("Error obteniendo estadísticas: " . $e->getMessage());
        Response::serverError('Error al obtener estadísticas', $e->getMessage());
    }
}
