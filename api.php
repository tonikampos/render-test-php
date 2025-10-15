<?php
/**
 * ==========================================================
 * CONFIGURACIÓN DE COOKIES DE SESIÓN PARA CROSS-DOMAIN
 * ==========================================================
 * Isto é necesario para que a sesión funcione entre o frontend (localhost)
 * e o backend (Render).
 */
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Asegúrate de que a orixe está na túa lista de permitidos
    $allowed_origins = [
        'http://localhost:4200',
        // Engade aquí calquera outro porto de localhost que uses
    ];

    // Se a orixe contén localhost, configura a cookie para desenvolvemento
    if (strpos($_SERVER['HTTP_ORIGIN'], 'localhost') !== false) {
        session_set_cookie_params([
            'lifetime' => 86400, // 1 día
            'path' => '/',
            'domain' => '', // Permite localhost
            'secure' => true, // Debe ser true para SameSite=None
            'httponly' => true,
            'samesite' => 'None' // Permite o envío de cookies entre dominios
        ]);
    }
}
// ==========================================================
// FIN DA CONFIGURACIÓN DE COOKIES
// ==========================================================
/**
 * API Proxy - Redirige todas las peticiones al backend
 * Workaround para el problema de Apache con /backend/
 */

// Configurar CORS
require_once __DIR__ . '/backend/config/cors.php';
setupCORS();

// Obtener la ruta solicitada
$resource = $_GET['resource'] ?? '';

// Cambiar al directorio backend
chdir(__DIR__ . '/backend');

// Delegar al router del backend
require_once __DIR__ . '/backend/api/index.php';
