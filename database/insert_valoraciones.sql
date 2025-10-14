TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;

INSERT INTO valoraciones (evaluador_id, evaluado_id, intercambio_id, puntuacion, comentario, fecha_valoracion) VALUES
(5, 3, 2, 5, 'Carlos es un profesional excelente. Vino puntual, revisó la encimera en minutos y me la dejó funcionando perfecta. Además fue muy amable. ¡Totalmente recomendado!', NOW() - INTERVAL '10 days'),
(3, 5, 2, 5, 'La clase de cocina gallega fue increíble. David es un maestro y explica todo muy bien. Aprendí a hacer pulpo a feira como nunca imaginé. ¡Repetiré seguro!', NOW() - INTERVAL '10 days'),
(2, 1, 1, 4, 'Toni está trabajando en mi web y por ahora todo va muy bien. Es muy profesional y entiende perfectamente lo que necesito. Actualizo valoración cuando termine.', NOW() - INTERVAL '3 days');

SELECT COUNT(*) as total_valoraciones FROM valoraciones;
