-- #############################################################################-- #############################################################################-- SEEDS PARA SUPABASE - GaliTroco TFM-- #############################################################################-- #############################################################################-- #############################################################################

-- SEEDS PARA SUPABASE - GaliTroco TFM

-- Password para TODOS los usuarios: abc123.-- SEEDS PARA SUPABASE - GaliTroco TFM

-- Hash: $2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K

-- #############################################################################-- Password para TODOS los usuarios: abc123.-- Password para TODOS los usuarios: abc123.



-- Limpiar datos existentes (en orden inverso de dependencias)-- Hash: $2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K

TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;

TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;-- #############################################################################-- SEEDS PARA SUPABASE - GaliTroco TFM

TRUNCATE TABLE participantes_conversacion CASCADE;

TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;

TRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;

TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;-- Limpiar datos existentes (en orden inverso de dependencias)-- Limpiar datos existentes

TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;

TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;



-- #############################################################################TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;

-- USUARIOS (5 usuarios demo)TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;-- Datos de ejemplo para demostración del proyecto-- ## SEEDS PARA SUPABASE - GaliTroco TFM-- ## Datos de Prueba (Seeds) para "GaliTroco"

-- #############################################################################

TRUNCATE TABLE participantes_conversacion CASCADE;

INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo) VALUES

('tonicampos', 'toni.vendecasa@gmail.com', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'administrador', 'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.', 'A Coruña, Galicia', true),TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;

('mariaglez', 'maria.gonzalez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.', 'Santiago de Compostela, Galicia', true),

('carlosfdez', 'carlos.fernandez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Electricista con 15 años de experiencia. También me defiendo con la fontanería.', 'Vigo, Galicia', true),TRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;

('lauramtnez', 'laura.martinez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.', 'Lugo, Galicia', true),

('davidperez', 'david.perez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.', 'Ourense, Galicia', true);TRUNCATE TABLE reportes RESTART IDENTITY CASCADE;TRUNCATE TABLE participantes_conversacion CASCADE;-- Password para todos los usuarios: abc123.



-- #############################################################################TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;

-- HABILIDADES (15 habilidades variadas)

-- #############################################################################TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;



INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUESTRUNCATE TABLE password_resets RESTART IDENTITY CASCADE;

(1, 2, 'oferta', 'Desarrollo de sitios web con Angular', 'Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.', 'activa', 120),

(1, 4, 'demanda', 'Clases de fotografía digital', 'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.', 'activa', 90),TRUNCATE TABLE sesiones RESTART IDENTITY CASCADE;TRUNCATE TABLE notificaciones RESTART IDENTITY CASCADE;-- #############################################################################-- ## Datos de ejemplo para demostración del proyecto-- ## Ejecutar DESPUÉS de schema.sql

(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)', 'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.', 'activa', 60),

(2, 1, 'demanda', 'Reparación de electrodomésticos', 'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.', 'activa', 45),TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;

(2, 4, 'demanda', 'Diseño de logo para proyecto personal', 'Necesito un logo sencillo pero profesional para mi blog de viajes.', 'activa', 30),

(3, 1, 'oferta', 'Instalación eléctrica y reparaciones', 'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.', 'activa', 90),TRUNCATE TABLE reportes RESTART IDENTITY CASCADE;

(3, 1, 'oferta', 'Fontanería básica y desatascos', 'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.', 'activa', 60),

(3, 2, 'demanda', 'Ayuda con página web para mi negocio', 'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.', 'activa', 60),-- #############################################################################

(4, 4, 'oferta', 'Diseño gráfico y branding', 'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.', 'activa', 120),

(4, 4, 'oferta', 'Fotografía de eventos y retratos', 'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.', 'activa', 180),-- USUARIOS (5 usuarios demo)TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;

(4, 3, 'demanda', 'Clases de inglés conversacional', 'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.', 'activa', 60),

(5, 8, 'oferta', 'Clases de cocina tradicional gallega', 'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.', 'activa', 120),-- #############################################################################

(5, 8, 'oferta', 'Catering para eventos pequeños', 'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.', 'activa', 240),

(5, 1, 'demanda', 'Reparación de encimera eléctrica', 'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.', 'activa', 45),TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;

(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante', 'Necesito fotos de calidad de mis platos para la carta y redes sociales.', 'activa', 90);

INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password_hash, telefono, ubicacion, biografia, rol, activo, verificado) VALUES

-- #############################################################################

