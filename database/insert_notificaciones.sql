TTRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES
(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),
(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.', '/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),
(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!', '/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),
(5, 'nueva_valoracion', 'Nueva valoración recibida', 'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),
(3, 'intercambio_aceptado', 'Intercambio aceptado', 'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.', '/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),
(3, 'nueva_valoracion', 'Nueva valoración recibida', 'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),
(3, 'nuevo_mensaje', 'Nuevo mensaje', 'David Pérez te ha enviado un mensaje en la conversación del intercambio.', '/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),
(2, 'intercambio_aceptado', 'Intercambio aceptado', 'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),
(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.', '/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),
(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Toni Campos te ha propuesto un intercambio relacionado con fontanería y desarrollo web.', '/intercambios/4', 4, false, NOW() - INTERVAL '1 day');

SELECT COUNT(*) as total_notificaciones FROM notificaciones;
