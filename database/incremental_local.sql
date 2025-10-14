-- #############################################################################
-- ## SCRIPT INCREMENTAL PARA POSTGRESQL LOCAL - GaliTroco
-- ## Añade SOLO las tablas que faltan SIN borrar las existentes
-- ## NOTA: Conectarse primero a la base de datos 'galitrocodb' en DBeaver
-- #############################################################################

-- ========= VERIFICAR Y CREAR TIPOS ENUMERADOS (si no existen) =========

-- Verificar si los tipos ya existen antes de crearlos
DO $$ 
BEGIN
    -- Tipo rol_usuario
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'rol_usuario') THEN
        CREATE TYPE rol_usuario AS ENUM ('usuario', 'administrador');
    END IF;
    
    -- Tipo tipo_habilidad
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_habilidad') THEN
        CREATE TYPE tipo_habilidad AS ENUM ('oferta', 'demanda');
    END IF;
    
    -- Tipo estado_habilidad
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_habilidad') THEN
        CREATE TYPE estado_habilidad AS ENUM ('activa', 'pausada', 'intercambiada');
    END IF;
    
    -- Tipo estado_intercambio
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_intercambio') THEN
        CREATE TYPE estado_intercambio AS ENUM ('propuesto', 'aceptado', 'rechazado', 'completado', 'cancelado');
    END IF;
    
    -- Tipo tipo_contenido_reportado
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_contenido_reportado') THEN
        CREATE TYPE tipo_contenido_reportado AS ENUM ('perfil', 'habilidad');
    END IF;
    
    -- Tipo estado_reporte
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_reporte') THEN
        CREATE TYPE estado_reporte AS ENUM ('pendiente', 'revisado', 'resuelto');
    END IF;
    
    -- Tipo tipo_notificacion
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_notificacion') THEN
        CREATE TYPE tipo_notificacion AS ENUM (
            'nuevo_intercambio', 
            'intercambio_aceptado', 
            'intercambio_rechazado',
            'intercambio_completado',
            'nuevo_mensaje', 
            'nueva_valoracion'
        );
    END IF;
END $$;


-- ========= TABLA DE USUARIOS (si no existe) =========

