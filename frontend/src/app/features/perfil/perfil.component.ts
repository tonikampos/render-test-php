import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatButtonModule } from '@angular/material/button';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { forkJoin } from 'rxjs';
import { AuthService } from '../../core/services/auth.service';
import { ValoracionesService } from '../../core/services/valoraciones.service';
import { HabilidadesService } from '../../core/services/habilidades.service';
import { IntercambiosService } from '../../core/services/intercambios.service';
import { User } from '../../shared/models';
import { Valoracion } from '../../shared/models/valoracion.model';
import { ValoracionesListComponent } from '../../shared/components/valoraciones-list/valoraciones-list.component';
import { SkeletonLoaderComponent } from '../../shared/components/skeleton-loader/skeleton-loader.component';
import { EditarPerfilDialogComponent } from './editar-perfil-dialog/editar-perfil-dialog.component'; 

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatIconModule,
    MatProgressSpinnerModule,
    MatButtonModule,
    MatDialogModule,
    ValoracionesListComponent,
    SkeletonLoaderComponent
  ],
  templateUrl: './perfil.component.html', 
  styleUrls: ['./perfil.component.scss'] 
})
export class PerfilComponent implements OnInit {

  usuario: User | null = null;
  valoraciones: Valoracion[] = [];
  
  // Estadísticas
  stats = {
    totalHabilidades: 0,
    intercambiosCompletados: 0,
    valoracionPromedio: 0,
    totalValoraciones: 0
  };
  loadingStats = true;

  constructor(
    private authService: AuthService,
    private valoracionesService: ValoracionesService,
    private habilidadesService: HabilidadesService,
    private intercambiosService: IntercambiosService,
    private dialog: MatDialog
  ) {}

  ngOnInit(): void {
    this.usuario = this.authService.currentUserValue;

    if (this.usuario) {
      this.loadEstadisticas();
    }
  }

  loadEstadisticas(): void {
    if (!this.usuario) return;

    this.loadingStats = true;

    // Paralelizar las 3 peticiones independientes con forkJoin
    forkJoin({
      habilidades: this.habilidadesService.list({ usuario_id: this.usuario.id, per_page: 100 }),
      intercambios: this.intercambiosService.getMisIntercambios('completado'),
      valoraciones: this.valoracionesService.getValoracionesDeUsuario(this.usuario.id)
    }).subscribe({
      next: (results) => {
        // Procesar habilidades
        if (results.habilidades.success && results.habilidades.data) {
          this.stats.totalHabilidades = results.habilidades.data.pagination.total;
        }

        // Procesar intercambios
        if (results.intercambios.success && results.intercambios.data) {
          this.stats.intercambiosCompletados = results.intercambios.data.length;
        }

        // Procesar valoraciones (para stats Y para lista)
        if (results.valoraciones.success && results.valoraciones.data) {
          this.valoraciones = results.valoraciones.data;
          this.stats.totalValoraciones = results.valoraciones.data.length;
          
          if (results.valoraciones.data.length > 0) {
            const suma = results.valoraciones.data.reduce((acc, val) => acc + val.puntuacion, 0);
            this.stats.valoracionPromedio = suma / results.valoraciones.data.length;
          }
        }

        this.loadingStats = false;
      },
      error: () => {
        this.loadingStats = false;
      }
    });
  }

  getEstrellas(puntuacion: number): string[] {
    const estrellas: string[] = [];
    const full = Math.floor(puntuacion);
    const hasHalf = puntuacion % 1 >= 0.5;
    
    for (let i = 0; i < full; i++) {
      estrellas.push('star');
    }
    
    if (hasHalf) {
      estrellas.push('star_half');
    }
    
    while (estrellas.length < 5) {
      estrellas.push('star_border');
    }
    
    return estrellas;
  }

  openEditarPerfilDialog(): void {
    const dialogRef = this.dialog.open(EditarPerfilDialogComponent, {
      width: '500px',
      data: { usuario: this.usuario }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        // Actualizar el usuario en el componente
        this.usuario = result;
        // Actualizar también en AuthService para que se refleje en toda la app
        this.authService.updateCurrentUser(result);
      }
    });
  }
}