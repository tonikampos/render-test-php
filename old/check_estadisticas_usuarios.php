<?php
/**
 * Script para verificar si estadisticas_usuarios es tabla o vista
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    echo "=== VERIFICACIÓN: estadisticas_usuarios ===\n\n";
    
    // Verificar si es tabla
    $sql_table = "SELECT table_name FROM information_schema.tables 
                  WHERE table_schema = 'public' AND table_name = 'estadisticas_usuarios'";
    $stmt = $db->query($sql_table);
    $is_table = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si es vista
    $sql_view = "SELECT table_name FROM information_schema.views 
                 WHERE table_schema = 'public' AND table_name = 'estadisticas_usuarios'";
    $stmt2 = $db->query($sql_view);
    $is_view = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if ($is_table) {
        echo "✅ ES UNA TABLA\n";
    } elseif ($is_view) {
        echo "✅ ES UNA VISTA (VIEW)\n";
        
        // Obtener definición de la vista
        $sql_def = "SELECT definition FROM pg_views 
                    WHERE schemaname = 'public' AND viewname = 'estadisticas_usuarios'";
        $stmt3 = $db->query($sql_def);
        $def = $stmt3->fetch(PDO::FETCH_ASSOC);
        
        echo "\nDEFINICIÓN DE LA VISTA:\n";
        echo str_repeat("-", 80) . "\n";
        echo $def['definition'];
        echo "\n" . str_repeat("-", 80) . "\n";
    } else {
        echo "❌ NO EXISTE (ni tabla ni vista)\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
