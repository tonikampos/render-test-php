-- public.categorias_habilidades definition

-- Drop table

-- DROP TABLE public.categorias_habilidades;

CREATE TABLE public.categorias_habilidades (
	id serial4 NOT NULL,
	nombre varchar(100) NOT NULL,
	descripcion text NULL,
	icono varchar(50) NULL,
	CONSTRAINT categorias_habilidades_nombre_key UNIQUE (nombre),
	CONSTRAINT categorias_habilidades_pkey PRIMARY KEY (id)
);

-- public.conversaciones definition

-- Drop table

-- DROP TABLE public.conversaciones;

CREATE TABLE public.conversaciones (
	id serial4 NOT NULL,
	intercambio_id int4 NULL,
	fecha_creacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	ultima_actualizacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	CONSTRAINT conversaciones_pkey PRIMARY KEY (id)
);

-- Table Triggers

create trigger trigger_actualizar_conversaciones before
update
    on
    public.conversaciones for each row execute function actualizar_timestamp();


-- public.conversaciones foreign keys

ALTER TABLE public.conversaciones ADD CONSTRAINT conversaciones_intercambio_id_fkey FOREIGN KEY (intercambio_id) REFERENCES public.intercambios(id);


-- public.habilidades definition

-- Drop table

-- DROP TABLE public.habilidades;

