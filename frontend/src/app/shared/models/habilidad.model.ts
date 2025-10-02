export interface Habilidad {
  id: number;
  usuario_id: number;
  categoria_id: number;
  tipo: 'oferta' | 'demanda';
  titulo: string;
  descripcion: string;
  estado: 'activa' | 'pausada' | 'intercambiada';
  duracion_estimada?: number;
  fecha_publicacion: string;
  fecha_actualizacion?: string;
  // Datos relacionados (JOINs)
  categoria?: string;
  categoria_icono?: string;
  usuario_nombre?: string;
  usuario_ubicacion?: string;
  usuario_foto?: string;
  usuario_email?: string;
}

export interface HabilidadCreateRequest {
  categoria_id: number;
  tipo: 'oferta' | 'demanda';
  titulo: string;
  descripcion: string;
  duracion_estimada?: number;
}

export interface HabilidadUpdateRequest {
  titulo?: string;
  descripcion?: string;
  duracion_estimada?: number;
}

export interface HabilidadesListParams {
  page?: number;
  per_page?: number;
  tipo?: 'oferta' | 'demanda';
  categoria?: string;
  ubicacion?: string;
  search?: string;
}
