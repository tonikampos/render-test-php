<?php
require_once __DIR__ . '/../backend/config/database.php';

$db = Database::getConnection();

echo "=== INFORMACIÓN DE CONEXIÓN ===\n\n";

// Obtener información de la conexión actual
$stmt = $db->query("SELECT current_database(), current_user, inet_server_addr(), inet_server_port()");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Base de datos: " . $info['current_database'] . "\n";
echo "Usuario: " . $info['current_user'] . "\n";
echo "Host: " . ($info['inet_server_addr'] ?? 'localhost') . "\n";
echo "Puerto: " . ($info['inet_server_port'] ?? '5432') . "\n\n";

// Ver si es Supabase o local
$database_url = getenv('DATABASE_URL');
if ($database_url) {
    $db_parts = parse_url($database_url);
    echo "🌐 Conectado vía DATABASE_URL (Supabase)\n";
    echo "Host: " . $db_parts['host'] . "\n\n";
} else {
    echo "💻 Conectado a base de datos LOCAL\n\n";
}

// Contar registros
echo "=== DATOS ACTUALES ===\n\n";
$stmt = $db->query('SELECT COUNT(*) as total FROM habilidades');
$r = $stmt->fetch();
echo "Habilidades totales: " . $r['total'] . "\n\n";

// Mostrar todas las habilidades
$stmt = $db->query('SELECT id, titulo, tipo FROM habilidades ORDER BY id');
$habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "LISTA DE HABILIDADES:\n";
echo str_repeat("-", 80) . "\n";
foreach ($habilidades as $h) {
    echo "ID:{$h['id']} | Tipo:{$h['tipo']} | {$h['titulo']}\n";
}
