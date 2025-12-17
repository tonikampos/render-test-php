import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Reporte } from '../../shared/models'; 
@Injectable({
  providedIn: 'root'
})
export class ReportesService {

  constructor(private apiService: ApiService) { }

  /**
   * Crear un nuevo reporte (para usuarios autenticados).
   * Corresponde a: POST /api/reportes
   */
  crearReporte(datos: { tipo_contenido: 'habilidad' | 'usuario'; contenido_id: number; motivo: string }): Observable<ApiResponse<Reporte>> {
    return this.apiService.post<ApiResponse<Reporte>>('reportes', datos);
  }

  /**
   * Obtener los reportes pendientes (solo para admin).
   * GET /api/reportes?estado=pendiente
   */
  getReportesPendientes(): Observable<ApiResponse<Reporte[]>> {
    return this.apiService.get<ApiResponse<Reporte[]>>('reportes', { estado: 'pendiente' });
  }

  /**
   * Resolver un reporte (só para admin).
   * PUT /api/reportes/:id
   */
  resolverReporte(id: number, estado: string, notas: string): Observable<ApiResponse<Reporte>> {
    const body = {
      estado: estado,
      notas_revision: notas
    };
    return this.apiService.put<ApiResponse<Reporte>>(`reportes/${id}`, body);
  }
}