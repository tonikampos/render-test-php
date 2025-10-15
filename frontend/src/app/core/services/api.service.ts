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
   */
  get<T>(resource: string, params: HttpParams = new HttpParams()): Observable<T> {
    // CAMBIO: A URL agora constrúese como un camiño (path)
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.get<T>(url, { 
      params,
      withCredentials: true // Importante para as cookies de sesión
    }).pipe(catchError(this.handleError));
  }

  /**
   * POST request
   */
  post<T>(resource: string, body: any): Observable<T> {
    // CAMBIO: A URL agora constrúese como un camiño (path)
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.post<T>(url, body, {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' }),
      withCredentials: true
    }).pipe(catchError(this.handleError));
  }

  /**
   * PUT request
   */
  put<T>(resource: string, body: any): Observable<T> {
    // CAMBIO: A URL agora constrúese como un camiño (path)
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.put<T>(url, body, {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' }),
      withCredentials: true
    }).pipe(catchError(this.handleError));
  }

  /**
   * DELETE request
   */
  delete<T>(resource: string): Observable<T> {
    // CAMBIO: A URL agora constrúese como un camiño (path)
    const url = `${this.apiUrl}/${resource}`;
    
    return this.http.delete<T>(url, {
      withCredentials: true
    }).pipe(catchError(this.handleError));
  }

  /**
   * Error handler
   */
  private handleError(error: any): Observable<never> {
    let errorMessage = 'Error descoñecido';
    if (error.error?.message) {
      errorMessage = error.error.message;
    } else if (error.status === 401) {
      errorMessage = 'Non estás autenticado ou a túa sesión expirou.';
    } else {
      errorMessage = `Error ${error.status}: ${error.statusText}`;
    }
    console.error('API Error:', error);
    return throwError(() => new Error(errorMessage));
  }
}