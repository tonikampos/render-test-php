// src/app/core/services/intercambios.service.ts

import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Intercambio } from '../../shared/models'; // Asegúrate de crear el modelo 'Intercambio'

@Injectable({
  providedIn: 'root'
})
export class IntercambiosService {

  constructor(private apiService: ApiService) { }

  /**
   * Proponer un nuevo intercambio.
   * Corresponde a: POST /api/intercambios
   */
  proponer(datos: { habilidad_ofrecida_id: number; habilidad_solicitada_id: number; mensaje_propuesta: string }): Observable<ApiResponse<Intercambio>> {
    return this.apiService.post<ApiResponse<Intercambio>>('intercambios', datos);
  }

  /**
   * Obtener los intercambios del usuario actual, con opción de filtrar por estado.
   * Corresponde a: GET /api/intercambios?estado=...
   */
  getMisIntercambios(estado?: 'propuesto' | 'aceptado' | 'rechazado' | 'completado'): Observable<ApiResponse<Intercambio[]>> {
    const params = estado ? { estado } : {};
    return this.apiService.get<ApiResponse<Intercambio[]>>('intercambios', params);
  }

  /**
   * Actualizar el estado de un intercambio (aceptar o rechazar).
   * Corresponde a: PUT /api/intercambios/:id
   */
  actualizarEstado(id: number, accion: 'aceptado' | 'rechazado'): Observable<ApiResponse<Intercambio>> {
    return this.apiService.put<ApiResponse<Intercambio>>(`intercambios/${id}`, { estado: accion });
  }

  /**
   * Marcar un intercambio como completado (solo el proponente).
   * Corresponde a: PUT /api/intercambios/:id/completar
   */
  marcarComoCompletado(id: number): Observable<ApiResponse<Intercambio>> {
    return this.apiService.put<ApiResponse<Intercambio>>(`intercambios/${id}/completar`, {});
  }
}