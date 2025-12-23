import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { shareReplay } from 'rxjs/operators';
import { ApiService } from './api.service';
import { Categoria, ApiResponse } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class CategoriasService {
  private categorias$: Observable<ApiResponse<Categoria[]>> | null = null;

  constructor(private apiService: ApiService) {}

  /**
   * Listar todas las categorías (con caché en memoria)
   */
  list(): Observable<ApiResponse<Categoria[]>> {
    if (!this.categorias$) {
      this.categorias$ = this.apiService.get<ApiResponse<Categoria[]>>('categorias').pipe(
        shareReplay({ bufferSize: 1, refCount: false })
      );
    }
    return this.categorias$;
  }

  /**
   * Limpiar caché (útil si se añaden/modifican categorías desde admin)
   */
  clearCache(): void {
    this.categorias$ = null;
  }
}
