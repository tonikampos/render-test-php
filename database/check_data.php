<?php
require_once __DIR__ . '/../backend/config/database.php';

$db = Database::getConnection();

echo "=== VERIFICACIÓN DE DATOS EN SUPABASE ===\n\n";

// Usuarios
$stmt = $db->query('SELECT id, nombre_usuario, email FROM usuarios ORDER BY id');
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "USUARIOS (" . count($usuarios) . "):\n";
foreach ($usuarios as $u) {
    echo "  - ID:{$u['id']} | {$u['nombre_usuario']} ({$u['email']})\n";
}
echo "\n";

// Habilidades
$stmt = $db->query('SELECT id, titulo, usuario_id, tipo FROM habilidades ORDER BY id LIMIT 20');
$habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "HABILIDADES (" . count($habilidades) . " mostradas):\n";
foreach ($habilidades as $h) {
    echo "  - ID:{$h['id']} | {$h['titulo']} | Tipo:{$h['tipo']} | Usuario:{$h['usuario_id']}\n";
}
echo "\n";

// Categorías
$stmt = $db->query('SELECT id, nombre FROM categorias_habilidades ORDER BY id');
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "CATEGORÍAS (" . count($categorias) . "):\n";
foreach ($categorias as $c) {
    echo "  - ID:{$c['id']} | {$c['nombre']}\n";
}
