import { inject } from '@angular/core';
import { Router, CanActivateFn } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { map, take } from 'rxjs/operators';
import { Observable } from 'rxjs';

export const adminGuard: CanActivateFn = (route, state): Observable<boolean> => {
  const authService = inject(AuthService);
  const router = inject(Router);

  return authService.currentUser$.pipe(
    take(1),
    map(user => {
      console.log('AdminGuard executado. Usuario actual:', user);
      if (user && user.rol === 'administrador') {
        console.log('AdminGuard: Acceso permitido.');
        return true; // Se hai usuario E é administrador, deixámolo pasar
      } else {
        // Se non é administrador, rediriximos á páxina de inicio
        console.log('AdminGuard: Acceso denegado. Redirixindo á páxina de inicio...');
        router.navigate(['/']);
        return false;
      }
    })
  );
};