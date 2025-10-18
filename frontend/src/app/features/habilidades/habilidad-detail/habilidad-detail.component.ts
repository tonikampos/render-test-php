import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, RouterModule, Router } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatChipsModule } from '@angular/material/chips';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatDividerModule } from '@angular/material/divider';
import { HabilidadesService } from '../../../core/services/habilidades.service';
import { AuthService } from '../../../core/services/auth.service';
import { Habilidad } from '../../../shared/models';

import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { ProponerIntercambioDialogComponent } from '../../intercambios/proponer-intercambio-dialog/proponer-intercambio-dialog.component';

// CAMBIO REPORTE: Engadir import para o diálogo de reporte
import { ReportarDialogComponent } from '../../reportes/reportar-dialog/reportar-dialog.component';


@Component({
  selector: 'app-habilidad-detail',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatCardModule,
    MatButtonModule,
    MatIconModule,
    MatChipsModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatDividerModule,
    MatDialogModule // Xa inclúe o necesario para ambos diálogos
  ],
  templateUrl: './habilidad-detail.component.html',
  styleUrl: './habilidad-detail.component.scss'
})
export class HabilidadDetailComponent implements OnInit {
  habilidad: Habilidad | null = null;
  loading = true;
  isOwner = false;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private habilidadesService: HabilidadesService,
    public authService: AuthService,
    private snackBar: MatSnackBar,
    private dialog: MatDialog // Xa está inxectado
  ) {}

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.loadHabilidad(+id);
    }
  }

  loadHabilidad(id: number): void {
    this.loading = true;
    this.habilidadesService.getById(id).subscribe({
      next: (response) => {
        this.loading = false;
        if (response.success) {
          this.habilidad = response.data;
          this.checkOwnership();
        }
      },
      error: (error) => {
        this.loading = false;
        this.snackBar.open('Error al cargar la habilidad', 'Cerrar', { duration: 3000 });
        this.router.navigate(['/habilidades']);
      }
    });
  }

  checkOwnership(): void {
    const currentUser = this.authService.currentUserValue;
    if (currentUser && this.habilidad) {
      this.isOwner = currentUser.id === this.habilidad.usuario_id;
    }
  }

  getTipoIcon(): string {
    return this.habilidad?.tipo === 'oferta' ? 'volunteer_activism' : 'search';
  }

  formatDuration(minutes: number): string {
    if (minutes < 60) {
      return `${minutes} minutos`;
    }
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return mins > 0 ? `${hours}h ${mins}min` : `${hours} horas`;
  }

  editHabilidad(): void {
    if (this.habilidad) {
      this.router.navigate(['/habilidades', this.habilidad.id, 'editar']);
    }
  }

  deleteHabilidad(): void {
    if (!this.habilidad || !confirm('¿Estás seguro de eliminar esta habilidad?')) {
      return;
    }

    this.habilidadesService.delete(this.habilidad.id).subscribe({
      next: () => {
        this.snackBar.open('Habilidad eliminada correctamente', 'Cerrar', { duration: 3000 });
        this.router.navigate(['/habilidades']);
      },
      error: (error) => {
        this.snackBar.open('Error al eliminar la habilidad', 'Cerrar', { duration: 3000 });
      }
    });
  }

  contactUser(): void {
    if (!this.habilidad) {
      return;
    }

    const dialogRef = this.dialog.open(ProponerIntercambioDialogComponent, {
      width: '550px',
      data: { habilidadDeseada: this.habilidad },
      disableClose: true
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.snackBar.open('¡Propuesta enviada! Serás notificado con la respuesta.', 'Entendido', { duration: 4000 });
        this.router.navigate(['/perfil']); // Considerar redirixir a /intercambios no futuro
      }
    });
  }

  // CAMBIO REPORTE: Engadir o novo método para abrir o diálogo de reporte
  abrirDialogoReporte(): void {
    if (!this.habilidad) return;

    const dialogRef = this.dialog.open(ReportarDialogComponent, {
      width: '500px',
      data: {
        tipoContenido: 'habilidad',
        contenidoId: this.habilidad.id,
        tituloContenido: this.habilidad.titulo
      },
      disableClose: true
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        // O reporte foi enviado con éxito dende o diálogo
        this.snackBar.open('Reporte enviado. Revisarémolo pronto.', 'OK', { duration: 3000 });
      }
    });
  }
}