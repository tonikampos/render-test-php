<?php
/**
 * Configuración de CORS e das Cookies de Sesión para Cross-Domain
 */
function setupCORS() {
    // Lista de orixes permitidas.
    $allowed_origins = [
        'http://localhost:4200',
        'https://galitroco-frontend.onrender.com', // A túa URL de produción do frontend
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    // Comprobamos se a orixe da petición está na nosa lista de permitidos.
    // Tamén engadimos unha comprobación xenérica para outros portos de localhost en desenvolvemento.
    $is_allowed = in_array($origin, $allowed_origins) || (strpos($origin, 'http://localhost:') === 0);

    if ($is_allowed) {
        // Se a orixe está permitida, respondemos coa orixe específica.
        // Isto é OBRIGATORIO para que `withCredentials: true` funcione.
        header("Access-Control-Allow-Origin: $origin");

        // Configuración da cookie de sesión SÓ se a orixe é permitida
        session_set_cookie_params([
            'lifetime' => 86400, // 1 día
            'path' => '/',
            'domain' => '', 
            'secure' => true,    // Requirido para SameSite=None
            'httponly' => true,
            'samesite' => 'None'  // A clave para permitir cookies entre dominios
        ]);
    }

    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    // Manexar peticións preflight (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        exit();
    }
}