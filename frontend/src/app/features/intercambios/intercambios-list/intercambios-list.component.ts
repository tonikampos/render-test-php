import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatChipsModule } from '@angular/material/chips';
import { MatDividerModule } from '@angular/material/divider';

import { IntercambiosService } from '../../../core/services/intercambios.service';
import { AuthService } from '../../../core/services/auth.service';
import { Intercambio, User } from '../../../shared/models';

// CAMBIO: Añadir imports para el diálogo modal
import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { ValoracionDialogComponent } from '../../valoraciones/valoracion-dialog/valoracion-dialog.component';

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
    MatChipsModule,
    MatDialogModule,
    MatDividerModule
  ],
  templateUrl: './intercambios-list.component.html',
  styleUrls: ['./intercambios-list.component.scss']
})
export class IntercambiosListComponent implements OnInit {
  loading = true;
  currentUser: User | null = null;
  intercambiosRecibidos: Intercambio[] = [];
  intercambiosEnviados: Intercambio[] = [];
  intercambioDestacar: number | null = null;

  constructor(
    private intercambiosService: IntercambiosService,
    private authService: AuthService,
    private snackBar: MatSnackBar,
    private dialog: MatDialog,
    private route: ActivatedRoute
  ) { }

  ngOnInit(): void {
    this.currentUser = this.authService.currentUserValue;
    
    // Detectar si hay un intercambio a destacar desde notificación
    this.route.queryParams.subscribe(params => {
      if (params['destacar']) {
        this.intercambioDestacar = +params['destacar'];
      }
    });
    
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
        
        // Si hay un intercambio a destacar, hacer scroll después de renderizar
        if (this.intercambioDestacar) {
          setTimeout(() => this.destacarIntercambio(this.intercambioDestacar!), 500);
        }
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

  trackByIntercambioId(index: number, intercambio: Intercambio): number {
    return intercambio.id;
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

  abrirDialogoValoracion(intercambio: Intercambio): void {
    const dialogRef = this.dialog.open(ValoracionDialogComponent, {
      width: '450px',
      data: { intercambio: intercambio }, 
      disableClose: true
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        // Se a valoración foi exitosa, actualizamos a listaxe.
        this.loadIntercambios();
      }
    });
  }

  destacarIntercambio(id: number): void {
    const elemento = document.getElementById(`intercambio-${id}`);
    if (elemento) {
      // Hacer scroll suave hasta el elemento
      elemento.scrollIntoView({ behavior: 'smooth', block: 'center' });
      
      // Añadir clase para resaltar
      elemento.classList.add('destacado');
      
      // Quitar el resaltado después de 3 segundos
      setTimeout(() => {
        elemento.classList.remove('destacado');
      }, 3000);
    }
  }
}