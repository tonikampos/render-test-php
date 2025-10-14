<?php
/**
 * Endpoints de autenticación
 * POST /api/auth/register - Registrar usuario
 * POST /api/auth/login - Iniciar sesión
 * POST /api/auth/logout - Cerrar sesión
 * GET /api/auth/me - Obtener usuario actual
 * POST /api/auth/forgot-password - Solicitar recuperación de contraseña
 * POST /api/auth/reset-password - Restablecer contraseña con token
 */

function handleAuthRoutes($method, $action, $input) {
    
    // POST /api/auth/register
    if ($method === 'POST' && $action === 'register') {
            // Log para depuración del input recibido
            error_log('LOGIN INPUT: ' . print_r($input, true));
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
    
    // POST /api/auth/forgot-password
    if ($method === 'POST' && $action === 'forgot-password') {
        // Validar email
        if (empty($input['email'])) {
            Response::validationError([
                'email' => 'Email es requerido'
            ]);
        }
        
        $result = Auth::forgotPassword($input['email']);
        
        if ($result['success']) {
            Response::success(null, $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    // POST /api/auth/reset-password
    if ($method === 'POST' && $action === 'reset-password') {
        // Validar campos requeridos
        if (empty($input['token']) || empty($input['new_password']) || empty($input['confirm_password'])) {
            Response::validationError([
                'token' => 'Token es requerido',
                'new_password' => 'Nueva contraseña es requerida',
                'confirm_password' => 'Confirmación de contraseña es requerida'
            ]);
        }
        
        $result = Auth::resetPassword(
            $input['token'], 
            $input['new_password'], 
            $input['confirm_password']
        );
        
        if ($result['success']) {
            Response::success(null, $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    // Método no permitido
    Response::methodNotAllowed(['GET', 'POST']);
}
