<?php
/**
 * Configuración de CORS (Cross-Origin Resource Sharing)
 * Permite que Angular (frontend) consuma la API PHP (backend)
 */

// Configurar headers CORS
function setupCORS() {
    // Permitir solicitudes desde Angular en desarrollo y producción
    $allowed_origins = [
        'http://localhost:4200',      // Angular development
        'http://127.0.0.1:4200',      // Angular development (alternativa)
        'https://render-test-php-1.onrender.com', // Producción en Render (backend)
        'https://galitroco-frontend.onrender.com', // Producción en Render (frontend)
    ];
    
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    // Si el origen está en la lista permitida, permitirlo
    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: $origin");
    } else {
        // En desarrollo local, permitir cualquier origen
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
            strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
            header("Access-Control-Allow-Origin: *");
        }
    }
    
    // Permitir credenciales (cookies, sessions)
    header("Access-Control-Allow-Credentials: true");
    
    // Métodos HTTP permitidos
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    
    // Headers permitidos
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
    // Tiempo de caché para preflight requests
    header("Access-Control-Max-Age: 3600");
    
    // Content-Type JSON por defecto
    header("Content-Type: application/json; charset=UTF-8");
    
    // Manejar preflight requests (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}
