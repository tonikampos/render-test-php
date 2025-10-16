import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatChipsModule } from '@angular/material/chips';

import { IntercambiosService } from '../../../core/services/intercambios.service';
import { AuthService } from '../../../core/services/auth.service';
import { Intercambio, User } from '../../../shared/models';

@Component({
  selector: 'app-intercambios-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatCardModule,
    MatButtonModule,
    MatIconModule,
    MatTabsModule,
    MatProgressSpinnerModule,
    MatChipsModule
  ],
  templateUrl: './intercambios-list.component.html',
  styleUrls: ['./intercambios-list.component.scss']
})
export class IntercambiosListComponent implements OnInit {
  loading = true;
  currentUser: User | null = null;
  intercambiosRecibidos: Intercambio[] = [];
  intercambiosEnviados: Intercambio[] = [];

  constructor(
    private intercambiosService: IntercambiosService,
    private authService: AuthService,
    private snackBar: MatSnackBar
  ) { }

  ngOnInit(): void {
    this.currentUser = this.authService.currentUserValue;
    this.loadIntercambios();
  }

  loadIntercambios(): void {
    this.loading = true;
    this.intercambiosService.getMisIntercambios().subscribe({
      next: (response) => {
        if (response.success) {
          this.intercambiosRecibidos = response.data.filter(i => i.receptor_id === this.currentUser?.id);
          this.intercambiosEnviados = response.data.filter(i => i.proponente_id === this.currentUser?.id);
        }
        this.loading = false;
      },
      error: () => {
        this.loading = false;
        this.snackBar.open('Error al cargar tus intercambios.', 'Cerrar', { duration: 3000 });
      }
    });
  }

  responderPropuesta(id: number, accion: 'aceptado' | 'rechazado'): void {
    this.intercambiosService.actualizarEstado(id, accion).subscribe({
      next: () => {
        this.snackBar.open(`Propuesta ${accion === 'aceptado' ? 'aceptada' : 'rechazada'}.`, 'OK', { duration: 3000 });
        this.loadIntercambios(); // Recargamos la lista
      },
      error: (err) => {
        this.snackBar.open(err.message || 'Error al responder a la propuesta.', 'Cerrar', { duration: 3000 });
      }
    });
  }
completarIntercambio(id: number): void {
    this.intercambiosService.marcarComoCompletado(id).subscribe({
      next: () => {
        this.snackBar.open('¡Intercambio completado! Ahora puedes valorarlo.', 'OK', { duration: 3500 });
        this.loadIntercambios(); // Recargamos la lista para actualizar el estado
      },
      error: (err) => {
        this.snackBar.open(err.message || 'Error al marcar como completado.', 'Cerrar', { duration: 3000 });
      }
    });
  }

}