-- #############################################################################
-- ## SCRIPT DE RECREACIÓN COMPLETA - PostgreSQL LOCAL
-- ## BORRA TODO y crea desde cero con el esquema correcto
-- ## ⚠️ SOLO PARA LOCAL - NO EJECUTAR EN SUPABASE
-- #############################################################################

-- ========= PASO 1: ELIMINAR TODO LO EXISTENTE =========

-- Eliminar vistas
DROP VIEW IF EXISTS estadisticas_usuarios CASCADE;

-- Eliminar tablas en orden inverso (por dependencias)
DROP TABLE IF EXISTS reportes CASCADE;
DROP TABLE IF EXISTS notificaciones CASCADE;
DROP TABLE IF EXISTS valoraciones CASCADE;
DROP TABLE IF EXISTS mensajes CASCADE;
DROP TABLE IF EXISTS participantes_conversacion CASCADE;
DROP TABLE IF EXISTS conversaciones CASCADE;
DROP TABLE IF EXISTS intercambios CASCADE;
DROP TABLE IF EXISTS habilidades CASCADE;
DROP TABLE IF EXISTS categorias_habilidades CASCADE;
DROP TABLE IF EXISTS password_resets CASCADE;
DROP TABLE IF EXISTS sesiones CASCADE;
DROP TABLE IF EXISTS usuarios CASCADE;

-- Eliminar tipos ENUM
DROP TYPE IF EXISTS tipo_notificacion CASCADE;
DROP TYPE IF EXISTS estado_reporte CASCADE;
DROP TYPE IF EXISTS tipo_contenido_reportado CASCADE;
DROP TYPE IF EXISTS estado_intercambio CASCADE;
DROP TYPE IF EXISTS estado_habilidad CASCADE;
DROP TYPE IF EXISTS tipo_habilidad CASCADE;
DROP TYPE IF EXISTS rol_usuario CASCADE;

-- Eliminar función
DROP FUNCTION IF EXISTS actualizar_timestamp() CASCADE;


-- #############################################################################
-- ========= PASO 2: CREAR TIPOS ENUMERADOS =========
-- #############################################################################

CREATE TYPE rol_usuario AS ENUM ('usuario', 'administrador');
CREATE TYPE tipo_habilidad AS ENUM ('oferta', 'demanda');
CREATE TYPE estado_habilidad AS ENUM ('activa', 'pausada', 'intercambiada');
CREATE TYPE estado_intercambio AS ENUM ('propuesto', 'aceptado', 'rechazado', 'completado', 'cancelado');
CREATE TYPE tipo_contenido_reportado AS ENUM ('perfil', 'habilidad');
CREATE TYPE estado_reporte AS ENUM ('pendiente', 'revisado', 'resuelto');
CREATE TYPE tipo_notificacion AS ENUM (
    'nuevo_intercambio', 
    'intercambio_aceptado', 
    'intercambio_rechazado',
    'intercambio_completado',
    'nuevo_mensaje', 
    'nueva_valoracion'
);


-- #############################################################################
-- ========= PASO 3: CREAR TABLAS =========
-- #############################################################################

-- TABLA DE USUARIOS
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre_completo VARCHAR(255) NOT NULL,
    nombre_usuario VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    ubicacion VARCHAR(255),
    biografia TEXT,
    foto_perfil VARCHAR(255),
    fecha_registro TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP WITH TIME ZONE,
    activo BOOLEAN DEFAULT TRUE,
    verificado BOOLEAN DEFAULT FALSE,
    rol rol_usuario DEFAULT 'usuario'
);

CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_nombre_usuario ON usuarios(nombre_usuario);


-- TABLA DE SESIONES
CREATE TABLE sesiones (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT
);

CREATE INDEX idx_sesiones_usuario ON sesiones(usuario_id);
CREATE INDEX idx_sesiones_token ON sesiones(token);
CREATE INDEX idx_sesiones_expiracion ON sesiones(fecha_expiracion);


-- TABLA DE PASSWORD RESETS
CREATE TABLE password_resets (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE NOT NULL,
    usado BOOLEAN DEFAULT FALSE
);

CREATE INDEX idx_password_resets_token ON password_resets(token);
CREATE INDEX idx_password_resets_usuario ON password_resets(usuario_id);


