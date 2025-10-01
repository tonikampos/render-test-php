<?php
/**
 * Endpoints de autenticación
 * POST /api/auth/register - Registrar usuario
 * POST /api/auth/login - Iniciar sesión
 * POST /api/auth/logout - Cerrar sesión
 * GET /api/auth/me - Obtener usuario actual
 */

function handleAuthRoutes($method, $action, $input) {
    
    // POST /api/auth/register
    if ($method === 'POST' && $action === 'register') {
        $result = Auth::register($input);
        
        if ($result['success']) {
            Response::created($result['user'], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    // POST /api/auth/login
    if ($method === 'POST' && $action === 'login') {
        // Validar campos requeridos
        if (empty($input['email']) || empty($input['password'])) {
            Response::validationError([
                'email' => 'Email es requerido',
                'password' => 'Contraseña es requerida'
            ]);
        }
        
        $result = Auth::login($input['email'], $input['password']);
        
        if ($result['success']) {
            Response::success([
                'user' => $result['user'],
                'token' => $result['token']
            ], $result['message']);
        } else {
            Response::error($result['message'], 401);
        }
    }
    
    // POST /api/auth/logout
    if ($method === 'POST' && $action === 'logout') {
        $result = Auth::logout();
        
        if ($result['success']) {
            Response::success(null, $result['message']);
        } else {
            Response::error($result['message']);
        }
    }
    
    // GET /api/auth/me
    if ($method === 'GET' && $action === 'me') {
        $result = Auth::getCurrentUser();
        
        if ($result['success']) {
            Response::success($result['user'], 'Usuario autenticado');
        } else {
            Response::unauthorized($result['message']);
        }
    }
    
    // Método no permitido
    Response::methodNotAllowed(['GET', 'POST']);
}
