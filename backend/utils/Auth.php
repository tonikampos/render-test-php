<?php
/**
 * Sistema de autenticación y gestión de sesiones
 * Maneja login, logout, validación de usuarios y seguridad
 */

require_once __DIR__ . '/../config/database.php';

class Auth {
    
    /**
     * Iniciar sesión para un usuario
     */
    public static function login($email, $password) {
        try {
            $db = Database::getConnection();
            
            // Buscar usuario por email
            $stmt = $db->prepare("
                SELECT id, nombre_usuario, email, contrasena_hash, rol, ubicacion, foto_url, 
                       activo
                FROM usuarios 
                WHERE email = :email AND activo = true
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar si existe el usuario y la contraseña es correcta
            if (!$user || !password_verify($password, $user['contrasena_hash'])) {
                return [
                    'success' => false,
                    'message' => 'Email o contraseña incorrectos'
                ];
            }
            
            // Iniciar sesión PHP
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Guardar datos en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['rol'];
            $_SESSION['user_name'] = $user['nombre_usuario'];
            
            // Registrar sesión en base de datos
            $token = bin2hex(random_bytes(32));
            $stmt = $db->prepare("
                INSERT INTO sesiones (usuario_id, token, ip_address, user_agent)
                VALUES (:usuario_id, :token, :ip_address, :user_agent)
            ");
            $stmt->execute([
                'usuario_id' => $user['id'],
                'token' => $token,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
            
            // Actualizar último acceso
            $stmt = $db->prepare("
                UPDATE usuarios 
                SET ultima_conexion = CURRENT_TIMESTAMP 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $user['id']]);
            
            // Remover password del array antes de devolver
            unset($user['contrasena_hash']);
            
            return [
                'success' => true,
                'message' => 'Login exitoso',
                'user' => $user,
                'token' => $token
            ];
            
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor'
            ];
        }
    }
    
    /**
     * Registrar un nuevo usuario
     */
    public static function register($data) {
        try {
            $db = Database::getConnection();
            
            // Validar datos requeridos
            $required = ['nombre_usuario', 'email', 'password', 'ubicacion'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return [
                        'success' => false,
                        'message' => "El campo '$field' es obligatorio"
                    ];
                }
            }
            
            // Validar formato de email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Email inválido'
                ];
            }
            
            // Validar longitud de contraseña
            if (strlen($data['password']) < 6) {
                return [
                    'success' => false,
                    'message' => 'La contraseña debe tener al menos 6 caracteres'
                ];
            }
            
            // Verificar si el email ya existe
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->execute(['email' => $data['email']]);
            if ($stmt->fetch()) {
                return [
                    'success' => false,
                    'message' => 'Este email ya está registrado'
                ];
            }
            
            // Hash de la contraseña
            $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
            
            // Crear usuario
            $stmt = $db->prepare("
                INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, ubicacion, biografia)
                VALUES (:nombre_usuario, :email, :contrasena_hash, :ubicacion, :biografia)
                RETURNING id, nombre_usuario, email, ubicacion, rol
            ");
            
            $stmt->execute([
                'nombre_usuario' => $data['nombre_usuario'],
                'email' => $data['email'],
                'contrasena_hash' => $password_hash,
                'ubicacion' => $data['ubicacion'],
                'biografia' => $data['biografia'] ?? null
            ]);
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
           
            return [
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'user' => $user
            ];
            
        } catch (Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor'
            ];
        }
    }
    
    /**
     * Cerrar sesión
     */
    public static function logout() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $user_id = $_SESSION['user_id'] ?? null;
            
            if ($user_id) {
                $db = Database::getConnection();
                
                // Marcar sesión como cerrada
                $stmt = $db->prepare("
                    UPDATE sesiones 
                    SET activa = false 
                    WHERE usuario_id = :usuario_id AND activa = true
                ");
                $stmt->execute(['usuario_id' => $user_id]);
            }
            
            // Destruir sesión
            session_destroy();
            
            return [
                'success' => true,
                'message' => 'Sesión cerrada exitosamente'
            ];
            
        } catch (Exception $e) {
            error_log("Error en logout: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor'
            ];
        }
    }
    
    /**
     * Obtener usuario actual autenticado
     */
    public static function getCurrentUser() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$user_id) {
                return [
                    'success' => false,
                    'message' => 'No hay sesión activa'
                ];
            }
            
            $db = Database::getConnection();
            
            $stmt = $db->prepare("
                SELECT id, nombre_usuario, email, rol, ubicacion, biografia, 
                       foto_url, activo, fecha_registro, ultima_conexion
                FROM usuarios 
                WHERE id = :id AND activo = true
            ");
            $stmt->execute(['id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ];
            }
            
            return [
                'success' => true,
                'user' => $user
            ];
            
        } catch (Exception $e) {
            error_log("Error obteniendo usuario: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor'
            ];
        }
    }
    
    /**
     * Verificar si hay un usuario autenticado
     */
    public static function isAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public static function hasRole($role) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
    }
    
    /**
     * Middleware: Requiere autenticación
     */
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'No autenticado. Inicia sesión'
            ]);
            exit();
        }
    }
    
  /**
     * Middleware: Require rol admin
     */
    public static function requireAdmin() {
        self::requireAuth();
        

        if (!self::hasRole('administrador')) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'No tienes permisos de administrador'
            ]);
            exit();
        }
    }
    
    /**
     * Solicitar recuperación de contraseña
     * Genera token y envía email con enlace de recuperación
     * 
     * @param string $email Email del usuario
     * @return array Resultado de la operación
     */
    public static function forgotPassword($email) {
        try {
            // Validar formato de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Email inválido'
                ];
            }
            
            $db = Database::getConnection();
            
            // Verificar que el usuario existe
            $stmt = $db->prepare("
                SELECT id, nombre_usuario 
                FROM usuarios 
                WHERE email = :email AND activo = true
            ");
            $stmt->execute(['email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
  
            if (!$usuario) {
                usleep(500000); 
                
                return [
                    'success' => true,
                    'message' => 'Si el email está registrado, recibirás instrucciones para recuperar tu contraseña'
                ];
            }
            
            // Generar token aleatorio seguro (64 caracteres hexadecimales)
            $token = bin2hex(random_bytes(32));
            
            // Guardar token en base de datos con expiración de 1 hora
            $stmt = $db->prepare("
                INSERT INTO password_resets (email, token, fecha_creacion, fecha_expiracion, usado)
                VALUES (:email, :token, NOW(), NOW() + INTERVAL '1 hour', false)
            ");
            $stmt->execute([
                'email' => $email,
                'token' => $token
            ]);
            
            // Enviar email con el token
            require_once __DIR__ . '/EmailService.php';
            $email_enviado = EmailService::enviarRecuperacionPassword($email, $token);
            
            if (!$email_enviado) {
                error_log("Error: No se pudo enviar email de recuperación a: $email");
                // No revelar el error al usuario por seguridad
            }
            
            return [
                'success' => true,
                'message' => 'Si el email está registrado, recibirás instrucciones para recuperar tu contraseña'
            ];
            
        } catch (Exception $e) {
            error_log("Error en forgotPassword: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor. Inténtalo de nuevo más tarde'
            ];
        }
    }
    
    /**
     * Restablecer contraseña con token
     * 
     * @param string $token Token de recuperación
     * @param string $new_password Nueva contraseña
     * @param string $confirm_password Confirmación de contraseña
     * @return array Resultado de la operación
     */
    public static function resetPassword($token, $new_password, $confirm_password) {
        try {
            // Validaciones básicas
            if (empty($token) || empty($new_password) || empty($confirm_password)) {
                return [
                    'success' => false,
                    'message' => 'Todos los campos son obligatorios'
                ];
            }
            
            // Validar que las contraseñas coinciden
            if ($new_password !== $confirm_password) {
                return [
                    'success' => false,
                    'message' => 'Las contraseñas no coinciden'
                ];
            }
            
            // Validar longitud de contraseña
            if (strlen($new_password) < 8) {
                return [
                    'success' => false,
                    'message' => 'La contraseña debe tener al menos 8 caracteres'
                ];
            }
            
            // Validar complejidad de contraseña (opcional pero recomendado)
            if (!preg_match('/[A-Za-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
                return [
                    'success' => false,
                    'message' => 'La contraseña debe contener al menos una letra y un número'
                ];
            }
            
            $db = Database::getConnection();
            
            // Buscar token en la base de datos
            $stmt = $db->prepare("
                SELECT email, fecha_expiracion, usado
                FROM password_resets
                WHERE token = :token
            ");
            $stmt->execute(['token' => $token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Validar que el token existe
            if (!$reset) {
                return [
                    'success' => false,
                    'message' => 'Token inválido o expirado'
                ];
            }
            
            // Validar que el token no ha sido usado
            if ($reset['usado']) {
                return [
                    'success' => false,
                    'message' => 'Este token ya fue utilizado. Solicita uno nuevo'
                ];
            }
            
            // Validar que el token no ha expirado
            $fecha_expiracion = strtotime($reset['fecha_expiracion']);
            $fecha_actual = time();
            
            if ($fecha_expiracion < $fecha_actual) {
                return [
                    'success' => false,
                    'message' => 'El token ha expirado. Solicita uno nuevo (válido por 1 hora)'
                ];
            }
            
            // Hash de la nueva contraseña
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 12]);
            
            // Actualizar contraseña del usuario
            $stmt = $db->prepare("
                UPDATE usuarios 
                SET contrasena_hash = :password_hash 
                WHERE email = :email AND activo = true
            ");
            $resultado = $stmt->execute([
                'password_hash' => $password_hash,
                'email' => $reset['email']
            ]);
            
            if (!$resultado || $stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'No se pudo actualizar la contraseña. Usuario no encontrado'
                ];
            }
            
            // Marcar token como usado
            $stmt = $db->prepare("
                UPDATE password_resets 
                SET usado = true 
                WHERE token = :token
            ");
            $stmt->execute(['token' => $token]);
            
            // Cerrar todas las sesiones activas del usuario por seguridad
            $stmt = $db->prepare("
                UPDATE sesiones 
                SET activa = false 
                WHERE usuario_id = (
                    SELECT id FROM usuarios WHERE email = :email
                )
                AND activa = true
            ");
            $stmt->execute(['email' => $reset['email']]);
            
            // Log de seguridad
            error_log("Contraseña restablecida exitosamente para: " . $reset['email']);
            
            return [
                'success' => true,
                'message' => 'Contraseña actualizada correctamente. Ya puedes iniciar sesión'
            ];
            
        } catch (Exception $e) {
            error_log("Error en resetPassword: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en el servidor. Inténtalo de nuevo más tarde'
            ];
        }
    }
}
