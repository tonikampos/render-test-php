<?php
// DIAGNÓSTICO BÁSICO SIN DEPENDENCIAS
echo "<!DOCTYPE html><html><head><title>Test Básico</title></head><body>";
echo "<h1>🟢 PHP Funciona</h1>";
echo "<p>Versión PHP: " . phpversion() . "</p>";
echo "<p>Fecha: " . date('Y-m-d H:i:s') . "</p>";

// Test de extensiones básicas
echo "<h2>Extensiones PHP:</h2><ul>";
$extensiones = ['pdo', 'pdo_pgsql', 'mbstring', 'openssl', 'curl'];
foreach ($extensiones as $ext) {
    $status = extension_loaded($ext) ? "✅" : "❌";
    echo "<li>$ext: $status</li>";
}
echo "</ul>";

// Test de archivos
echo "<h2>Archivos:</h2><ul>";
$archivos = ['vendor/autoload.php', 'composer.json', 'composer.lock'];
foreach ($archivos as $archivo) {
    $status = file_exists($archivo) ? "✅" : "❌";
    echo "<li>$archivo: $status</li>";
}
echo "</ul>";

// Test de variables de entorno
echo "<h2>Variables de entorno:</h2><ul>";
$vars = ['DATABASE_URL', 'SENDGRID_API_KEY'];
foreach ($vars as $var) {
    $valor = getenv($var);
    $status = $valor ? "✅ (longitud: " . strlen($valor) . ")" : "❌";
    echo "<li>$var: $status</li>";
}
echo "</ul>";

echo "</body></html>";
?>