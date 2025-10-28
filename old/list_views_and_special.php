<?php
/**
 * Script para listar TODAS las vistas y tablas especiales
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    echo "=== VISTAS (VIEWS) EN SUPABASE ===\n\n";
    
    // Obtener todas las vistas
    $sql_views = "
        SELECT table_name
        FROM information_schema.views
        WHERE table_schema = 'public'
        ORDER BY table_name
    ";
    
    $stmt = $db->query($sql_views);
    $views = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total de vistas: " . count($views) . "\n\n";
    
    if (empty($views)) {
        echo "❌ No hay vistas en el schema public\n";
    } else {
        foreach ($views as $view) {
            echo "- " . $view['table_name'] . "\n";
        }
    }
    
    // Verificar específicamente estadisticas_usuarios y visitantes
    echo "\n\n=== VERIFICACIÓN ESPECÍFICA ===\n\n";
    
    $special_tables = ['estadisticas_usuarios', 'visitantes'];
    
    foreach ($special_tables as $name) {
        echo "Buscando '$name'...\n";
        
        // Es tabla?
        $sql_t = "SELECT 1 FROM information_schema.tables 
                  WHERE table_schema = 'public' AND table_name = '$name' AND table_type = 'BASE TABLE'";
        $is_table = $db->query($sql_t)->fetch();
        
        // Es vista?
        $sql_v = "SELECT 1 FROM information_schema.views 
                  WHERE table_schema = 'public' AND table_name = '$name'";
        $is_view = $db->query($sql_v)->fetch();
        
        if ($is_table) {
            echo "  ✅ ES TABLA\n";
            
            // Obtener estructura
            $sql_cols = "SELECT column_name, data_type, character_maximum_length 
                         FROM information_schema.columns 
                         WHERE table_name = '$name' ORDER BY ordinal_position";
            $stmt_cols = $db->query($sql_cols);
            $cols = $stmt_cols->fetchAll(PDO::FETCH_ASSOC);
            
            echo "  Columnas:\n";
            foreach ($cols as $col) {
                $length = $col['character_maximum_length'] ? "({$col['character_maximum_length']})" : "";
                echo "    - {$col['column_name']}: {$col['data_type']}{$length}\n";
            }
            
        } elseif ($is_view) {
            echo "  ✅ ES VISTA\n";
            
            // Obtener definición
            $sql_def = "SELECT definition FROM pg_views 
                        WHERE schemaname = 'public' AND viewname = '$name'";
            $stmt_def = $db->query($sql_def);
            $def = $stmt_def->fetch(PDO::FETCH_ASSOC);
            
            echo "  Definición:\n";
            echo "  " . str_repeat("-", 70) . "\n";
            echo "  " . $def['definition'] . "\n";
            echo "  " . str_repeat("-", 70) . "\n";
            
        } else {
            echo "  ❌ NO EXISTE\n";
        }
        
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
