<?php
// --- Bloque 1: Carga de librerías (YA VALIDADO) ---
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h1>Paso 1 Superado: Autoloader y PHPMailer cargados.</h1>";


// --- Bloque 2: Conexión a la Base de Datos (PROBANDO AHORA) ---
$db_url = getenv('DATABASE_URL');
$conn = null;
$error_msg = '';

if (!$db_url) {
    $error_msg = "Error Crítico: No se encontró la variable de entorno DATABASE_URL.";
} else {
    try {
        $db_parts = parse_url($db_url);
        $host = $db_parts['host'];
        $port = $db_parts['port'] ?? '5432';
        $dbname = ltrim($db_parts['path'], '/');
        $user = $db_parts['user'];
        $password = $db_parts['pass'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Si llega aquí, la conexión es exitosa
        echo "<h2>Paso 2 Superado: Conexión a la base de datos de Supabase exitosa.</h2>";

    } catch (PDOException $e) {
        // Si falla, mostramos el error de conexión
        $error_msg = "Error en Paso 2 (Conexión a BBDD): " . $e->getMessage();
        $conn = null;
    }
}

if ($error_msg) {
    echo "<h2 style='color: red;'>" . $error_msg . "</h2>";
}