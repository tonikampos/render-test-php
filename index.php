<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// FUNCIÓN PARA ENVIAR EMAIL CON SENDGRID + cURL
// ============================================
function enviarEmailSendGrid($apiKey, $contador) {
    $data = [
        'personalizations' => [[
            'to' => [['email' => 'kampos@gmail.com', 'name' => 'Toni']]
        ]],
        'from' => ['email' => 'kampos@gmail.com', 'name' => 'GaliTroco'],
        'subject' => '🚀 Prueba de email desde Render - Contador: ' . $contador,
        'content' => [[
            'type' => 'text/html',
            'value' => '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h1 style="color: #667eea;">🎉 ¡Email enviado correctamente!</h1>
                    <p><strong>Contador de visitas:</strong> ' . $contador . '</p>
                    <p><strong>Fecha:</strong> ' . date('Y-m-d H:i:s') . '</p>
                    <p><strong>Servidor:</strong> Render + PHP + Apache</p>
                    <hr style="margin: 20px 0;">
                    <p style="color: #666; font-size: 0.9rem;">
                        Este email se envió desde tu proyecto de TFM usando SendGrid API con cURL nativo.
                    </p>
                </div>
            '
        ]]
    ];
    
    $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // DEBUG
    
    $resultado = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $curlInfo = curl_getinfo($ch);
    curl_close($ch);
    
    return [
        'success' => ($httpCode >= 200 && $httpCode < 300),
        'http_code' => $httpCode,
        'response' => $resultado,
        'error' => $error,
        'curl_info' => $curlInfo
    ];
}

// ============================================
// PROCESAR ENVÍO DE EMAIL SI SE PULSÓ EL BOTÓN
// ============================================
$email_enviado = false;
$email_status = '';

