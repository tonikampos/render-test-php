<?php
/**
 * Configuración de CORS e Cookies de Sesión (Versión Definitiva)
 */
function setupCORS() {
    // Lista de orixes de confianza
    $allowed_origins = [
        'http://localhost:4200',
        'https://galitroco-frontend.onrender.com',
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    // Comprobamos se a orixe da petición está na nosa lista de permitidos
    $is_allowed = in_array($origin, $allowed_origins) || (strpos($origin, 'http://localhost:') === 0);

    if ($is_allowed) {
        // Se a orixe está permitida, respondemos coa orixe específica.
        // Isto é OBRIGATORIO para que `withCredentials: true` no frontend funcione.
        header("Access-Control-Allow-Origin: $origin");

        // LÓXICA CONDICIONAL PARA O DOMINIO DA COOKIE
        $cookie_domain = ''; // Valor por defecto para localhost
        if (strpos($origin, '.onrender.com') !== false) {
            // Se estamos en produción, facemos a cookie válida para todos os subdominios de onrender.com
            $cookie_domain = '.onrender.com';
        }

        // ESTA É A SOLUCIÓN: Establecemos os parámetros da cookie de sesión para que funcione entre dominios
        session_set_cookie_params([
            'lifetime' => 86400, // 1 día
            'path' => '/',
            'domain' => $cookie_domain, // A CLAVE ESTÁ AQUÍ
            'secure' => true,    // Requirido para SameSite=None
            'httponly' => true,
            'samesite' => 'None'  // A clave para permitir cookies entre dominios
        ]);
    }

    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    // Manexar peticións de verificación (preflight) que fai o navegador
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        exit();
    }
}