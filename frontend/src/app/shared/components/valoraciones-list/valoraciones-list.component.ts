import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Valoracion } from '../../models/valoracion.model';

@Component({
  selector: 'app-valoraciones-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './valoraciones-list.component.html',
  styleUrls: ['./valoraciones-list.component.scss']
})
export class ValoracionesListComponent {
  @Input() valoraciones: Valoracion[] = [];
}