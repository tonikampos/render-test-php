import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatBadgeModule } from '@angular/material/badge';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatDividerModule } from '@angular/material/divider';

import { ConversacionesService } from '../../../core/services/conversaciones.service';
import { Conversacion } from '../../../shared/models';
import { SkeletonLoaderComponent } from '../../../shared/components/skeleton-loader/skeleton-loader.component';

@Component({
  selector: 'app-conversaciones-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatCardModule,
    MatListModule,
    MatIconModule,
    MatButtonModule,
    MatBadgeModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatDividerModule,
    SkeletonLoaderComponent
  ],
  templateUrl: './conversaciones-list.component.html',
  styleUrl: './conversaciones-list.component.scss'
})
export class ConversacionesListComponent implements OnInit {
  conversaciones: Conversacion[] = [];
  loading = true;

  constructor(
    private conversacionesService: ConversacionesService,
    private snackBar: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.loadConversaciones();
  }

  loadConversaciones(): void {
    this.loading = true;
    this.conversacionesService.list().subscribe({
      next: (response) => {
        if (response.success) {
          // Filtrar duplicados por ID
          const conversacionesUnicas = response.data.filter((conv, index, self) =>
            index === self.findIndex((c) => c.id === conv.id)
          );
          this.conversaciones = conversacionesUnicas;
        }
        this.loading = false;
      },
      error: (error) => {
        this.loading = false;
        this.snackBar.open('Error al cargar conversaciones', 'Cerrar', { duration: 3000 });
      }
    });
  }

  getTimeAgo(fecha: string): string {
    const now = new Date();
    const messageDate = new Date(fecha);
    const diffMs = now.getTime() - messageDate.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) return 'Ahora';
    if (diffMins < 60) return `Hace ${diffMins}m`;
    if (diffHours < 24) return `Hace ${diffHours}h`;
    if (diffDays < 7) return `Hace ${diffDays}d`;
    
    return messageDate.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
  }

  trackByConversacionId(index: number, conversacion: Conversacion): number {
    return conversacion.id;
  }
}
