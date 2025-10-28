-- =========================================================================
-- DATOS DE MUESTRA - GaliTroco
-- =========================================================================
-- Este archivo contiene datos de ejemplo para testing y demostración
-- Contraseña para todos los usuarios: Pass123456
-- =========================================================================

-- Usuarios de prueba
INSERT INTO usuarios (id, nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo)
VALUES 
(1, 'admin', 'admin@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'administrador', 'Administrador del sistema GaliTroco', 'Santiago de Compostela', TRUE),
(2, 'usuario_demo', 'demo@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'usuario', 'Usuario de demostración para pruebas', 'A Coruña', TRUE),
(3, 'test_user', 'test@galitroco.com', '$2y$12$vGgtjnKBImJeaWMgmwdiE.JPrzPE.EauHfvetbA4rZmwd17mfunoi', 'usuario', 'Usuario de pruebas', 'Vigo', TRUE);

-- Categorías de habilidades
INSERT INTO categorias_habilidades (id, nombre, descripcion, icono)
VALUES 
(1, 'Tecnología e Informática', 'Programación, diseño web, redes, etc.', '💻'),
(2, 'Idiomas', 'Enseñanza y práctica de idiomas', '🌍'),
(3, 'Música', 'Instrumentos, teoría musical, canto', '🎵'),
(4, 'Deportes y Fitness', 'Entrenamiento, yoga, artes marciales', '⚽'),
(5, 'Cocina y Gastronomía', 'Recetas, técnicas culinarias', '🍳'),
(6, 'Arte y Diseño', 'Pintura, dibujo, diseño gráfico', '🎨'),
(7, 'Clases y Formación', 'Materias académicas, apoyo escolar', '📚'),
(8, 'Otros', 'Otras habilidades', '🔧');

-- Habilidades de ejemplo (2 por usuario: 1 oferta + 1 demanda)
INSERT INTO habilidades (id, usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada)
VALUES 
(1, 1, 1, 'oferta', 'Clases de Angular y desarrollo web', 'Ofrezco clases de Angular 18+ y desarrollo frontend. Experiencia con TypeScript, RxJS y arquitectura de componentes.', 'activa', 60),
(2, 1, 2, 'demanda', 'Busco clases de inglés conversacional', 'Me gustaría mejorar mi inglés hablado para presentaciones técnicas. Nivel actual B1-B2.', 'activa', 60),
(3, 2, 2, 'oferta', 'Clases de inglés - Native speaker', 'Soy profesor nativo de inglés con experiencia en conversación y preparación de exámenes Cambridge.', 'activa', 60),
(4, 2, 5, 'demanda', 'Busco clases de cocina gallega tradicional', 'Quiero aprender a cocinar platos típicos gallegos: pulpo, empanada, caldo gallego, etc.', 'activa', 90),
(5, 3, 3, 'oferta', 'Clases de guitarra acústica y eléctrica', 'Ofrezco clases de guitarra para principiantes e intermedios. Rock, pop y blues principalmente.', 'activa', 60),
(6, 3, 1, 'demanda', 'Necesito ayuda con bases de datos PostgreSQL', 'Busco alguien que me ayude a optimizar consultas y entender mejor índices y performance en PostgreSQL.', 'activa', 90);

-- Intercambio de ejemplo
INSERT INTO intercambios (id, habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta)
VALUES (1, 1, 3, 1, 2, 'propuesto', 'Hola! He visto tu oferta de clases de inglés. Me interesa mucho mejorar mi conversación. ¿Te interesaría intercambiar por clases de Angular? Un saludo!');

-- Actualizar secuencias para permitir inserts futuros
SELECT setval('usuarios_id_seq', 3);
SELECT setval('categorias_habilidades_id_seq', 8);
SELECT setval('habilidades_id_seq', 6);
SELECT setval('intercambios_id_seq', 1);

