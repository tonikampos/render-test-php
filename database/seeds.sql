-- #############################################################################
-- ## Datos de Prueba (Seeds) para "GaliTroco"
-- ## Ejecutar DESPUÉS de schema.sql
-- #############################################################################

-- ========= USUARIOS DE PRUEBA =========

INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion) VALUES
-- Contraseña para todos: 'password123' (debes hashearla en producción)
('maria_garcia', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Profesora de inglés con 10 años de experiencia. Me encanta enseñar y aprender cosas nuevas.', 'A Coruña'),
('juan_lopez', 'juan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Técnico informático freelance. Puedo ayudarte con tu PC o enseñarte programación.', 'Santiago'),
('ana_martinez', 'ana@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Apasionada de la cocina y la repostería. Hago tartas personalizadas.', 'Vigo'),
('pedro_rodriguez', 'pedro@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Fontanero profesional. También hago pequeñas reparaciones en el hogar.', 'Ferrol'),
('laura_fernandez', 'laura@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Diseñadora gráfica y fotógrafa. Capturo momentos especiales.', 'Lugo'),
('carlos_sanchez', 'carlos@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Guitarrista y profesor de música. Doy clases de guitarra para principiantes.', 'Pontevedra'),
('admin_galitroco', 'admin@galitroco.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'Administrador del sistema GaliTroco.', 'A Coruña');


-- ========= HABILIDADES DE PRUEBA (OFERTAS) =========

INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada) VALUES
-- Ofertas de María (Clases y Formación)
(1, 3, 'oferta', 'Clases de inglés nivel básico e intermedio', 'Profesora titulada con experiencia. Clases dinámicas y personalizadas. Preparación para exámenes oficiales.', 60),
(1, 3, 'oferta', 'Apoyo escolar para primaria', 'Ayuda con deberes y refuerzo en todas las asignaturas de educación primaria.', 90),

-- Ofertas de Juan (Tecnología)
(2, 2, 'oferta', 'Reparación y mantenimiento de ordenadores', 'Formateo, instalación de programas, eliminación de virus, actualización de componentes.', 120),
(2, 2, 'oferta', 'Clases de programación web (HTML, CSS, JavaScript)', 'Aprende a crear páginas web desde cero. Para principiantes.', 120),

-- Ofertas de Ana (Cocina)
(3, 8, 'oferta', 'Clases de repostería casera', 'Aprende a hacer tartas, galletas, cupcakes y postres deliciosos.', 180),
(3, 8, 'oferta', 'Catering para eventos pequeños', 'Menús personalizados para cumpleaños, reuniones familiares (máx. 20 personas).', 240),

-- Ofertas de Pedro (Hogar)
(4, 1, 'oferta', 'Reparación de grifos y desatascos', 'Soluciono problemas de fontanería básica en el hogar.', 90),
(4, 1, 'oferta', 'Montaje de muebles', 'Monto muebles de IKEA y similares. Herramientas propias.', 120),

-- Ofertas de Laura (Arte)
(5, 4, 'oferta', 'Sesión de fotos familiar o de eventos', 'Fotografía profesional para eventos, familias, mascotas. Retoque básico incluido.', 120),
(5, 4, 'oferta', 'Diseño de logos e identidad corporativa', 'Creo logos profesionales para tu negocio o proyecto.', 180),

-- Ofertas de Carlos (Música)
(6, 3, 'oferta', 'Clases de guitarra acústica y eléctrica', 'Para todos los niveles. Aprende tus canciones favoritas.', 60),
(6, 3, 'oferta', 'Amenización musical para eventos', 'Toco en bodas, cumpleaños y eventos. Amplio repertorio.', 180);


-- ========= HABILIDADES DE PRUEBA (DEMANDAS) =========

INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada) VALUES
-- Demandas de María
(1, 1, 'demanda', 'Necesito pintar mi salón', 'Busco alguien con experiencia en pintura de interiores. Pintura incluida.', 480),
(1, 7, 'demanda', 'Mudanza pequeña (furgoneta)', 'Necesito trasladar algunos muebles a otra ciudad cercana.', 240),

-- Demandas de Juan
(2, 8, 'demanda', 'Clases de cocina básica', 'Quiero aprender a cocinar platos sencillos y saludables.', 120),
(2, 5, 'demanda', 'Corte de pelo a domicilio', 'Busco peluquero/a que se desplace a domicilio.', 45),

