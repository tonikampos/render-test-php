import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { AuthService } from '../../core/services/auth.service';
import { ValoracionesService } from '../../core/services/valoraciones.service';
import { HabilidadesService } from '../../core/services/habilidades.service';
import { IntercambiosService } from '../../core/services/intercambios.service';
import { User } from '../../shared/models';
import { Valoracion } from '../../shared/models/valoracion.model';
import { ValoracionesListComponent } from '../../shared/components/valoraciones-list/valoraciones-list.component';
import { SkeletonLoaderComponent } from '../../shared/components/skeleton-loader/skeleton-loader.component'; 

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatIconModule,
    MatProgressSpinnerModule,
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
    private intercambiosService: IntercambiosService
  ) {}

  ngOnInit(): void {
    this.usuario = this.authService.currentUserValue;

    if (this.usuario) {
      this.loadEstadisticas();
      this.loadValoraciones();
    }
  }

  loadEstadisticas(): void {
    if (!this.usuario) return;

    this.loadingStats = true;

    // Cargar total de habilidades (del usuario actual)
    this.habilidadesService.list({ per_page: 1000 }).subscribe({
      next: (response) => {
        if (response.success && response.data) {
          // Filtrar habilidades del usuario actual
          const misHabilidades = response.data.items.filter(h => h.usuario_id === this.usuario!.id);
          this.stats.totalHabilidades = misHabilidades.length;
        }
      }
    });

    // Cargar intercambios completados
    this.intercambiosService.getMisIntercambios('completado').subscribe({
      next: (response) => {
        if (response.success && response.data) {
          this.stats.intercambiosCompletados = response.data.length;
        }
      }
    });

    // Cargar valoraciones para calcular promedio
    this.valoracionesService.getValoracionesDeUsuario(this.usuario.id).subscribe({
      next: (response) => {
        if (response.success && response.data) {
          this.stats.totalValoraciones = response.data.length;
          
          if (response.data.length > 0) {
            const suma = response.data.reduce((acc, val) => acc + val.puntuacion, 0);
            this.stats.valoracionPromedio = suma / response.data.length;
          }
        }
        this.loadingStats = false;
      },
      error: () => {
        this.loadingStats = false;
      }
    });
  }

  loadValoraciones(): void {
    if (!this.usuario) return;

    this.valoracionesService.getValoracionesDeUsuario(this.usuario.id).subscribe({
      next: (response) => {
        if (response.success && response.data) {
          this.valoraciones = response.data;
        }
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
}