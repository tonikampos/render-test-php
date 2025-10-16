<?php
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
//problemas
