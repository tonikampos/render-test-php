import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, User } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {

  constructor(private apiService: ApiService) { }

  /**
   * Obtener los datos públicos de un usuario por ID.
   * Corresponde a: GET /api/usuarios/:id
   */
  getById(id: number): Observable<ApiResponse<User>> {
    return this.apiService.get<ApiResponse<User>>(`usuarios/${id}`);
  }

  /**
   * Actualizar perfil de usuario.
   * Corresponde a: PUT /api/usuarios/:id
   */
  update(id: number, data: Partial<User>): Observable<ApiResponse<User>> {
    return this.apiService.put<ApiResponse<User>>(`usuarios/${id}`, data);
  }
}