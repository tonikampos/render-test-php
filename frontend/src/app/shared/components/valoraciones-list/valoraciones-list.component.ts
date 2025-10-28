import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { Valoracion } from '../../models/valoracion.model';

@Component({
  selector: 'app-valoraciones-list',
  standalone: true,
  imports: [
    CommonModule,
    // Engadimos os módulos aquí para poder usar <mat-card> e <mat-icon>
    MatCardModule,
    MatIconModule
  ],
  templateUrl: './valoraciones-list.component.html',
  styleUrls: ['./valoraciones-list.component.scss']
})
export class ValoracionesListComponent {
  @Input() valoraciones: Valoracion[] = [];
  
  // Engadimos esta liña para que o compoñente poida recibir o nome do usuario
  @Input() usuarioNombre: string | null = null; 

  constructor() {}
}