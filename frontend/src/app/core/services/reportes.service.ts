import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse } from '../../shared/models';
import { Reporte } from '../../shared/models/reporte.model'; // Asegúrate de que este import sexa correcto

@Injectable({
  providedIn: 'root'
})
export class ReportesService {

  constructor(private apiService: ApiService) { }

  /**
   * Obter os reportes pendentes (só para admin).
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