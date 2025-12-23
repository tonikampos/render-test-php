import { Injectable } from '@angular/core';
import { Observable, interval, switchMap, startWith, catchError, of } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Notificacion } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class NotificacionesService {

  constructor(private apiService: ApiService) {}

  /**
   * Listar mis notificaciones
   * GET /api/notificaciones
   */
  list(): Observable<ApiResponse<Notificacion[]>> {
    return this.apiService.get<ApiResponse<Notificacion[]>>('notificaciones');
  }

  /**
   * Contar notificaciones no leídas
   * GET /api/notificaciones/no-leidas
   */
  countNoLeidas(): Observable<ApiResponse<{ count: number }>> {
    return this.apiService.get<ApiResponse<{ count: number }>>('notificaciones/no-leidas');
  }

  /**
   * Marcar una notificación como leída
   * PUT /api/notificaciones/:id
   */
  marcarLeida(id: number): Observable<ApiResponse<any>> {
    return this.apiService.put<ApiResponse<any>>(`notificaciones/${id}`, { leida: true });
  }

  /**
   * Marcar todas las notificaciones como leídas
   * PUT /api/notificaciones/marcar-todas-leidas
   */
  marcarTodasLeidas(): Observable<ApiResponse<any>> {
    return this.apiService.put<ApiResponse<any>>('notificaciones/marcar-todas-leidas', {});
  }

  /**
   * Polling para actualizar contador de no leídas cada 60 segundos
   */
  pollNoLeidas(): Observable<ApiResponse<{ count: number }>> {
    return interval(60000).pipe(
      startWith(0),
      switchMap(() => this.countNoLeidas().pipe(
        catchError(() => of({ success: false, data: { count: 0 }, message: '' }))
      ))
    );
  }
}