-- INTERCAMBIOS (5 intercambios en diferentes estados)('Antonio Manuel Campos', 'tonicampos', 'toni.vendecasa@gmail.com', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666123456', 'A Coruña, Galicia', 'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.', 'administrador', true, true),TRUNCATE TABLE password_resets RESTART IDENTITY CASCADE;-- ========= LIMPIAR DATOS EXISTENTES (mantener estructura) =========-- ## Password para todos los usuarios: abc123.-- #############################################################################

-- #############################################################################

('María González López', 'mariaglez', 'maria.gonzalez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666234567', 'Santiago de Compostela, Galicia', 'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.', 'usuario', true, true),

INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES

(3, 1, 2, 1, 'aceptado', 'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.', NOW() - INTERVAL '7 days'),('Carlos Fernández Díaz', 'carlosfdez', 'carlos.fernandez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666345678', 'Vigo, Galicia', 'Electricista con 15 años de experiencia. También me defiendo con la fontanería.', 'usuario', true, true),TRUNCATE TABLE sesiones RESTART IDENTITY CASCADE;

(6, 14, 3, 5, 'completado', 'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.', NOW() - INTERVAL '15 days'),

(9, 5, 4, 2, 'propuesto', '¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?', NOW() - INTERVAL '2 days'),('Laura Martínez Rodríguez', 'lauramtnez', 'laura.martinez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666456789', 'Lugo, Galicia', 'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.', 'usuario', true, true),

(1, 7, 1, 3, 'propuesto', 'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?', NOW() - INTERVAL '1 day'),

(6, 4, 3, 2, 'aceptado', 'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?', NOW() - INTERVAL '5 days');('David Pérez Castro', 'davidperez', 'david.perez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666567890', 'Ourense, Galicia', 'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.', 'usuario', true, true);TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;



-- #############################################################################

-- CONVERSACIONES Y MENSAJES

-- #############################################################################-- #############################################################################



INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES-- HABILIDADES (15 habilidades variadas)

(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days'),

(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');-- #############################################################################-- USUARIOS (password: abc123. - Hash: $2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K)-- Eliminar en orden inverso por dependencias-- #############################################################################



INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES

(1, 3, NOW() - INTERVAL '15 days'),

(1, 5, NOW() - INTERVAL '15 days'),INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUESINSERT INTO usuarios (nombre_completo, nombre_usuario, email, password_hash, telefono, ubicacion, biografia, rol, activo, verificado) VALUES

(2, 2, NOW() - INTERVAL '7 days'),

(2, 1, NOW() - INTERVAL '7 days');(1, 2, 'oferta', 'Desarrollo de sitios web con Angular', 'Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.', 'activa', 120),



INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES(1, 4, 'demanda', 'Clases de fotografía digital', 'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.', 'activa', 90),('Antonio Manuel Campos', 'tonicampos', 'toni.vendecasa@gmail.com', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666123456', 'A Coruña, Galicia', 'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.', 'administrador', true, true),DELETE FROM valoraciones;

(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?', true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),

(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)', 'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.', 'activa', 60),

(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),

(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),(2, 1, 'demanda', 'Reparación de electrodomésticos', 'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.', 'activa', 45),('María González López', 'mariaglez', 'maria.gonzalez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666234567', 'Santiago de Compostela, Galicia', 'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.', 'usuario', true, true),

(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),

(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!', true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days'),(2, 4, 'demanda', 'Diseño de logo para proyecto personal', 'Necesito un logo sencillo pero profesional para mi blog de viajes.', 'activa', 30),

(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),

(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),(3, 1, 'oferta', 'Instalación eléctrica y reparaciones', 'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.', 'activa', 90),('Carlos Fernández Díaz', 'carlosfdez', 'carlos.fernandez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666345678', 'Vigo, Galicia', 'Electricista con 15 años de experiencia. También me defiendo con la fontanería.', 'usuario', true, true),DELETE FROM mensajes;-- ========= USUARIOS DE PRUEBA =========

(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?', true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),

(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.', false, NOW() - INTERVAL '6 days', NULL);(3, 1, 'oferta', 'Fontanería básica y desatascos', 'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.', 'activa', 60),



-- #############################################################################(3, 2, 'demanda', 'Ayuda con página web para mi negocio', 'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.', 'activa', 60),('Laura Martínez Rodríguez', 'lauramtnez', 'laura.martinez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666456789', 'Lugo, Galicia', 'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.', 'usuario', true, true),

-- VALORACIONES

-- #############################################################################(4, 4, 'oferta', 'Diseño gráfico y branding', 'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.', 'activa', 120),



INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES(4, 4, 'oferta', 'Fotografía de eventos y retratos', 'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.', 'activa', 180),('David Pérez Castro', 'davidperez', 'david.perez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', '666567890', 'Ourense, Galicia', 'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.', 'usuario', true, true);DELETE FROM participantes_conversacion;

(5, 3, 2, 5, 'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!', NOW() - INTERVAL '10 days'),

(3, 5, 2, 5, 'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!', NOW() - INTERVAL '10 days'),(4, 3, 'demanda', 'Clases de inglés conversacional', 'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.', 'activa', 60),

(2, 1, 1, 4, 'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.', NOW() - INTERVAL '3 days');

(5, 8, 'oferta', 'Clases de cocina tradicional gallega', 'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.', 'activa', 120),

-- #############################################################################

-- NOTIFICACIONES(5, 8, 'oferta', 'Catering para eventos pequeños', 'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.', 'activa', 240),

-- #############################################################################

(5, 1, 'demanda', 'Reparación de encimera eléctrica', 'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.', 'activa', 45),-- HABILIDADESDELETE FROM conversaciones;-- ========= LIMPIAR DATOS EXISTENTES (mantener estructura) =========

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES

(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante', 'Necesito fotos de calidad de mis platos para la carta y redes sociales.', 'activa', 90);

(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.', '/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),

(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!', '/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUES

(5, 'nueva_valoracion', 'Nueva valoración recibida', 'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

(3, 'intercambio_aceptado', 'Intercambio aceptado', 'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.', '/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),-- #############################################################################

(3, 'nueva_valoracion', 'Nueva valoración recibida', 'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

(3, 'nuevo_mensaje', 'Nuevo mensaje', 'David Pérez te ha enviado un mensaje en la conversación del intercambio.', '/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),-- INTERCAMBIOS (5 intercambios en diferentes estados)(1, 2, 'oferta', 'Desarrollo de sitios web con Angular', 'Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.', 'activa', 120),DELETE FROM notificaciones;

(2, 'intercambio_aceptado', 'Intercambio aceptado', 'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.', '/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),-- #############################################################################

(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Toni Campos te ha propuesto un intercambio relacionado con fontanería y desarrollo web.', '/intercambios/4', 4, false, NOW() - INTERVAL '1 day');

(1, 4, 'demanda', 'Clases de fotografía digital', 'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.', 'activa', 90),

-- #############################################################################

-- VERIFICACIONINSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES

-- #############################################################################

(3, 1, 2, 1, 'aceptado', 'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.', NOW() - INTERVAL '7 days'),(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)', 'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.', 'activa', 60),DELETE FROM reportes;INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion) VALUES

SELECT 'SEEDS EJECUTADOS CORRECTAMENTE' as resultado, 

       (SELECT COUNT(*) FROM usuarios) as usuarios,(6, 14, 3, 5, 'completado', 'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.', NOW() - INTERVAL '15 days'),

       (SELECT COUNT(*) FROM habilidades) as habilidades,

       (SELECT COUNT(*) FROM intercambios) as intercambios,(9, 5, 4, 2, 'propuesto', '¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?', NOW() - INTERVAL '2 days'),(2, 1, 'demanda', 'Reparación de electrodomésticos', 'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.', 'activa', 45),

       (SELECT COUNT(*) FROM conversaciones) as conversaciones,

       (SELECT COUNT(*) FROM mensajes) as mensajes,(1, 7, 1, 3, 'propuesto', 'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?', NOW() - INTERVAL '1 day'),

       (SELECT COUNT(*) FROM valoraciones) as valoraciones,

       (SELECT COUNT(*) FROM notificaciones) as notificaciones;(6, 4, 3, 2, 'aceptado', 'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?', NOW() - INTERVAL '5 days');(2, 4, 'demanda', 'Diseño de logo para proyecto personal', 'Necesito un logo sencillo pero profesional para mi blog de viajes.', 'activa', 30),DELETE FROM intercambios;




-- #############################################################################(3, 1, 'oferta', 'Instalación eléctrica y reparaciones', 'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.', 'activa', 90),

-- CONVERSACIONES Y MENSAJES

-- #############################################################################(3, 1, 'oferta', 'Fontanería básica y desatascos', 'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.', 'activa', 60),DELETE FROM habilidades;-- Eliminar en orden inverso por dependencias-- Contraseña para todos: 'password123' (debes hashearla en producción)



INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES(3, 2, 'demanda', 'Ayuda con página web para mi negocio', 'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.', 'activa', 60),

(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days'),

(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');(4, 4, 'oferta', 'Diseño gráfico y branding', 'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.', 'activa', 120),DELETE FROM password_resets;



INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES(4, 4, 'oferta', 'Fotografía de eventos y retratos', 'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.', 'activa', 180),

(1, 3, NOW() - INTERVAL '15 days'),

(1, 5, NOW() - INTERVAL '15 days'),(4, 3, 'demanda', 'Clases de inglés conversacional', 'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.', 'activa', 60),DELETE FROM sesiones;DELETE FROM valoraciones;('maria_garcia', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Profesora de inglés con 10 años de experiencia. Me encanta enseñar y aprender cosas nuevas.', 'A Coruña'),

(2, 2, NOW() - INTERVAL '7 days'),

(2, 1, NOW() - INTERVAL '7 days');(5, 8, 'oferta', 'Clases de cocina tradicional gallega', 'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.', 'activa', 120),



INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES(5, 8, 'oferta', 'Catering para eventos pequeños', 'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.', 'activa', 240),DELETE FROM usuarios;

(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?', true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),

(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),(5, 1, 'demanda', 'Reparación de encimera eléctrica', 'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.', 'activa', 45),

(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),

(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante', 'Necesito fotos de calidad de mis platos para la carta y redes sociales.', 'activa', 90);DELETE FROM mensajes;('juan_lopez', 'juan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Técnico informático freelance. Puedo ayudarte con tu PC o enseñarte programación.', 'Santiago'),

(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),

(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!', true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days'),

(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),

(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),-- INTERCAMBIOS-- Reiniciar secuencias para IDs limpios

(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?', true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),

(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.', false, NOW() - INTERVAL '6 days', NULL);INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES



-- #############################################################################(3, 1, 2, 1, 'aceptado', 'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.', NOW() - INTERVAL '7 days'),ALTER SEQUENCE usuarios_id_seq RESTART WITH 1;DELETE FROM participantes_conversacion;('ana_martinez', 'ana@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Apasionada de la cocina y la repostería. Hago tartas personalizadas.', 'Vigo'),

-- VALORACIONES

-- #############################################################################(6, 14, 3, 5, 'completado', 'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.', NOW() - INTERVAL '15 days'),



INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES(9, 5, 4, 2, 'propuesto', '¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?', NOW() - INTERVAL '2 days'),ALTER SEQUENCE habilidades_id_seq RESTART WITH 1;

(5, 3, 2, 5, 'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!', NOW() - INTERVAL '10 days'),

(3, 5, 2, 5, 'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!', NOW() - INTERVAL '10 days'),(1, 7, 1, 3, 'propuesto', 'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?', NOW() - INTERVAL '1 day'),

(2, 1, 1, 4, 'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.', NOW() - INTERVAL '3 days');

(6, 4, 3, 2, 'aceptado', 'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?', NOW() - INTERVAL '5 days');ALTER SEQUENCE intercambios_id_seq RESTART WITH 1;DELETE FROM conversaciones;('pedro_rodriguez', 'pedro@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Fontanero profesional. También hago pequeñas reparaciones en el hogar.', 'Ferrol'),

-- #############################################################################

-- NOTIFICACIONES

-- #############################################################################

-- CONVERSACIONESALTER SEQUENCE conversaciones_id_seq RESTART WITH 1;

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES

(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES

(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.', '/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),

(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!', '/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days'),ALTER SEQUENCE mensajes_id_seq RESTART WITH 1;DELETE FROM notificaciones;('laura_fernandez', 'laura@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Diseñadora gráfica y fotógrafa. Capturo momentos especiales.', 'Lugo'),

(5, 'nueva_valoracion', 'Nueva valoración recibida', 'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

(3, 'intercambio_aceptado', 'Intercambio aceptado', 'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.', '/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');

(3, 'nueva_valoracion', 'Nueva valoración recibida', 'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

(3, 'nuevo_mensaje', 'Nuevo mensaje', 'David Pérez te ha enviado un mensaje en la conversación del intercambio.', '/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),ALTER SEQUENCE valoraciones_id_seq RESTART WITH 1;

(2, 'intercambio_aceptado', 'Intercambio aceptado', 'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.', '/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),-- PARTICIPANTES

(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Toni Campos te ha propuesto un intercambio relacionado con fontanería y desarrollo web.', '/intercambios/4', 4, false, NOW() - INTERVAL '1 day');

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUESALTER SEQUENCE notificaciones_id_seq RESTART WITH 1;DELETE FROM reportes;('carlos_sanchez', 'carlos@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario', 'Guitarrista y profesor de música. Doy clases de guitarra para principiantes.', 'Pontevedra'),

-- #############################################################################

-- VERIFICACION(1, 3, NOW() - INTERVAL '15 days'),

-- #############################################################################

(1, 5, NOW() - INTERVAL '15 days'),ALTER SEQUENCE reportes_id_seq RESTART WITH 1;

SELECT 'SEEDS EJECUTADOS CORRECTAMENTE' as resultado, 

       (SELECT COUNT(*) FROM usuarios) as usuarios,(2, 2, NOW() - INTERVAL '7 days'),

       (SELECT COUNT(*) FROM habilidades) as habilidades,

       (SELECT COUNT(*) FROM intercambios) as intercambios,(2, 1, NOW() - INTERVAL '7 days');DELETE FROM intercambios;('admin_galitroco', 'admin@galitroco.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'Administrador del sistema GaliTroco.', 'A Coruña');

       (SELECT COUNT(*) FROM conversaciones) as conversaciones,

       (SELECT COUNT(*) FROM mensajes) as mensajes,

       (SELECT COUNT(*) FROM valoraciones) as valoraciones,

       (SELECT COUNT(*) FROM notificaciones) as notificaciones;-- MENSAJES


INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES

(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?', true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),-- #############################################################################DELETE FROM habilidades;

(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),

(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?', true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),-- CREAR USUARIOS (password: abc123. para todos)

(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),

(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.', true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),-- Hash generado: $2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.KDELETE FROM password_resets;

(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!', true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days'),

(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),-- #############################################################################

(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.', true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),

(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?', true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),DELETE FROM sesiones;-- ========= HABILIDADES DE PRUEBA (OFERTAS) =========

(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.', false, NOW() - INTERVAL '6 days', NULL);

INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password_hash, telefono, ubicacion, biografia, rol, activo, verificado) VALUES

-- VALORACIONES

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUESDELETE FROM usuarios;

(5, 3, 2, 5, 'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!', NOW() - INTERVAL '10 days'),

(3, 5, 2, 5, 'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!', NOW() - INTERVAL '10 days'),-- Usuario 1: Toni (TU USUARIO - ADMINISTRADOR)

(2, 1, 1, 4, 'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.', NOW() - INTERVAL '3 days');

('Antonio Manuel Campos', 'tonicampos', 'toni.vendecasa@gmail.com', INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada) VALUES

-- NOTIFICACIONES

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',

(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.', '/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),'666123456', 'A Coruña, Galicia',-- Reiniciar secuencias para IDs limpios-- Ofertas de María (Clases y Formación)

(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!', '/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),

(5, 'nueva_valoracion', 'Nueva valoración recibida', 'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.',

(3, 'intercambio_aceptado', 'Intercambio aceptado', 'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.', '/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),

(3, 'nueva_valoracion', 'Nueva valoración recibida', 'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!', '/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),'administrador', true, true),ALTER SEQUENCE usuarios_id_seq RESTART WITH 1;(1, 3, 'oferta', 'Clases de inglés nivel básico e intermedio', 'Profesora titulada con experiencia. Clases dinámicas y personalizadas. Preparación para exámenes oficiales.', 60),

(3, 'nuevo_mensaje', 'Nuevo mensaje', 'David Pérez te ha enviado un mensaje en la conversación del intercambio.', '/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),

(2, 'intercambio_aceptado', 'Intercambio aceptado', 'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!', '/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.', '/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),

(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Toni Campos te ha propuesto un intercambio relacionado con fontanería y desarrollo web.', '/intercambios/4', 4, false, NOW() - INTERVAL '1 day');-- Usuario 2: María (Usuario activo)ALTER SEQUENCE habilidades_id_seq RESTART WITH 1;(1, 3, 'oferta', 'Apoyo escolar para primaria', 'Ayuda con deberes y refuerzo en todas las asignaturas de educación primaria.', 90),



-- VERIFICACION('María González López', 'mariaglez', 'maria.gonzalez@demo.galitro.co',

SELECT 'SEEDS EJECUTADOS CORRECTAMENTE' as resultado, 

       (SELECT COUNT(*) FROM usuarios) as usuarios,'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',ALTER SEQUENCE intercambios_id_seq RESTART WITH 1;

       (SELECT COUNT(*) FROM habilidades) as habilidades,

       (SELECT COUNT(*) FROM intercambios) as intercambios,'666234567', 'Santiago de Compostela, Galicia',

       (SELECT COUNT(*) FROM conversaciones) as conversaciones,

       (SELECT COUNT(*) FROM mensajes) as mensajes,'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.',ALTER SEQUENCE conversaciones_id_seq RESTART WITH 1;-- Ofertas de Juan (Tecnología)

       (SELECT COUNT(*) FROM valoraciones) as valoraciones,

       (SELECT COUNT(*) FROM notificaciones) as notificaciones;'usuario', true, true),


ALTER SEQUENCE mensajes_id_seq RESTART WITH 1;(2, 2, 'oferta', 'Reparación y mantenimiento de ordenadores', 'Formateo, instalación de programas, eliminación de virus, actualización de componentes.', 120),

-- Usuario 3: Carlos (Usuario activo)

('Carlos Fernández Díaz', 'carlosfdez', 'carlos.fernandez@demo.galitro.co',ALTER SEQUENCE valoraciones_id_seq RESTART WITH 1;(2, 2, 'oferta', 'Clases de programación web (HTML, CSS, JavaScript)', 'Aprende a crear páginas web desde cero. Para principiantes.', 120),

'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',

'666345678', 'Vigo, Galicia',ALTER SEQUENCE notificaciones_id_seq RESTART WITH 1;

'Electricista con 15 años de experiencia. También me defiendo con la fontanería.',

'usuario', true, true),ALTER SEQUENCE reportes_id_seq RESTART WITH 1;-- Ofertas de Ana (Cocina)



-- Usuario 4: Laura (Usuario activo)(3, 8, 'oferta', 'Clases de repostería casera', 'Aprende a hacer tartas, galletas, cupcakes y postres deliciosos.', 180),

('Laura Martínez Rodríguez', 'lauramtnez', 'laura.martinez@demo.galitro.co',

'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',(3, 8, 'oferta', 'Catering para eventos pequeños', 'Menús personalizados para cumpleaños, reuniones familiares (máx. 20 personas).', 240),

'666456789', 'Lugo, Galicia',

'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.',-- #############################################################################

'usuario', true, true),

-- ========= CREAR USUARIOS (password: abc123. para todos) =========-- Ofertas de Pedro (Hogar)

-- Usuario 5: David (Usuario activo)

('David Pérez Castro', 'davidperez', 'david.perez@demo.galitro.co',-- #############################################################################(4, 1, 'oferta', 'Reparación de grifos y desatascos', 'Soluciono problemas de fontanería básica en el hogar.', 90),

'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',

'666567890', 'Ourense, Galicia',(4, 1, 'oferta', 'Montaje de muebles', 'Monto muebles de IKEA y similares. Herramientas propias.', 120),

'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.',

'usuario', true, true);-- Password hash para 'abc123.' usando bcrypt cost 12



-- Hash generado: $2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K-- Ofertas de Laura (Arte)

-- #############################################################################

-- CREAR HABILIDADES (ofertas y demandas)(5, 4, 'oferta', 'Sesión de fotos familiar o de eventos', 'Fotografía profesional para eventos, familias, mascotas. Retoque básico incluido.', 120),

-- #############################################################################

INSERT INTO usuarios (nombre_completo, nombre_usuario, email, password_hash, telefono, ubicacion, biografia, rol, activo, verificado) VALUES(5, 4, 'oferta', 'Diseño de logos e identidad corporativa', 'Creo logos profesionales para tu negocio o proyecto.', 180),

INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUES



-- Habilidades de Toni (ID 1)

(1, 2, 'oferta', 'Desarrollo de sitios web con Angular',-- Usuario 1: Toni (TU USUARIO - ADMINISTRADOR)-- Ofertas de Carlos (Música)

'Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.',

'activa', 120),('Antonio Manuel Campos', 'tonicampos', 'toni.vendecasa@gmail.com', (6, 3, 'oferta', 'Clases de guitarra acústica y eléctrica', 'Para todos los niveles. Aprende tus canciones favoritas.', 60),



(1, 2, 'demanda', 'Clases de fotografía digital','$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',(6, 3, 'oferta', 'Amenización musical para eventos', 'Toco en bodas, cumpleaños y eventos. Amplio repertorio.', 180);

'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.',

'activa', 90),'666123456', 'A Coruña, Galicia',



-- Habilidades de María (ID 2)'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.',

(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)',

'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.','administrador', true, true),-- ========= HABILIDADES DE PRUEBA (DEMANDAS) =========

'activa', 60),



(2, 3, 'demanda', 'Reparación de electrodomésticos',

'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.',-- Usuario 2: María (Usuario activo)INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, duracion_estimada) VALUES

'activa', 45),

('María González López', 'mariaglez', 'maria.gonzalez@demo.galitro.co',-- Demandas de María

(2, 4, 'demanda', 'Diseño de logo para proyecto personal',

'Necesito un logo sencillo pero profesional para mi blog de viajes.','$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',(1, 1, 'demanda', 'Necesito pintar mi salón', 'Busco alguien con experiencia en pintura de interiores. Pintura incluida.', 480),

'activa', 30),

'666234567', 'Santiago de Compostela, Galicia',(1, 7, 'demanda', 'Mudanza pequeña (furgoneta)', 'Necesito trasladar algunos muebles a otra ciudad cercana.', 240),

-- Habilidades de Carlos (ID 3)

(3, 1, 'oferta', 'Instalación eléctrica y reparaciones','Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.',

'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.',

'activa', 90),'usuario', true, true),-- Demandas de Juan



(3, 1, 'oferta', 'Fontanería básica y desatascos',(2, 8, 'demanda', 'Clases de cocina básica', 'Quiero aprender a cocinar platos sencillos y saludables.', 120),

'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.',

'activa', 60),-- Usuario 3: Carlos (Usuario activo)(2, 5, 'demanda', 'Corte de pelo a domicilio', 'Busco peluquero/a que se desplace a domicilio.', 45),



(3, 2, 'demanda', 'Ayuda con página web para mi negocio',('Carlos Fernández Díaz', 'carlosfdez', 'carlos.fernandez@demo.galitro.co',

'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.',

'activa', 60),'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',-- Demandas de Ana



-- Habilidades de Laura (ID 4)'666345678', 'Vigo, Galicia',(3, 2, 'demanda', 'Configuración de red WiFi en casa', 'Tengo problemas con la señal WiFi. Necesito ayuda para optimizarla.', 90),

(4, 4, 'oferta', 'Diseño gráfico y branding',

'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.','Electricista con 15 años de experiencia. También me defiendo con la fontanería.',(3, 4, 'demanda', 'Sesión de fotos para Instagram', 'Necesito fotos profesionales para mi perfil de repostería.', 60),

'activa', 120),

'usuario', true, true),

(4, 4, 'oferta', 'Fotografía de eventos y retratos',

'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.',-- Demandas de Pedro

'activa', 180),

-- Usuario 4: Laura (Usuario activo)(4, 3, 'demanda', 'Clases de inglés para viajar', 'Necesito inglés básico para poder comunicarme en viajes.', 60),

(4, 3, 'demanda', 'Clases de inglés conversacional',

'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.',('Laura Martínez Rodríguez', 'lauramtnez', 'laura.martinez@demo.galitro.co',(4, 4, 'demanda', 'Reparación de una silla de madera', 'Tengo una silla antigua que necesita arreglo de carpintería.', 120),

'activa', 60),

'$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',

-- Habilidades de David (ID 5)

(5, 8, 'oferta', 'Clases de cocina tradicional gallega','666456789', 'Lugo, Galicia',-- Demandas de Laura

'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.',

'activa', 120),'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.',(5, 1, 'demanda', 'Instalación de estantería en pared', 'Necesito colgar varias estanterías. Tengo los materiales.', 60),



(5, 8, 'oferta', 'Catering para eventos pequeños','usuario', true, true),(5, 3, 'demanda', 'Clases de guitarra para principiante', 'Siempre quise aprender. Nivel cero absoluto.', 60),

'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.',

'activa', 240),



(5, 1, 'demanda', 'Reparación de encimera eléctrica',-- Usuario 5: David (Usuario activo)-- Demandas de Carlos

'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.',

'activa', 45),('David Pérez Castro', 'davidperez', 'david.perez@demo.galitro.co',(6, 2, 'demanda', 'Creación de página web sencilla', 'Necesito una web para promocionar mis clases de música.', 300),



(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante','$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K',(6, 6, 'demanda', 'Asesoramiento para declaración de autónomo', 'Primera vez que voy a darme de alta como autónomo.', 90);

'Necesito fotos de calidad de mis platos para la carta y redes sociales.',

'activa', 90);'666567890', 'Ourense, Galicia',



'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.',

-- #############################################################################

-- CREAR INTERCAMBIOS'usuario', true, true);-- ========= INTERCAMBIOS DE PRUEBA =========

-- #############################################################################



INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES

INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES

-- Intercambio 1: María ofrece inglés a Toni, Toni le hace web

(1, 3, 2, 1, 'aceptado', -- #############################################################################-- María propone a Juan: Clases de inglés por Reparación de PC

'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.',

NOW() - INTERVAL '7 days'),-- ========= CREAR HABILIDADES (ofertas y demandas) =========(1, 15, 1, 2, 'aceptado', '¡Hola Juan! Vi que ofreces reparación de ordenadores. Me interesa mucho. Te propongo clases de inglés a cambio. ¿Qué te parece?', CURRENT_TIMESTAMP - INTERVAL '5 days'),



-- Intercambio 2: Carlos ofrece electricidad a David por clases de cocina-- #############################################################################

(6, 14, 3, 5, 'completado',

'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.',-- Ana propone a Laura: Clases de repostería por Sesión de fotos

NOW() - INTERVAL '15 days'),

INSERT INTO habilidades (usuario_id, categoria_id, tipo, titulo, descripcion, estado, duracion_estimada) VALUES(5, 18, 3, 5, 'completado', 'Hola Laura, necesito fotos profesionales para mi Instagram de repostería. ¿Te interesan clases de repostería a cambio?', CURRENT_TIMESTAMP - INTERVAL '10 days'),

-- Intercambio 3: Laura ofrece diseño de logo a María

(9, 5, 4, 2, 'propuesto',

'¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?',

NOW() - INTERVAL '2 days'),-- Habilidades de Toni (ID 1)-- Pedro propone a Carlos: Reparación fontanería por Clases de guitarra



-- Intercambio 4: Toni ofrece web a Carlos por fontanería(1, 2, 'oferta', 'Desarrollo de sitios web con Angular',(7, 19, 4, 6, 'propuesto', 'Hola Carlos, vi que das clases de guitarra. Siempre quise aprender. Te ofrezco mis servicios de fontanería si los necesitas.', CURRENT_TIMESTAMP - INTERVAL '2 days'),

(1, 7, 1, 3, 'propuesto',

'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?','Desarrollo de aplicaciones web modernas con Angular, TypeScript y Material Design. Experiencia en integración con APIs REST.',

NOW() - INTERVAL '1 day'),

'activa', 120),-- Juan propone a Ana: Configuración WiFi por Clases de cocina

-- Intercambio 5: Carlos revisa electrodoméstico de María

(6, 4, 3, 2, 'aceptado',(3, 14, 2, 3, 'aceptado', '¡Hola Ana! Puedo ayudarte con tu red WiFi. Vi que das clases de cocina y me encantaría aprender. ¿Hacemos trueque?', CURRENT_TIMESTAMP - INTERVAL '3 days'),

'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?',

NOW() - INTERVAL '5 days');(1, 2, 'demanda', 'Clases de fotografía digital',



'Busco alguien que me enseñe los fundamentos de fotografía digital y edición básica con Lightroom.',-- Laura propone a Juan: Diseño de logo por Página web

-- #############################################################################

-- CREAR CONVERSACIONES Y MENSAJES'activa', 90),(10, 22, 5, 2, 'propuesto', 'Hola Juan, necesito una web sencilla. Veo que sabes programación. Te ofrezco diseñar el logo y la identidad visual.', CURRENT_TIMESTAMP - INTERVAL '1 day');

-- #############################################################################



-- Conversación del Intercambio 2 (Carlos y David - COMPLETADO)

INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES-- Habilidades de María (ID 2)

(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days');

(2, 3, 'oferta', 'Clases particulares de inglés (todos los niveles)',-- ========= CONVERSACIONES Y MENSAJES DE PRUEBA =========

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES

(1, 3, NOW() - INTERVAL '15 days'),'Profesora titulada con experiencia en preparación de exámenes oficiales (Cambridge, Trinity). Clases personalizadas.',

(1, 5, NOW() - INTERVAL '15 days');

'activa', 60),-- Conversación entre María y Juan (Intercambio #1)

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES

(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?',INSERT INTO conversaciones (intercambio_id) VALUES (1);

true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),

(2, 3, 'demanda', 'Reparación de electrodomésticos',

(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?',

true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),'Mi lavadora hace un ruido extraño y necesito que alguien la revise antes de llamar al técnico.',INSERT INTO participantes_conversacion (conversacion_id, usuario_id) VALUES



(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?','activa', 45),(1, 1), -- María

true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),

(1, 2); -- Juan

(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊',

true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),(2, 4, 'demanda', 'Diseño de logo para proyecto personal',



(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.','Necesito un logo sencillo pero profesional para mi blog de viajes.',INSERT INTO mensajes (conversacion_id, emisor_id, contenido, fecha_envio, leido) VALUES

true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),

'activa', 30),(1, 1, '¡Hola Juan! ¿Qué tal? Vi tu perfil y me encantaría intercambiar.', CURRENT_TIMESTAMP - INTERVAL '5 days', TRUE),

(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!',

true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days');(1, 2, 'Hola María, encantado. ¿Cuándo te vendría bien empezar?', CURRENT_TIMESTAMP - INTERVAL '5 days', TRUE),



-- Habilidades de Carlos (ID 3)(1, 1, 'Perfecto. ¿Te va bien el lunes a las 18:00?', CURRENT_TIMESTAMP - INTERVAL '4 days', TRUE),

-- Conversación del Intercambio 1 (María y Toni - ACEPTADO)

INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES(3, 1, 'oferta', 'Instalación eléctrica y reparaciones',(1, 2, 'Perfecto, el lunes nos vemos. ¿Dónde tienes el ordenador?', CURRENT_TIMESTAMP - INTERVAL '4 days', FALSE);

(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');

'Electricista profesional. Instalaciones, reparaciones, cambio de enchufes, cuadros eléctricos, etc.',

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES

(2, 2, NOW() - INTERVAL '7 days'),'activa', 90),-- Conversación entre Ana y Laura (Intercambio #2)

(2, 1, NOW() - INTERVAL '7 days');

INSERT INTO conversaciones (intercambio_id) VALUES (2);

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES

(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?',(3, 1, 'oferta', 'Fontanería básica y desatascos',

true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),

'Reparación de grifos, instalación de lavabos, desatascos de tuberías y averías básicas de fontanería.',INSERT INTO participantes_conversacion (conversacion_id, usuario_id) VALUES

(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.',

true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),'activa', 60),(2, 3), -- Ana



(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?',(2, 5); -- Laura

true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),

(3, 2, 'demanda', 'Ayuda con página web para mi negocio',

(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.',

false, NOW() - INTERVAL '6 days', NULL);'Quiero crear una página web sencilla para mi negocio de electricidad pero no sé por dónde empezar.',INSERT INTO mensajes (conversacion_id, emisor_id, contenido, fecha_envio, leido) VALUES



'activa', 60),(2, 3, 'Hola Laura, me encantan tus fotos. ¿Te interesan clases de repostería?', CURRENT_TIMESTAMP - INTERVAL '10 days', TRUE),

-- #############################################################################

-- CREAR VALORACIONES(2, 5, '¡Claro que sí! Siempre quise aprender. ¿Cuándo hacemos la sesión?', CURRENT_TIMESTAMP - INTERVAL '10 days', TRUE),

-- #############################################################################

-- Habilidades de Laura (ID 4)(2, 3, 'Genial. La semana que viene. ¿Qué estilo de fotos necesitas?', CURRENT_TIMESTAMP - INTERVAL '9 days', TRUE),

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES

(4, 4, 'oferta', 'Diseño gráfico y branding',(2, 5, 'Fotos de productos para Instagram, fondo blanco y con ambiente de cocina.', CURRENT_TIMESTAMP - INTERVAL '9 days', TRUE);

-- David valora a Carlos (Intercambio completado)

(5, 3, 2, 5,'Diseño de logos, tarjetas de visita, flyers y material corporativo. Trabajo con Adobe Illustrator y Photoshop.',

'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!',

NOW() - INTERVAL '10 days'),'activa', 120),



-- Carlos valora a David (Intercambio completado)-- ========= VALORACIONES DE PRUEBA =========

(3, 5, 2, 5,

'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!',(4, 4, 'oferta', 'Fotografía de eventos y retratos',

NOW() - INTERVAL '10 days'),

'Sesiones fotográficas para eventos, bodas, bautizos o retratos personales. Incluye edición básica.',-- María valora a Juan (después del intercambio #1 completado... bueno, aceptado)

-- María valora a Toni (aunque el intercambio aún no está completado)

(2, 1, 1, 4,'activa', 180),-- En un caso real solo se valoraría después de completar, pero para demo:

'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.',

NOW() - INTERVAL '3 days');INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES



(4, 3, 'demanda', 'Clases de inglés conversacional',(1, 2, 1, 5, '¡Excelente profesional! Dejó mi ordenador como nuevo y muy rápido. Totalmente recomendable.');

-- #############################################################################

-- CREAR NOTIFICACIONES'Quiero mejorar mi inglés hablado para poder comunicarme mejor con clientes internacionales.',

-- #############################################################################

'activa', 60),-- Laura valora a Ana (después del intercambio #2 completado)

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES

-- Notificación para Toni

(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio',-- Habilidades de David (ID 5)(5, 3, 2, 5, 'Ana es una maestra en la cocina. Las clases fueron super divertidas y aprendí muchísimo. ¡Gracias!');

'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.',

'/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),(5, 8, 'oferta', 'Clases de cocina tradicional gallega',



-- Notificación para David'Enseño a preparar platos típicos gallegos: pulpo, empanada, lacón con grelos, filloas, etc.',-- Ana valora a Laura

(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio',

'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.','activa', 120),INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario) VALUES

'/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),

(3, 5, 2, 5, 'Laura es increíble. Las fotos quedaron espectaculares y muy profesionales. Súper recomendada.');

(5, 'intercambio_completado', 'Intercambio completado',

'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!',(5, 8, 'oferta', 'Catering para eventos pequeños',

'/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),

'Preparo menús personalizados para eventos de hasta 20 personas. Cocina casera de calidad.',

(5, 'nueva_valoracion', 'Nueva valoración recibida',

'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!','activa', 240),-- ========= NOTIFICACIONES DE PRUEBA =========

'/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),



-- Notificación para Carlos

(3, 'intercambio_aceptado', 'Intercambio aceptado',(5, 1, 'demanda', 'Reparación de encimera eléctrica',INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida) VALUES

'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.',

'/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),'Una placa de mi encimera no calienta correctamente. Necesito que alguien la revise.',-- Notificaciones para Juan



(3, 'nueva_valoracion', 'Nueva valoración recibida','activa', 45),(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'María te ha propuesto intercambiar: Clases de inglés por Reparación de PC', '/intercambios/1', 1, TRUE),

'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!',

'/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),(2, 'nuevo_mensaje', 'Nuevo mensaje de María', 'María te ha enviado un mensaje', '/mensajes/1', 1, TRUE),



(3, 'nuevo_mensaje', 'Nuevo mensaje',(5, 4, 'demanda', 'Fotografías profesionales para carta de restaurante',

'David Pérez te ha enviado un mensaje en la conversación del intercambio.',

'/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),'Necesito fotos de calidad de mis platos para la carta y redes sociales.',-- Notificaciones para María



-- Notificación para María'activa', 90);(1, 'intercambio_aceptado', '¡Intercambio aceptado!', 'Juan ha aceptado tu propuesta de intercambio', '/intercambios/1', 1, TRUE),

(2, 'intercambio_aceptado', 'Intercambio aceptado',

'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!',(1, 'nueva_valoracion', 'Nueva valoración recibida', 'Juan te ha valorado con 5 estrellas', '/perfil/1', 1, FALSE),

'/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),



(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio',

'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.',-- #############################################################################-- Notificaciones para Laura

'/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),

-- ========= CREAR INTERCAMBIOS =========(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Ana te ha propuesto intercambiar: Clases de repostería por Sesión de fotos', '/intercambios/2', 2, TRUE),

-- Notificación para Laura

(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio',-- #############################################################################(5, 'intercambio_completado', 'Intercambio completado', 'Tu intercambio con Ana se ha marcado como completado', '/intercambios/2', 2, TRUE),

'Toni Campos te ha propuesto un intercambio relacionado con fontanería y desarrollo web.',

'/intercambios/4', 4, false, NOW() - INTERVAL '1 day');



INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES-- Notificaciones para Carlos

-- #############################################################################

-- VERIFICACIÓN FINAL(6, 'nuevo_intercambio', 'Nueva propuesta de intercambio', 'Pedro te ha propuesto intercambiar: Reparación fontanería por Clases de guitarra', '/intercambios/3', 3, FALSE);

-- #############################################################################

-- Intercambio 1: María ofrece inglés a Toni, Toni le hace web

-- Mostrar resumen de datos insertados

SELECT (1, 3, 2, 1, 'aceptado', 

    '✅ Seeds ejecutados correctamente' as estado,

    (SELECT COUNT(*) FROM usuarios) as usuarios,'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.',-- ========= REPORTES DE PRUEBA (para testing del panel admin) =========

    (SELECT COUNT(*) FROM habilidades) as habilidades,

    (SELECT COUNT(*) FROM intercambios) as intercambios,NOW() - INTERVAL '7 days'),

    (SELECT COUNT(*) FROM conversaciones) as conversaciones,

    (SELECT COUNT(*) FROM mensajes) as mensajes,INSERT INTO reportes (reportador_id, tipo_contenido, contenido_id, motivo, estado) VALUES

    (SELECT COUNT(*) FROM valoraciones) as valoraciones,

    (SELECT COUNT(*) FROM notificaciones) as notificaciones;-- Intercambio 2: Carlos ofrece electricidad a David por clases de cocina(2, 'habilidad', 999, 'Esta habilidad parece ser spam o fraudulenta.', 'pendiente'),



-- Listar usuarios creados con sus credenciales(6, 12, 3, 5, 'completado',(3, 'perfil', 999, 'Este usuario tiene comportamiento sospechoso.', 'revisado');

SELECT 

    '📋 USUARIOS DEMO CREADOS' as info,'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.',

    nombre_usuario as usuario,

    email,NOW() - INTERVAL '15 days'),

    rol,

    'abc123.' as password-- #############################################################################

FROM usuarios

ORDER BY id;-- Intercambio 3: Laura ofrece diseño de logo a María-- ## FIN DE LOS SEEDS



-- #############################################################################(9, 5, 4, 2, 'propuesto',-- #############################################################################

-- FIN DE SEEDS

-- #############################################################################'¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?',


NOW() - INTERVAL '2 days'),-- ========= CONSULTAS ÚTILES PARA VERIFICAR LOS DATOS =========



-- Intercambio 4: Toni ofrece fotografía a Laura por diseño gráfico-- Ver todos los usuarios con sus estadísticas

(2, 9, 1, 4, 'propuesto',-- SELECT * FROM estadisticas_usuarios ORDER BY valoracion_promedio DESC;

'Hola Laura! Estoy buscando alguien que me enseñe fotografía digital. Vi que ofreces fotografía de eventos. ¿Te interesaría que te ayude con desarrollo web para tu portfolio?',

NOW() - INTERVAL '1 day'),-- Ver todos los intercambios activos

-- SELECT i.*, h1.titulo as ofrecida, h2.titulo as solicitada, u1.nombre_usuario as proponente, u2.nombre_usuario as receptor

-- Intercambio 5: Carlos revisa electrodoméstico de María-- FROM intercambios i

(6, 4, 3, 2, 'aceptado',-- JOIN habilidades h1 ON i.habilidad_ofrecida_id = h1.id

'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?',-- JOIN habilidades h2 ON i.habilidad_solicitada_id = h2.id

NOW() - INTERVAL '5 days');-- JOIN usuarios u1 ON i.proponente_id = u1.id

-- JOIN usuarios u2 ON i.receptor_id = u2.id

-- WHERE i.estado IN ('propuesto', 'aceptado');

-- #############################################################################

-- ========= CREAR CONVERSACIONES Y MENSAJES =========-- Ver mensajes no leídos por usuario

-- #############################################################################-- SELECT u.nombre_usuario, COUNT(*) as mensajes_no_leidos

-- FROM mensajes m

-- Conversación del Intercambio 2 (Carlos y David - COMPLETADO)-- JOIN conversaciones c ON m.conversacion_id = c.id

INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES-- JOIN participantes_conversacion pc ON c.id = pc.conversacion_id

(2, NOW() - INTERVAL '15 days', NOW() - INTERVAL '10 days');-- JOIN usuarios u ON pc.usuario_id = u.id

-- WHERE m.leido = FALSE AND m.emisor_id != u.id

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES-- GROUP BY u.nombre_usuario;

(1, 3, NOW() - INTERVAL '15 days'),
(1, 5, NOW() - INTERVAL '15 days');

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES
(1, 5, '¡Hola Carlos! Perfecto, me parece un intercambio muy justo. ¿Cuándo te viene bien que venga a revisar la encimera?',
true, NOW() - INTERVAL '15 days', NOW() - INTERVAL '14 days'),

(1, 3, 'Esta semana puedo el jueves por la tarde. ¿Te va bien sobre las 17:00?',
true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '14 days'),

(1, 5, 'Perfecto! Te espero el jueves. Mi dirección es Rúa do Paseo 45, Ourense. ¿Y cuándo empezamos con las clases de cocina?',
true, NOW() - INTERVAL '14 days', NOW() - INTERVAL '13 days'),

(1, 3, 'El sábado que viene podríamos hacer la primera clase si te viene bien. Tengo muchas ganas de aprender a hacer pulpo como los maestros 😊',
true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '13 days'),

(1, 5, 'Jajaja, te va a quedar de escándalo! Nos vemos el jueves entonces. Trae tu caja de herramientas.',
true, NOW() - INTERVAL '13 days', NOW() - INTERVAL '12 days'),

(1, 3, 'Listo! Ya revisé la encimera. Era el termostato, lo he cambiado. Ya funciona perfecta. Nos vemos el sábado para la clase!',
true, NOW() - INTERVAL '11 days', NOW() - INTERVAL '11 days');


-- Conversación del Intercambio 1 (María y Toni - ACEPTADO)
INSERT INTO conversaciones (intercambio_id, fecha_creacion, ultima_actualizacion) VALUES
(1, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days');

INSERT INTO participantes_conversacion (conversacion_id, usuario_id, fecha_union) VALUES
(2, 2, NOW() - INTERVAL '7 days'),
(2, 1, NOW() - INTERVAL '7 days');

INSERT INTO mensajes (conversacion_id, emisor_id, contenido, leido, fecha_envio, fecha_lectura) VALUES
(2, 1, 'Hola María! Me parece genial el intercambio. ¿Qué tipo de web necesitas exactamente?',
true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '7 days'),

(2, 2, 'Necesito algo sencillo: página de inicio, sobre mí, servicios que ofrezco y un formulario de contacto. Nada muy complicado.',
true, NOW() - INTERVAL '7 days', NOW() - INTERVAL '6 days'),

(2, 1, 'Perfecto, puedo hacerte eso sin problema. ¿Cuántas horas de clases de inglés serían?',
true, NOW() - INTERVAL '6 days', NOW() - INTERVAL '6 days'),

(2, 2, '¿Qué te parecen 10 horas? Podríamos hacer 2 horas semanales durante 5 semanas.',
false, NOW() - INTERVAL '6 days', NULL);


-- #############################################################################
-- ========= CREAR VALORACIONES =========
-- #############################################################################

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES

-- David valora a Carlos (Intercambio completado)
(5, 3, 2, 5,
'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!',
NOW() - INTERVAL '10 days'),

-- Carlos valora a David (Intercambio completado)
(3, 5, 2, 5,
'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!',
NOW() - INTERVAL '10 days'),

-- María valora a Toni (aunque el intercambio aún no está completado, puede ser adelantada)
(2, 1, 1, 4,
'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.',
NOW() - INTERVAL '3 days');


-- #############################################################################
-- ========= CREAR NOTIFICACIONES =========
-- #############################################################################

INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace, referencia_id, leida, fecha_creacion) VALUES

-- Notificación para Toni
(1, 'nuevo_intercambio', 'Nueva propuesta de intercambio',
'María González te ha propuesto un intercambio: sus clases de inglés por tu desarrollo web.',
'/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

-- Notificación para David
(5, 'nuevo_intercambio', 'Nueva propuesta de intercambio',
'Carlos Fernández te ha propuesto un intercambio de sus servicios de electricidad por tus clases de cocina.',
'/intercambios/2', 2, true, NOW() - INTERVAL '15 days'),

(5, 'intercambio_completado', 'Intercambio completado',
'Tu intercambio con Carlos ha sido marcado como completado. ¡No olvides valorar la experiencia!',
'/intercambios/2', 2, true, NOW() - INTERVAL '10 days'),

(5, 'nueva_valoracion', 'Nueva valoración recibida',
'Carlos Fernández te ha valorado con 5 estrellas. ¡Felicidades!',
'/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

-- Notificación para Carlos
(3, 'intercambio_aceptado', 'Intercambio aceptado',
'David Pérez ha aceptado tu propuesta de intercambio. Ahora podéis coordinaros para realizar el intercambio.',
'/intercambios/2', 2, true, NOW() - INTERVAL '14 days'),

(3, 'nueva_valoracion', 'Nueva valoración recibida',
'David Pérez te ha valorado con 5 estrellas. ¡Excelente trabajo!',
'/perfil/valoraciones', 2, false, NOW() - INTERVAL '10 days'),

(3, 'nuevo_mensaje', 'Nuevo mensaje',
'David Pérez te ha enviado un mensaje en la conversación del intercambio.',
'/conversaciones/1', 1, true, NOW() - INTERVAL '15 days'),

-- Notificación para María
(2, 'intercambio_aceptado', 'Intercambio aceptado',
'Toni Campos ha aceptado tu propuesta de intercambio. ¡Podéis empezar a coordinaros!',
'/intercambios/1', 1, true, NOW() - INTERVAL '7 days'),

(2, 'nuevo_intercambio', 'Nueva propuesta de intercambio',
'Laura Martínez te ha propuesto un intercambio: diseño de logo por clases de inglés.',
'/intercambios/3', 3, false, NOW() - INTERVAL '2 days'),

-- Notificación para Laura
(4, 'nuevo_intercambio', 'Nueva propuesta de intercambio',
'Toni Campos te ha propuesto un intercambio relacionado con fotografía y desarrollo web.',
'/intercambios/4', 4, false, NOW() - INTERVAL '1 day');


-- #############################################################################
-- ========= VERIFICACIÓN FINAL =========
-- #############################################################################

-- Mostrar resumen de datos insertados
SELECT 
    '✅ Seeds ejecutados correctamente' as estado,
    (SELECT COUNT(*) FROM usuarios) as usuarios,
    (SELECT COUNT(*) FROM habilidades) as habilidades,
    (SELECT COUNT(*) FROM intercambios) as intercambios,
    (SELECT COUNT(*) FROM conversaciones) as conversaciones,
    (SELECT COUNT(*) FROM mensajes) as mensajes,
    (SELECT COUNT(*) FROM valoraciones) as valoraciones,
    (SELECT COUNT(*) FROM notificaciones) as notificaciones;

-- Listar usuarios creados con sus credenciales
SELECT 
    '📋 USUARIOS DEMO CREADOS' as info,
    nombre_usuario as usuario,
    email,
    rol,
    'abc123.' as password
FROM usuarios
ORDER BY id;

-- #############################################################################
-- ## FIN DE SEEDS
-- #############################################################################
