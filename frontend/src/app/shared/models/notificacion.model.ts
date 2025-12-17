export interface Notificacion {
  id: number;
  usuario_id: number;
  tipo: 'nuevo_intercambio' | 'intercambio_aceptado' | 'intercambio_rechazado' | 
        'intercambio_completado' | 'nueva_valoracion' | 'nuevo_mensaje';
  titulo: string;
  mensaje: string;
  enlace: string | null;
  referencia_id: number | null;
  leida: boolean;
  enviada_email: boolean;
  fecha_creacion: string;
  fecha_lectura?: string;
}
