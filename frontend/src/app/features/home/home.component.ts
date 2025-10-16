import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';
import { AuthService } from '../../core/services/auth.service';

// Se define la "forma" de los objetos
interface Feature {
  icon: string;
  title: string;
  description: string;
}

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatButtonModule,
    MatCardModule,
    MatIconModule,
    MatToolbarModule
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
  // ===== LA CORRECCIÓN ESTÁ EN ESTA LÍNEA =====
  features: Feature[] = [
    {
      icon: 'swap_horiz',
      title: 'Intercambia Habilidades',
      description: 'Ofrece lo que sabes hacer y recibe lo que necesitas'
    },
    {
      icon: 'people',
      title: 'Comunidad',
      description: 'Conecta con personas de tu zona'
    },
    {
      icon: 'star',
      title: 'Valoraciones',
      description: 'Sistema de reputación transparente'
    }
  ];
  // ===========================================

  constructor(public authService: AuthService, private router: Router) {}

  logout(): void {
    this.authService.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }
}