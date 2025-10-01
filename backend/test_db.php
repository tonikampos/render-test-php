<?php
// Test de conexión a base de datos
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getConnection();
    echo "✅ Conexión exitosa a la base de datos!\n\n";
    
    // Probar query simple
    $stmt = $db->query("SELECT COUNT(*) as total FROM categorias_habilidades");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Total de categorías: " . $result['total'] . "\n\n";
    
    // Listar categorías
    $stmt = $db->query("SELECT id, nombre FROM categorias_habilidades");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Categorías:\n";
    foreach ($categorias as $cat) {
        echo "  - [{$cat['id']}] {$cat['nombre']}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
