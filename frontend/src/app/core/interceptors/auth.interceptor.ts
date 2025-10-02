import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';
import { AuthService } from '../services/auth.service';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  return next(req).pipe(
    catchError((error) => {
      // Si recibimos 401 (No autorizado), limpiar sesión y redirigir a login
      if (error.status === 401) {
        authService.clearSession();
        router.navigate(['/login']);
      }

      // Si recibimos 403 (Forbidden), redirigir a home
      if (error.status === 403) {
        router.navigate(['/']);
      }

      return throwError(() => error);
    })
  );
};
