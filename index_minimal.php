<?php
// VERSIÓN ULTRA SIMPLE - SIN DEPENDENCIAS EXTERNAS
echo "<!DOCTYPE html><html><head><title>Test Render</title></head><body>";
echo "<h1>🚀 Render Test - Versión Simple</h1>";

// Solo mostrar que PHP funciona
echo "<p>✅ PHP está funcionando correctamente</p>";
echo "<p>Versión: " . phpversion() . "</p>";
echo "<p>Hora: " . date('Y-m-d H:i:s') . "</p>";

// Test básico de base de datos (sin PHPMailer)
$db_url = getenv('DATABASE_URL');
$contador = 0;

if ($db_url) {
    try {
        $db_parts = parse_url($db_url);
        $dsn = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $db_parts['host'],
            $db_parts['port'] ?? 5432,
            ltrim($db_parts['path'], '/'),
            $db_parts['user'],
            $db_parts['pass']
        );
        
        $conn = new PDO($dsn);
        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $resultado ? $resultado['contador'] : 0;
        
        echo "<p>✅ Base de datos: CONECTADA</p>";
        echo "<h2>Contador: $contador visitas</h2>";
        
    } catch (Exception $e) {
        echo "<p>❌ Error BD: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>❌ DATABASE_URL no configurada</p>";
}

// Información sobre SendGrid (sin intentar enviar)
$sendgrid_key = getenv('SENDGRID_API_KEY');
if ($sendgrid_key) {
    echo "<p>✅ SENDGRID_API_KEY configurada</p>";
} else {
    echo "<p>❌ SENDGRID_API_KEY no configurada</p>";
}

echo "<hr>";
echo "<p><a href='/test.php'>Ver phpinfo()</a> | <a href='/simple.php'>Diagnóstico detallado</a></p>";
echo "</body></html>";
?>