export interface Notificacion {
  id: number;
  usuario_id: number;
  tipo: 'intercambio_propuesto' | 'intercambio_aceptado' | 'intercambio_rechazado' | 
        'intercambio_completado' | 'valoracion_recibida' | 'mensaje_nuevo';
  titulo: string;
  mensaje: string;
  entidad_tipo: 'intercambio' | 'valoracion' | 'conversacion';
  entidad_id: number;
  leida: boolean;
  fecha_creacion: string;
  fecha_lectura?: string;
}
