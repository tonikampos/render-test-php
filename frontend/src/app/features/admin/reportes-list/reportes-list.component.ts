import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { HttpErrorResponse } from '@angular/common/http';

// Imports de Angular Material
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatDialog, MatDialogModule } from '@angular/material/dialog'; // <-- Importar MatDialog y MatDialogModule

// Nuestros Servicios y Modelos
import { AdminService } from '../../../core/services/admin.service';
import { ApiResponse, Reporte } from '../../../shared/models';
import { ResolverReporteDialogComponent } from '../resolver-reporte-dialog/resolver-reporte-dialog.component'; // <-- Importar el componente del diálogo

@Component({
  selector: 'app-reportes-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatTableModule,
    MatButtonModule,
    MatIconModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatTooltipModule,
    MatDialogModule // <-- Añadir MatDialogModule aquí
  ],
  templateUrl: './reportes-list.component.html',
  styleUrls: ['./reportes-list.component.scss']
})
export class ReportesListComponent implements OnInit {
  loading = true;
  reportes: Reporte[] = [];
  displayedColumns: string[] = ['id', 'tipo_contenido', 'contenido_id', 'motivo', 'fecha_reporte', 'acciones'];

  constructor(
    private adminService: AdminService,
    private snackBar: MatSnackBar,
    private dialog: MatDialog // <-- Inyectar MatDialog
  ) { }

  ngOnInit(): void {
    this.loadReportesPendientes();
  }

  loadReportesPendientes(): void {
    this.loading = true;
    this.adminService.getReportes('pendiente').subscribe({
      next: (response: ApiResponse<Reporte[]>) => {
        if (response.success) {
          this.reportes = response.data;
        }
        this.loading = false;
      },
      error: (error: HttpErrorResponse) => {
        this.loading = false;
        this.snackBar.open('Error al cargar los reportes pendientes.', 'Cerrar', { duration: 3000 });
      }
    });
  }

  // --- MODIFICAR ESTOS MÉTODOS ---
  abrirDialogoResolver(reporte: Reporte): void {
    const dialogRef = this.dialog.open(ResolverReporteDialogComponent, {
      width: '500px',
      data: { reporte: reporte }, // Pasar el reporte completo al diálogo
      disableClose: true
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        // Si el diálogo se cerró con éxito (se resolvió el reporte), recargamos la lista
        this.loadReportesPendientes();
      }
    });
  }
  // ------------------------------
}