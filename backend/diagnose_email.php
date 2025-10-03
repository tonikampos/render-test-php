<?php
/**
 * Script de diagnóstico para verificar configuración de email
 */

header('Content-Type: application/json');

$diagnostico = [
    'timestamp' => date('Y-m-d H:i:s'),
    'variables_entorno' => [
        'RESEND_API_KEY' => getenv('RESEND_API_KEY') ? 'Configurada ('. substr(getenv('RESEND_API_KEY'), 0, 10) . '...)' : '❌ NO CONFIGURADA',
        'RESEND_FROM_EMAIL' => getenv('RESEND_FROM_EMAIL') ?: '❌ NO CONFIGURADA',
        'FRONTEND_URL' => getenv('FRONTEND_URL') ?: '❌ NO CONFIGURADA'
    ],
    'php_info' => [
        'version' => phpversion(),
        'curl_enabled' => function_exists('curl_init') ? '✅ Habilitado' : '❌ Deshabilitado',
        'openssl_enabled' => extension_loaded('openssl') ? '✅ Habilitado' : '❌ Deshabilitado'
    ]
];

echo json_encode($diagnostico, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
