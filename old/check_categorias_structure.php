<?php
/**
 * Script para verificar la estructura real de la tabla categorias_habilidades
 * en la base de datos de producción (Supabase)
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    echo "=== VERIFICACIÓN ESTRUCTURA: categorias_habilidades ===\n\n";
    
    // Obtener estructura de la tabla
    $sql = "
        SELECT 
            column_name,
            data_type,
            character_maximum_length,
            column_default,
            is_nullable
        FROM information_schema.columns
        WHERE table_name = 'categorias_habilidades'
        ORDER BY ordinal_position;
    ";
    
    $stmt = $db->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "COLUMNAS DE LA TABLA:\n";
    echo str_repeat("-", 80) . "\n";
    printf("%-30s %-20s %-15s %-10s\n", "COLUMNA", "TIPO", "LONGITUD", "NULLABLE");
    echo str_repeat("-", 80) . "\n";
    
    foreach ($columns as $col) {
        printf(
            "%-30s %-20s %-15s %-10s\n",
            $col['column_name'],
            $col['data_type'],
            $col['character_maximum_length'] ?? 'N/A',
            $col['is_nullable']
        );
    }
    
    echo "\n\n=== DATOS ACTUALES EN LA TABLA ===\n\n";
    
    // Obtener datos actuales
    $sql2 = "SELECT * FROM categorias_habilidades LIMIT 3";
    $stmt2 = $db->query($sql2);
    $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($rows)) {
        echo "⚠️ La tabla está vacía\n";
    } else {
        echo "Primeras 3 filas:\n";
        echo str_repeat("-", 80) . "\n";
        print_r($rows);
    }
    
    echo "\n✅ Verificación completada\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
