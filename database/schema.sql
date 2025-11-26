-- =========================================================================
-- ESQUEMA COMPLETO DE BASE DE DATOS - GaliTroco
-- Generado automáticamente desde Supabase (Producción)
-- Fecha: 2025-10-28 16:22:28
-- =========================================================================

-- =========================================================================
-- TIPOS ENUMERADOS (ENUM)
-- =========================================================================

CREATE TYPE estado_habilidad AS ENUM ('activa', 'pausada', 'intercambiada');
CREATE TYPE estado_intercambio AS ENUM ('propuesto', 'aceptado', 'rechazado', 'completado', 'cancelado');
CREATE TYPE estado_reporte AS ENUM ('pendiente', 'revisado', 'desestimado', 'accion_tomada');
CREATE TYPE rol_usuario AS ENUM ('usuario', 'administrador');
CREATE TYPE tipo_contenido_reportado AS ENUM ('perfil', 'habilidad');
CREATE TYPE tipo_habilidad AS ENUM ('oferta', 'demanda');
CREATE TYPE tipo_notificacion AS ENUM ('nuevo_intercambio', 'intercambio_aceptado', 'intercambio_rechazado', 'intercambio_completado', 'nuevo_mensaje', 'nueva_valoracion');

-- =========================================================================
-- TABLAS
-- =========================================================================

-- Tabla: categorias_habilidades
CREATE TABLE categorias_habilidades (id INTEGER NOT NULL DEFAULT nextval('categorias_habilidades_id_seq'::regclass), nombre VARCHAR(100) NOT NULL, descripcion TEXT, icono VARCHAR(50));

ALTER TABLE categorias_habilidades ADD PRIMARY KEY (id);

-- Tabla: conversaciones
CREATE TABLE conversaciones (id INTEGER NOT NULL DEFAULT nextval('conversaciones_id_seq'::regclass), intercambio_id INTEGER, fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, ultima_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP);

ALTER TABLE conversaciones ADD PRIMARY KEY (id);

-- Tabla: habilidades
CREATE TABLE habilidades (id INTEGER NOT NULL DEFAULT nextval('habilidades_id_seq'::regclass), usuario_id INTEGER NOT NULL, categoria_id INTEGER NOT NULL, tipo tipo_habilidad NOT NULL, titulo VARCHAR(150) NOT NULL, descripcion TEXT NOT NULL, estado estado_habilidad NOT NULL DEFAULT 'activa'::estado_habilidad, duracion_estimada INTEGER, fecha_publicacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, ultima_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP);

ALTER TABLE habilidades ADD PRIMARY KEY (id);

-- Tabla: intercambios
CREATE TABLE intercambios (id INTEGER NOT NULL DEFAULT nextval('intercambios_id_seq'::regclass), habilidad_ofrecida_id INTEGER NOT NULL, habilidad_solicitada_id INTEGER NOT NULL, proponente_id INTEGER NOT NULL, receptor_id INTEGER NOT NULL, estado estado_intercambio NOT NULL DEFAULT 'propuesto'::estado_intercambio, mensaje_propuesta TEXT, fecha_propuesta TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_actualizacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_completado TIMESTAMP WITH TIME ZONE, notas_adicionales TEXT);

ALTER TABLE intercambios ADD PRIMARY KEY (id);

-- Tabla: mensajes
CREATE TABLE mensajes (id INTEGER NOT NULL DEFAULT nextval('mensajes_id_seq'::regclass), conversacion_id INTEGER NOT NULL, emisor_id INTEGER NOT NULL, contenido TEXT NOT NULL, fecha_envio TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, leido BOOLEAN DEFAULT false, fecha_lectura TIMESTAMP WITH TIME ZONE);

ALTER TABLE mensajes ADD PRIMARY KEY (id);

-- Tabla: notificaciones
CREATE TABLE notificaciones (id INTEGER NOT NULL DEFAULT nextval('notificaciones_id_seq'::regclass), usuario_id INTEGER NOT NULL, tipo tipo_notificacion NOT NULL, titulo VARCHAR(255) NOT NULL, mensaje TEXT NOT NULL, enlace VARCHAR(255), referencia_id INTEGER, leida BOOLEAN DEFAULT false, enviada_email BOOLEAN DEFAULT false, fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_lectura TIMESTAMP WITH TIME ZONE);

ALTER TABLE notificaciones ADD PRIMARY KEY (id);

-- Tabla: participantes_conversacion
CREATE TABLE participantes_conversacion (conversacion_id INTEGER NOT NULL, usuario_id INTEGER NOT NULL, fecha_union TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP);

ALTER TABLE participantes_conversacion ADD PRIMARY KEY (conversacion_id, usuario_id);

-- Tabla: password_resets
CREATE TABLE password_resets (id INTEGER NOT NULL DEFAULT nextval('password_resets_id_seq'::regclass), email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_expiracion TIMESTAMP WITH TIME ZONE DEFAULT (CURRENT_TIMESTAMP + '01:00:00'::interval), usado BOOLEAN DEFAULT false);

