<?php<?php

error_reporting(E_ALL);// VERSIÓN CON EMAIL AÑADIDO DE FORMA SEGURA

ini_set('display_errors', 1);error_reporting(E_ALL);

ini_set('display_errors', 1);

echo "<!DOCTYPE html>

<html>// CARGAR PHPMAILER AL INICIO (FUERA DE CONDICIONALES)

<head>$phpmailer_available = false;

    <meta charset='UTF-8'>$phpmailer_error = '';

    <title>Render + PHP + Supabase</title>

    <style>if (file_exists('vendor/autoload.php')) {

        body {    try {

            font-family: Arial, sans-serif;        require_once 'vendor/autoload.php';

            max-width: 800px;        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {

            margin: 50px auto;            $phpmailer_available = true;

            padding: 20px;        } else {

            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);            $phpmailer_error = 'Clase PHPMailer no encontrada';

            color: white;        }

        }    } catch (Throwable $e) {

        .container {        $phpmailer_error = 'Error cargando autoload: ' . $e->getMessage();

            background: rgba(255, 255, 255, 0.1);    }

            padding: 30px;} else {

            border-radius: 15px;    $phpmailer_error = 'vendor/autoload.php no existe';

            backdrop-filter: blur(10px);}

            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);

        }echo "<!DOCTYPE html>

        h1 {<html>

            text-align: center;<head>

            font-size: 2.5rem;    <meta charset='UTF-8'>

            margin-bottom: 30px;    <title>🚀 Render + PHP + Email</title>

            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);    <style>

        }        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }

        .counter {        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin: 20px 0; }

            font-size: 5rem;        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }

            text-align: center;        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }

            margin: 40px 0;        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }

            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);        h1 { color: #2c3e50; text-align: center; }

            font-weight: bold;        .counter { font-size: 3rem; text-align: center; color: #e74c3c; font-weight: bold; }

        }    </style>

        .info {</head>

            background: rgba(255, 255, 255, 0.2);<body>

            padding: 20px;    <div class='card'>

            border-radius: 10px;        <h1>🚀 ¡RENDER + PHP + EMAIL!</h1>

            margin: 20px 0;        <div class='success'>✅ Sistema funcionando correctamente</div>

        }        <p><strong>Versión PHP:</strong> " . phpversion() . "</p>

        .success {        <p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>

            color: #4ade80;        <p><strong>PHPMailer:</strong> " . ($phpmailer_available ? "✅ Disponible" : "❌ " . $phpmailer_error) . "</p>

            font-weight: bold;    </div>";

        }

        .label {// Test de base de datos

            opacity: 0.8;$contador = 0;

            font-size: 0.9rem;$db_status = '';

        }

    </style>try {

</head>    $db_url = getenv('DATABASE_URL');

<body>    if ($db_url) {

    <div class='container'>        $db_parts = parse_url($db_url);

        <h1>🚀 Render + PHP + Supabase</h1>";        $dsn = "pgsql:host={$db_parts['host']};port=" . ($db_parts['port'] ?? 5432) . ";dbname=" . ltrim($db_parts['path'], '/') . ";user={$db_parts['user']};password={$db_parts['pass']}";

        

// Conectar a la base de datos        $conn = new PDO($dsn, null, null, [PDO::ATTR_TIMEOUT => 5]);

$contador = 0;        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db_status = '';        

        // Incrementar contador

try {        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");

    $db_url = getenv('DATABASE_URL');        

            // Obtener contador

    if (!$db_url) {        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");

        throw new Exception('DATABASE_URL no configurada');        $result = $stmt->fetch(PDO::FETCH_ASSOC);

    }        $contador = $result ? $result['contador'] : 0;

            

    $db_parts = parse_url($db_url);        $db_status = "<div class='success'>✅ Base de datos SUPABASE: CONECTADA</div>";

    $host = $db_parts['host'];    } else {

    $port = $db_parts['port'] ?? 5432;        $db_status = "<div class='error'>❌ DATABASE_URL no configurada</div>";

    $dbname = ltrim($db_parts['path'], '/');    }

    $user = $db_parts['user'];} catch (Exception $e) {

    $pass = $db_parts['pass'];    $db_status = "<div class='error'>❌ Error BD: " . htmlspecialchars($e->getMessage()) . "</div>";

    }

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    $conn = new PDO($dsn, $user, $pass, [echo "<div class='card'>";

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,echo "<h2>📊 Base de datos</h2>";

        PDO::ATTR_TIMEOUT => 5echo $db_status;

    ]);echo "<div class='counter'>$contador</div>";

    echo "<p style='text-align: center;'><strong>Visitas totales</strong></p>";

    // Incrementar contadorecho "</div>";

    $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");

    // ENVÍO DE EMAIL - VERSIÓN SEGURA

    // Obtener contador$email_status = '';

    $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");$sendgrid_key = getenv('SENDGRID_API_KEY');

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $contador = $result ? $result['contador'] : 0;echo "<div class='card'>";

    echo "<h2>📧 Sistema de email</h2>";

    $db_status = "<span class='success'>✅ Conectado a Supabase</span>";

    if ($sendgrid_key && $phpmailer_available) {

} catch (Exception $e) {    echo "<div class='info'>✅ SendGrid y PHPMailer configurados</div>";

    $db_status = "❌ Error: " . htmlspecialchars($e->getMessage());    

}    // INTENTAR ENVÍO DE EMAIL DE FORMA SEGURA

    try {

echo "<div class='counter'>$contador</div>";        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

echo "<p style='text-align: center; font-size: 1.2rem; opacity: 0.9;'>visitas totales</p>";        

        // Configuración SMTP básica

echo "<div class='info'>";        $mail->isSMTP();

echo "<p class='label'>Estado de la base de datos:</p>";        $mail->Host = 'smtp.sendgrid.net';

echo "<p>$db_status</p>";        $mail->SMTPAuth = true;

echo "</div>";        $mail->Username = 'apikey';

        $mail->Password = $sendgrid_key;

echo "<div class='info'>";        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;

echo "<p class='label'>Información del sistema:</p>";        $mail->Port = 587;

echo "<p><strong>PHP:</strong> " . phpversion() . "</p>";        

echo "<p><strong>Servidor:</strong> Apache</p>";        // Configurar emails

echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";        $mail->setFrom('kampos@gmail.com', 'GaliTroco');

echo "</div>";        $mail->addAddress('kampos@gmail.com', 'Toni');

        

echo "<div style='text-align: center; margin-top: 30px; opacity: 0.7;'>";        // Contenido simple

echo "<p>🔗 GitHub → Render → Supabase</p>";        $mail->isHTML(true);

echo "</div>";        $mail->Subject = 'Nueva visita en GaliTroco - Contador: ' . $contador;

        $mail->Body = "<h1>¡Nueva visita!</h1><p>Contador: <strong>$contador</strong></p><p>Fecha: " . date('Y-m-d H:i:s') . "</p>";

echo "</div>        

</body>        // ENVIAR

</html>";        $mail->send();

?>        $email_status = "<div class='success'>🎉 ¡Email enviado exitosamente!</div>";

        
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