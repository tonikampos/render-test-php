// src/app/shared/models/intercambio.model.ts

export interface Intercambio {
  id: number;
  estado: 'propuesto' | 'aceptado' | 'rechazado' | 'completado' | 'cancelado';
  
  // Usuario que propone el intercambio
  proponente_id: number;
  proponente_nombre: string;

  // Usuario que recibe la propuesta
  receptor_id: number;
  receptor_nombre: string;

  // Habilidad que ofrece el proponente
  habilidad_ofrecida_id: number;
  habilidad_ofrecida_titulo: string;

  // Habilidad que solicita el proponente
  habilidad_solicitada_id: number;
  habilidad_solicitada_titulo: string;

  // Mensaje y fechas
  mensaje_propuesta?: string; // Opcional por si hay mensajes adicionales
  fecha_propuesta: string; // Formato 'YYYY-MM-DD HH:MM:SS'
  fecha_actualizacion: string;
}