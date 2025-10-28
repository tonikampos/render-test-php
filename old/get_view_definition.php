<?php
/**
 * Script para obtener la definición de la vista estadisticas_usuarios
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    // Como es una tabla, vamos a obtener su estructura
    $sql = "SELECT 
                column_name, 
                data_type, 
                is_nullable,
                column_default
            FROM information_schema.columns 
            WHERE table_schema = 'public' 
            AND table_name = 'estadisticas_usuarios'
            ORDER BY ordinal_position";
    
    $stmt = $db->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "=== ESTRUCTURA DE estadisticas_usuarios ===\n\n";
    
    if ($columns) {
        echo "Es una TABLA con las siguientes columnas:\n\n";
        foreach ($columns as $col) {
            echo sprintf("- %-30s %s %s %s\n", 
                $col['column_name'],
                $col['data_type'],
                $col['is_nullable'] === 'NO' ? 'NOT NULL' : 'NULL',
                $col['column_default'] ? "DEFAULT {$col['column_default']}" : ''
            );
        }
        
        // Verificar si es una vista materializada
        $sql_mat = "SELECT matviewname FROM pg_matviews WHERE schemaname = 'public' AND matviewname = 'estadisticas_usuarios'";
        $stmt_mat = $db->query($sql_mat);
        $is_materialized = $stmt_mat->fetch(PDO::FETCH_ASSOC);
        
        if ($is_materialized) {
            echo "\n✅ Es una VISTA MATERIALIZADA (MATERIALIZED VIEW)\n";
        }
        
    } else {
        echo "❌ No se encontraron columnas\n";
    }
    
    // Intentar obtener datos de ejemplo
    echo "\n=== DATOS DE EJEMPLO ===\n\n";
    $sql_data = "SELECT * FROM estadisticas_usuarios LIMIT 3";
    $stmt_data = $db->query($sql_data);
    $data = $stmt_data->fetchAll(PDO::FETCH_ASSOC);
    
    if ($data) {
        print_r($data);
    } else {
        echo "No hay datos\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