if (isset($_POST['enviar_email'])) {
    $sendgrid_key = getenv('SENDGRID_API_KEY');
    
    if ($sendgrid_key) {
        // Obtener contador actual antes de enviar
        try {
            $db_url = getenv('DATABASE_URL');
            if ($db_url) {
                $db_parts = parse_url($db_url);
                $dsn = "pgsql:host={$db_parts['host']};port=" . ($db_parts['port'] ?? 5432) . ";dbname=" . ltrim($db_parts['path'], '/');
                $conn_temp = new PDO($dsn, $db_parts['user'], $db_parts['pass']);
                $stmt_temp = $conn_temp->query("SELECT contador FROM visitantes WHERE id = 1");
                $result_temp = $stmt_temp->fetch(PDO::FETCH_ASSOC);
                $contador_temp = $result_temp ? $result_temp['contador'] : 0;
                
                // Enviar email
                $resultado_email = enviarEmailSendGrid($sendgrid_key, $contador_temp);
                
                if ($resultado_email['success']) {
                    $email_enviado = true;
                    $email_status = "✅ ¡Email enviado correctamente! (HTTP " . $resultado_email['http_code'] . ")";
                    
                    // DEBUG: Mostrar respuesta completa de SendGrid
                    if (!empty($resultado_email['response'])) {
                        $email_status .= "<br><small style='opacity: 0.8;'>Respuesta: " . htmlspecialchars($resultado_email['response']) . "</small>";
                    }
                } else {
                    $email_status = "❌ Error enviando email: HTTP " . $resultado_email['http_code'];
                    
                    // Mostrar detalles del error
                    if (!empty($resultado_email['response'])) {
                        $email_status .= "<br><small>Respuesta: " . htmlspecialchars($resultado_email['response']) . "</small>";
                    }
                    if (!empty($resultado_email['error'])) {
                        $email_status .= "<br><small>Error cURL: " . htmlspecialchars($resultado_email['error']) . "</small>";
                    }
                }
            }
        } catch (Exception $e) {
            $email_status = "❌ Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $email_status = "❌ SENDGRID_API_KEY no configurada en Render";
    }
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Render + PHP + Supabase + Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .counter {
            font-size: 5rem;
            text-align: center;
            margin: 40px 0;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            font-weight: bold;
        }
        .info {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .success {
            color: #4ade80;
            font-weight: bold;
        }
        .error {
            color: #ff6b6b;
            font-weight: bold;
        }
        .label {
            opacity: 0.8;
            font-size: 0.9rem;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn-email {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px 0 rgba(245, 87, 108, 0.4);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(245, 87, 108, 0.6);
        }
        .btn-email:active {
            transform: translateY(0);
        }
        .email-status {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .email-status.success {
            background: rgba(74, 222, 128, 0.2);
            border: 2px solid #4ade80;
        }
        .email-status.error {
            background: rgba(255, 107, 107, 0.2);
            border: 2px solid #ff6b6b;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚀 Render + PHP + Supabase + Email</h1>";

// Mostrar estado del email si se envió
if ($email_status) {
    $statusClass = $email_enviado ? 'success' : 'error';
    echo "<div class='email-status $statusClass'>$email_status</div>";
}
        
// Conectar a la base de datos
$contador = 0;
$db_status = '';

try {
    $db_url = getenv('DATABASE_URL');
    
    if (!$db_url) {
        throw new Exception('DATABASE_URL no configurada');
    }
    
    $db_parts = parse_url($db_url);
    $host = $db_parts['host'];
    $port = $db_parts['port'] ?? 5432;
    $dbname = ltrim($db_parts['path'], '/');
    $user = $db_parts['user'];
    $pass = $db_parts['pass'];
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    // Incrementar contador
    $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
    
    // Obtener contador
    $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $contador = $result ? $result['contador'] : 0;
    
    $db_status = "<span class='success'>✅ Conectado a Supabase</span>";
    
} catch (Exception $e) {
    $db_status = "❌ Error: " . htmlspecialchars($e->getMessage());
}

echo "<div class='counter'>$contador</div>";
echo "<p style='text-align: center; font-size: 1.2rem; opacity: 0.9;'>visitas totales</p>";

// BOTÓN PARA ENVIAR EMAIL
echo "<div class='btn-container'>";
echo "<form method='POST' style='display: inline;'>";
echo "<button type='submit' name='enviar_email' class='btn-email'>📧 Enviar Email de Prueba</button>";
echo "</form>";
echo "</div>";

// Verificar si SendGrid está configurado
$sendgrid_configurado = getenv('SENDGRID_API_KEY') ? '✅ Configurada' : '❌ No configurada';

echo "<div class='info'>";
echo "<p class='label'>Estado de la base de datos:</p>";
echo "<p>$db_status</p>";
echo "</div>";

echo "<div class='info'>";
echo "<p class='label'>Estado de SendGrid:</p>";
echo "<p><strong>API Key:</strong> $sendgrid_configurado</p>";

// Mostrar información de la API Key (primeros y últimos caracteres)
$api_key = getenv('SENDGRID_API_KEY');
if ($api_key) {
    $key_length = strlen($api_key);
    $key_preview = substr($api_key, 0, 7) . '...' . substr($api_key, -4);
    echo "<p><strong>Key Preview:</strong> <code>$key_preview</code> (longitud: $key_length)</p>";
}

echo "<p><strong>Email remitente:</strong> kampos@gmail.com</p>";
echo "<p><strong>Email destino:</strong> kampos@gmail.com</p>";
echo "<p style='opacity: 0.7; font-size: 0.85rem; margin-top: 10px;'>💡 Pulsa el botón para enviar un email de prueba con el contador actual</p>";
echo "</div>";

echo "<div class='info'>";
echo "<p class='label'>Información del sistema:</p>";
echo "<p><strong>PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Servidor:</strong> Apache</p>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>cURL:</strong> " . (function_exists('curl_version') ? '✅ Disponible' : '❌ No disponible') . "</p>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px; opacity: 0.7;'>";
echo "<p>🔗 GitHub → Render → Supabase → SendGrid</p>";
echo "</div>";

echo "</div>
</body>
</html>";
?>