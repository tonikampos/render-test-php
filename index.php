<?php
// VERSIÓN CON EMAIL AÑADIDO DE FORMA SEGURA
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CARGAR PHPMAILER AL INICIO (FUERA DE CONDICIONALES)
$phpmailer_available = false;
$phpmailer_error = '';

if (file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            $phpmailer_available = true;
        } else {
            $phpmailer_error = 'Clase PHPMailer no encontrada';
        }
    } catch (Throwable $e) {
        $phpmailer_error = 'Error cargando autoload: ' . $e->getMessage();
    }
} else {
    $phpmailer_error = 'vendor/autoload.php no existe';
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>🚀 Render + PHP + Email</title>
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
        <h1>🚀 ¡RENDER + PHP + EMAIL!</h1>
        <div class='success'>✅ Sistema funcionando correctamente</div>
        <p><strong>Versión PHP:</strong> " . phpversion() . "</p>
        <p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>
        <p><strong>PHPMailer:</strong> " . ($phpmailer_available ? "✅ Disponible" : "❌ " . $phpmailer_error) . "</p>
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

// ENVÍO DE EMAIL - VERSIÓN SEGURA
$email_status = '';
$sendgrid_key = getenv('SENDGRID_API_KEY');

echo "<div class='card'>";
echo "<h2>📧 Sistema de email</h2>";

if ($sendgrid_key && $phpmailer_available) {
    echo "<div class='info'>✅ SendGrid y PHPMailer configurados</div>";
    
    // INTENTAR ENVÍO DE EMAIL DE FORMA SEGURA
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Configuración SMTP básica
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey';
        $mail->Password = $sendgrid_key;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Configurar emails
        $mail->setFrom('kampos@gmail.com', 'GaliTroco');
        $mail->addAddress('kampos@gmail.com', 'Toni');
        
        // Contenido simple
        $mail->isHTML(true);
        $mail->Subject = 'Nueva visita en GaliTroco - Contador: ' . $contador;
        $mail->Body = "<h1>¡Nueva visita!</h1><p>Contador: <strong>$contador</strong></p><p>Fecha: " . date('Y-m-d H:i:s') . "</p>";
        
        // ENVIAR
        $mail->send();
        $email_status = "<div class='success'>🎉 ¡Email enviado exitosamente!</div>";
        
    } catch (Exception $e) {
        $email_status = "<div class='error'>❌ Error enviando: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    
} elseif (!$sendgrid_key) {
    $email_status = "<div class='error'>❌ SENDGRID_API_KEY no configurada</div>";
} elseif (!$phpmailer_available) {
    $email_status = "<div class='error'>❌ PHPMailer no disponible: $phpmailer_error</div>";
}

echo $email_status;
echo "</div>";

// Resumen
echo "<div class='card'>";
echo "<h2>🔧 Estado del sistema</h2>";
echo "<ul>";
echo "<li>✅ <strong>PHP:</strong> " . phpversion() . "</li>";
echo "<li>✅ <strong>Apache:</strong> Funcionando</li>";
echo "<li>✅ <strong>Base de datos:</strong> $contador visitas</li>";
echo "<li>" . ($phpmailer_available ? "✅" : "❌") . " <strong>PHPMailer:</strong> " . ($phpmailer_available ? "Disponible" : $phpmailer_error) . "</li>";
echo "<li>" . ($sendgrid_key ? "✅" : "❌") . " <strong>SendGrid:</strong> " . ($sendgrid_key ? "Configurado" : "No configurado") . "</li>";
echo "</ul>";
echo "</div>";

echo "<div class='card' style='text-align: center;'>";
echo "<h3>🎉 DEPLOY CON EMAIL FUNCIONANDO</h3>";
echo "<p><strong>GitHub</strong> → <strong>Render</strong> → <strong>Supabase</strong> → <strong>SendGrid</strong></p>";
echo "</div>";

echo "</body></html>";
?>