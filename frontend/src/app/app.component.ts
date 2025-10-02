import { Component } from '@angular/core';
import { RouterOutlet, RouterModule } from '@angular/router';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatMenuModule } from '@angular/material/menu';
import { MatDividerModule } from '@angular/material/divider';
import { CommonModule } from '@angular/common';
import { AuthService } from './core/services/auth.service';

@Component({
  selector: 'app-root',
  imports: [
    CommonModule,
    RouterOutlet,
    RouterModule,
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatMenuModule,
    MatDividerModule
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'GaliTroco';

  constructor(public authService: AuthService) {}

  logout(): void {
    this.authService.logout().subscribe({
      next: () => {
        // Redirigir a home después del logout se maneja en el interceptor
      },
      error: (error) => {
        console.error('Error al cerrar sesión:', error);
        // Limpiar sesión local aunque falle en servidor
        this.authService.clearSession();
      }
    });
  }
}
