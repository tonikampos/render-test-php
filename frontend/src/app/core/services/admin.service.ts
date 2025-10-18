import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
// Engadir User e PaginatedResponse aos imports dende os modelos compartidos
import { ApiResponse, Reporte, User, PaginatedResponse } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private apiService: ApiService) { }

  // --- NOVO MÉTODO ENGADIDO ---
  /**
   * Obter a listaxe de usuarios con filtros e paxinación (só admin).
   * Corresponde a: GET /api/usuarios
   */
  getUsuarios(params?: { page?: number, per_page?: number, search?: string, ubicacion?: string, activo?: boolean }): Observable<ApiResponse<PaginatedResponse<User>>> {
    // Engadir aquí calquera parámetro adicional que o teu backend admita
    return this.apiService.get<ApiResponse<PaginatedResponse<User>>>('usuarios', params);
  }
  // -------------------------

  /**
   * Obter os reportes, con opción de filtrar por estado.
   * Corresponde a: GET /api/reportes?estado=...
   */
  getReportes(estado: 'pendiente' | 'revisado' | 'accion_tomada'): Observable<ApiResponse<Reporte[]>> {
    return this.apiService.get<ApiResponse<Reporte[]>>('reportes', { estado });
  }

  /**
   * Resolver un reporte.
   * Corresponde a: PUT /api/reportes/:id
   */
  resolverReporte(id: number, decision: string, notas: string): Observable<ApiResponse<Reporte>> {
    const body = {
      estado: decision,
      notas_revision: notas
    };
    return this.apiService.put<ApiResponse<Reporte>>(`reportes/${id}`, body);
  }
}