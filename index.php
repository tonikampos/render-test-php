<?php
// VERSIÓN COMPLETAMENTE NUEVA Y SIMPLE
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Render Test - Funcionando</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🚀 Render + PHP Test</h1>";

echo "<div class='success'>✅ PHP está funcionando correctamente</div>";
echo "<p>Versión PHP: " . phpversion() . "</p>";
echo "<p>Fecha: " . date('Y-m-d H:i:s') . "</p>";

// Test básico de base de datos SIN dependencias externas
$contador = 0;
$db_status = '';

try {
    $db_url = getenv('DATABASE_URL');
    if ($db_url) {
        $db_parts = parse_url($db_url);
        $dsn = "pgsql:host={$db_parts['host']};port=" . ($db_parts['port'] ?? 5432) . ";dbname=" . ltrim($db_parts['path'], '/') . ";user={$db_parts['user']};password={$db_parts['pass']}";
        
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Incrementar contador
        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
        
        // Obtener contador
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $result ? $result['contador'] : 0;
        
        $db_status = "<div class='success'>✅ Base de datos: CONECTADA</div>";
    } else {
        $db_status = "<div class='error'>❌ DATABASE_URL no configurada</div>";
    }
} catch (Exception $e) {
    $db_status = "<div class='error'>❌ Error BD: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo $db_status;
echo "<h2>Contador de visitas: $contador</h2>";

// Info sobre SendGrid (sin intentar usar PHPMailer)
$sendgrid_key = getenv('SENDGRID_API_KEY');
if ($sendgrid_key) {
    echo "<div class='info'>📧 SendGrid configurado (longitud: " . strlen($sendgrid_key) . ")</div>";
} else {
    echo "<div class='error'>❌ SENDGRID_API_KEY no configurada</div>";
}

echo "<hr>";
echo "<p><a href='/static.html'>Test HTML estático</a></p>";
echo "<p>Deploy: Render | BD: Supabase | Estado: FUNCIONANDO</p>";

echo "</body></html>";
?>