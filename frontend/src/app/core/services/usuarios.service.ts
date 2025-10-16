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
   * Obter os datos públicos dun usuario por ID.
   * Corresponde a: GET /api/usuarios/:id
   */
  getById(id: number): Observable<ApiResponse<User>> {
    return this.apiService.get<ApiResponse<User>>(`usuarios/${id}`);
  }
}