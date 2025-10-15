<?php
/**
 * API Proxy - Redirixe todas as peticións ao backend
 */

// 1. Cargar a configuración de CORS e das cookies
require_once __DIR__ . '/backend/config/cors.php';
setupCORS();

// 2. Iniciar a sesión AQUÍ, xusto despois da configuración.
// Este é o único sitio onde se fará session_start().
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Cargar as utilidades necesarias (xa que o outro ficheiro non as cargará)
require_once __DIR__ . '/backend/utils/Response.php';
require_once __DIR__ . '/backend/utils/Auth.php';

// 4. Cambiar ao directorio backend e delegar o enrutamento
chdir(__DIR__ . '/backend');
require_once __DIR__ . '/backend/api/index.php';