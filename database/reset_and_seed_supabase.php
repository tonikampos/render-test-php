<?php
/**
 * SCRIPT DE RESETEO Y CARGA DE DATOS EN SUPABASE
 * 
 * Este script:
 * 1. Elimina todos los datos de las tablas (manteniendo la estructura)
 * 2. Carga los datos de ejemplo desde seeds.sql
 * 
 * ⚠️ ADVERTENCIA: Eliminará todos los datos actuales en Supabase
 * ⚠️ Solo ejecutar si estás seguro
 */

require_once __DIR__ . '/../backend/config/database.php';

echo "=============================================================\n";
echo "   🔄 RESETEO Y CARGA DE DATOS - SUPABASE\n";
echo "=============================================================\n\n";

echo "⚠️  ADVERTENCIA: Este script eliminará TODOS los datos de Supabase.\n";
echo "⚠️  Luego cargará los datos de ejemplo desde seeds.sql\n\n";

// Solicitar confirmación
echo "¿Estás seguro de que deseas continuar? (escribe 'SI' para confirmar): ";
$confirmacion = trim(fgets(STDIN));

if ($confirmacion !== 'SI') {
    echo "\n❌ Operación cancelada por el usuario.\n";
    exit(0);
}

echo "\n🔄 Iniciando reseteo y carga de datos...\n\n";

try {
    $conn = Database::getConnection();
    echo "✅ Conexión exitosa a Supabase\n\n";
    
    // Iniciar transacción
    $conn->beginTransaction();
    
    // =========================================================================
    // PASO 1: ELIMINAR DATOS DE TODAS LAS TABLAS
    // =========================================================================
    echo "📋 Paso 1/2: Eliminando datos existentes...\n";
    
    // Orden de eliminación: de tablas dependientes a tablas principales
    $tablas_ordenadas = [
        'valoraciones',
        'notificaciones',
        'mensajes',
        'participantes_conversacion',
        'conversaciones',
        'intercambios',
        'reportes',
        'habilidades',
        'password_resets',
        'sesiones',
        'usuarios',
        'categorias_habilidades'
    ];
    
    foreach ($tablas_ordenadas as $tabla) {
        try {
            $conn->exec("TRUNCATE TABLE {$tabla} RESTART IDENTITY CASCADE");
            echo "   ✅ {$tabla} - datos eliminados\n";
        } catch (Exception $e) {
            echo "   ⚠️  {$tabla} - error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n";
    
    // =========================================================================
    // PASO 2: CARGAR DATOS DESDE seeds.sql
    // =========================================================================
    echo "📋 Paso 2/2: Cargando datos desde seeds.sql...\n\n";
    
    // Leer el archivo seeds.sql
    $seeds_file = __DIR__ . '/seeds.sql';
    
    if (!file_exists($seeds_file)) {
        throw new Exception("❌ Archivo seeds.sql no encontrado en: {$seeds_file}");
    }
    
    $sql_content = file_get_contents($seeds_file);
    
    // Limpiar comentarios y líneas vacías
    $sql_lines = explode("\n", $sql_content);
    $sql_statements = [];
    $current_statement = '';
    
    foreach ($sql_lines as $line) {
        $line = trim($line);
        
        // Saltar comentarios y líneas vacías
        if (empty($line) || strpos($line, '--') === 0) {
            continue;
        }
        
        $current_statement .= $line . ' ';
        
        // Si la línea termina con ;, es el final de un statement
        if (substr($line, -1) === ';') {
            $sql_statements[] = trim($current_statement);
            $current_statement = '';
        }
    }
    
    // Ejecutar cada statement
    $count_categorias = 0;
    $count_usuarios = 0;
    $count_habilidades = 0;
    $count_intercambios = 0;
    $count_otros = 0;
    
    foreach ($sql_statements as $statement) {
        if (empty(trim($statement))) continue;
        
        try {
            $conn->exec($statement);
            
            // Contar qué tipo de insert es
            if (stripos($statement, 'INSERT INTO categorias_habilidades') !== false) {
                $count_categorias++;
            } elseif (stripos($statement, 'INSERT INTO usuarios') !== false) {
                $count_usuarios++;
            } elseif (stripos($statement, 'INSERT INTO habilidades') !== false) {
                $count_habilidades++;
            } elseif (stripos($statement, 'INSERT INTO intercambios') !== false) {
                $count_intercambios++;
            } elseif (stripos($statement, 'INSERT INTO') !== false) {
                $count_otros++;
            }
            
        } catch (Exception $e) {
            // Mostrar warning pero continuar
            echo "   ⚠️  Error en statement: " . substr($statement, 0, 50) . "...\n";
            echo "       " . $e->getMessage() . "\n";
        }
    }
    
    // Confirmar transacción
    $conn->commit();
    
    echo "   ✅ Datos cargados correctamente\n\n";
    
    echo "=============================================================\n";
    echo "✅ RESETEO Y CARGA COMPLETADOS EXITOSAMENTE\n";
    echo "=============================================================\n\n";
    
    echo "📊 RESUMEN DE DATOS CARGADOS:\n";
    echo "   - Categorías: {$count_categorias}\n";
    echo "   - Usuarios: {$count_usuarios}\n";
    echo "   - Habilidades: {$count_habilidades}\n";
    echo "   - Intercambios: {$count_intercambios}\n";
    echo "   - Otros registros: {$count_otros}\n\n";
    
    // Verificar datos cargados
    echo "📋 VERIFICACIÓN FINAL:\n\n";
    
    $verificaciones = [
        'categorias_habilidades' => 'SELECT COUNT(*) as total FROM categorias_habilidades',
        'usuarios' => 'SELECT COUNT(*) as total FROM usuarios',
        'habilidades' => 'SELECT COUNT(*) as total FROM habilidades',
        'intercambios' => 'SELECT COUNT(*) as total FROM intercambios'
    ];
    
    foreach ($verificaciones as $tabla => $query) {
        $stmt = $conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   ✅ {$tabla}: {$result['total']} registros\n";
    }
    
    echo "\n";
    
    // Mostrar usuarios de ejemplo
    echo "👤 USUARIOS DE EJEMPLO CARGADOS:\n\n";
    
    $stmt = $conn->query("SELECT nombre_usuario, email, rol FROM usuarios ORDER BY id LIMIT 10");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($usuarios as $usuario) {
        echo "   - {$usuario['nombre_usuario']}\n";
        echo "     Email: {$usuario['email']}\n";
        echo "     Rol: {$usuario['rol']}\n\n";
    }
    
    echo "🔑 CONTRASEÑA PARA TODOS LOS USUARIOS: Pass123456\n\n";
    
    echo "🚀 La base de datos de Supabase está lista con datos de ejemplo.\n";
    echo "   Puedes probar la aplicación en: https://galitroco-frontend.onrender.com\n\n";
    
} catch (Exception $e) {
    // Revertir cambios en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo "\n❌ ERROR durante el proceso:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "   Los cambios fueron revertidos (rollback).\n\n";
    exit(1);
}