-- TABLA DE CATEGORÍAS
CREATE TABLE categorias_habilidades (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT,
    icono VARCHAR(50)
);

-- Insertar categorías predefinidas
INSERT INTO categorias_habilidades (nombre, descripcion, icono) VALUES
('Hogar y Bricolaje', 'Reparaciones, pintura, carpintería', 'home'),
('Tecnología e Informática', 'Programación, diseño web, reparación PC', 'computer'),
('Clases y Formación', 'Idiomas, música, apoyo escolar', 'school'),
('Arte y Creatividad', 'Fotografía, dibujo, manualidades', 'palette'),
('Cuidado Personal y Bienestar', 'Peluquería, masajes, entrenamiento', 'spa'),
('Gestiones y Trámites', 'Asesoramiento legal, contabilidad', 'folder'),
('Transporte y Logística', 'Mudanzas, mensajería, desplazamientos', 'local_shipping'),
('Cocina y Alimentación', 'Catering, repostería, clases de cocina', 'restaurant');


-- TABLA DE HABILIDADES
CREATE TABLE habilidades (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    categoria_id INT NOT NULL REFERENCES categorias_habilidades(id),
    tipo tipo_habilidad NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    estado estado_habilidad NOT NULL DEFAULT 'activa',
    duracion_estimada INT,
    fecha_publicacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_habilidades_usuario ON habilidades(usuario_id);
CREATE INDEX idx_habilidades_categoria ON habilidades(categoria_id);
CREATE INDEX idx_habilidades_tipo ON habilidades(tipo);
CREATE INDEX idx_habilidades_estado ON habilidades(estado);


-- TABLA DE INTERCAMBIOS
CREATE TABLE intercambios (
    id SERIAL PRIMARY KEY,
    habilidad_ofrecida_id INT NOT NULL REFERENCES habilidades(id),
    habilidad_solicitada_id INT NOT NULL REFERENCES habilidades(id),
    proponente_id INT NOT NULL REFERENCES usuarios(id),
    receptor_id INT NOT NULL REFERENCES usuarios(id),
    estado estado_intercambio NOT NULL DEFAULT 'propuesto',
    mensaje_propuesta TEXT,
    fecha_propuesta TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_completado TIMESTAMP WITH TIME ZONE,
    notas_adicionales TEXT,
    CONSTRAINT diferentes_usuarios CHECK (proponente_id <> receptor_id),
    CONSTRAINT diferentes_habilidades CHECK (habilidad_ofrecida_id <> habilidad_solicitada_id)
);

CREATE INDEX idx_intercambios_proponente ON intercambios(proponente_id);
CREATE INDEX idx_intercambios_receptor ON intercambios(receptor_id);
CREATE INDEX idx_intercambios_estado ON intercambios(estado);


-- TABLAS DE MENSAJERÍA
CREATE TABLE conversaciones (
    id SERIAL PRIMARY KEY,
    intercambio_id INT REFERENCES intercambios(id),
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    ultima_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE participantes_conversacion (
    conversacion_id INT NOT NULL REFERENCES conversaciones(id) ON DELETE CASCADE,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    fecha_union TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (conversacion_id, usuario_id)
);

CREATE TABLE mensajes (
    id SERIAL PRIMARY KEY,
    conversacion_id INT NOT NULL REFERENCES conversaciones(id) ON DELETE CASCADE,
    emisor_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    contenido TEXT NOT NULL,
    fecha_envio TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    fecha_lectura TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_mensajes_conversacion ON mensajes(conversacion_id, fecha_envio DESC);
CREATE INDEX idx_mensajes_emisor ON mensajes(emisor_id);
CREATE INDEX idx_mensajes_no_leidos ON mensajes(conversacion_id) WHERE leido = FALSE;


-- TABLA DE VALORACIONES
CREATE TABLE valoraciones (
    id SERIAL PRIMARY KEY,
    evaluador_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    evaluado_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    intercambio_id INT REFERENCES intercambios(id),
    puntuacion INT NOT NULL CHECK (puntuacion >= 1 AND puntuacion <= 5),
    comentario TEXT,
    fecha_valoracion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT no_autoevaluacion CHECK (evaluador_id <> evaluado_id)
);

CREATE UNIQUE INDEX idx_valoracion_unica ON valoraciones(evaluador_id, evaluado_id, intercambio_id);
CREATE INDEX idx_valoraciones_evaluado ON valoraciones(evaluado_id);


-- TABLA DE NOTIFICACIONES
CREATE TABLE notificaciones (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo tipo_notificacion NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    enlace VARCHAR(255),
    referencia_id INT,
    leida BOOLEAN DEFAULT FALSE,
    enviada_email BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_lectura TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_notificaciones_usuario_no_leidas ON notificaciones(usuario_id, leida) WHERE leida = FALSE;
CREATE INDEX idx_notificaciones_fecha ON notificaciones(fecha_creacion DESC);


-- TABLA DE REPORTES
CREATE TABLE reportes (
    id SERIAL PRIMARY KEY,
    reportador_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo_contenido tipo_contenido_reportado NOT NULL,
    contenido_id INT NOT NULL,
    motivo TEXT NOT NULL,
    estado estado_reporte NOT NULL DEFAULT 'pendiente',
    fecha_reporte TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_revision TIMESTAMP WITH TIME ZONE,
    revisor_id INT REFERENCES usuarios(id),
    notas_revision TEXT
);

CREATE INDEX idx_reportes_estado ON reportes(estado);
CREATE INDEX idx_reportes_tipo_contenido ON reportes(tipo_contenido, contenido_id);


-- #############################################################################
-- ========= PASO 4: CREAR VISTA Y FUNCIONES =========
-- #############################################################################

-- VISTA DE ESTADÍSTICAS
CREATE VIEW estadisticas_usuarios AS
SELECT 
    u.id,
    u.nombre_usuario,
    u.ubicacion,
    COUNT(DISTINCT h.id) as total_habilidades,
    COUNT(DISTINCT CASE WHEN h.tipo = 'oferta' THEN h.id END) as ofertas_activas,
    COUNT(DISTINCT CASE WHEN h.tipo = 'demanda' THEN h.id END) as demandas_activas,
    COUNT(DISTINCT i.id) as total_intercambios,
    COUNT(DISTINCT CASE WHEN i.estado = 'completado' THEN i.id END) as intercambios_completados,
    COALESCE(AVG(v.puntuacion), 0) as valoracion_promedio,
    COUNT(v.id) as total_valoraciones
FROM usuarios u
LEFT JOIN habilidades h ON u.id = h.usuario_id AND h.estado = 'activa'
LEFT JOIN intercambios i ON u.id = i.proponente_id OR u.id = i.receptor_id
LEFT JOIN valoraciones v ON u.id = v.evaluado_id
GROUP BY u.id, u.nombre_usuario, u.ubicacion;


-- FUNCIÓN PARA ACTUALIZAR TIMESTAMPS
CREATE FUNCTION actualizar_timestamp()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_actualizacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


-- #############################################################################
-- ========= PASO 5: CREAR TRIGGERS =========
-- #############################################################################

CREATE TRIGGER trigger_actualizar_habilidades
    BEFORE UPDATE ON habilidades
    FOR EACH ROW
    EXECUTE FUNCTION actualizar_timestamp();

CREATE TRIGGER trigger_actualizar_intercambios
    BEFORE UPDATE ON intercambios
    FOR EACH ROW
    EXECUTE FUNCTION actualizar_timestamp();

CREATE TRIGGER trigger_actualizar_conversaciones
    BEFORE UPDATE ON conversaciones
    FOR EACH ROW
    EXECUTE FUNCTION actualizar_timestamp();


-- #############################################################################
-- ========= VERIFICACIÓN FINAL =========
-- #############################################################################

SELECT 
    '✅ Base de datos recreada correctamente' as estado,
    COUNT(*) as total_tablas
FROM information_schema.tables
WHERE table_schema = 'public'
AND table_type = 'BASE TABLE';

-- Listar todas las tablas creadas
SELECT 
    table_name as "📋 Tabla creada"
FROM information_schema.tables
WHERE table_schema = 'public'
AND table_type = 'BASE TABLE'
ORDER BY table_name;

-- #############################################################################
-- ## FIN DEL SCRIPT DE RECREACIÓN
-- #############################################################################
