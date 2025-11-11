export interface Conversacion {
  id: number;
  usuario1_id: number;
  usuario2_id: number;
  fecha_inicio: string;
  ultimo_mensaje?: string;
  ultimo_mensaje_fecha?: string;
  mensajes_no_leidos?: number;
  // Datos del otro usuario (calculados en backend)
  otro_usuario_id: number;
  otro_usuario_nombre: string;
  otro_usuario_email?: string;
}
