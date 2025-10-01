<?php
// VERSIÓN CON ENVÍO DE EMAIL SEGURO
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Render Test - Con SendGrid</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .warning { color: orange; background: #fff3cd; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🚀 Render + PHP + SendGrid</h1>";

echo "<div class='success'>✅ PHP está funcionando correctamente</div>";
echo "<p>Versión PHP: " . phpversion() . "</p>";
echo "<p>Fecha: " . date('Y-m-d H:i:s') . "</p>";

// Test básico de base de datos
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

// ---- NUEVA SECCIÓN: ENVÍO DE EMAIL ----
$email_status = '';
$sendgrid_key = getenv('SENDGRID_API_KEY');

if ($sendgrid_key) {
    echo "<div class='info'>📧 SendGrid configurado (longitud: " . strlen($sendgrid_key) . ")</div>";
    
    // Verificar si PHPMailer está disponible
    if (file_exists('vendor/autoload.php')) {
        try {
            require_once 'vendor/autoload.php';
            
            echo "<div class='success'>✅ PHPMailer cargado correctamente</div>";
            
            // Intentar enviar email
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                
                // Configuración SMTP de SendGrid
                $mail->isSMTP();
                $mail->Host = 'smtp.sendgrid.net';
                $mail->SMTPAuth = true;
                $mail->Username = 'apikey';
                $mail->Password = $sendgrid_key;
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Configurar remitente y destinatario
                $mail->setFrom('kampos@gmail.com', 'GaliTroco App');
                $mail->addAddress('kampos@gmail.com', 'Toni');
                
                // Contenido del email
                $mail->isHTML(true);
                $mail->Subject = '🎉 Nueva visita en GaliTroco - Render funcionando!';
                $mail->Body = "
                    <h1>🚀 ¡Visita detectada en tu app!</h1>
                    <p>Tu aplicación de prueba en Render ha registrado una nueva visita.</p>
                    <p><strong>Contador actual:</strong> $contador visitas</p>
                    <p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>
                    <p><strong>Estado:</strong> ✅ Sistema funcionando correctamente</p>
                    <hr>
                    <p><em>Deploy: Render | BD: Supabase | Email: SendGrid</em></p>
                ";
                
                // Enviar el email
                $mail->send();
                $email_status = "<div class='success'>🎉 ¡Email enviado exitosamente! Revisa tu bandeja de entrada.</div>";
                
            } catch (Exception $e) {
                $email_status = "<div class='error'>❌ Error enviando email: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
            
        } catch (Exception $e) {
            $email_status = "<div class='error'>❌ Error cargando PHPMailer: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        $email_status = "<div class='warning'>⚠️ PHPMailer no encontrado (vendor/autoload.php)</div>";
    }
} else {
    $email_status = "<div class='error'>❌ SENDGRID_API_KEY no configurada</div>";
}

echo $email_status;

echo "<hr>";
echo "<div class='info'>";
echo "<p><strong>Estado del sistema:</strong></p>";
echo "<ul>";
echo "<li>✅ PHP: " . phpversion() . "</li>";
echo "<li>✅ Base de datos: Supabase PostgreSQL</li>";
echo "<li>✅ Contador: $contador visitas</li>";
echo "<li>" . ($sendgrid_key ? "✅" : "❌") . " SendGrid: " . ($sendgrid_key ? "Configurado" : "No configurado") . "</li>";
echo "<li>" . (file_exists('vendor/autoload.php') ? "✅" : "❌") . " PHPMailer: " . (file_exists('vendor/autoload.php') ? "Disponible" : "No disponible") . "</li>";
echo "</ul>";
echo "</div>";

echo "<p><a href='/static.html'>Test HTML estático</a> | <a href='/healthcheck.php'>Health Check</a></p>";
echo "<p><strong>Deploy:</strong> Render | <strong>BD:</strong> Supabase | <strong>Email:</strong> SendGrid</p>";

echo "</body></html>";
?>