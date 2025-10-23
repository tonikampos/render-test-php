-- =========================================================================
-- DATOS DE MUESTRA
-- =========================================================================

-- Datos de: usuarios
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (1, 'maria_garcia', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Profesora de inglÃ©s con 10 aÃ±os de experiencia. Me encanta enseÃ±ar y aprender cosas nuevas.', NULL, 'A CoruÃ±a', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (2, 'juan_lopez', 'juan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'TÃ©cnico informÃ¡tico freelance. Puedo ayudarte con tu PC o enseÃ±arte programaciÃ³n.', NULL, 'Santiago', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (3, 'ana_martinez', 'ana@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Apasionada de la cocina y la reposterÃ­a. Hago tartas personalizadas.', NULL, 'Vigo', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (4, 'pedro_rodriguez', 'pedro@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Fontanero profesional. TambiÃ©n hago pequeÃ±as reparaciones en el hogar.', NULL, 'Ferrol', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (5, 'laura_fernandez', 'laura@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'DiseÃ±adora grÃ¡fica y fotÃ³grafa. Capturo momentos especiales.', NULL, 'Lugo', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (6, 'carlos_sanchez', 'carlos@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Guitarrista y profesor de mÃºsica. Doy clases de guitarra para principiantes.', NULL, 'Pontevedra', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (7, 'admin_galitroco', 'admin@galitroco.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'Administrador del sistema GaliTroco.', NULL, 'A CoruÃ±a', TRUE, '2025-10-02 00:05:53.398492+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (8, 'test_user', 'test@test.com', '$2y$10$W/BkV7k1cuIBOJt1Ie2PfeNyQeyKKGUwGTvRcsMbz0iWgY5.eixa2', 'usuario', NULL, NULL, 'A Coruna', TRUE, '2025-10-02 00:07:46.239367+02', '2025-10-02 00:08:40.883705+02');

-- Datos de: categorias_habilidades
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (1, 'Hogar y Bricolaje', 'Reparaciones, pintura, carpinterÃ­a', 'home');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (2, 'TecnologÃ­a e InformÃ¡tica', 'ProgramaciÃ³n, diseÃ±o web, reparaciÃ³n PC', 'computer');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (3, 'Clases y FormaciÃ³n', 'Idiomas, mÃºsica, apoyo escolar', 'school');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (4, 'Arte y Creatividad', 'FotografÃ­a, dibujo, manualidades', 'palette');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (5, 'Cuidado Personal y Bienestar', 'PeluquerÃ­a, masajes, entrenamiento', 'spa');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (6, 'Gestiones y TrÃ¡mites', 'Asesoramiento legal, contabilidad', 'folder');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (7, 'Transporte y LogÃ­stica', 'Mudanzas, mensajerÃ­a, desplazamientos', 'local_shipping');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (8, 'Cocina y AlimentaciÃ³n', 'Catering, reposterÃ­a, clases de cocina', 'restaurant');

-- Datos de: habilidades
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (1, 1, 3, 'oferta', 'Clases de inglÃ©s nivel bÃ¡sico e intermedio', 'Profesora titulada con experiencia. Clases dinÃ¡micas y personalizadas. PreparaciÃ³n para exÃ¡menes oficiales.', 'activa', 60, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (2, 1, 3, 'oferta', 'Apoyo escolar para primaria', 'Ayuda con deberes y refuerzo en todas las asignaturas de educaciÃ³n primaria.', 'activa', 90, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (3, 2, 2, 'oferta', 'ReparaciÃ³n y mantenimiento de ordenadores', 'Formateo, instalaciÃ³n de programas, eliminaciÃ³n de virus, actualizaciÃ³n de componentes.', 'activa', 120, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (4, 2, 2, 'oferta', 'Clases de programaciÃ³n web (HTML, CSS, JavaScript)', 'Aprende a crear pÃ¡ginas web desde cero. Para principiantes.', 'activa', 120, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (5, 3, 8, 'oferta', 'Clases de reposterÃ­a casera', 'Aprende a hacer tartas, galletas, cupcakes y postres deliciosos.', 'activa', 180, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (6, 3, 8, 'oferta', 'Catering para eventos pequeÃ±os', 'MenÃºs personalizados para cumpleaÃ±os, reuniones familiares (mÃ¡x. 20 personas).', 'activa', 240, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (7, 4, 1, 'oferta', 'ReparaciÃ³n de grifos y desatascos', 'Soluciono problemas de fontanerÃ­a bÃ¡sica en el hogar.', 'activa', 90, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (8, 4, 1, 'oferta', 'Montaje de muebles', 'Monto muebles de IKEA y similares. Herramientas propias.', 'activa', 120, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (9, 5, 4, 'oferta', 'SesiÃ³n de fotos familiar o de eventos', 'FotografÃ­a profesional para eventos, familias, mascotas. Retoque bÃ¡sico incluido.', 'activa', 120, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (10, 5, 4, 'oferta', 'DiseÃ±o de logos e identidad corporativa', 'Creo logos profesionales para tu negocio o proyecto.', 'activa', 180, '2025-10-02 00:05:53.416416+02', '2025-10-02 00:05:53.416416+02');

-- Datos de: intercambios
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion, fecha_completado, notas_adicionales)
VALUES (1, 1, 15, 1, 2, 'aceptado', 'Â¡Hola Juan! Vi que ofreces reparaciÃ³n de ordenadores. Me interesa mucho. Te propongo clases de inglÃ©s a cambio. Â¿QuÃ© te parece?', '2025-09-27 00:05:53.422457+02', '2025-10-02 00:05:53.422457+02', NULL, NULL);
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion, fecha_completado, notas_adicionales)
VALUES (2, 5, 18, 3, 5, 'completado', 'Hola Laura, necesito fotos profesionales para mi Instagram de reposterÃ­a. Â¿Te interesan clases de reposterÃ­a a cambio?', '2025-09-22 00:05:53.422457+02', '2025-10-02 00:05:53.422457+02', NULL, NULL);
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion, fecha_completado, notas_adicionales)
VALUES (3, 7, 19, 4, 6, 'propuesto', 'Hola Carlos, vi que das clases de guitarra. Siempre quise aprender. Te ofrezco mis servicios de fontanerÃ­a si los necesitas.', '2025-09-30 00:05:53.422457+02', '2025-10-02 00:05:53.422457+02', NULL, NULL);
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion, fecha_completado, notas_adicionales)
VALUES (4, 3, 14, 2, 3, 'aceptado', 'Â¡Hola Ana! Puedo ayudarte con tu red WiFi. Vi que das clases de cocina y me encantarÃ­a aprender. Â¿Hacemos trueque?', '2025-09-29 00:05:53.422457+02', '2025-10-02 00:05:53.422457+02', NULL, NULL);
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion, fecha_completado, notas_adicionales)
VALUES (5, 10, 22, 5, 2, 'propuesto', 'Hola Juan, necesito una web sencilla. Veo que sabes programaciÃ³n. Te ofrezco diseÃ±ar el logo y la identidad visual.', '2025-10-01 00:05:53.422457+02', '2025-10-02 00:05:53.422457+02', NULL, NULL);

-- Datos de: conversaciones
INSERT INTO conversaciones (id, intercambio_id, fecha_creacion, ultima_actualizacion)
VALUES (1, 1, '2025-10-02 00:05:53.425947+02', '2025-10-02 00:05:53.425947+02');
INSERT INTO conversaciones (id, intercambio_id, fecha_creacion, ultima_actualizacion)
VALUES (2, 2, '2025-10-02 00:05:53.431665+02', '2025-10-02 00:05:53.431665+02');

-- Datos de: participantes_conversacion
INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union)
VALUES (1, 1, '2025-10-02 00:05:53.42728+02');
INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union)
VALUES (1, 2, '2025-10-02 00:05:53.42728+02');
INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union)
VALUES (2, 3, '2025-10-02 00:05:53.432335+02');
INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union)
VALUES (2, 5, '2025-10-02 00:05:53.432335+02');

-- Datos de: mensajes
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (1, 1, 1, 'Â¡Hola Juan! Â¿QuÃ© tal? Vi tu perfil y me encantarÃ­a intercambiar.', '2025-09-27 00:05:53.429041+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (2, 1, 2, 'Hola MarÃ­a, encantado. Â¿CuÃ¡ndo te vendrÃ­a bien empezar?', '2025-09-27 00:05:53.429041+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (3, 1, 1, 'Perfecto. Â¿Te va bien el lunes a las 18:00?', '2025-09-28 00:05:53.429041+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (4, 1, 2, 'Perfecto, el lunes nos vemos. Â¿DÃ³nde tienes el ordenador?', '2025-09-28 00:05:53.429041+02', FALSE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (5, 2, 3, 'Hola Laura, me encantan tus fotos. Â¿Te interesan clases de reposterÃ­a?', '2025-09-22 00:05:53.433011+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (6, 2, 5, 'Â¡Claro que sÃ­! Siempre quise aprender. Â¿CuÃ¡ndo hacemos la sesiÃ³n?', '2025-09-22 00:05:53.433011+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (7, 2, 3, 'Genial. La semana que viene. Â¿QuÃ© estilo de fotos necesitas?', '2025-09-23 00:05:53.433011+02', TRUE, NULL);
INSERT INTO mensajes (id, conversacion_id, emisor_id, contenido, fecha_envio, leido, fecha_lectura)
VALUES (8, 2, 5, 'Fotos de productos para Instagram, fondo blanco y con ambiente de cocina.', '2025-09-23 00:05:53.433011+02', TRUE, NULL);

-- Datos de: valoraciones
INSERT INTO valoraciones (id, evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion)
VALUES (1, 1, 2, 1, 5, 'Â¡Excelente profesional! DejÃ³ mi ordenador como nuevo y muy rÃ¡pido. Totalmente recomendable.', '2025-10-02 00:05:53.43392+02');
INSERT INTO valoraciones (id, evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion)
VALUES (2, 5, 3, 2, 5, 'Ana es una maestra en la cocina. Las clases fueron super divertidas y aprendÃ­ muchÃ­simo. Â¡Gracias!', '2025-10-02 00:05:53.436218+02');
INSERT INTO valoraciones (id, evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion)
VALUES (3, 3, 5, 2, 5, 'Laura es increÃ­ble. Las fotos quedaron espectaculares y muy profesionales. SÃºper recomendada.', '2025-10-02 00:05:53.436961+02');

-- Datos de: notificaciones
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (1, 2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'MarÃ­a te ha propuesto intercambiar: Clases de inglÃ©s por ReparaciÃ³n de PC', '/intercambios/1', 1, TRUE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (2, 2, 'nuevo_mensaje', 'Nuevo mensaje de MarÃ­a', 'MarÃ­a te ha enviado un mensaje', '/mensajes/1', 1, TRUE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (3, 1, 'intercambio_aceptado', 'Â¡Intercambio aceptado!', 'Juan ha aceptado tu propuesta de intercambio', '/intercambios/1', 1, TRUE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (4, 1, 'nueva_valoracion', 'Nueva valoraciÃ³n recibida', 'Juan te ha valorado con 5 estrellas', '/perfil/1', 1, FALSE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (5, 5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Ana te ha propuesto intercambiar: Clases de reposterÃ­a por SesiÃ³n de fotos', '/intercambios/2', 2, TRUE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (6, 5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Ana se ha marcado como completado', '/intercambios/2', 2, TRUE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);
INSERT INTO notificaciones (id, usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, enviada_email, fecha_creacion, fecha_lectura)
VALUES (7, 6, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Pedro te ha propuesto intercambiar: ReparaciÃ³n fontanerÃ­a por Clases de guitarra', '/intercambios/3', 3, FALSE, FALSE, '2025-10-02 00:05:53.437642+02', NULL);

