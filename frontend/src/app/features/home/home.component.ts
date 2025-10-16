import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';

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
    RouterModule, // Se mantiene para que funcione 'routerLink' en el HTML
    MatButtonModule,
    MatCardModule,
    MatIconModule
    // Se elimina MatToolbarModule porque ya no se usa aquí
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
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

  // El constructor ahora puede estar vacío
  constructor() {}
}