import { Injectable } from '@angular/core';
import { Observable, timer, switchMap, startWith, catchError, of } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Notificacion } from '../../shared/models';
import { UserActivityService } from './user-activity.service';

@Injectable({
  providedIn: 'root'
})
export class NotificacionesService {

  constructor(
    private apiService: ApiService,
    private userActivityService: UserActivityService
  ) {}

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
   * Polling adaptativo para contador de no leídas
   * - 15s cuando usuario activo (interactuando)
   * - 120s cuando inactivo (>5 min sin interacción)
   */
  pollNoLeidas(): Observable<ApiResponse<{ count: number }>> {
    return timer(0, 1000).pipe(
      switchMap(() => {
        const interval = this.userActivityService.getPollingInterval();
        return timer(0, interval).pipe(
          switchMap(() => this.countNoLeidas().pipe(
            catchError(() => of({ success: false, data: { count: 0 }, message: '' }))
          ))
        );
      })
    );
  }
}
