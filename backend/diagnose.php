<?php
/**
 * Script de diagnóstico para verificar configuración
 */

header('Content-Type: application/json');

$diagnostics = [
    'php_version' => PHP_VERSION,
    'timestamp' => date('Y-m-d H:i:s'),
    'environment' => getenv('ENVIRONMENT') ?: 'development',
    'database_url_configured' => !empty(getenv('DATABASE_URL')),
    'extensions' => [
        'pdo' => extension_loaded('pdo'),
        'pdo_pgsql' => extension_loaded('pdo_pgsql'),
    ],
    'memory_limit' => ini_get('memory_limit'),
    'timezone' => date_default_timezone_get()
];

// Intentar conexión (sin revelar credenciales)
try {
    require_once __DIR__ . '/config/database.php';
    $db = Database::getConnection();
    $diagnostics['database_connection'] = 'SUCCESS';
    
    // Test query simple
    $stmt = $db->query("SELECT 1 as test");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $diagnostics['database_query'] = $result ? 'SUCCESS' : 'FAILED';
    
} catch (Exception $e) {
    $diagnostics['database_connection'] = 'FAILED';
    $diagnostics['database_error'] = $e->getMessage();
}

echo json_encode($diagnostics, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
