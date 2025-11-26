import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatChipsModule } from '@angular/material/chips';

import { AdminService } from '../../../core/services/admin.service';
import { SkeletonLoaderComponent } from '../../../shared/components/skeleton-loader/skeleton-loader.component';

interface Estadisticas {
  total_usuarios: number;
  usuarios_mes: number;
  total_habilidades: number;
  habilidades_oferta: number;
  habilidades_demanda: number;
  total_intercambios: number;
  intercambios_propuestos: number;
  intercambios_aceptados: number;
  intercambios_completados: number;
  intercambios_rechazados: number;
  total_reportes: number;
  reportes_pendientes: number;
  reportes_resueltos: number;
  total_valoraciones: number;
  valoracion_promedio: number;
  total_conversaciones: number;
  total_mensajes: number;
  categoria_mas_popular: string;
  categoria_mas_popular_count: number;
}

@Component({
  selector: 'app-admin-dashboard',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatIconModule,
    MatProgressSpinnerModule,
    MatGridListModule,
    MatChipsModule,
    SkeletonLoaderComponent
  ],
  templateUrl: './admin-dashboard.component.html',
  styleUrl: './admin-dashboard.component.scss'
})
export class AdminDashboardComponent implements OnInit {
  estadisticas: Estadisticas | null = null;
  loading = true;
  error: string | null = null;

  constructor(private adminService: AdminService) {}

  ngOnInit(): void {
    this.loadEstadisticas();
  }

  loadEstadisticas(): void {
    this.loading = true;
    this.error = null;

    this.adminService.getEstadisticas().subscribe({
      next: (response) => {
        if (response.success) {
          this.estadisticas = response.data;
        } else {
          this.error = 'Error al cargar estadísticas';
        }
        this.loading = false;
      },
      error: (err) => {
        console.error('Error al cargar estadísticas:', err);
        this.error = 'Error al cargar las estadísticas del sistema';
        this.loading = false;
      }
    });
  }

  getIntercambiosActivosPorcentaje(): number {
    if (!this.estadisticas || this.estadisticas.total_intercambios === 0) return 0;
    const activos = this.estadisticas.intercambios_propuestos + this.estadisticas.intercambios_aceptados;
    return Math.round((activos / this.estadisticas.total_intercambios) * 100);
  }

  getReportesPendientesPorcentaje(): number {
    if (!this.estadisticas || this.estadisticas.total_reportes === 0) return 0;
    return Math.round((this.estadisticas.reportes_pendientes / this.estadisticas.total_reportes) * 100);
  }

  getEstrellas(promedio: number): string[] {
    const estrellas: string[] = [];
    const entero = Math.floor(promedio);
    const decimal = promedio - entero;

    for (let i = 0; i < entero; i++) {
      estrellas.push('star');
    }

    if (decimal >= 0.5) {
      estrellas.push('star_half');
    }

    while (estrellas.length < 5) {
      estrellas.push('star_border');
    }

    return estrellas;
  }
}
