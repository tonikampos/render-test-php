<?php
/**
 * Configuración de Base de Datos
 * Soporta conexión a PostgreSQL local y Supabase
 */

class Database {
    private static $conn = null;
    
    /**
     * Obtener conexión a la base de datos
     * Primero intenta usar DATABASE_URL (Supabase/Render)
     * Si no existe, usa credenciales locales
     */
    public static function getConnection() {
        // Si ya hay conexión, retornarla
        if (self::$conn !== null) {
            return self::$conn;
        }

        try {
            // Intentar obtener DATABASE_URL (producción: Supabase/Render)
            $database_url = getenv('DATABASE_URL');
            
            if ($database_url) {
                // Parsear DATABASE_URL
                $db_parts = parse_url($database_url);
                $host = $db_parts['host'];
                $port = $db_parts['port'] ?? 5432;
                $dbname = ltrim($db_parts['path'], '/');
                $user = $db_parts['user'];
                $password = $db_parts['pass'];
                
                $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
            } else {
                // Configuración local (desarrollo)
                $host = getenv('DB_HOST') ?: 'localhost';
                $port = getenv('DB_PORT') ?: 5432;
                $dbname = getenv('DB_NAME') ?: 'galitrocodb';
                $user = getenv('DB_USER') ?: 'postgres';
                $password = getenv('DB_PASSWORD') ?: 'abc123.,';
                
                $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
            }
            
            // Crear conexión PDO
            self::$conn = new PDO($dsn, $user ?? null, $password ?? null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 5
            ]);
            
            // Configurar zona horaria
            self::$conn->exec("SET TIME ZONE 'Europe/Madrid'");
            
            return self::$conn;
            
        } catch (PDOException $e) {
            error_log("Error de conexión a BD: " . $e->getMessage());
            
            $is_dev = (getenv('ENVIRONMENT') !== 'production');
            $message = $is_dev ? $e->getMessage() : "Error al conectar con la base de datos";
            
            throw new Exception($message, 500);
        }
    }
    
    /**
     * Cerrar conexión
     */
    public static function closeConnection() {
        self::$conn = null;
    }
}
