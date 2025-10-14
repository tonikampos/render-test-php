TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE participantes_conversacion CASCADE;

INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES
(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days'),
(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES
(1, 3, NOW() - INTERVAL '15 days'),
(1, 5, NOW() - INTERVAL '15 days'),
(2, 2, NOW() - INTERVAL '7 days'),
(2, 1, NOW() - INTERVAL '7 days');

SELECT COUNT(*) as total_conversaciones FROM conversaciones;
SELECT COUNT(*) as total_participantes FROM participantes_conversacion;
