import { inject } from '@angular/core';
import { Router, CanActivateFn } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { map, take } from 'rxjs/operators';
import { Observable } from 'rxjs';

export const authGuard: CanActivateFn = (route, state): Observable<boolean> => {
  const authService = inject(AuthService);
  const router = inject(Router);

  // A forma correcta: Subscribímonos ao estado do usuario
  return authService.currentUser$.pipe(
    take(1), // Collemos só o primeiro valor para evitar subscricións abertas
    map(user => {
      // Cando o AuthService nos responda, tomamos a decisión
      if (user) {
        return true; // Se hai un usuario, deixámolo pasar
      } else {
        // Se non hai usuario, rediriximos a login
        router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
        return false;
      }
    })
  );
};