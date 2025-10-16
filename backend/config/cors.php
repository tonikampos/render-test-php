<?php
function setupCORS() {
    $allowed_origins = [
        'http://localhost:4200',
        'https://galitroco-frontend.onrender.com',
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if (in_array($origin, $allowed_origins) || strpos($origin, 'http://localhost') !== false) {
        header("Access-Control-Allow-Origin: $origin");
    }

    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        exit();
    }
}