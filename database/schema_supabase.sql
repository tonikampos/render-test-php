-- #############################################################################
-- ## Esquema de Base de Datos para "GaliTroco" - VERSIÓN SUPABASE
-- ## Sistema de Intercambio de Habilidades/Servicios
-- ## Base de Datos: PostgreSQL (Supabase)
-- #############################################################################

-- NOTA: Este archivo está adaptado para Supabase.
-- Se ejecuta directamente en la base de datos "postgres" que ya existe.
-- NO incluye CREATE DATABASE porque Supabase ya proporciona la BD.

-- ========= TIPOS ENUMERADOS =========

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


-- ========= TABLA DE USUARIOS (Épica 1 y 2) =========
-- Almacena la información de los miembros de la comunidad.

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    rol rol_usuario NOT NULL DEFAULT 'usuario',
    biografia TEXT,
    foto_url VARCHAR(255),
    ubicacion VARCHAR(100), -- Ciudad/provincia para filtro de proximidad
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    ultima_conexion TIMESTAMP WITH TIME ZONE
);

-- Índices para búsquedas frecuentes
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_ubicacion ON usuarios(ubicacion);


-- ========= TABLA DE CATEGORÍAS (Épica 2) =========
-- Para organizar las habilidades en categorías predefinidas.

CREATE TABLE categorias_habilidades (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT,
    icono VARCHAR(50) -- Para el frontend (ej: 'home', 'tech', 'art')
);

-- Insertamos categorías de ejemplo
INSERT INTO categorias_habilidades (nombre, descripcion, icono) VALUES
('Hogar y Bricolaje', 'Reparaciones, pintura, carpintería', 'home'),
('Tecnología e Informática', 'Programación, diseño web, reparación PC', 'computer'),
('Clases y Formación', 'Idiomas, música, apoyo escolar', 'school'),
('Arte y Creatividad', 'Fotografía, dibujo, manualidades', 'palette'),
('Cuidado Personal y Bienestar', 'Peluquería, masajes, entrenamiento', 'spa'),
('Gestiones y Trámites', 'Asesoramiento legal, contabilidad', 'folder'),
('Transporte y Logística', 'Mudanzas, mensajería, desplazamientos', 'local_shipping'),
('Cocina y Alimentación', 'Catering, repostería, clases de cocina', 'restaurant');


-- ========= TABLA DE HABILIDADES (Épica 2) =========
-- El núcleo de la aplicación: las habilidades que se ofrecen y se buscan.

