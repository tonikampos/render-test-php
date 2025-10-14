TTRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES
(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?', true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),
(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),
(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),
(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),
(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),
(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!', true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days'),
(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),
(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),
(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?', true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),
(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.', false, NOW() - INTERVAL '6 days', NULL);

SELECT COUNT(*) as total_mensajes FROM mensajes;
