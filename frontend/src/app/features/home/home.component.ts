import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatButtonModule,
    MatCardModule,
    MatIconModule
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
  features = [
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
}
