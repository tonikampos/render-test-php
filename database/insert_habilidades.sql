TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;

INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUES
(1, 2, 'oferta', 'Desarrollo de sitios web con Angular', 'Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.', 'activa', 120),
(1, 4, 'demanda', 'Clases de fotografía digital', 'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.', 'activa', 90),
(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)', 'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.', 'activa', 60),
(2, 1, 'demanda', 'Reparación de electrodomésticos', 'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.', 'activa', 45),
(2, 4, 'demanda', 'Diseño de logo para proyecto personal', 'Necesito un logo sencillo pero profesional para mi blog de viajes.', 'activa', 30),
(3, 1, 'oferta', 'Instalación eléctrica y reparaciones', 'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.', 'activa', 90),
(3, 1, 'oferta', 'Fontanería básica y desatascos', 'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.', 'activa', 60),
(3, 2, 'demanda', 'Ayuda con página web para mi negocio', 'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.', 'activa', 60),
(4, 4, 'oferta', 'Diseño gráfico y branding', 'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.', 'activa', 120),
(4, 4, 'oferta', 'Fotografía de eventos y retratos', 'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.', 'activa', 180),
(4, 3, 'demanda', 'Clases de inglés conversacional', 'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.', 'activa', 60),
(5, 8, 'oferta', 'Clases de cocina tradicional gallega', 'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.', 'activa', 120),
(5, 8, 'oferta', 'Catering para eventos pequeños', 'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.', 'activa', 240),
(5, 1, 'demanda', 'Reparación de encimera eléctrica', 'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.', 'activa', 45),
(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante', 'Necesito fotos de calidad de mis platos para la carta y redes sociales.', 'activa', 90);

SELECT COUNT(*) as total_habilidades FROM habilidades;
