-- =========================================================================
-- SCRIPT DE INSERCIÓN - 4 Habilidades tipo OFERTA para usuariocarballo1 (ID: 6)
-- =========================================================================
-- Fecha: 13 de diciembre de 2025
-- =========================================================================

-- Habilidad 1: Clases de Inglés
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    1,
    'oferta',
    'Clases particulares de inglés nivel B2-C1',
    'Ofrezco clases de inglés conversacional y preparación para exámenes oficiales. Tengo certificado C1 de Cambridge y experiencia dando clases particulares. Puedo ayudarte con gramática, conversación, listening y writing.',
    60,
    'activa'
);

-- Habilidad 2: Desarrollo web frontend
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    2,
    'oferta',
    'Desarrollo web con Angular y React',
    'Ofrezco clases de desarrollo frontend moderno. Puedo enseñar Angular, React, TypeScript, HTML5, CSS3, y buenas prácticas de desarrollo. Tengo 5 años de experiencia profesional trabajando en proyectos reales.',
    120,
    'activa'
);

-- Habilidad 3: Fotografía digital
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    3,
    'oferta',
    'Curso básico de fotografía digital y edición',
    'Enseño fotografía digital desde cero: manejo de la cámara, composición, iluminación natural, y edición básica con Lightroom. Ideal para principiantes que quieran mejorar sus fotos de viajes o retratos.',
    90,
    'activa'
);

-- Habilidad 4: Reparación de ordenadores
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    2,
    'oferta',
    'Reparación y mantenimiento de ordenadores',
    'Ofrezco ayuda con problemas de hardware y software: instalación de sistemas operativos, limpieza de virus, cambio de componentes, optimización de rendimiento. Experiencia tanto en Windows como Linux.',
    120,
    'activa'
);

-- Habilidad 5: Clases de guitarra
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    7,
    'oferta',
    'Clases de guitarra acústica y eléctrica',
    'Enseño guitarra desde nivel principiante hasta intermedio. Incluyo teoría musical básica, lectura de tablaturas, acordes, ritmos y técnicas de digitación. Puedo enseñar estilos como rock, pop, blues y flamenco.',
    90,
    'activa'
);

-- Habilidad 6: Carpintería básica
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    6,
    'oferta',
    'Iniciación a la carpintería y restauración de muebles',
    'Ofrezco enseñar carpintería básica: uso de herramientas manuales y eléctricas, técnicas de ensamblaje, lijado, barnizado y restauración de muebles antiguos. Ideal para quien quiera aprender a hacer pequeños proyectos en casa.',
    120,
    'activa'
);

-- Habilidad 7: DEMANDA - Cocina vegetariana
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    4,
    'demanda',
    'Busco aprender cocina vegetariana saludable',
    'Quiero aprender a cocinar platos vegetarianos nutritivos y sabrosos. Me interesa especialmente aprender sobre proteínas vegetales, legumbres y cómo hacer menús semanales equilibrados. Busco alguien con experiencia que me enseñe recetas prácticas.',
    90,
    'activa'
);

-- Habilidad 8: DEMANDA - Yoga para principiantes
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    6,
    8,
    'demanda',
    'Clases de yoga para principiantes',
    'Busco alguien que pueda enseñarme yoga desde cero. Me interesa para mejorar la flexibilidad, reducir el estrés y trabajar la concentración. Prefiero sesiones personalizadas para aprender bien las posturas básicas y la respiración.',
    60,
    'activa'
);

-- =========================================================================
-- HABILIDADES PARA usuariocarballo2 (ID: 7) - Complementarias para intercambios
-- =========================================================================

-- Habilidad 9: OFERTA - Cocina vegetariana (complementa demanda de usuario 6)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    4,
    'oferta',
    'Cocina vegetariana y vegana saludable',
    'Ofrezco clases de cocina vegetariana y vegana. Enseño recetas equilibradas, uso de proteínas vegetales, legumbres, tofu, seitán y cómo planificar menús semanales nutritivos. Más de 10 años de experiencia en alimentación plant-based.',
    90,
    'activa'
);

-- Habilidad 10: OFERTA - Yoga y meditación (complementa demanda de usuario 6)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    8,
    'oferta',
    'Clases de yoga para todos los niveles',
    'Imparto clases de Hatha Yoga y Vinyasa. Incluyo técnicas de respiración, posturas básicas e intermedias, relajación y meditación guiada. Certificado con 8 años de práctica. Ideal para mejorar flexibilidad y reducir estrés.',
    60,
    'activa'
);

-- Habilidad 11: OFERTA - Italiano conversacional
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    1,
    'oferta',
    'Clases de italiano nivel básico e intermedio',
    'Ofrezco clases de italiano conversacional. Soy nativo y puedo ayudarte con pronunciación, gramática básica, vocabulario cotidiano y preparación para viajes. Método práctico centrado en la conversación real.',
    60,
    'activa'
);

-- Habilidad 12: OFERTA - Diseño gráfico con Photoshop
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    3,
    'oferta',
    'Diseño gráfico y edición con Photoshop',
    'Enseño Adobe Photoshop desde cero: retoque fotográfico, composiciones, diseño de carteles, branding básico y trucos profesionales. Experiencia como diseñador freelance durante 6 años.',
    120,
    'activa'
);

-- Habilidad 13: OFERTA - Huerto urbano
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    4,
    'oferta',
    'Iniciación al huerto urbano en casa',
    'Te enseño a crear y mantener un huerto urbano en balcón o terraza. Cultivo de hortalizas, aromáticas, compostaje casero y control de plagas ecológico. Perfecto para principiantes que quieran cultivar sus propios alimentos.',
    90,
    'activa'
);

-- Habilidad 14: OFERTA - Costura y arreglos de ropa
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    5,
    'oferta',
    'Costura básica y arreglos de ropa',
    'Enseño costura a mano y máquina: hacer dobladillos, coser botones, arreglar cremalleras, ajustar ropa y hacer proyectos sencillos. Ideal para ser más autosuficiente y alargar la vida de tu ropa.',
    90,
    'activa'
);

-- Habilidad 15: DEMANDA - Desarrollo web (complementa oferta de usuario 6)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    2,
    'demanda',
    'Aprender desarrollo web frontend moderno',
    'Busco aprender desarrollo web con frameworks modernos como Angular o React. Tengo conocimientos básicos de HTML y CSS pero quiero profundizar en JavaScript/TypeScript y crear aplicaciones web profesionales.',
    120,
    'activa'
);

-- Habilidad 16: DEMANDA - Fotografía (complementa oferta de usuario 6)
INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada, estado)
VALUES (
    7,
    3,
    'demanda',
    'Aprender fotografía digital y composición',
    'Quiero mejorar mis habilidades fotográficas. Tengo una cámara réflex pero solo uso el modo automático. Me gustaría aprender sobre exposición, composición, iluminación y sacar el máximo partido a mi equipo.',
    90,
    'activa'
);

-- Verificar inserción ambos usuarios
SELECT 
    u.nombre_usuario,
    h.tipo,
    h.titulo,
    c.nombre as categoria
FROM habilidades h
JOIN usuarios u ON h.usuario_id = u.id
JOIN categorias_habilidades c ON h.categoria_id = c.id
WHERE u.id IN (6, 7)
ORDER BY u.id, h.tipo, h.id;
