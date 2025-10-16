import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router'; // Importa Router
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar'; // Importa MatToolbarModule

import { AuthService } from '../../core/services/auth.service'; // Importa AuthService

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatButtonModule,
    MatCardModule,
    MatIconModule,
    MatToolbarModule // Añade MatToolbarModule
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
  features = [
    // ... (tu array de features no cambia)
  ];

  // Inyecta AuthService y Router en el constructor
  constructor(public authService: AuthService, private router: Router) {}

  // Añade el método para cerrar sesión
  logout(): void {
    this.authService.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }
}