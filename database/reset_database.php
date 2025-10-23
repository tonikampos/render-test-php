<?php
/**
 * SCRIPT DE RESETEO DE BASE DE DATOS
 * 
 * Este script ELIMINA todos los datos de todas las tablas,
 * pero mantiene la estructura (tablas, columnas, relaciones, índices).
 * 
 * Luego crea usuarios de prueba básicos para poder empezar a usar la aplicación.
 * 
 * ⚠️ ADVERTENCIA: Este script es DESTRUCTIVO.
 * ⚠️ Todos los datos actuales se perderán permanentemente.
 * ⚠️ Solo ejecutar en desarrollo o cuando estés seguro.
 */

require_once __DIR__ . '/../backend/config/database.php';

echo "=============================================================\n";
echo "   ⚠️  RESETEO DE BASE DE DATOS - ELIMINACIÓN DE DATOS\n";
echo "=============================================================\n\n";

echo "⚠️  ADVERTENCIA: Este script eliminará TODOS los datos.\n";
echo "⚠️  La estructura de la BD se mantendrá intacta.\n\n";

// Solicitar confirmación
echo "¿Estás seguro de que deseas continuar? (escribe 'SI' para confirmar): ";
$confirmacion = trim(fgets(STDIN));

if ($confirmacion !== 'SI') {
    echo "\n❌ Operación cancelada por el usuario.\n";
    exit(0);
}

echo "\n🔄 Iniciando reseteo de base de datos...\n\n";

