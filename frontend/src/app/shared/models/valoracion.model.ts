export interface Valoracion {
  id: number;
  puntuacion: number;
  comentario: string;
  fecha_valoracion: string;
  evaluador_nombre: string;
  evaluador_foto: string | null;
}