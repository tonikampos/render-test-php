<?php
// DIAGNÓSTICO FINAL - CAPTURA EXACTA DEL ERROR
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);

// Función para capturar errores fatales
function shutdown_handler() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        echo "<h1>ERROR FATAL DETECTADO:</h1>";
        echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>Archivo:</strong> " . htmlspecialchars($error['file']) . "</p>";
        echo "<p><strong>Línea:</strong> " . $error['line'] . "</p>";
        echo "<p><strong>Tipo:</strong> " . $error['type'] . "</p>";
    }
}
register_shutdown_function('shutdown_handler');

echo "<h1>🔧 INICIANDO DIAGNÓSTICO</h1>";

// Test 1: PHP básico
echo "<p>✅ PHP funciona: " . phpversion() . "</p>";

// Test 2: Archivos
echo "<p>vendor/autoload.php: " . (file_exists('vendor/autoload.php') ? "✅" : "❌") . "</p>";

// Test 3: Autoload
echo "<p>Cargando autoload...</p>";
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p>✅ Autoload cargado</p>";
    } else {
        echo "<p>❌ vendor/autoload.php no existe</p>";
    }
} catch (Throwable $e) {
    echo "<p>❌ Error autoload: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Archivo: " . $e->getFile() . " línea " . $e->getLine() . "</p>";
}

// Test 4: PHPMailer
echo "<p>Verificando PHPMailer...</p>";
try {
    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        echo "<p>✅ PHPMailer disponible</p>";
        
        // Test de instancia
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        echo "<p>✅ Instancia PHPMailer creada</p>";
        
    } else {
        echo "<p>❌ Clase PHPMailer no encontrada</p>";
    }
} catch (Throwable $e) {
    echo "<p>❌ Error PHPMailer: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Archivo: " . $e->getFile() . " línea " . $e->getLine() . "</p>";
}

// Test 5: Variables de entorno
echo "<p>DATABASE_URL: " . (getenv('DATABASE_URL') ? "✅" : "❌") . "</p>";
echo "<p>SENDGRID_API_KEY: " . (getenv('SENDGRID_API_KEY') ? "✅" : "❌") . "</p>";

echo "<h2>🎯 DIAGNÓSTICO COMPLETADO</h2>";
echo "<p>Si ves este mensaje, el problema NO está en autoload ni PHPMailer básico.</p>";
echo "<p><a href='/index.php'>Probar index.php</a></p>";
?>