-- =========================================================================
-- SCRIPT DE INSERCIÓN - Datos demo para defensa TFM
-- =========================================================================
-- Usuarios: 4, 6, 7 (cada uno con 3 ofertas + 1 demanda)
-- Ambientación: Galicia / Carballo
-- =========================================================================

-- =========================================================================
-- USUARIO 4: Perfil cultural/tradicional gallego
-- =========================================================================

-- OFERTA 1: Gaita gallega (EN GALLEGO - autenticidad cultural)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    4,
    7,
    'oferta',
    'Clases de gaita gallega para principiantes',
    'Ensino a tocar a gaita galega desde cero. Veremos respiración, digitación, punteo, escalas e melodías tradicionais. Inclúo notas sobre a música tradicional galega e ás festas populares de Carballo. Ideal para quen queira conectar coa cultura galega.',
    90,
    'activa'
);

-- OFERTA 2: Cocina gallega tradicional (EN GALLEGO - autenticidad cultural)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    4,
    4,
    'oferta',
    'Cociña galega tradicional: empanada, pulpo e caldos',
    'Aprende a facer os pratos típicos galegos: empanada de lura, polbo á feira, caldo galego, filloas e tarta de Santiago. Ensino as técnicas tradicionais que aprendín da miña avoa en Carballo. Sesións prácticas con degustación incluída.',
    120,
    'activa'
);

-- OFERTA 3: Rutas senderismo Costa da Morte
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    4,
    8,
    'oferta',
    'Rutas de senderismo por la Costa da Morte',
    'Organizo rutas de senderismo por la Costa da Morte: Cabo Vilán, Monte Branco, Camino de los Faros. Conozco muy bien toda la zona de Carballo y alrededores. Explico la historia, leyendas y naturaleza de la comarca. Para todos los niveles físicos.',
    180,
    'activa'
);

-- DEMANDA 1: Fotografía de paisajes
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    4,
    3,
    'demanda',
    'Busco aprender fotografía de paisajes',
    'Quiero mejorar mis fotos de los paisajes gallegos. Tengo una cámara pero no sé usar bien el modo manual. Me gustaría aprender sobre exposición, filtros y composición para capturar la belleza de la Costa da Morte y sus atardeceres.',
    90,
    'activa'
);

-- =========================================================================
-- USUARIO 6: Perfil técnico/profesional
-- =========================================================================

-- OFERTA 1: Desarrollo web
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    2,
    'oferta',
    'Desarrollo web con Angular y TypeScript',
    'Enseño desarrollo web moderno con Angular, TypeScript, HTML5 y CSS3. Tengo 6 años de experiencia como programador en Carballo trabajando con empresas locales. Aprenderás desde la configuración del proyecto hasta el despliegue en producción.',
    120,
    'activa'
);

-- OFERTA 2: Inglés para el turismo
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    1,
    'oferta',
    'Inglés práctico para turismo y hostelería',
    'Clases de inglés orientado al sector turístico en Galicia. Vocabulario específico para alojamientos, restaurantes, rutas y atención al peregrino del Camino. Certificado B2 de Cambridge. Útil para profesionales de la zona de Carballo y Bergantiños.',
    60,
    'activa'
);

-- OFERTA 3: Reparación de ordenadores
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    2,
    'oferta',
    'Reparación y mantenimiento de ordenadores',
    'Ayudo con problemas de hardware y software: instalación de sistemas operativos, limpieza de virus, cambio de componentes, optimización. Trabajo en Carballo y tengo experiencia tanto en Windows como Linux. Servicio a domicilio en la comarca.',
    90,
    'activa'
);

-- DEMANDA 1: Gaita gallega
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    7,
    'demanda',
    'Aprender a tocar la gaita gallega',
    'Siempre quise aprender a tocar la gaita pero nunca encontré tiempo. Ahora me gustaría empezar desde cero, aprender lo básico y poder tocar alguna muiñeira en las fiestas de Carballo. Busco alguien paciente que enseñe bien los fundamentos.',
    90,
    'activa'
);

-- =========================================================================
-- USUARIO 7: Perfil artístico/creativo
-- =========================================================================

-- OFERTA 1: Fotografía de paisajes
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    3,
    'oferta',
    'Fotografía de paisajes y naturaleza en Galicia',
    'Enseño fotografía de paisajes con la Costa da Morte como escenario. Aprenderás modo manual, composición, filtros ND, long exposure en los faros y playas de Carballo. Salidas fotográficas al amanecer y atardecer. Edición con Lightroom incluida.',
    120,
    'activa'
);

-- OFERTA 2: Yoga y meditación
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    8,
    'oferta',
    'Yoga y meditación en contacto con la naturaleza',
    'Imparto clases de Hatha Yoga y meditación mindfulness. Siempre que el tiempo acompaña hacemos las sesiones al aire libre, en las playas de Razo o Baldaio. Técnicas de respiración, posturas básicas y relajación. Certificación con 8 años de práctica.',
    60,
    'activa'
);

-- OFERTA 3: Cerámica artesanal
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    5,
    'oferta',
    'Cerámica artesanal y alfarería básica',
    'Enseño cerámica desde lo básico: trabajo con el torno, modelado, esmaltes y cocción. Tengo mi taller en Carballo donde hacemos piezas únicas inspiradas en la naturaleza gallega. Ideal para quien busque un hobby relajante y creativo.',
    120,
    'activa'
);

-- DEMANDA 1: Cocina gallega (EN GALLEGO - autenticidad cultural)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    4,
    'demanda',
    'Aprender cociña galega tradicional',
    'Gustaríame aprender a cociñar pratos típicos galegos como a empanada, o polbo ou o caldo. Veño de fóra de Galicia e quero conectar coa cultura gastronómica local. Busco alguén que ensine as recetas tradicionais de Carballo e arredores.',
    120,
    'activa'
);

-- Verificar inserción de los tres usuarios
SELECT 
    u.nombre_usuario,
    h.tipo,
    h.titulo,
    c.nombre as categoria
FROM habilidades h
JOIN usuarios u ON h.usuario_id = u.id
JOIN categorias_habilidades c ON h.categoria_id = c.id
WHERE u.id IN (4, 6, 7)
ORDER BY u.id, h.tipo DESC, h.id;
