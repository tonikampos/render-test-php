import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiService } from './api.service';
import { ApiResponse, Conversacion, Mensaje, MensajeCreateRequest } from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class ConversacionesService {

  constructor(private apiService: ApiService) {}

  /**
   * Listar mis conversaciones
   * GET /api/conversaciones
   */
  list(): Observable<ApiResponse<Conversacion[]>> {
    return this.apiService.get<ApiResponse<Conversacion[]>>('conversaciones');
  }

  /**
   * Obtener una conversación por ID
   * GET /api/conversaciones/:id
   */
  getById(id: number): Observable<ApiResponse<Conversacion>> {
    return this.apiService.get<ApiResponse<Conversacion>>(`conversaciones/${id}`);
  }

  /**
   * Obtener mensajes de una conversación
   * GET /api/conversaciones/:id/mensajes
   */
  getMensajes(conversacionId: number): Observable<ApiResponse<Mensaje[]>> {
    return this.apiService.get<ApiResponse<Mensaje[]>>(`conversaciones/${conversacionId}/mensajes`);
  }

  /**
   * Crear nueva conversación
   * POST /api/conversaciones
   */
  create(data: { usuario2_id: number; mensaje_inicial?: string }): Observable<ApiResponse<Conversacion>> {
    // El backend espera receptor_id, no usuario2_id
    return this.apiService.post<ApiResponse<Conversacion>>('conversaciones', {
      receptor_id: data.usuario2_id,
      mensaje_inicial: data.mensaje_inicial
    });
  }

  /**
   * Enviar mensaje en una conversación
   * POST /api/conversaciones/:id/mensaje
   */
  sendMensaje(conversacionId: number, data: MensajeCreateRequest): Observable<ApiResponse<Mensaje>> {
    return this.apiService.post<ApiResponse<Mensaje>>(`conversaciones/${conversacionId}/mensaje`, data);
  }

  /**
   * Marcar mensajes como leídos
   * PUT /api/conversaciones/:id/marcar-leido
   */
  marcarLeido(conversacionId: number): Observable<ApiResponse<any>> {
    return this.apiService.put<ApiResponse<any>>(`conversaciones/${conversacionId}/marcar-leido`, {});
  }
}
