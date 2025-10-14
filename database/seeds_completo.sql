TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;
TRUNCATE TABLE participantes_conversacion CASCADE;
TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;
TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;
TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;

INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo) VALUES
('tonicampos', 'toni.vendecasa@gmail.com', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'administrador', 'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.', 'A Coruña, Galicia', true),
('mariaglez', 'maria.gonzalez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.', 'Santiago de Compostela, Galicia', true),
('carlosfdez', 'carlos.fernandez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Electricista con 15 años de experiencia. También me defiendo con la fontanería.', 'Vigo, Galicia', true),
('lauramtnez', 'laura.martinez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.', 'Lugo, Galicia', true),
('davidperez', 'david.perez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.', 'Ourense, Galicia', true);

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

INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES
(3, 1, 2, 1, 'aceptado', 'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.', NOW() - INTERVAL '7 days'),
(6, 14, 3, 5, 'completado', 'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.', NOW() - INTERVAL '15 days'),
(9, 5, 4, 2, 'propuesto', '¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?', NOW() - INTERVAL '2 days'),
(1, 7, 1, 3, 'propuesto', 'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?', NOW() - INTERVAL '1 day'),
(6, 4, 3, 2, 'aceptado', 'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?', NOW() - INTERVAL '5 days');

INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES
(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days'),
(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES
(1, 3, NOW() - INTERVAL '15 days'),
(1, 5, NOW() - INTERVAL '15 days'),
(2, 2, NOW() - INTERVAL '7 days'),
(2, 1, NOW() - INTERVAL '7 days');

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

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES
(5, 3, 2, 5, 'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!', NOW() - INTERVAL '10 days'),
(3, 5, 2, 5, 'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!', NOW() - INTERVAL '10 days'),
(2, 1, 1, 4, 'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.', NOW() - INTERVAL '3 days');

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

SELECT 
    'DATOS CARGADOS CORRECTAMENTE' as resultado,
    (SELECT COUNT(*) FROM usuarios) as usuarios,
    (SELECT COUNT(*) FROM habilidades) as habilidades,
    (SELECT COUNT(*) FROM intercambios) as intercambios,
    (SELECT COUNT(*) FROM conversaciones) as conversaciones,
    (SELECT COUNT(*) FROM participantes_conversacion) as participantes,
    (SELECT COUNT(*) FROM mensajes) as mensajes,
    (SELECT COUNT(*) FROM valoraciones) as valoraciones,
    (SELECT COUNT(*) FROM notificaciones) as notificaciones;
