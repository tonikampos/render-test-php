import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse } from '../../shared/models/api-response.model';
import { Valoracion } from '../../shared/models/valoracion.model'; // Crearemos este modelo despois

@Injectable({
  providedIn: 'root'
})
export class ValoracionesService {

  constructor(private apiService: ApiService) { }

  /**
   * Obter as valoracións recibidas por un usuario específico.
   * Corresponde a GET /api/usuarios/:id/valoraciones
   */
  getValoracionesDeUsuario(usuarioId: number): Observable<ApiResponse<Valoracion[]>> {
    return this.apiService.get<ApiResponse<Valoracion[]>>(`usuarios/${usuarioId}/valoraciones`);
  }

  /**
   * Crear unha nova valoración para un intercambio.
   * Corresponde a POST /api/valoraciones
   */
  crearValoracion(datos: { intercambio_id: number; puntuacion: number; comentario?: string }): Observable<ApiResponse<Valoracion>> {
    return this.apiService.post<ApiResponse<Valoracion>>('valoraciones', datos);
  }
}