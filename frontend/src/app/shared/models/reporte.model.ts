export interface Reporte {
  id: number;
  reportador_id: number;
  tipo_contenido: 'usuario' | 'habilidad' | 'valoracion';
  contenido_id: number;
  motivo: string;
  estado: 'pendiente' | 'revisado' | 'desestimado' | 'accion_tomada';
  fecha_reporte: string;
  fecha_revision?: string | null;
  revisor_id?: number | null;
  notas_revision?: string | null;
}