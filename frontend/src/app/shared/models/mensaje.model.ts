export interface Mensaje {
  id: number;
  conversacion_id: number;
  emisor_id: number;
  receptor_id: number;
  contenido: string; // El backend usa 'contenido' no 'texto'
  fecha_envio: string;
  leido: boolean;
  fecha_lectura?: string;
  // Datos del emisor (opcional, calculados en backend)
  emisor_nombre?: string;
}

export interface MensajeCreateRequest {
  contenido: string; // El backend espera 'contenido' no 'texto'
}
