import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { Categoria, ApiResponse } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class CategoriasService {

  constructor(private apiService: ApiService) {}

  /**
   * Listar todas las categorías
   */
  list(): Observable<ApiResponse<Categoria[]>> {
    return this.apiService.get<ApiResponse<Categoria[]>>('categorias');
  }
}