try {
    $conn = Database::getConnection();
    echo "✅ Conexión exitosa a la base de datos\n\n";
    
    // Iniciar transacción para garantizar atomicidad
    $conn->beginTransaction();
    
    // =========================================================================
    // PASO 1: DESHABILITAR TEMPORALMENTE LAS FOREIGN KEY CHECKS
    // =========================================================================
    echo "📋 Paso 1/3: Deshabilitando restricciones de claves foráneas...\n";
    
    // PostgreSQL no tiene un modo global de deshabilitar FKs,
    // pero podemos usar TRUNCATE CASCADE que respeta el orden
    
    echo "   ✅ Listo para truncar tablas\n\n";
    
    // =========================================================================
    // PASO 2: ELIMINAR DATOS EN ORDEN CORRECTO (respetando dependencias)
    // =========================================================================
    echo "📋 Paso 2/3: Eliminando datos de todas las tablas...\n";
    
    // Orden de eliminación: de tablas dependientes a tablas principales
    $tablas_ordenadas = [
        'valoraciones',              // Depende de: usuarios, intercambios
        'notificaciones',            // Depende de: usuarios
        'mensajes',                  // Depende de: conversaciones, usuarios
        'participantes_conversacion', // Depende de: conversaciones, usuarios
        'conversaciones',            // Depende de: intercambios
        'intercambios',              // Depende de: habilidades, usuarios
        'reportes',                  // Depende de: usuarios
        'habilidades',               // Depende de: usuarios, categorias_habilidades
        'password_resets',           // Independiente (tokens de recuperación)
        'sesiones',                  // Depende de: usuarios
        'usuarios',                  // Tabla principal
        'categorias_habilidades'     // Tabla base (sin dependencias)
    ];
    
    foreach ($tablas_ordenadas as $tabla) {
        try {
            // TRUNCATE es más eficiente que DELETE y resetea secuencias
            $conn->exec("TRUNCATE TABLE {$tabla} RESTART IDENTITY CASCADE");
            echo "   ✅ {$tabla} - datos eliminados\n";
        } catch (Exception $e) {
            echo "   ⚠️  {$tabla} - error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n";
    
    // =========================================================================
    // PASO 3: CREAR DATOS MÍNIMOS (usuarios de prueba)
    // =========================================================================
    echo "📋 Paso 3/3: Creando usuarios de prueba...\n\n";
    
    // Crear categorías básicas (necesarias para habilidades)
    echo "   Creando categorías de habilidades...\n";
    $categorias = [
        ['nombre' => 'Tecnología e Informática', 'descripcion' => 'Programación, diseño web, redes, etc.', 'icono' => '💻'],
        ['nombre' => 'Idiomas', 'descripcion' => 'Enseñanza y práctica de idiomas', 'icono' => '🌍'],
        ['nombre' => 'Música', 'descripcion' => 'Instrumentos, teoría musical, canto', 'icono' => '🎵'],
        ['nombre' => 'Deportes y Fitness', 'descripcion' => 'Entrenamiento, yoga, artes marciales', 'icono' => '⚽'],
        ['nombre' => 'Cocina y Gastronomía', 'descripcion' => 'Recetas, técnicas culinarias', 'icono' => '🍳'],
        ['nombre' => 'Arte y Diseño', 'descripcion' => 'Pintura, dibujo, diseño gráfico', 'icono' => '🎨'],
        ['nombre' => 'Clases y Formación', 'descripcion' => 'Materias académicas, apoyo escolar', 'icono' => '📚'],
        ['nombre' => 'Otros', 'descripcion' => 'Otras habilidades', 'icono' => '🔧']
    ];
    
    $stmt = $conn->prepare("
        INSERT INTO categorias_habilidades (nombre, descripcion, icono)
        VALUES (:nombre, :descripcion, :icono)
    ");
    
    foreach ($categorias as $categoria) {
        $stmt->execute($categoria);
    }
    echo "   ✅ 8 categorías creadas\n\n";
    
    // Crear usuarios de prueba
    echo "   Creando usuarios de prueba...\n";
    
    // Hash de contraseñas (todas usan: Pass123456)
    $password_hash = password_hash('Pass123456', PASSWORD_BCRYPT, ['cost' => 12]);
    
    $usuarios = [
        [
            'nombre_usuario' => 'admin',
            'email' => 'admin@galitroco.com',
            'contrasena_hash' => $password_hash,
            'rol' => 'administrador',
            'biografia' => 'Administrador del sistema GaliTroco',
            'ubicacion' => 'Santiago de Compostela',
            'activo' => true
        ],
        [
            'nombre_usuario' => 'usuario_demo',
            'email' => 'demo@galitroco.com',
            'contrasena_hash' => $password_hash,
            'rol' => 'usuario',
            'biografia' => 'Usuario de demostración para pruebas',
            'ubicacion' => 'A Coruña',
            'activo' => true
        ],
        [
            'nombre_usuario' => 'test_user',
            'email' => 'test@galitroco.com',
            'contrasena_hash' => $password_hash,
            'rol' => 'usuario',
            'biografia' => 'Usuario de pruebas',
            'ubicacion' => 'Vigo',
            'activo' => true
        ]
    ];
    
    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo)
        VALUES (:nombre_usuario, :email, :contrasena_hash, :rol, :biografia, :ubicacion, :activo)
    ");
    
    foreach ($usuarios as $usuario) {
        $stmt->execute($usuario);
    }
    
    echo "   ✅ 3 usuarios creados\n\n";
    
    // Confirmar transacción
    $conn->commit();
    
    echo "=============================================================\n";
    echo "✅ RESETEO COMPLETADO EXITOSAMENTE\n";
    echo "=============================================================\n\n";
    
    echo "📊 ESTADO FINAL:\n";
    echo "  - Todos los datos anteriores eliminados\n";
    echo "  - Estructura de BD intacta (tablas, columnas, FKs, índices)\n";
    echo "  - Secuencias reiniciadas (IDs comienzan desde 1)\n";
    echo "  - 8 categorías de habilidades creadas\n";
    echo "  - 3 usuarios de prueba creados\n\n";
    
    echo "👤 CREDENCIALES DE ACCESO:\n\n";
    echo "  Administrador:\n";
    echo "    Email:    admin@galitroco.com\n";
    echo "    Password: Pass123456\n";
    echo "    Rol:      administrador\n\n";
    
    echo "  Usuario Demo:\n";
    echo "    Email:    demo@galitroco.com\n";
    echo "    Password: Pass123456\n";
    echo "    Rol:      usuario\n\n";
    
    echo "  Usuario Test:\n";
    echo "    Email:    test@galitroco.com\n";
    echo "    Password: Pass123456\n";
    echo "    Rol:      usuario\n\n";
    
    echo "🚀 La aplicación está lista para usar con estos usuarios.\n";
    echo "   Puedes crear habilidades, proponer intercambios, etc.\n\n";
    
} catch (Exception $e) {
    // Revertir cambios en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo "\n❌ ERROR durante el reseteo:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "   Los cambios fueron revertidos (rollback).\n\n";
    exit(1);
}
