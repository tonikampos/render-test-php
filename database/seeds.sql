-- =========================================================================
-- DATOS DE MUESTRA
-- =========================================================================

-- Datos de: usuarios
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (1, 'admin', 'admin@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'administrador', 'Administrador del sistema GaliTroco', NULL, 'Santiago de Compostela', TRUE, '2025-10-24 00:18:44.749445+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (2, 'usuario_demo', 'demo@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'usuario', 'Usuario de demostración para pruebas', NULL, 'A Coruña', TRUE, '2025-10-24 00:18:44.749445+02', NULL);
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, foto_url, ubicacion, activo, fecha_registro, ultima_conexion)
VALUES (3, 'test_user', 'test@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'usuario', 'Usuario de pruebas', NULL, 'Vigo', TRUE, '2025-10-24 00:18:44.749445+02', NULL);

-- Datos de: categorias_habilidades
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (1, 'Tecnología e Informática', 'Programación, diseño web, redes, etc.', '💻');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (2, 'Idiomas', 'Enseñanza y práctica de idiomas', '🌍');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (3, 'Música', 'Instrumentos, teoría musical, canto', '🎵');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (4, 'Deportes y Fitness', 'Entrenamiento, yoga, artes marciales', '⚽');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (5, 'Cocina y Gastronomía', 'Recetas, técnicas culinarias', '🍳');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (6, 'Arte y Diseño', 'Pintura, dibujo, diseño gráfico', '🎨');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (7, 'Clases y Formación', 'Materias académicas, apoyo escolar', '📚');
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES (8, 'Otros', 'Otras habilidades', '🔧');

-- Datos de: habilidades (ejemplos de demostración)
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (1, 1, 1, 'oferta', 'Clases de Angular y desarrollo web', 'Ofrezco clases de Angular 18+ y desarrollo frontend. Experiencia con TypeScript, RxJS y arquitectura de componentes.', 'activa', 60, '2025-10-25 10:00:00+02', '2025-10-25 10:00:00+02');

INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (2, 1, 2, 'demanda', 'Busco clases de inglés conversacional', 'Me gustaría mejorar mi inglés hablado para presentaciones técnicas. Nivel actual B1-B2.', 'activa', 60, '2025-10-25 10:30:00+02', '2025-10-25 10:30:00+02');

INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (3, 2, 2, 'oferta', 'Clases de inglés - Native speaker', 'Soy profesor nativo de inglés con experiencia en conversación y preparación de exámenes Cambridge.', 'activa', 60, '2025-10-25 11:00:00+02', '2025-10-25 11:00:00+02');

INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (4, 2, 5, 'demanda', 'Busco clases de cocina gallega tradicional', 'Quiero aprender a cocinar platos típicos gallegos: pulpo, empanada, caldo gallego, etc.', 'activa', 90, '2025-10-25 11:30:00+02', '2025-10-25 11:30:00+02');

INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (5, 3, 3, 'oferta', 'Clases de guitarra acústica y eléctrica', 'Ofrezco clases de guitarra para principiantes e intermedios. Rock, pop y blues principalmente.', 'activa', 60, '2025-10-26 09:00:00+02', '2025-10-26 09:00:00+02');

INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada, fecha_publicacion, fecha_actualizacion)
VALUES (6, 3, 1, 'demanda', 'Necesito ayuda con bases de datos PostgreSQL', 'Busco alguien que me ayude a optimizar consultas y entender mejor índices y performance en PostgreSQL.', 'activa', 90, '2025-10-26 09:30:00+02', '2025-10-26 09:30:00+02');

-- Datos de: intercambios (ejemplo de demostración)
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta, fecha_actualizacion)
VALUES (1, 1, 3, 1, 2, 'propuesto', 'Hola! He visto tu oferta de clases de inglés. Me interesa mucho mejorar mi conversación. ¿Te interesaría intercambiar por clases de Angular? Un saludo!', '2025-10-26 12:00:00+02', '2025-10-26 12:00:00+02');

-- Actualizar secuencias (importante para inserts posteriores)
SELECT setval('usuarios_id_seq', (SELECT MAX(id) FROM usuarios));
SELECT setval('categorias_habilidades_id_seq', (SELECT MAX(id) FROM categorias_habilidades));
SELECT setval('habilidades_id_seq', (SELECT MAX(id) FROM habilidades));
SELECT setval('intercambios_id_seq', (SELECT MAX(id) FROM intercambios));

