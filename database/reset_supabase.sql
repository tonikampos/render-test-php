-- =========================================================================
-- SCRIPT DE RESETEO DE BASE DE DATOS PARA SUPABASE
-- =========================================================================
-- Este script ELIMINA todos los datos de todas las tablas,
-- pero mantiene la estructura (tablas, columnas, relaciones, índices).
-- Luego crea usuarios de prueba básicos y categorías.
--
-- ⚠️ ADVERTENCIA: Este script es DESTRUCTIVO.
-- ⚠️ Todos los datos actuales se perderán permanentemente.
--
-- CÓMO USAR:
-- 1. Ir a Supabase → SQL Editor
-- 2. Copiar y pegar este script completo
-- 3. Click en "Run" (o Ctrl+Enter)
-- =========================================================================

-- =========================================================================
-- PASO 1: ELIMINAR TODOS LOS DATOS (orden correcto para respetar FKs)
-- =========================================================================

-- Deshabilitar triggers temporalmente para acelerar el proceso
SET session_replication_role = 'replica';

-- Eliminar datos en orden de dependencias (de dependientes a independientes)
TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;
TRUNCATE TABLE participantes_conversacion CASCADE;
TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;
TRUNCATE TABLE reportes RESTART IDENTITY CASCADE;
TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;
TRUNCATE TABLE password_resets RESTART IDENTITY CASCADE;
TRUNCATE TABLE sesiones RESTART IDENTITY CASCADE;
TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;
TRUNCATE TABLE categorias_habilidades RESTART IDENTITY CASCADE;

-- Reactivar triggers
SET session_replication_role = 'origin';

-- =========================================================================
-- PASO 2: CREAR CATEGORÍAS DE HABILIDADES
-- =========================================================================

INSERT INTO categorias_habilidades (nombre, descripcion, icono) VALUES
('Tecnología e Informática', 'Programación, diseño web, redes, etc.', '💻'),
('Idiomas', 'Enseñanza y práctica de idiomas', '🌍'),
('Música', 'Instrumentos, teoría musical, canto', '🎵'),
('Deportes y Fitness', 'Entrenamiento, yoga, artes marciales', '⚽'),
('Cocina y Gastronomía', 'Recetas, técnicas culinarias', '🍳'),
('Arte y Diseño', 'Pintura, dibujo, diseño gráfico', '🎨'),
('Clases y Formación', 'Materias académicas, apoyo escolar', '📚'),
('Otros', 'Otras habilidades', '🔧');

-- =========================================================================
-- PASO 3: CREAR USUARIOS DE PRUEBA
-- =========================================================================

-- Contraseña para todos los usuarios: Pass123456
-- Hash generado con bcrypt (cost 12)
-- PHP: password_hash('Pass123456', PASSWORD_BCRYPT, ['cost' => 12])

INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo) VALUES
(
    'admin',
    'admin@galitroco.com',
    '$2y$12$Jtnxb1ibPwo15QLWLfxLp.ZHtdvtNXgVXk0ngl7md8o2S8n/oZyOW',
    'administrador',
    'Administrador del sistema GaliTroco',
    'Santiago de Compostela',
    true
),
(
    'usuario_demo',
    'demo@galitroco.com',
    '$2y$12$Jtnxb1ibPwo15QLWLfxLp.ZHtdvtNXgVXk0ngl7md8o2S8n/oZyOW',
    'usuario',
    'Usuario de demostración para pruebas',
    'A Coruña',
    true
),
(
    'test_user',
    'test@galitroco.com',
    '$2y$12$Jtnxb1ibPwo15QLWLfxLp.ZHtdvtNXgVXk0ngl7md8o2S8n/oZyOW',
    'usuario',
    'Usuario de pruebas',
    'Vigo',
    true
);

-- =========================================================================
-- VERIFICACIÓN FINAL
-- =========================================================================

-- Mostrar resumen de datos creados
SELECT 'Categorías creadas' as tabla, COUNT(*) as registros FROM categorias_habilidades
UNION ALL
SELECT 'Usuarios creados' as tabla, COUNT(*) as registros FROM usuarios
UNION ALL
SELECT 'Habilidades' as tabla, COUNT(*) as registros FROM habilidades
UNION ALL
SELECT 'Intercambios' as tabla, COUNT(*) as registros FROM intercambios
UNION ALL
SELECT 'Mensajes' as tabla, COUNT(*) as registros FROM mensajes
UNION ALL
SELECT 'Valoraciones' as tabla, COUNT(*) as registros FROM valoraciones;

-- =========================================================================
-- ✅ RESETEO COMPLETADO
-- =========================================================================
-- 
-- ESTADO FINAL:
-- ✅ Todos los datos anteriores eliminados
-- ✅ Estructura de BD intacta (tablas, FKs, índices)
-- ✅ Secuencias reiniciadas (IDs comienzan desde 1)
-- ✅ 8 categorías de habilidades creadas
-- ✅ 3 usuarios de prueba creados
--
-- CREDENCIALES DE ACCESO:
-- 
-- Administrador:
--   Email:    admin@galitroco.com
--   Password: Pass123456
--   Rol:      administrador
--
-- Usuario Demo:
--   Email:    demo@galitroco.com
--   Password: Pass123456
--   Rol:      usuario
--
-- Usuario Test:
--   Email:    test@galitroco.com
--   Password: Pass123456
--   Rol:      usuario
--
-- =========================================================================
