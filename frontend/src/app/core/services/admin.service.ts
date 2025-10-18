import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Reporte } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private apiService: ApiService) { }

  /**
   * Obtener los reportes, con opción de filtrar por estado.
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