CREATE TABLE IF NOT EXISTS usuarios (
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

-- Índices para usuarios
CREATE INDEX IF NOT EXISTS idx_usuarios_email ON usuarios(email);
CREATE INDEX IF NOT EXISTS idx_usuarios_nombre_usuario ON usuarios(nombre_usuario);


-- ========= TABLA DE SESIONES (si no existe) =========

CREATE TABLE IF NOT EXISTS sesiones (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- Índices para sesiones
CREATE INDEX IF NOT EXISTS idx_sesiones_usuario ON sesiones(usuario_id);
CREATE INDEX IF NOT EXISTS idx_sesiones_token ON sesiones(token);
CREATE INDEX IF NOT EXISTS idx_sesiones_expiracion ON sesiones(fecha_expiracion);


-- ========= TABLA DE PASSWORD RESETS (si no existe) =========

CREATE TABLE IF NOT EXISTS password_resets (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP WITH TIME ZONE NOT NULL,
    usado BOOLEAN DEFAULT FALSE
);

-- Índices para password_resets
CREATE INDEX IF NOT EXISTS idx_password_resets_token ON password_resets(token);
CREATE INDEX IF NOT EXISTS idx_password_resets_usuario ON password_resets(usuario_id);


-- ========= TABLA DE CATEGORÍAS (si no existe) =========

CREATE TABLE IF NOT EXISTS categorias_habilidades (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT,
    icono VARCHAR(50)
);

-- Insertar categorías solo si la tabla está vacía
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM categorias_habilidades LIMIT 1) THEN
        INSERT INTO categorias_habilidades (nombre, descripcion, icono) VALUES
        ('Hogar y Bricolaje', 'Reparaciones, pintura, carpintería', 'home'),
        ('Tecnología e Informática', 'Programación, diseño web, reparación PC', 'computer'),
        ('Clases y Formación', 'Idiomas, música, apoyo escolar', 'school'),
        ('Arte y Creatividad', 'Fotografía, dibujo, manualidades', 'palette'),
        ('Cuidado Personal y Bienestar', 'Peluquería, masajes, entrenamiento', 'spa'),
        ('Gestiones y Trámites', 'Asesoramiento legal, contabilidad', 'folder'),
        ('Transporte y Logística', 'Mudanzas, mensajería, desplazamientos', 'local_shipping'),
        ('Cocina y Alimentación', 'Catering, repostería, clases de cocina', 'restaurant');
    END IF;
END $$;


-- ========= TABLA DE HABILIDADES (si no existe) =========

CREATE TABLE IF NOT EXISTS habilidades (
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

-- Índices para habilidades
CREATE INDEX IF NOT EXISTS idx_habilidades_usuario ON habilidades(usuario_id);
CREATE INDEX IF NOT EXISTS idx_habilidades_categoria ON habilidades(categoria_id);
CREATE INDEX IF NOT EXISTS idx_habilidades_tipo ON habilidades(tipo);
CREATE INDEX IF NOT EXISTS idx_habilidades_estado ON habilidades(estado);


-- ========= TABLA DE INTERCAMBIOS (si no existe) =========

CREATE TABLE IF NOT EXISTS intercambios (
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

-- Índices para intercambios
CREATE INDEX IF NOT EXISTS idx_intercambios_proponente ON intercambios(proponente_id);
CREATE INDEX IF NOT EXISTS idx_intercambios_receptor ON intercambios(receptor_id);
CREATE INDEX IF NOT EXISTS idx_intercambios_estado ON intercambios(estado);


-- ========= TABLAS DE MENSAJERÍA (si no existen) =========

CREATE TABLE IF NOT EXISTS conversaciones (
    id SERIAL PRIMARY KEY,
    intercambio_id INT REFERENCES intercambios(id),
    fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    ultima_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS participantes_conversacion (
    conversacion_id INT NOT NULL REFERENCES conversaciones(id) ON DELETE CASCADE,
    usuario_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    fecha_union TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (conversacion_id, usuario_id)
);

CREATE TABLE IF NOT EXISTS mensajes (
    id SERIAL PRIMARY KEY,
    conversacion_id INT NOT NULL REFERENCES conversaciones(id) ON DELETE CASCADE,
    emisor_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    contenido TEXT NOT NULL,
    fecha_envio TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    fecha_lectura TIMESTAMP WITH TIME ZONE
);

-- Índices para mensajería
CREATE INDEX IF NOT EXISTS idx_mensajes_conversacion ON mensajes(conversacion_id, fecha_envio DESC);
CREATE INDEX IF NOT EXISTS idx_mensajes_emisor ON mensajes(emisor_id);
CREATE INDEX IF NOT EXISTS idx_mensajes_no_leidos ON mensajes(conversacion_id) WHERE leido = FALSE;


-- ========= TABLA DE VALORACIONES (si no existe) =========

CREATE TABLE IF NOT EXISTS valoraciones (
    id SERIAL PRIMARY KEY,
    evaluador_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    evaluado_id INT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    intercambio_id INT REFERENCES intercambios(id),
    puntuacion INT NOT NULL CHECK (puntuacion >= 1 AND puntuacion <= 5),
    comentario TEXT,
    fecha_valoracion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT no_autoevaluacion CHECK (evaluador_id <> evaluado_id)
);

-- Índices para valoraciones
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_indexes 
        WHERE indexname = 'idx_valoracion_unica'
    ) THEN
        CREATE UNIQUE INDEX idx_valoracion_unica 
        ON valoraciones(evaluador_id, evaluado_id, intercambio_id);
    END IF;
END $$;

CREATE INDEX IF NOT EXISTS idx_valoraciones_evaluado ON valoraciones(evaluado_id);


-- ========= TABLA DE NOTIFICACIONES (si no existe) =========

CREATE TABLE IF NOT EXISTS notificaciones (
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

-- Índices para notificaciones
CREATE INDEX IF NOT EXISTS idx_notificaciones_usuario_no_leidas 
    ON notificaciones(usuario_id, leida) WHERE leida = FALSE;
CREATE INDEX IF NOT EXISTS idx_notificaciones_fecha 
    ON notificaciones(fecha_creacion DESC);


-- ========= TABLA DE REPORTES (si no existe) =========

CREATE TABLE IF NOT EXISTS reportes (
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

-- Índices para reportes
CREATE INDEX IF NOT EXISTS idx_reportes_estado ON reportes(estado);
CREATE INDEX IF NOT EXISTS idx_reportes_tipo_contenido 
    ON reportes(tipo_contenido, contenido_id);


-- ========= VISTA DE ESTADÍSTICAS (si no existe) =========

CREATE OR REPLACE VIEW estadisticas_usuarios AS
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


-- ========= FUNCIÓN PARA ACTUALIZAR TIMESTAMPS (si no existe) =========

CREATE OR REPLACE FUNCTION actualizar_timestamp()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_actualizacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


-- ========= TRIGGERS PARA ACTUALIZACIÓN AUTOMÁTICA =========

-- Trigger para habilidades
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_trigger 
        WHERE tgname = 'trigger_actualizar_habilidades'
    ) THEN
        CREATE TRIGGER trigger_actualizar_habilidades
            BEFORE UPDATE ON habilidades
            FOR EACH ROW
            EXECUTE FUNCTION actualizar_timestamp();
    END IF;
END $$;

-- Trigger para intercambios
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_trigger 
        WHERE tgname = 'trigger_actualizar_intercambios'
    ) THEN
        CREATE TRIGGER trigger_actualizar_intercambios
            BEFORE UPDATE ON intercambios
            FOR EACH ROW
            EXECUTE FUNCTION actualizar_timestamp();
    END IF;
END $$;

-- Trigger para conversaciones
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_trigger 
        WHERE tgname = 'trigger_actualizar_conversaciones'
    ) THEN
        CREATE TRIGGER trigger_actualizar_conversaciones
            BEFORE UPDATE ON conversaciones
            FOR EACH ROW
            EXECUTE FUNCTION actualizar_timestamp();
    END IF;
END $$;


-- #############################################################################
-- ## VERIFICACIÓN FINAL
-- #############################################################################

-- Consulta para verificar todas las tablas creadas
DO $$
DECLARE
    tabla_count INT;
BEGIN
    SELECT COUNT(*) INTO tabla_count
    FROM information_schema.tables
    WHERE table_schema = 'public'
    AND table_type = 'BASE TABLE';
    
    RAISE NOTICE '================================';
    RAISE NOTICE 'RESUMEN DE TABLAS CREADAS';
    RAISE NOTICE '================================';
    RAISE NOTICE 'Total de tablas en la BD: %', tabla_count;
    RAISE NOTICE '================================';
END $$;

-- Listar todas las tablas
SELECT 
    table_name,
    CASE 
        WHEN table_name IN ('usuarios', 'sesiones', 'password_resets') 
        THEN '✅ YA EXISTÍA'
        ELSE '🆕 NUEVA'
    END as estado
FROM information_schema.tables
WHERE table_schema = 'public'
AND table_type = 'BASE TABLE'
ORDER BY table_name;

-- #############################################################################
-- ## FIN DEL SCRIPT INCREMENTAL LOCAL
-- #############################################################################