ALTER TABLE password_resets ADD PRIMARY KEY (id);

-- Tabla: reportes
CREATE TABLE reportes (id INTEGER NOT NULL DEFAULT nextval('reportes_id_seq'::regclass), reportador_id INTEGER NOT NULL, tipo_contenido tipo_contenido_reportado NOT NULL, contenido_id INTEGER NOT NULL, motivo TEXT NOT NULL, estado estado_reporte NOT NULL DEFAULT 'pendiente'::estado_reporte, fecha_reporte TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_revision TIMESTAMP WITH TIME ZONE, revisor_id INTEGER, notas_revision TEXT);

ALTER TABLE reportes ADD PRIMARY KEY (id);

-- Tabla: sesiones
CREATE TABLE sesiones (id INTEGER NOT NULL DEFAULT nextval('sesiones_id_seq'::regclass), usuario_id INTEGER NOT NULL, token VARCHAR(255) NOT NULL, ip_address VARCHAR(45), user_agent TEXT, fecha_creacion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, fecha_expiracion TIMESTAMP WITH TIME ZONE DEFAULT (CURRENT_TIMESTAMP + '7 days'::interval), fecha_ultimo_acceso TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, activa BOOLEAN DEFAULT true);

ALTER TABLE sesiones ADD PRIMARY KEY (id);

-- Tabla: usuarios
CREATE TABLE usuarios (id INTEGER NOT NULL DEFAULT nextval('usuarios_id_seq'::regclass), nombre_usuario VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, contrasena_hash VARCHAR(255) NOT NULL, rol rol_usuario NOT NULL DEFAULT 'usuario'::rol_usuario, biografia TEXT, foto_url VARCHAR(255), ubicacion VARCHAR(100), activo BOOLEAN DEFAULT true, fecha_registro TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, ultima_conexion TIMESTAMP WITH TIME ZONE);

ALTER TABLE usuarios ADD PRIMARY KEY (id);

-- Tabla: valoraciones
CREATE TABLE valoraciones (id INTEGER NOT NULL DEFAULT nextval('valoraciones_id_seq'::regclass), evaluador_id INTEGER NOT NULL, evaluado_id INTEGER NOT NULL, intercambio_id INTEGER, puntuacion INTEGER NOT NULL, comentario TEXT, fecha_valoracion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP);

ALTER TABLE valoraciones ADD PRIMARY KEY (id);

-- =========================================================================
-- FOREIGN KEYS
-- =========================================================================

ALTER TABLE conversaciones
  ADD CONSTRAINT conversaciones_intercambio_id_fkey
  FOREIGN KEY (intercambio_id)
  REFERENCES intercambios(id);

ALTER TABLE habilidades
  ADD CONSTRAINT habilidades_categoria_id_fkey
  FOREIGN KEY (categoria_id)
  REFERENCES categorias_habilidades(id);

