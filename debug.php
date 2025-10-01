<?php
// ARCHIVO DE DEBUG PARA RENDER
// Este archivo nos ayudará a identificar exactamente dónde falla

// Configuración de errores y logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');

echo "<h1>🔍 DIAGNÓSTICO DE RENDER + SENDGRID</h1>\n";
echo "<pre>\n";

// 1. Verificar versión PHP
echo "=== 1. INFORMACIÓN DEL SISTEMA ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Sistema Operativo: " . php_uname() . "\n";
echo "Fecha/Hora: " . date('Y-m-d H:i:s') . "\n\n";

// 2. Verificar Composer y autoload
echo "=== 2. VERIFICACIÓN DE COMPOSER ===\n";
if (file_exists('vendor/autoload.php')) {
    echo "✅ vendor/autoload.php existe\n";
    try {
        require 'vendor/autoload.php';
        echo "✅ Autoload cargado correctamente\n";
    } catch (Exception $e) {
        echo "❌ Error al cargar autoload: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ vendor/autoload.php NO EXISTE\n";
}

// 3. Verificar PHPMailer
echo "\n=== 3. VERIFICACIÓN DE PHPMAILER ===\n";
try {
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        echo "✅ Clase PHPMailer disponible\n";
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        echo "✅ Instancia de PHPMailer creada\n";
    } else {
        echo "❌ Clase PHPMailer NO disponible\n";
    }
} catch (Exception $e) {
    echo "❌ Error con PHPMailer: " . $e->getMessage() . "\n";
}

// 4. Verificar variables de entorno
echo "\n=== 4. VARIABLES DE ENTORNO ===\n";
$database_url = getenv('DATABASE_URL');
$sendgrid_key = getenv('SENDGRID_API_KEY');

echo "DATABASE_URL: " . ($database_url ? "✅ Configurada (longitud: " . strlen($database_url) . ")" : "❌ NO configurada") . "\n";
echo "SENDGRID_API_KEY: " . ($sendgrid_key ? "✅ Configurada (longitud: " . strlen($sendgrid_key) . ")" : "❌ NO configurada") . "\n";

// 5. Test de conexión a base de datos
echo "\n=== 5. TEST DE BASE DE DATOS ===\n";
if ($database_url) {
    try {
        $db_parts = parse_url($database_url);
        echo "Host BD: " . $db_parts['host'] . "\n";
        echo "Puerto BD: " . ($db_parts['port'] ?? '5432') . "\n";
        echo "Base de datos: " . ltrim($db_parts['path'], '/') . "\n";
        
        $host = $db_parts['host'];
        $port = $db_parts['port'] ?? '5432';
        $dbname = ltrim($db_parts['path'], '/');
        $user = $db_parts['user'];
        $password = $db_parts['pass'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Conexión a BD exitosa\n";
        
        // Test de la tabla
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Tabla visitantes accesible. Contador actual: " . ($resultado ? $resultado['contador'] : 'No encontrado') . "\n";
        
    } catch (PDOException $e) {
        echo "❌ Error de BD: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ DATABASE_URL no configurada\n";
}

// 6. Test básico de SendGrid (solo configuración)
echo "\n=== 6. TEST DE SENDGRID (CONFIGURACIÓN) ===\n";
if ($sendgrid_key && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey';
        $mail->Password = $sendgrid_key;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        echo "✅ Configuración SMTP de SendGrid establecida\n";
        echo "✅ No se envía email en esta prueba\n";
    } catch (Exception $e) {
        echo "❌ Error en configuración SendGrid: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ SendGrid no se puede testear (falta API key o PHPMailer)\n";
}

// 7. Verificar extensiones PHP
echo "\n=== 7. EXTENSIONES PHP IMPORTANTES ===\n";
$extensions = ['pdo', 'pdo_pgsql', 'openssl', 'curl', 'mbstring'];
foreach ($extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "✅ Cargada" : "❌ NO cargada") . "\n";
}

// 8. Información de memoria y límites
echo "\n=== 8. LÍMITES DEL SISTEMA ===\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "\n";

echo "\n=== 9. DIRECTORIO DE TRABAJO ===\n";
echo "Directorio actual: " . getcwd() . "\n";
echo "Archivos en directorio:\n";
$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "  - $file\n";
    }
}

echo "\n=== FIN DEL DIAGNÓSTICO ===\n";
echo "</pre>";

echo "<p><strong>Instrucciones:</strong></p>";
echo "<ol>";
echo "<li>Sube este archivo a tu repositorio Git</li>";
echo "<li>Haz deploy en Render</li>";
echo "<li>Visita tu-app.onrender.com/debug.php</li>";
echo "<li>Envíame la salida completa para diagnosticar el problema</li>";
echo "</ol>";
?>