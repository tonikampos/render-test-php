import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { ApiService } from './api.service';
import { StorageService } from './storage.service';
import { 
  User, 
  LoginRequest, 
  RegisterRequest, 
  AuthResponse, 
  ApiResponse 
} from '../../shared/models';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private currentUserSubject: BehaviorSubject<User | null>;
  public currentUser$: Observable<User | null>;

  constructor(
    private apiService: ApiService,
    private storageService: StorageService
  ) {
    // Inicializar con usuario guardado en localStorage
    const storedUser = this.storageService.getUser();
    this.currentUserSubject = new BehaviorSubject<User | null>(storedUser);
    this.currentUser$ = this.currentUserSubject.asObservable();
  }

  /**
   * Obtener usuario actual
   */
  public get currentUserValue(): User | null {
    return this.currentUserSubject.value;
  }

  /**
   * Verificar si el usuario está autenticado
   */
  isAuthenticated(): boolean {
    return this.currentUserValue !== null;
  }

  /**
   * Verificar si el usuario es administrador
   */
  isAdmin(): boolean {
    return this.currentUserValue?.rol === 'administrador';
  }

  /**
   * Registro de nuevo usuario
   */
  register(data: RegisterRequest): Observable<AuthResponse> {
    return this.apiService.post<AuthResponse>('auth/register', data).pipe(
      tap(response => {
        if (response.success && response.data) {
          this.storageService.setUser(response.data.user);
          this.storageService.setToken(response.data.token);
          this.currentUserSubject.next(response.data.user);
        }
      })
    );
  }

  /**
   * Login
   */
  login(credentials: LoginRequest): Observable<AuthResponse> {
    return this.apiService.post<AuthResponse>('auth/login', credentials).pipe(
      tap(response => {
        if (response.success && response.data) {
          this.storageService.setUser(response.data.user);
          this.storageService.setToken(response.data.token);
          this.currentUserSubject.next(response.data.user);
        }
      })
    );
  }

  /**
   * Logout
   */
  logout(): Observable<ApiResponse<any>> {
    return this.apiService.post<ApiResponse<any>>('auth/logout', {}).pipe(
      tap(() => {
        this.clearSession();
      })
    );
  }

  /**
   * Obtener usuario actual desde el servidor
   */
  getCurrentUser(): Observable<ApiResponse<User>> {
    return this.apiService.get<ApiResponse<User>>('auth/me').pipe(
      tap(response => {
        if (response.success && response.data) {
          this.storageService.setUser(response.data);
          this.currentUserSubject.next(response.data);
        }
      })
    );
  }

  /**
   * Limpiar sesión local
   */
  clearSession(): void {
    this.storageService.clearAll();
    this.currentUserSubject.next(null);
  }

  /**
   * Solicitar recuperación de contraseña
   */
  forgotPassword(email: string): Observable<ApiResponse<null>> {
    return this.apiService.post<ApiResponse<null>>('auth/forgot-password', { email });
  }

  /**
   * Restablecer contraseña con token
   */
  resetPassword(token: string, newPassword: string, confirmPassword: string): Observable<ApiResponse<null>> {
    return this.apiService.post<ApiResponse<null>>('auth/reset-password', {
      token,
      new_password: newPassword,
      confirm_password: confirmPassword
    });
  }
}
