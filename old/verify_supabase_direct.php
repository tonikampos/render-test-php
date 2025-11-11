<?php
/**
 * Verificación DIRECTA a Supabase sin usar Database.php
 * Para asegurarnos de que estamos viendo la BD correcta
 */

echo "=== CONEXIÓN DIRECTA A SUPABASE ===\n\n";

// Lee las credenciales de Supabase desde las variables de entorno del sistema
$database_url = getenv('DATABASE_URL');

if (!$database_url) {
    die("❌ ERROR: DATABASE_URL no está configurada.\n");
}

echo "✅ DATABASE_URL encontrada\n";

// Parsear la URL
$db_parts = parse_url($database_url);
$host = $db_parts['host'];
$port = $db_parts['port'] ?? 5432;
$dbname = ltrim($db_parts['path'], '/');
$user = $db_parts['user'];
$password = $db_parts['pass'];

echo "\nConectando a:\n";
echo "  Host: {$host}\n";
echo "  Puerto: {$port}\n";
echo "  Base de datos: {$dbname}\n";
echo "  Usuario: {$user}\n\n";

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "✅ Conexión exitosa\n\n";
    
    // Verificar que estamos en Supabase
    $stmt = $pdo->query("SELECT current_database(), inet_server_addr()");
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Base de datos actual: {$info['current_database']}\n";
    echo "Dirección del servidor: {$info['inet_server_addr']}\n\n";
    
    // Contar habilidades
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM habilidades");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "=== HABILIDADES EN SUPABASE ===\n";
    echo "Total: {$count['total']}\n\n";
    
    // Listar todas
    $stmt = $pdo->query("SELECT id, titulo, tipo, usuario_id FROM habilidades ORDER BY id");
    $habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($habilidades)) {
        echo "❌ NO HAY HABILIDADES EN LA BASE DE DATOS\n";
    } else {
        foreach ($habilidades as $h) {
            echo "  [{$h['id']}] {$h['titulo']} (Tipo: {$h['tipo']}, Usuario: {$h['usuario_id']})\n";
        }
    }
    
    echo "\n";
    
    // Usuarios
    $stmt = $pdo->query("SELECT id, nombre_usuario, email FROM usuarios ORDER BY id");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "=== USUARIOS EN SUPABASE ===\n";
    echo "Total: " . count($usuarios) . "\n\n";
    foreach ($usuarios as $u) {
        echo "  [{$u['id']}] {$u['nombre_usuario']} ({$u['email']})\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
