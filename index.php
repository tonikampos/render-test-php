<?php
// DEBUGGING HABILITADO PARA RENDER
error_reporting(E_ALL);
ini_set('display_errors', 1); // Temporalmente habilitado para debug
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');

// Función helper para debug
function debug_log($message) {
    echo "<!-- DEBUG: $message -->\n";
    error_log("DEBUG: $message");
}

debug_log("Iniciando aplicación");

try {
    require 'vendor/autoload.php';
    debug_log("Autoload cargado correctamente");
} catch (Exception $e) {
    debug_log("ERROR al cargar autoload: " . $e->getMessage());
    die("Error crítico: No se pudo cargar autoload");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

debug_log("Clases PHPMailer importadas");

// --- 1. LÓGICA DE LA BASE DE DATOS (Contador de visitas) ---
$db_url = getenv('DATABASE_URL');
$conn = null;
$error_msg = '';
$contador = 0;

debug_log("Iniciando conexión a BD");

if ($db_url) {
    debug_log("DATABASE_URL encontrada");
    try {
        $db_parts = parse_url($db_url);
        $host = $db_parts['host'];
        $port = $db_parts['port'] ?? '5432';
        $dbname = ltrim($db_parts['path'], '/');
        $user = $db_parts['user'];
        $password = $db_parts['pass'];

        debug_log("Parámetros BD parseados: host=$host, puerto=$port, db=$dbname");

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        debug_log("Conexión BD establecida");

        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
        debug_log("Contador incrementado");
        
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $resultado ? $resultado['contador'] : 0;
        
        debug_log("Contador actual: $contador");

    } catch (PDOException $e) {
        $error_msg = "Error de BBDD: " . $e->getMessage();
        debug_log("ERROR BD: " . $e->getMessage());
        $conn = null;
    }
} else {
    debug_log("DATABASE_URL no configurada");
}

// --- 2. LÓGICA DE ENVÍO DE EMAIL ---
$email_status = '';
$sendgrid_api_key = getenv('SENDGRID_API_KEY');

debug_log("Iniciando lógica de email");

if ($sendgrid_api_key) {
    debug_log("SENDGRID_API_KEY encontrada (longitud: " . strlen($sendgrid_api_key) . ")");
    
    try {
        $mail = new PHPMailer(true);
        debug_log("Instancia PHPMailer creada");
        
        //Configuración del servidor SMTP de SendGrid
        $mail->isSMTP();
        $mail->Host       = 'smtp.sendgrid.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'apikey'; // Esto es siempre 'apikey' para SendGrid
        $mail->Password   = $sendgrid_api_key;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        debug_log("Configuración SMTP establecida");

        //Remitente y Destinatario
        //IMPORTANTE: El SetFrom DEBE SER el email que verificaste en SendGrid
        $mail->setFrom('TONI.KAMPOS@gmail.com', 'App GaliTroco'); 
        //IMPORTANTE: Cambia esto a tu email para recibir la prueba
        $mail->addAddress('TONI.KAMPOS@gmail.com', 'Usuario de Prueba');

        debug_log("Remitente y destinatario configurados");

        //Contenido del Email
        $mail->isHTML(true);
        $mail->Subject = 'Nueva visita en GaliTroco!';
        $mail->Body    = '<h1>¡Visita Detectada!</h1><p>Tu aplicación de prueba en Render ha sido visitada. El contador está ahora en: <b>' . $contador . '</b></p>';
        $mail->AltBody = 'Tu aplicación de prueba ha sido visitada. Contador: ' . $contador;

        debug_log("Contenido del email configurado");

        $mail->send();
        $email_status = 'Email de notificación enviado con éxito.';
        debug_log("Email enviado exitosamente");
        
    } catch (Exception $e) {
        $email_status = "El email no se pudo enviar. Error de PHPMailer: {$mail->ErrorInfo}";
        debug_log("ERROR enviando email: " . $e->getMessage() . " | PHPMailer Error: " . $mail->ErrorInfo);
    }
} else {
    $email_status = "Variable de entorno SENDGRID_API_KEY no configurada.";
    debug_log("SENDGRID_API_KEY no configurada");
}

debug_log("Aplicación completada, generando HTML");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Prueba de Despliegue en Render + Email</title>
        <style>
            body { font-family: sans-serif; display: grid; place-content: center; height: 100vh; margin: 0; background: #f0f2f5; text-align: center; }
            .container { background: white; padding: 2rem 4rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
            h1 { color: #1877f2; }
            p.counter { font-size: 2.5rem; font-weight: bold; color: #333; margin: 1rem 0; }
            .status { margin-top: 20px; padding: 10px; border-radius: 5px; }
            .error { color: #d93025; background: #fbeae9; }
            .success { color: #1e8e3e; background: #e6f4ea; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🚀 ¡Hola desde Render + SendGrid! 🚀</h1>
            <p>Esta página ha sido visitada:</p>
            <p class="counter"><?php echo htmlspecialchars($contador); ?> veces</p>

            <?php if ($error_msg): ?>
                <p class="status error"><?php echo $error_msg; ?></p>
            <?php endif; ?>

            <p class="status <?php echo str_contains($email_status, 'Error') ? 'error' : 'success'; ?>"><?php echo $email_status; ?></p>
        </div>
    </body>
</html>