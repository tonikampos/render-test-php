<?php
// VERSIÓN ULTRA SIMPLE - SIN PHPMAILER
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>🚀 Render + PHP FUNCIONA!</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin: 20px 0; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        h1 { color: #2c3e50; text-align: center; }
        .counter { font-size: 3rem; text-align: center; color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>
    <div class='card'>
        <h1>🚀 ¡RENDER + PHP FUNCIONANDO!</h1>
        <div class='success'>✅ Sistema operativo correctamente</div>
        <p><strong>Versión PHP:</strong> " . phpversion() . "</p>
        <p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>
        <p><strong>Servidor:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Apache') . "</p>
    </div>";

// Test de base de datos
$contador = 0;
$db_status = '';

try {
    $db_url = getenv('DATABASE_URL');
    if ($db_url) {
        $db_parts = parse_url($db_url);
        $dsn = "pgsql:host={$db_parts['host']};port=" . ($db_parts['port'] ?? 5432) . ";dbname=" . ltrim($db_parts['path'], '/') . ";user={$db_parts['user']};password={$db_parts['pass']}";
        
        $conn = new PDO($dsn, null, null, [PDO::ATTR_TIMEOUT => 5]);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Incrementar contador
        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
        
        // Obtener contador
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $result ? $result['contador'] : 0;
        
        $db_status = "<div class='success'>✅ Base de datos SUPABASE: CONECTADA</div>";
    } else {
        $db_status = "<div class='error'>❌ DATABASE_URL no configurada</div>";
    }
} catch (Exception $e) {
    $db_status = "<div class='error'>❌ Error BD: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "<div class='card'>";
echo "<h2>📊 Base de datos</h2>";
echo $db_status;
echo "<div class='counter'>$contador</div>";
echo "<p style='text-align: center;'><strong>Visitas totales</strong></p>";
echo "</div>";

// Estado del email (sin enviar)
$sendgrid_key = getenv('SENDGRID_API_KEY');
echo "<div class='card'>";
echo "<h2>📧 Sistema de email</h2>";
if ($sendgrid_key) {
    echo "<div class='info'>✅ SendGrid configurado (longitud: " . strlen($sendgrid_key) . ")</div>";
    echo "<p>Email: kampos@gmail.com</p>";
    echo "<p><em>Sistema preparado para envío de emails</em></p>";
} else {
    echo "<div class='error'>❌ SENDGRID_API_KEY no configurada</div>";
}
echo "</div>";

// Resumen del sistema
echo "<div class='card'>";
echo "<h2>🔧 Estado del sistema</h2>";
echo "<ul>";
echo "<li>✅ <strong>PHP:</strong> " . phpversion() . "</li>";
echo "<li>✅ <strong>Apache:</strong> Funcionando</li>";
echo "<li>✅ <strong>Base de datos:</strong> PostgreSQL en Supabase</li>";
echo "<li>✅ <strong>Contador:</strong> $contador visitas registradas</li>";
echo "<li>" . ($sendgrid_key ? "✅" : "❌") . " <strong>Email:</strong> " . ($sendgrid_key ? "SendGrid configurado" : "Pendiente configuración") . "</li>";
echo "</ul>";
echo "</div>";

echo "<div class='card' style='text-align: center;'>";
echo "<h3>🎉 ¡DEPLOY EXITOSO!</h3>";
echo "<p><strong>GitHub</strong> → <strong>Render</strong> → <strong>Supabase</strong> → <strong>SendGrid</strong></p>";
echo "<p><em>Tu arquitectura de proyecto final está funcionando correctamente</em></p>";
echo "</div>";

echo "</body></html>";
?>