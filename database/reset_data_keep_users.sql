

BEGIN;
DELETE FROM mensajes;
DELETE FROM participantes_conversacion;
DELETE FROM conversaciones;
DELETE FROM valoraciones;
DELETE FROM intercambios;
DELETE FROM habilidades;
DELETE FROM notificaciones;
DELETE FROM reportes;
DELETE FROM sesiones;
DELETE FROM password_resets;
ALTER SEQUENCE habilidades_id_seq RESTART WITH 1;
ALTER SEQUENCE intercambios_id_seq RESTART WITH 1;
ALTER SEQUENCE conversaciones_id_seq RESTART WITH 1;
ALTER SEQUENCE mensajes_id_seq RESTART WITH 1;
ALTER SEQUENCE notificaciones_id_seq RESTART WITH 1;
ALTER SEQUENCE valoraciones_id_seq RESTART WITH 1;
ALTER SEQUENCE reportes_id_seq RESTART WITH 1;
ALTER SEQUENCE sesiones_id_seq RESTART WITH 1;
ALTER SEQUENCE password_resets_id_seq RESTART WITH 1;
commit;



BEGIN;

-- 1. Eliminar mensajes (depende de conversaciones)
DELETE FROM mensajes;
RAISE NOTICE 'Mensajes eliminados';

-- 2. Eliminar participantes_conversacion (depende de conversaciones)
DELETE FROM participantes_conversacion;
RAISE NOTICE 'Participantes de conversación eliminados';

-- 3. Eliminar conversaciones (depende de intercambios)
DELETE FROM conversaciones;
RAISE NOTICE 'Conversaciones eliminadas';

-- 4. Eliminar valoraciones (depende de intercambios y usuarios)
DELETE FROM valoraciones;
RAISE NOTICE 'Valoraciones eliminadas';

-- 5. Eliminar intercambios (depende de habilidades y usuarios)
DELETE FROM intercambios;
RAISE NOTICE 'Intercambios eliminados';

-- 6. Eliminar habilidades (depende de usuarios y categorías)
DELETE FROM habilidades;
RAISE NOTICE 'Habilidades eliminadas';

-- 7. Eliminar notificaciones (depende de usuarios)
DELETE FROM notificaciones;
RAISE NOTICE 'Notificaciones eliminadas';

-- 8. Eliminar reportes (depende de usuarios)
DELETE FROM reportes;
RAISE NOTICE 'Reportes eliminados';

-- 9. Eliminar sesiones activas (depende de usuarios)
DELETE FROM sesiones;
RAISE NOTICE 'Sesiones eliminadas';

-- 10. Eliminar tokens de recuperación de contraseña
DELETE FROM password_resets;
RAISE NOTICE 'Tokens de password eliminados';

-- Resetear secuencias (IDs empiezan desde 1 otra vez)
ALTER SEQUENCE habilidades_id_seq RESTART WITH 1;
ALTER SEQUENCE intercambios_id_seq RESTART WITH 1;
ALTER SEQUENCE conversaciones_id_seq RESTART WITH 1;
ALTER SEQUENCE mensajes_id_seq RESTART WITH 1;
ALTER SEQUENCE notificaciones_id_seq RESTART WITH 1;
ALTER SEQUENCE valoraciones_id_seq RESTART WITH 1;
ALTER SEQUENCE reportes_id_seq RESTART WITH 1;
ALTER SEQUENCE sesiones_id_seq RESTART WITH 1;
ALTER SEQUENCE password_resets_id_seq RESTART WITH 1;

COMMIT;

-- =========================================================================
-- VERIFICACIÓN FINAL
-- =========================================================================
SELECT 
    'usuarios' as tabla, COUNT(*) as registros FROM usuarios
UNION ALL
SELECT 'categorias_habilidades', COUNT(*) FROM categorias_habilidades
UNION ALL
SELECT 'habilidades', COUNT(*) FROM habilidades
UNION ALL
SELECT 'intercambios', COUNT(*) FROM intercambios
UNION ALL
SELECT 'conversaciones', COUNT(*) FROM conversaciones
UNION ALL
SELECT 'mensajes', COUNT(*) FROM mensajes
UNION ALL
SELECT 'notificaciones', COUNT(*) FROM notificaciones
UNION ALL
SELECT 'valoraciones', COUNT(*) FROM valoraciones
UNION ALL
SELECT 'reportes', COUNT(*) FROM reportes
UNION ALL
SELECT 'sesiones', COUNT(*) FROM sesiones
UNION ALL
SELECT 'password_resets', COUNT(*) FROM password_resets
ORDER BY tabla;

