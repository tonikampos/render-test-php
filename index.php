<?php
// Bloque 1: Activamos errores y cargamos librerías
error_reporting(E_ALL);
ini_set('display_errors', 0); // No mostrar errores en pantalla
ini_set('log_errors', 1);    // Sí escribir errores en los logs

// Intentamos cargar el autoload.php de Composer
require 'vendor/autoload.php';

// Intentamos declarar el uso de las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Si el script llega hasta aquí sin un error fatal, mostrará este mensaje.
echo "<h1>Paso 1 Superado: Autoloader y PHPMailer cargados correctamente.</h1>";