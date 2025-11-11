import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { 
  Habilidad, 
  HabilidadCreateRequest, 
  HabilidadUpdateRequest,
  HabilidadesListParams,
  ApiResponse, 
  PaginatedResponse 
} from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class HabilidadesService {

  constructor(private apiService: ApiService) {}

  /**
   * Listar habilidades con filtros y paginación
   */
  list(params?: HabilidadesListParams): Observable<ApiResponse<PaginatedResponse<Habilidad>>> {
    return this.apiService.get<ApiResponse<PaginatedResponse<Habilidad>>>('habilidades', params);
  }

  /**
   * Obtener una habilidad por ID
   */
  getById(id: number): Observable<ApiResponse<Habilidad>> {
    return this.apiService.get<ApiResponse<Habilidad>>(`habilidades/${id}`);
  }

  /**
   * Crear nueva habilidad (requiere autenticación)
   */
  create(data: HabilidadCreateRequest): Observable<ApiResponse<Habilidad>> {
    return this.apiService.post<ApiResponse<Habilidad>>('habilidades', data);
  }

  /**
   * Actualizar habilidad (requiere autenticación y ser propietario)
   */
  update(id: number, data: HabilidadUpdateRequest): Observable<ApiResponse<Habilidad>> {
    return this.apiService.put<ApiResponse<Habilidad>>(`habilidades/${id}`, data);
  }

  /**
   * Eliminar habilidad (soft delete - requiere autenticación y ser propietario)
   */
  delete(id: number): Observable<ApiResponse<any>> {
    return this.apiService.delete<ApiResponse<any>>(`habilidades/${id}`);
  }

  /**
   * Cambiar estado de habilidad (activa/pausada)
   */
  cambiarEstado(id: number, estado: 'activa' | 'pausada'): Observable<ApiResponse<Habilidad>> {
    return this.apiService.put<ApiResponse<Habilidad>>(`habilidades/${id}/estado`, { estado });
  }

  /**
   * Obtener habilidades de un usuario específico
   */
  getByUser(userId: number): Observable<ApiResponse<Habilidad[]>> {
    return this.apiService.get<ApiResponse<Habilidad[]>>(`usuarios/${userId}/habilidades`);
  }
}
