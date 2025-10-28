<?php
/**
 * Script para verificar la estructura real de la tabla habilidades
 */

require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    echo "=== ESTRUCTURA TABLA: habilidades ===\n\n";
    
    $sql = "
        SELECT 
            column_name,
            data_type,
            character_maximum_length,
            is_nullable
        FROM information_schema.columns
        WHERE table_name = 'habilidades'
        ORDER BY ordinal_position;
    ";
    
    $stmt = $db->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
