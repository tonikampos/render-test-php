<?php
/**
 * Script para listar TODAS las tablas en Supabase y comparar con schema_production.sql
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    echo "=== TODAS LAS TABLAS EN SUPABASE ===\n\n";
    
    // Obtener todas las tablas del schema public
    $sql = "
        SELECT table_name, table_type
        FROM information_schema.tables
        WHERE table_schema = 'public'
        AND table_type = 'BASE TABLE'
        ORDER BY table_name
    ";
    
    $stmt = $db->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total de tablas encontradas: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        echo "- " . $table['table_name'] . "\n";
    }
    
    // Tablas en schema_production.sql
    echo "\n\n=== TABLAS EN schema_production.sql ===\n\n";
    
    $schema_tables = [
        'categorias_habilidades',
        'conversaciones',
        'habilidades',
        'intercambios',
        'mensajes',
        'notificaciones',
        'participantes_conversacion',
        'password_resets',
        'reportes',
        'sesiones',
        'usuarios',
        'valoraciones'
    ];
    
    echo "Total en schema: " . count($schema_tables) . "\n\n";
    
    foreach ($schema_tables as $table) {
        echo "- " . $table . "\n";
    }
    
    // Comparar
    echo "\n\n=== TABLAS FALTANTES EN schema_production.sql ===\n\n";
    
    $supabase_table_names = array_column($tables, 'table_name');
    $missing = array_diff($supabase_table_names, $schema_tables);
    
    if (empty($missing)) {
        echo "✅ No hay tablas faltantes\n";
    } else {
        echo "⚠️ Tablas encontradas en Supabase pero NO en schema_production.sql:\n\n";
        foreach ($missing as $table) {
            echo "- " . $table . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