CREATE TABLE habilidades (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    categoria_id INT NOT NULL REFERENCES categorias_habilidades(id),
    tipo tipo_habilidad NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    estado estado_habilidad NOT NULL DEFAULT 'activa',
    duracion_estimada INT, -- Duración en minutos (opcional)
    fecha_publicacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Índices para búsquedas y filtros
CREATE INDEX idx_habilidades_usuario ON habilidades(usuario_id);
CREATE INDEX idx_habilidades_categoria ON habilidades(categoria_id);
CREATE INDEX idx_habilidades_tipo ON habilidades(tipo);
CREATE INDEX idx_habilidades_estado ON habilidades(estado);


-- ========= TABLA DE INTERCAMBIOS (NUEVA - Épica 3) =========
-- Registra las propuestas y realizaciones de intercambios entre usuarios.

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

-- Índices para consultas de intercambios
CREATE INDEX idx_intercambios_proponente ON intercambios(proponente_id);
CREATE INDEX idx_intercambios_receptor ON intercambios(receptor_id);
CREATE INDEX idx_intercambios_estado ON intercambios(estado);


-- ========= TABLAS PARA MENSAJERÍA (Épica 4) =========
-- Sistema de mensajería privada entre usuarios.

CREATE TABLE conversaciones (
    id SERIAL PRIMARY KEY,
    intercambio_id INT REFERENCES intercambios(id), -- Opcional: vincular con intercambio
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

-- Índices para optimizar consultas de mensajería
CREATE INDEX idx_mensajes_conversacion ON mensajes(conversacion_id, fecha_envio DESC);
CREATE INDEX idx_mensajes_emisor ON mensajes(emisor_id);
CREATE INDEX idx_mensajes_no_leidos ON mensajes(conversacion_id) WHERE leido = FALSE;


-- ========= TABLA DE VALORACIONES (Épica 5) =========
-- Sistema de reputación basado en estrellas y comentarios.

CREATE TABLE valoraciones (
    id SERIAL PRIMARY KEY,
    evaluador_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    evaluado_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    intercambio_id INT REFERENCES intercambios(id), -- Vincular con intercambio específico
    puntuacion INT NOT NULL CHECK (puntuacion >= 1 AND puntuacion <= 5),
    comentario TEXT,
    fecha_valoracion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT no_autoevaluacion CHECK (evaluador_id <> evaluado_id)
);

-- Índices y constraint para evitar valoraciones duplicadas
CREATE UNIQUE INDEX idx_valoracion_unica ON valoraciones(evaluador_id, evaluado_id, intercambio_id);
CREATE INDEX idx_valoraciones_evaluado ON valoraciones(evaluado_id);


-- ========= TABLA DE NOTIFICACIONES (NUEVA - Épica 4 y 5) =========
-- Sistema de notificaciones in-app y por email.

CREATE TABLE notificaciones (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo tipo_notificacion NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    enlace VARCHAR(255), -- URL de destino al hacer click
    referencia_id INT, -- ID del intercambio/mensaje/valoración relacionado
    leida BOOLEAN DEFAULT FALSE,
    enviada_email BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_lectura TIMESTAMP WITH TIME ZONE
);

-- Índices para consultas de notificaciones
CREATE INDEX idx_notificaciones_usuario_no_leidas ON notificaciones(usuario_id, leida) WHERE leida = FALSE;
CREATE INDEX idx_notificaciones_fecha ON notificaciones(fecha_creacion DESC);


-- ========= TABLA DE RECUPERACIÓN DE CONTRASEÑA (Épica 1) =========
-- Tokens temporales para el proceso de "olvidé mi contraseña".

CREATE TABLE password_resets (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 hour'),
    usado BOOLEAN DEFAULT FALSE
);

-- Índice para búsqueda rápida de tokens
CREATE INDEX idx_password_resets_token ON password_resets(token);
CREATE INDEX idx_password_resets_email ON password_resets(email);


-- ========= TABLA DE SESIONES (NUEVA - Épica 1) =========
-- Para gestionar login/logout y múltiples dispositivos.

CREATE TABLE sesiones (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE DEFAULT (CURRENT_TIMESTAMP + INTERVAL '7 days'),
    fecha_ultimo_acceso TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    activa BOOLEAN DEFAULT TRUE
);

-- Índices para sesiones
CREATE INDEX idx_sesiones_token ON sesiones(token) WHERE activa = TRUE;
CREATE INDEX idx_sesiones_usuario ON sesiones(usuario_id);


-- ========= TABLA DE REPORTES (Épica 4 y 6) =========
-- Para reportar contenido inapropiado y gestión por administradores.

CREATE TABLE reportes (
    id SERIAL PRIMARY KEY,
    reportador_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo_contenido tipo_contenido_reportado NOT NULL,
    contenido_id INT NOT NULL, -- ID del usuario o habilidad reportada
    motivo TEXT NOT NULL,
    estado estado_reporte NOT NULL DEFAULT 'pendiente',
    fecha_reporte TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_revision TIMESTAMP WITH TIME ZONE,
    revisor_id INT REFERENCES usuarios(id), -- Admin que revisó
    notas_revision TEXT
);

-- Índices para gestión de reportes
CREATE INDEX idx_reportes_estado ON reportes(estado);
CREATE INDEX idx_reportes_tipo_contenido ON reportes(tipo_contenido, contenido_id);


-- ========= VISTA PARA ESTADÍSTICAS DE USUARIOS =========
-- Vista útil para mostrar reputación y actividad de usuarios.

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


-- ========= FUNCIÓN PARA ACTUALIZAR TIMESTAMP =========
-- Función reutilizable para actualizar automáticamente fecha_actualizacion.

CREATE OR REPLACE FUNCTION actualizar_timestamp()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_actualizacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Triggers para actualización automática de timestamps
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
-- ## FIN DEL ESQUEMA SUPABASE
-- #############################################################################

-- ========= NOTAS IMPORTANTES PARA SUPABASE =========
-- 
-- 1. Este script se ejecuta en el SQL Editor de Supabase
-- 2. Ya incluye las categorías predefinidas (INSERT)
-- 3. Para los datos de prueba, ejecuta después "seeds.sql"
-- 4. Supabase creará automáticamente las políticas de seguridad RLS
--    (Row Level Security) - configúralas según tus necesidades
-- 
-- 5. Para habilitar RLS en las tablas (recomendado para producción):
--    ALTER TABLE usuarios ENABLE ROW LEVEL SECURITY;
--    ALTER TABLE habilidades ENABLE ROW LEVEL SECURITY;
--    -- etc. para cada tabla
-- 
-- #############################################################################
