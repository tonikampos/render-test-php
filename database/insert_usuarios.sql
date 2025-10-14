TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;

INSERT INTO usuarios (nombre_usuario, email, contrasena_hash, rol, biografia, ubicacion, activo) VALUES
('tonicampos', 'toni.vendecasa@gmail.com', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'administrador', 'Desarrollador web especializado en aplicaciones colaborativas. Creador de GaliTroco.', 'A Coruña, Galicia', true),
('mariaglez', 'maria.gonzalez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Profesora de inglés y español. Me encanta compartir conocimientos y aprender cosas nuevas.', 'Santiago de Compostela, Galicia', true),
('carlosfdez', 'carlos.fernandez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Electricista con 15 años de experiencia. También me defiendo con la fontanería.', 'Vigo, Galicia', true),
('lauramtnez', 'laura.martinez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Diseñadora gráfica freelance. Apasionada del arte y la fotografía.', 'Lugo, Galicia', true),
('davidperez', 'david.perez@demo.galitro.co', '$2y$12$LQ7PjrXKGGdQh5FNYKq.vO.KCrJmNpz1f6jF.xPHqFYqxPzR8qB.K', 'usuario', 'Chef profesional y amante de la cocina tradicional gallega. Siempre dispuesto a enseñar.', 'Ourense, Galicia', true);

SELECT COUNT(*) as total_usuarios FROM usuarios;