-- Demandas de Ana
(3, 2, 'demanda', 'Configuración de red WiFi en casa', 'Tengo problemas con la señal WiFi. Necesito ayuda para optimizarla.', 90),
(3, 4, 'demanda', 'Sesión de fotos para Instagram', 'Necesito fotos profesionales para mi perfil de repostería.', 60),

-- Demandas de Pedro
(4, 3, 'demanda', 'Clases de inglés para viajar', 'Necesito inglés básico para poder comunicarme en viajes.', 60),
(4, 4, 'demanda', 'Reparación de una silla de madera', 'Tengo una silla antigua que necesita arreglo de carpintería.', 120),

-- Demandas de Laura
(5, 1, 'demanda', 'Instalación de estantería en pared', 'Necesito colgar varias estanterías. Tengo los materiales.', 60),
(5, 3, 'demanda', 'Clases de guitarra para principiante', 'Siempre quise aprender. Nivel cero absoluto.', 60),

-- Demandas de Carlos
(6, 2, 'demanda', 'Creación de página web sencilla', 'Necesito una web para promocionar mis clases de música.', 300),
(6, 6, 'demanda', 'Asesoramiento para declaración de autónomo', 'Primera vez que voy a darme de alta como autónomo.', 90);


-- ========= INTERCAMBIOS DE PRUEBA =========

INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES
-- María propone a Juan: Clases de inglés por Reparación de PC
(1, 15, 1, 2, 'aceptado', '¡Hola Juan! Vi que ofreces reparación de ordenadores. Me interesa mucho. Te propongo clases de inglés a cambio. ¿Qué te parece?', CURRENT_TIMESTAMP - INTERVAL '5 days'),

-- Ana propone a Laura: Clases de repostería por Sesión de fotos
(5, 18, 3, 5, 'completado', 'Hola Laura, necesito fotos profesionales para mi Instagram de repostería. ¿Te interesan clases de repostería a cambio?', CURRENT_TIMESTAMP - INTERVAL '10 days'),

-- Pedro propone a Carlos: Reparación fontanería por Clases de guitarra
(7, 19, 4, 6, 'propuesto', 'Hola Carlos, vi que das clases de guitarra. Siempre quise aprender. Te ofrezco mis servicios de fontanería si los necesitas.', CURRENT_TIMESTAMP - INTERVAL '2 days'),

-- Juan propone a Ana: Configuración WiFi por Clases de cocina
(3, 14, 2, 3, 'aceptado', '¡Hola Ana! Puedo ayudarte con tu red WiFi. Vi que das clases de cocina y me encantaría aprender. ¿Hacemos trueque?', CURRENT_TIMESTAMP - INTERVAL '3 days'),

-- Laura propone a Juan: Diseño de logo por Página web
(10, 22, 5, 2, 'propuesto', 'Hola Juan, necesito una web sencilla. Veo que sabes programación. Te ofrezco diseñar el logo y la identidad visual.', CURRENT_TIMESTAMP - INTERVAL '1 day');


-- ========= CONVERSACIONES Y MENSAJES DE PRUEBA =========

-- Conversación entre María y Juan (Intercambio #1)
INSERT INTO conversaciones (intercambio_id) VALUES (1);

INSERT INTO participantes_conversacion (conversacion_id, usuario_id) VALUES
(1, 1), -- María
(1, 2); -- Juan

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, fecha_envio, leido) VALUES
(1, 1, '¡Hola Juan! ¿Qué tal? Vi tu perfil y me encantaría intercambiar.', CURRENT_TIMESTAMP - INTERVAL '5 days', TRUE),
(1, 2, 'Hola María, encantado. ¿Cuándo te vendría bien empezar?', CURRENT_TIMESTAMP - INTERVAL '5 days', TRUE),
(1, 1, 'Perfecto. ¿Te va bien el lunes a las 18:00?', CURRENT_TIMESTAMP - INTERVAL '4 days', TRUE),
(1, 2, 'Perfecto, el lunes nos vemos. ¿Dónde tienes el ordenador?', CURRENT_TIMESTAMP - INTERVAL '4 days', FALSE);

