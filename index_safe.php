<?php
// VERSIÓN DE RESPALDO CON MANEJO DE ERRORES ROBUSTO
// Usar solo si el index.php principal falla

// Configuración de errores para producción
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');

// Función para capturar errores fatales
function shutdown_handler() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo "<!DOCTYPE html><html><head><title>Error de Sistema</title></head><body>";
        echo "<h1>Error del sistema detectado</h1>";
        echo "<p>La aplicación encontró un error fatal. Los detalles han sido registrados.</p>";
        echo "<p>Error: " . htmlspecialchars($error['message']) . "</p>";
        echo "<p>Archivo: " . htmlspecialchars($error['file']) . " línea " . $error['line'] . "</p>";
        echo "</body></html>";
    }
}
register_shutdown_function('shutdown_handler');

// Variables por defecto
$contador = 0;
$error_msg = '';
$email_status = 'Sistema en modo seguro - Email deshabilitado';

try {
    // Verificar autoload
    if (!file_exists('vendor/autoload.php')) {
        throw new Exception('vendor/autoload.php no encontrado. Ejecutar composer install.');
    }
    
    require 'vendor/autoload.php';

    // Conexión a base de datos (simplificada)
    $db_url = getenv('DATABASE_URL');
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
            
            $conn = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5, // 5 segundos timeout
            ]);
            
            $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
            $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $contador = $resultado ? (int)$resultado['contador'] : 0;
            
        } catch (PDOException $e) {
            $error_msg = "Error de BD: " . $e->getMessage();
        }
    } else {
        $error_msg = "DATABASE_URL no configurada";
    }

    // Email solo si no hay errores críticos y está configurado
    $sendgrid_api_key = getenv('SENDGRID_API_KEY');
    if ($sendgrid_api_key && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.sendgrid.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'apikey';
            $mail->Password = $sendgrid_api_key;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Timeout = 10; // 10 segundos timeout
            
            $mail->setFrom('kampos@gmail.com', 'App GaliTroco');
            $mail->addAddress('kampos@gmail.com', 'Usuario de Prueba');
            
            $mail->isHTML(true);
            $mail->Subject = 'Nueva visita en GaliTroco (Modo Seguro)';
            $mail->Body = "<h1>Visita detectada</h1><p>Contador: <b>$contador</b></p>";
            
            $mail->send();
            $email_status = 'Email enviado correctamente (modo seguro)';
            
        } catch (Exception $e) {
            $email_status = "Error enviando email: " . $e->getMessage();
        }
    }

} catch (Exception $e) {
    $error_msg = "Error crítico: " . $e->getMessage();
} catch (Error $e) {
    $error_msg = "Error fatal: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GaliTroco - Modo Seguro</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .container { 
            background: white; 
            padding: 2rem; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            text-align: center; 
            max-width: 500px; 
            width: 90%; 
        }
        h1 { color: #333; margin-bottom: 1rem; }
        .counter { 
            font-size: 3rem; 
            font-weight: bold; 
            color: #667eea; 
            margin: 1rem 0; 
        }
        .status { 
            margin: 1rem 0; 
            padding: 0.8rem; 
            border-radius: 8px; 
            font-size: 0.9rem; 
        }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ef5350; }
        .success { background: #e8f5e8; color: #2e7d32; border: 1px solid #4caf50; }
        .warning { background: #fff3e0; color: #f57c00; border: 1px solid #ff9800; }
        .info { background: #e3f2fd; color: #1976d2; border: 1px solid #2196f3; }
        .footer { margin-top: 2rem; font-size: 0.8rem; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 GaliTroco</h1>
        <p>Aplicación ejecutándose en modo seguro</p>
        
        <div class="counter"><?php echo htmlspecialchars($contador); ?></div>
        <p>Visitas registradas</p>
        
        <?php if ($error_msg): ?>
            <div class="status error">
                ⚠️ <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php else: ?>
            <div class="status success">
                ✅ Base de datos funcionando correctamente
            </div>
        <?php endif; ?>
        
        <div class="status <?php echo str_contains($email_status, 'Error') ? 'error' : (str_contains($email_status, 'deshabilitado') ? 'warning' : 'success'); ?>">
            📧 <?php echo htmlspecialchars($email_status); ?>
        </div>
        
        <div class="status info">
            🔧 Modo seguro activado - Sistema estable
        </div>
        
        <div class="footer">
            <p>Deploy: Render | BD: Supabase | Email: SendGrid</p>
            <p><a href="/debug.php">Ver diagnóstico completo</a></p>
        </div>
    </div>
</body>
</html>