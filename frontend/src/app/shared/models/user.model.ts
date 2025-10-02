export interface User {
  id: number;
  nombre_usuario: string;
  email: string;
  rol: 'usuario' | 'administrador';
  ubicacion: string;
  biografia?: string;
  foto_url?: string;
  activo: boolean;
  fecha_registro?: string;
  ultima_conexion?: string;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface RegisterRequest {
  nombre_usuario: string;
  email: string;
  password: string;
  ubicacion: string;
}

export interface AuthResponse {
  success: boolean;
  message: string;
  data: {
    user: User;
    token: string;
  };
}