-- Conversación entre Ana y Laura (Intercambio #2)
INSERT INTO conversaciones (intercambio_id) VALUES (2);

INSERT INTO participantes_conversacion (conversacion_id, usuario_id) VALUES
(2, 3), -- Ana
(2, 5); -- Laura

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, fecha_envio, leido) VALUES
(2, 3, 'Hola Laura, me encantan tus fotos. ¿Te interesan clases de repostería?', CURRENT_TIMESTAMP - INTERVAL '10 days', TRUE),
(2, 5, '¡Claro que sí! Siempre quise aprender. ¿Cuándo hacemos la sesión?', CURRENT_TIMESTAMP - INTERVAL '10 days', TRUE),
(2, 3, 'Genial. La semana que viene. ¿Qué estilo de fotos necesitas?', CURRENT_TIMESTAMP - INTERVAL '9 days', TRUE),
(2, 5, 'Fotos de productos para Instagram, fondo blanco y con ambiente de cocina.', CURRENT_TIMESTAMP - INTERVAL '9 days', TRUE);


-- ========= VALORACIONES DE PRUEBA =========

-- María valora a Juan (después del intercambio #1 completado... bueno, aceptado)
-- En un caso real solo se valoraría después de completar, pero para demo:
INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES
(1, 2, 1, 5, '¡Excelente profesional! Dejó mi ordenador como nuevo y muy rápido. Totalmente recomendable.');

-- Laura valora a Ana (después del intercambio #2 completado)
INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES
(5, 3, 2, 5, 'Ana es una maestra en la cocina. Las clases fueron super divertidas y aprendí muchísimo. ¡Gracias!');

-- Ana valora a Laura
INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES
(3, 5, 2, 5, 'Laura es increíble. Las fotos quedaron espectaculares y muy profesionales. Súper recomendada.');


-- ========= NOTIFICACIONES DE PRUEBA =========

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida) VALUES
-- Notificaciones para Juan
(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María te ha propuesto intercambiar: Clases de inglés por Reparación de PC', '/intercambios/1', 1, TRUE),
(2, 'nuevo_mensaje', 'Nuevo mensaje de María', 'María te ha enviado un mensaje', '/mensajes/1', 1, TRUE),

-- Notificaciones para María
(1, 'intercambio_aceptado', '¡Intercambio aceptado!', 'Juan ha aceptado tu propuesta de intercambio', '/intercambios/1', 1, TRUE),
(1, 'nueva_valoracion', 'Nueva valoración recibida', 'Juan te ha valorado con 5 estrellas', '/perfil/1', 1, FALSE),

-- Notificaciones para Laura
(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Ana te ha propuesto intercambiar: Clases de repostería por Sesión de fotos', '/intercambios/2', 2, TRUE),
(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Ana se ha marcado como completado', '/intercambios/2', 2, TRUE),

-- Notificaciones para Carlos
(6, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Pedro te ha propuesto intercambiar: Reparación fontanería por Clases de guitarra', '/intercambios/3', 3, FALSE);


-- ========= REPORTES DE PRUEBA (para testing del panel admin) =========

INSERT INTO reportes (reportador_id, tipo_contenido, contenido_id, motivo, estado) VALUES
(2, 'habilidad', 999, 'Esta habilidad parece ser spam o fraudulenta.', 'pendiente'),
(3, 'perfil', 999, 'Este usuario tiene comportamiento sospechoso.', 'revisado');


-- #############################################################################
-- ## FIN DE LOS SEEDS
-- #############################################################################

-- ========= CONSULTAS ÚTILES PARA VERIFICAR LOS DATOS =========

-- Ver todos los usuarios con sus estadísticas
-- SELECT * FROM estadisticas_usuarios ORDER BY valoracion_promedio DESC;

-- Ver todos los intercambios activos
-- SELECT i.*, h1.titulo as ofrecida, h2.titulo as solicitada, u1.nombre_usuario as proponente, u2.nombre_usuario as receptor
-- FROM intercambios i
-- JOIN habilidades h1 ON i.habilidad_ofrecida_id = h1.id
-- JOIN habilidades h2 ON i.habilidad_solicitada_id = h2.id
-- JOIN usuarios u1 ON i.proponente_id = u1.id
-- JOIN usuarios u2 ON i.receptor_id = u2.id
-- WHERE i.estado IN ('propuesto', 'aceptado');

-- Ver mensajes no leídos por usuario
-- SELECT u.nombre_usuario, COUNT(*) as mensajes_no_leidos
-- FROM mensajes m
-- JOIN conversaciones c ON m.conversacion_id = c.id
-- JOIN participantes_conversacion pc ON c.id = pc.conversacion_id
-- JOIN usuarios u ON pc.usuario_id = u.id
-- WHERE m.leido = FALSE AND m.emisor_id != u.id
-- GROUP BY u.nombre_usuario;