ALTER TABLE habilidades
  ADD CONSTRAINT habilidades_usuario_id_fkey
  FOREIGN KEY (usuario_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE intercambios
  ADD CONSTRAINT intercambios_habilidad_ofrecida_id_fkey
  FOREIGN KEY (habilidad_ofrecida_id)
  REFERENCES habilidades(id);

ALTER TABLE intercambios
  ADD CONSTRAINT intercambios_habilidad_solicitada_id_fkey
  FOREIGN KEY (habilidad_solicitada_id)
  REFERENCES habilidades(id);

ALTER TABLE intercambios
  ADD CONSTRAINT intercambios_proponente_id_fkey
  FOREIGN KEY (proponente_id)
  REFERENCES usuarios(id);

ALTER TABLE intercambios
  ADD CONSTRAINT intercambios_receptor_id_fkey
  FOREIGN KEY (receptor_id)
  REFERENCES usuarios(id);

ALTER TABLE mensajes
  ADD CONSTRAINT mensajes_conversacion_id_fkey
  FOREIGN KEY (conversacion_id)
  REFERENCES conversaciones(id) ON DELETE CASCADE;

ALTER TABLE mensajes
  ADD CONSTRAINT mensajes_emisor_id_fkey
  FOREIGN KEY (emisor_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE notificaciones
  ADD CONSTRAINT notificaciones_usuario_id_fkey
  FOREIGN KEY (usuario_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE participantes_conversacion
  ADD CONSTRAINT participantes_conversacion_conversacion_id_fkey
  FOREIGN KEY (conversacion_id)
  REFERENCES conversaciones(id) ON DELETE CASCADE;

ALTER TABLE participantes_conversacion
  ADD CONSTRAINT participantes_conversacion_usuario_id_fkey
  FOREIGN KEY (usuario_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE reportes
  ADD CONSTRAINT reportes_reportador_id_fkey
  FOREIGN KEY (reportador_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE reportes
  ADD CONSTRAINT reportes_revisor_id_fkey
  FOREIGN KEY (revisor_id)
  REFERENCES usuarios(id);

ALTER TABLE sesiones
  ADD CONSTRAINT sesiones_usuario_id_fkey
  FOREIGN KEY (usuario_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE valoraciones
  ADD CONSTRAINT valoraciones_evaluado_id_fkey
  FOREIGN KEY (evaluado_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE valoraciones
  ADD CONSTRAINT valoraciones_evaluador_id_fkey
  FOREIGN KEY (evaluador_id)
  REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE valoraciones
  ADD CONSTRAINT valoraciones_intercambio_id_fkey
  FOREIGN KEY (intercambio_id)
  REFERENCES intercambios(id);

-- =========================================================================
-- ÍNDICES
-- =========================================================================

CREATE UNIQUE INDEX categorias_habilidades_nombre_key ON public.categorias_habilidades USING btree (nombre);
CREATE INDEX idx_habilidades_categoria ON public.habilidades USING btree (categoria_id);
CREATE INDEX idx_habilidades_estado ON public.habilidades USING btree (estado);
CREATE INDEX idx_habilidades_tipo ON public.habilidades USING btree (tipo);
CREATE INDEX idx_habilidades_usuario ON public.habilidades USING btree (usuario_id);
CREATE INDEX idx_intercambios_estado ON public.intercambios USING btree (estado);
CREATE INDEX idx_intercambios_proponente ON public.intercambios USING btree (proponente_id);
CREATE INDEX idx_intercambios_receptor ON public.intercambios USING btree (receptor_id);
CREATE INDEX idx_mensajes_conversacion ON public.mensajes USING btree (conversacion_id, fecha_envio DESC);
CREATE INDEX idx_mensajes_emisor ON public.mensajes USING btree (emisor_id);
CREATE INDEX idx_mensajes_no_leidos ON public.mensajes USING btree (conversacion_id) WHERE (leido = false);
CREATE INDEX idx_notificaciones_fecha ON public.notificaciones USING btree (fecha_creacion DESC);
CREATE INDEX idx_notificaciones_usuario_no_leidas ON public.notificaciones USING btree (usuario_id, leida) WHERE (leida = false);
CREATE INDEX idx_password_resets_email ON public.password_resets USING btree (email);
CREATE INDEX idx_password_resets_token ON public.password_resets USING btree (token);
CREATE UNIQUE INDEX password_resets_token_key ON public.password_resets USING btree (token);
CREATE INDEX idx_reportes_estado ON public.reportes USING btree (estado);
CREATE INDEX idx_reportes_tipo_contenido ON public.reportes USING btree (tipo_contenido, contenido_id);
CREATE INDEX idx_sesiones_token ON public.sesiones USING btree (token) WHERE (activa = true);
CREATE INDEX idx_sesiones_usuario ON public.sesiones USING btree (usuario_id);
CREATE UNIQUE INDEX sesiones_token_key ON public.sesiones USING btree (token);
CREATE INDEX idx_usuarios_email ON public.usuarios USING btree (email);
CREATE INDEX idx_usuarios_ubicacion ON public.usuarios USING btree (ubicacion);
CREATE UNIQUE INDEX usuarios_email_key ON public.usuarios USING btree (email);
CREATE UNIQUE INDEX usuarios_nombre_usuario_key ON public.usuarios USING btree (nombre_usuario);
CREATE UNIQUE INDEX idx_valoracion_unica ON public.valoraciones USING btree (evaluador_id, evaluado_id, intercambio_id);
CREATE INDEX idx_valoraciones_evaluado ON public.valoraciones USING btree (evaluado_id);

-- =========================================================================
-- VISTAS
-- =========================================================================

-- Vista: estadisticas_usuarios
-- Propósito: Calcular estadísticas agregadas para cada usuario en tiempo real
CREATE OR REPLACE VIEW estadisticas_usuarios AS
 SELECT u.id,
    u.nombre_usuario,
    u.ubicacion,
    count(DISTINCT h.id) AS total_habilidades,
    count(DISTINCT
        CASE
            WHEN (h.tipo = 'oferta'::tipo_habilidad) THEN h.id
            ELSE NULL::integer
        END) AS ofertas_activas,
    count(DISTINCT
        CASE
            WHEN (h.tipo = 'demanda'::tipo_habilidad) THEN h.id
            ELSE NULL::integer
        END) AS demandas_activas,
    count(DISTINCT i.id) AS total_intercambios,
    count(DISTINCT
        CASE
            WHEN (i.estado = 'completado'::estado_intercambio) THEN i.id
            ELSE NULL::integer
        END) AS intercambios_completados,
    COALESCE(avg(v.puntuacion), (0)::numeric) AS valoracion_promedio,
    count(v.id) AS total_valoraciones
   FROM (((usuarios u
     LEFT JOIN habilidades h ON (((u.id = h.usuario_id) AND (h.estado = 'activa'::estado_habilidad))))
     LEFT JOIN intercambios i ON (((u.id = i.proponente_id) OR (u.id = i.receptor_id))))
     LEFT JOIN valoraciones v ON ((u.id = v.evaluado_id)))
  GROUP BY u.id, u.nombre_usuario, u.ubicacion;
