<?php
// DIAGNÓSTICO ULTRA RÁPIDO
echo "<!DOCTYPE html><html><body>";
echo "<h1>🔧 DIAGNÓSTICO RÁPIDO</h1>";

echo "<h2>1. PHP Básico</h2>";
echo "✅ PHP funciona<br>";
echo "Versión: " . phpversion() . "<br>";
echo "Fecha: " . date('Y-m-d H:i:s') . "<br>";

echo "<h2>2. Archivos</h2>";
echo "composer.json: " . (file_exists('composer.json') ? "✅ SÍ" : "❌ NO") . "<br>";
echo "composer.lock: " . (file_exists('composer.lock') ? "✅ SÍ" : "❌ NO") . "<br>";
echo "vendor/: " . (is_dir('vendor') ? "✅ SÍ" : "❌ NO") . "<br>";
echo "vendor/autoload.php: " . (file_exists('vendor/autoload.php') ? "✅ SÍ" : "❌ NO") . "<br>";

if (is_dir('vendor')) {
    $vendor_files = scandir('vendor');
    echo "Archivos en vendor: " . implode(', ', array_slice($vendor_files, 2, 10)) . "<br>";
}

echo "<h2>3. Test de autoload</h2>";
if (file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        echo "✅ Autoload cargado<br>";
        
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            echo "✅ PHPMailer disponible<br>";
        } else {
            echo "❌ PHPMailer NO disponible<br>";
        }
    } catch (Exception $e) {
        echo "❌ Error autoload: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ vendor/autoload.php no existe<br>";
}

echo "<h2>4. Variables de entorno</h2>";
$db = getenv('DATABASE_URL');
$sg = getenv('SENDGRID_API_KEY');
echo "DATABASE_URL: " . ($db ? "✅ OK" : "❌ NO") . "<br>";
echo "SENDGRID_API_KEY: " . ($sg ? "✅ OK" : "❌ NO") . "<br>";

echo "<h2>5. Directorio actual</h2>";
echo "Directorio: " . getcwd() . "<br>";
$files = scandir('.');
echo "Archivos: " . implode(', ', array_slice($files, 2, 15)) . "<br>";

echo "</body></html>";
?>