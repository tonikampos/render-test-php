<?php
// Test de acceso a backend desde raíz
echo "Test desde raíz\n\n";

echo "1. Verificando estructura de directorios:\n";
$backend_exists = is_dir(__DIR__ . '/backend');
echo "¿Existe /backend/? " . ($backend_exists ? "SÍ" : "NO") . "\n";

if ($backend_exists) {
    echo "\n2. Archivos en /backend/:\n";
    $files = scandir(__DIR__ . '/backend');
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "  - $file\n";
        }
    }
}

echo "\n3. Intentando incluir config/database.php:\n";
$db_path = __DIR__ . '/backend/config/database.php';
echo "Ruta: $db_path\n";
echo "¿Existe? " . (file_exists($db_path) ? "SÍ" : "NO") . "\n";
echo "¿Es legible? " . (is_readable($db_path) ? "SÍ" : "NO") . "\n";

if (file_exists($db_path) && is_readable($db_path)) {
    try {
        require_once $db_path;
        echo "✅ Incluido correctamente\n";
        
        // Intentar conexión
        echo "\n4. Intentando conectar a BD:\n";
        $db = Database::getConnection();
        echo "✅ Conexión exitosa\n";
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}