CREATE TABLE public.habilidades (
	id serial4 NOT NULL,
	usuario_id int4 NOT NULL,
	categoria_id int4 NOT NULL,
	tipo public."tipo_habilidad" NOT NULL,
	titulo varchar(150) NOT NULL,
	descripcion text NOT NULL,
	estado public."estado_habilidad" DEFAULT 'activa'::estado_habilidad NOT NULL,
	duracion_estimada int4 NULL,
	fecha_publicacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_actualizacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	CONSTRAINT habilidades_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_habilidades_categoria ON public.habilidades (categoria_id);
CREATE INDEX idx_habilidades_estado ON public.habilidades (estado);
CREATE INDEX idx_habilidades_tipo ON public.habilidades (tipo);
CREATE INDEX idx_habilidades_usuario ON public.habilidades (usuario_id);

-- Table Triggers

create trigger trigger_actualizar_habilidades before
update
    on
    public.habilidades for each row execute function actualizar_timestamp();


-- public.habilidades foreign keys

ALTER TABLE public.habilidades ADD CONSTRAINT habilidades_categoria_id_fkey FOREIGN KEY (categoria_id) REFERENCES public.categorias_habilidades(id);
ALTER TABLE public.habilidades ADD CONSTRAINT habilidades_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;


-- public.intercambios definition

-- Drop table

-- DROP TABLE public.intercambios;

CREATE TABLE public.intercambios (
	id serial4 NOT NULL,
	habilidad_ofrecida_id int4 NOT NULL,
	habilidad_solicitada_id int4 NOT NULL,
	proponente_id int4 NOT NULL,
	receptor_id int4 NOT NULL,
	estado public."estado_intercambio" DEFAULT 'propuesto'::estado_intercambio NOT NULL,
	mensaje_propuesta text NULL,
	fecha_propuesta timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_actualizacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_completado timestamptz NULL,
	notas_adicionales text NULL,
	CONSTRAINT diferentes_habilidades CHECK ((habilidad_ofrecida_id <> habilidad_solicitada_id)),
	CONSTRAINT diferentes_usuarios CHECK ((proponente_id <> receptor_id)),
	CONSTRAINT intercambios_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_intercambios_estado ON public.intercambios USING btree (estado);
CREATE INDEX idx_intercambios_proponente ON public.intercambios USING btree (proponente_id);
CREATE INDEX idx_intercambios_receptor ON public.intercambios USING btree (receptor_id);

-- Table Triggers

create trigger trigger_actualizar_intercambios before
update
    on
    public.intercambios for each row execute function actualizar_timestamp();


-- public.intercambios foreign keys

ALTER TABLE public.intercambios ADD CONSTRAINT intercambios_habilidad_ofrecida_id_fkey FOREIGN KEY (habilidad_ofrecida_id) REFERENCES public.habilidades(id);
ALTER TABLE public.intercambios ADD CONSTRAINT intercambios_habilidad_solicitada_id_fkey FOREIGN KEY (habilidad_solicitada_id) REFERENCES public.habilidades(id);
ALTER TABLE public.intercambios ADD CONSTRAINT intercambios_proponente_id_fkey FOREIGN KEY (proponente_id) REFERENCES public.usuarios(id);
ALTER TABLE public.intercambios ADD CONSTRAINT intercambios_receptor_id_fkey FOREIGN KEY (receptor_id) REFERENCES public.usuarios(id);

-- public.mensajes definition

-- Drop table

-- DROP TABLE public.mensajes;

CREATE TABLE public.mensajes (
	id serial4 NOT NULL,
	conversacion_id int4 NOT NULL,
	emisor_id int4 NOT NULL,
	contenido text NOT NULL,
	fecha_envio timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	leido bool DEFAULT false NULL,
	fecha_lectura timestamptz NULL,
	CONSTRAINT mensajes_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_mensajes_conversacion ON public.mensajes (conversacion_id,fecha_envio DESC);
CREATE INDEX idx_mensajes_emisor ON public.mensajes (emisor_id);
CREATE INDEX idx_mensajes_no_leidos ON public.mensajes (conversacion_id);


-- public.mensajes foreign keys

ALTER TABLE public.mensajes ADD CONSTRAINT mensajes_conversacion_id_fkey FOREIGN KEY (conversacion_id) REFERENCES public.conversaciones(id) ON DELETE CASCADE;
ALTER TABLE public.mensajes ADD CONSTRAINT mensajes_emisor_id_fkey FOREIGN KEY (emisor_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;


-- public.notificaciones definition

-- Drop table

-- DROP TABLE public.notificaciones;

CREATE TABLE public.notificaciones (
	id serial4 NOT NULL,
	usuario_id int4 NOT NULL,
	tipo public."tipo_notificacion" NOT NULL,
	titulo varchar(255) NOT NULL,
	mensaje text NOT NULL,
	enlace varchar(255) NULL,
	referencia_id int4 NULL,
	leida bool DEFAULT false NULL,
	enviada_email bool DEFAULT false NULL,
	fecha_creacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_lectura timestamptz NULL,
	CONSTRAINT notificaciones_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_notificaciones_fecha ON public.notificaciones (fecha_creacion DESC);
CREATE INDEX idx_notificaciones_usuario_no_leidas ON public.notificaciones (usuario_id,leida);


-- public.notificaciones foreign keys

ALTER TABLE public.notificaciones ADD CONSTRAINT notificaciones_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;




-- public.participantes_conversacion definition

-- Drop table

-- DROP TABLE public.participantes_conversacion;

CREATE TABLE public.participantes_conversacion (
	conversacion_id int4 NOT NULL,
	usuario_id int4 NOT NULL,
	fecha_union timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	CONSTRAINT participantes_conversacion_pkey PRIMARY KEY (conversacion_id,usuario_id)
);


-- public.participantes_conversacion foreign keys

ALTER TABLE public.participantes_conversacion ADD CONSTRAINT participantes_conversacion_conversacion_id_fkey FOREIGN KEY (conversacion_id) REFERENCES public.conversaciones(id) ON DELETE CASCADE;
ALTER TABLE public.participantes_conversacion ADD CONSTRAINT participantes_conversacion_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;



-- public.password_resets definition

-- Drop table

-- DROP TABLE public.password_resets;

CREATE TABLE public.password_resets (
	id serial4 NOT NULL,
	email varchar(255) NOT NULL,
	"token" varchar(255) NOT NULL,
	fecha_creacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_expiracion timestamptz DEFAULT CURRENT_TIMESTAMP + '01:00:00'::interval NULL,
	usado bool DEFAULT false NULL,
	CONSTRAINT password_resets_pkey PRIMARY KEY (id),
	CONSTRAINT password_resets_token_key UNIQUE ("token")
);
CREATE INDEX idx_password_resets_email ON public.password_resets (email);
CREATE INDEX idx_password_resets_token ON public.password_resets ("token");



-- public.reportes definition

-- Drop table

-- DROP TABLE public.reportes;

CREATE TABLE public.reportes (
	id serial4 NOT NULL,
	reportador_id int4 NOT NULL,
	tipo_contenido public."tipo_contenido_reportado" NOT NULL,
	contenido_id int4 NOT NULL,
	motivo text NOT NULL,
	estado public."estado_reporte" DEFAULT 'pendiente'::estado_reporte NOT NULL,
	fecha_reporte timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_revision timestamptz NULL,
	revisor_id int4 NULL,
	notas_revision text NULL,
	CONSTRAINT reportes_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_reportes_estado ON public.reportes (estado);
CREATE INDEX idx_reportes_tipo_contenido ON public.reportes (tipo_contenido,contenido_id);


-- public.reportes foreign keys

ALTER TABLE public.reportes ADD CONSTRAINT reportes_reportador_id_fkey FOREIGN KEY (reportador_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;
ALTER TABLE public.reportes ADD CONSTRAINT reportes_revisor_id_fkey FOREIGN KEY (revisor_id) REFERENCES public.usuarios(id);



-- public.sesiones definition

-- Drop table

-- DROP TABLE public.sesiones;

CREATE TABLE public.sesiones (
	id serial4 NOT NULL,
	usuario_id int4 NOT NULL,
	"token" varchar(255) NOT NULL,
	ip_address varchar(45) NULL,
	user_agent text NULL,
	fecha_creacion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	fecha_expiracion timestamptz DEFAULT CURRENT_TIMESTAMP + '7 days'::interval NULL,
	fecha_ultimo_acceso timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	activa bool DEFAULT true NULL,
	CONSTRAINT sesiones_pkey PRIMARY KEY (id),
	CONSTRAINT sesiones_token_key UNIQUE ("token")
);
CREATE INDEX idx_sesiones_token ON public.sesiones ("token");
CREATE INDEX idx_sesiones_usuario ON public.sesiones (usuario_id);


-- public.sesiones foreign keys

ALTER TABLE public.sesiones ADD CONSTRAINT sesiones_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;



-- public.usuarios definition

-- Drop table

-- DROP TABLE public.usuarios;

CREATE TABLE public.usuarios (
	id serial4 NOT NULL,
	nombre_usuario varchar(50) NOT NULL,
	email varchar(255) NOT NULL,
	contrasena_hash varchar(255) NOT NULL,
	rol public."rol_usuario" DEFAULT 'usuario'::rol_usuario NOT NULL,
	biografia text NULL,
	foto_url varchar(255) NULL,
	ubicacion varchar(100) NULL,
	activo bool DEFAULT true NULL,
	fecha_registro timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	ultima_conexion timestamptz NULL,
	CONSTRAINT usuarios_email_key UNIQUE (email),
	CONSTRAINT usuarios_nombre_usuario_key UNIQUE (nombre_usuario),
	CONSTRAINT usuarios_pkey PRIMARY KEY (id)
);
CREATE INDEX idx_usuarios_email ON public.usuarios (email);
CREATE INDEX idx_usuarios_ubicacion ON public.usuarios (ubicacion);


-- public.valoraciones definition

-- Drop table

-- DROP TABLE public.valoraciones;

CREATE TABLE public.valoraciones (
	id serial4 NOT NULL,
	evaluador_id int4 NOT NULL,
	evaluado_id int4 NOT NULL,
	intercambio_id int4 NULL,
	puntuacion int4 NOT NULL,
	comentario text NULL,
	fecha_valoracion timestamptz DEFAULT CURRENT_TIMESTAMP NULL,
	CONSTRAINT no_autoevaluacion CHECK (((evaluador_id <> evaluado_id))),
	CONSTRAINT valoraciones_pkey PRIMARY KEY (id),
	CONSTRAINT valoraciones_puntuacion_check CHECK ((((puntuacion >= 1) AND (puntuacion <= 5))))
);
CREATE UNIQUE INDEX idx_valoracion_unica ON public.valoraciones (evaluador_id,evaluado_id,intercambio_id);
CREATE INDEX idx_valoraciones_evaluado ON public.valoraciones (evaluado_id);


-- public.valoraciones foreign keys

ALTER TABLE public.valoraciones ADD CONSTRAINT valoraciones_evaluado_id_fkey FOREIGN KEY (evaluado_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;
ALTER TABLE public.valoraciones ADD CONSTRAINT valoraciones_evaluador_id_fkey FOREIGN KEY (evaluador_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;
ALTER TABLE public.valoraciones ADD CONSTRAINT valoraciones_intercambio_id_fkey FOREIGN KEY (intercambio_id) REFERENCES public.intercambios(id);


-- public.visitantes definition

-- Drop table

-- DROP TABLE public.visitantes;

CREATE TABLE public.visitantes (
	id int4 NOT NULL,
	contador int4 NULL,
	CONSTRAINT visitantes_pkey PRIMARY KEY (id)
);







