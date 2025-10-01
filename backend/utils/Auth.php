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
            
            // TODO: Enviar email de verificación con Resend
            
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
     * Middleware: Requiere rol admin
     */
    public static function requireAdmin() {
        self::requireAuth();
        
        if (!self::hasRole('admin')) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'No tienes permisos de administrador'
            ]);
            exit();
        }
    }
}
