TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;

INSERT INTO intercambios (habilidad_ofrecida_id, habilidad_solicitada_id, proponente_id, receptor_id, estado, mensaje_propuesta, fecha_propuesta) VALUES
(3, 1, 2, 1, 'aceptado', 'Hola Toni! Vi que ofreces desarrollo web. Yo soy profesora de inglés y me vendría genial una página web sencilla. ¿Te interesaría un intercambio? Puedo darte clases de inglés a cambio.', NOW() - INTERVAL '7 days'),
(6, 14, 3, 5, 'completado', 'Hola David! Soy electricista y vi que das clases de cocina gallega. Me encantaría aprender a hacer pulpo a feira. ¿Cambiamos? Yo te puedo revisar esa encimera que no calienta.', NOW() - INTERVAL '15 days'),
(9, 5, 4, 2, 'propuesto', '¡Hola María! Vi que necesitas un logo para tu blog de viajes. Me encantaría diseñártelo. ¿Te interesaría darme unas clases de inglés conversacional a cambio?', NOW() - INTERVAL '2 days'),
(1, 7, 1, 3, 'propuesto', 'Hola Carlos! Necesito arreglar un grifo que pierde agua. Vi que ofreces fontanería. ¿Te interesaría que te haga una web para tu negocio?', NOW() - INTERVAL '1 day'),
(6, 4, 3, 2, 'aceptado', 'Hola María! Soy electricista y puedo revisar tu lavadora sin problema. ¿Te parece bien cambiarlo por unas clases de inglés para mi hija?', NOW() - INTERVAL '5 days');

SELECT COUNT(*) as total_intercambios FROM intercambios;
