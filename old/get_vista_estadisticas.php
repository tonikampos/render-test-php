<?php
/**
 * Script para obtener la definición de la VISTA estadisticas_usuarios
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    // Consultar pg_views que es la tabla del sistema que contiene las vistas
    $sql = "SELECT 
                schemaname,
                viewname,
                viewowner,
                definition
            FROM pg_views 
            WHERE schemaname = 'public' 
            AND viewname = 'estadisticas_usuarios'";
    
    $stmt = $db->query($sql);
    $view = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($view) {
        echo "=== VISTA: estadisticas_usuarios ===\n\n";
        echo "Schema: {$view['schemaname']}\n";
        echo "Owner: {$view['viewowner']}\n\n";
        echo "DEFINICIÓN:\n";
        echo str_repeat("=", 80) . "\n";
        echo $view['definition'];
        echo "\n" . str_repeat("=", 80) . "\n\n";
        
        // Generar el CREATE VIEW completo
        echo "SQL COMPLETO PARA schema.sql:\n";
        echo str_repeat("=", 80) . "\n";
        echo "CREATE OR REPLACE VIEW estadisticas_usuarios AS\n";
        echo $view['definition'];
        echo ";\n";
        echo str_repeat("=", 80) . "\n";
    } else {
        echo "❌ Vista no encontrada en pg_views\n";
        
        // Intentar de forma alternativa
        echo "\nIntentando obtener desde information_schema.views...\n";
        $sql2 = "SELECT view_definition FROM information_schema.views 
                 WHERE table_schema = 'public' AND table_name = 'estadisticas_usuarios'";
        $stmt2 = $db->query($sql2);
        $view2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        
        if ($view2) {
            echo "✅ Encontrada!\n\n";
            echo $view2['view_definition'];
        } else {
            echo "❌ Tampoco encontrada en information_schema.views\n";
        }
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
