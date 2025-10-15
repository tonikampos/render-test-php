<?php
/**
 * Configuración de CORS (Cross-Origin Resource Sharing)
 */
function setupCORS() {
    // Lista de orixes permitidas. Engade aquí calquera porto que uses en desenvolvemento.
    $allowed_origins = [
        'http://localhost:4200',
        'https://render-test-php-1.onrender.com', 
        'https://galitroco-frontend.onrender.com',
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    // Comprobamos se a orixe da petición está na nosa lista de permitidos.
    // Tamén engadimos unha comprobación xenérica por se usas outros portos de localhost.
    if (in_array($origin, $allowed_origins) || (strpos($origin, 'http://localhost:') === 0)) {
        // Se está permitido, respondemos coa orixe específica.
        // Isto é OBRIGATORIO para que `withCredentials: true` funcione.
        header("Access-Control-Allow-Origin: $origin");
    }

    // Permitir credenciais (cookies, sessions)
    header("Access-Control-Allow-Credentials: true");

    // Métodos HTTP permitidos
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    // Headers permitidos
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    // Content-Type JSON por defecto
    header("Content-Type: application/json; charset=UTF-8");

    // Manexar peticións preflight (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}