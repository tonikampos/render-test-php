import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private readonly apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  /**
   * GET request
   * @param resource Recurso de la API (ej: 'habilidades', 'usuarios')
   * @param params Query parameters (opcional)
   */
  get<T>(resource: string, params?: any): Observable<T> {
    let httpParams = new HttpParams();
    
    if (params) {
      Object.keys(params).forEach(key => {
        if (params[key] !== null && params[key] !== undefined) {
          httpParams = httpParams.set(key, params[key].toString());
        }
      });
    }

    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.get<T>(url, { 
      params: httpParams,
      withCredentials: true // Importante para cookies de sesión PHP
    }).pipe(
      catchError(this.handleError)
    );
  }

  /**
   * POST request
   * @param resource Recurso de la API
   * @param body Datos a enviar
   */
  post<T>(resource: string, body: any): Observable<T> {
   const url = `${this.apiUrl}/${resource}`;
    
    return this.http.post<T>(url, body, {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' }),
      withCredentials: true
    }).pipe(
      catchError(this.handleError)
    );
  }

  /**
   * PUT request
   * @param resource Recurso de la API (incluye ID, ej: 'habilidades/5')
   * @param body Datos a actualizar
   */
  put<T>(resource: string, body: any): Observable<T> {
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.put<T>(url, body, {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' }),
      withCredentials: true
    }).pipe(
      catchError(this.handleError)
    );
  }

  /**
   * DELETE request
   * @param resource Recurso de la API (incluye ID, ej: 'habilidades/5')
   */
  delete<T>(resource: string): Observable<T> {
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.delete<T>(url, {
      withCredentials: true
    }).pipe(
      catchError(this.handleError)
    );
  }

  /**
   * Error handler
   */
  private handleError(error: any): Observable<never> {
    let errorMessage = 'Error desconocido';
    
    if (error.error instanceof ErrorEvent) {
      // Error del lado del cliente
      errorMessage = `Error: ${error.error.message}`;
    } else {
      // Error del lado del servidor
      if (error.error && error.error.message) {
        errorMessage = error.error.message;
      } else {
        errorMessage = `Error ${error.status}: ${error.statusText}`;
      }
    }
    
    console.error('API Error:', error);
    return throwError(() => new Error(errorMessage));
  }
}
