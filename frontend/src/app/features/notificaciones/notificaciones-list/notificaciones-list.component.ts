import { Component, OnInit, OnDestroy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatChipsModule } from '@angular/material/chips';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { Subscription, interval } from 'rxjs';
import { startWith, switchMap } from 'rxjs/operators';

import { NotificacionesService } from '../../../core/services/notificaciones.service';
import { Notificacion } from '../../../shared/models/notificacion.model';
import { SkeletonLoaderComponent } from '../../../shared/components/skeleton-loader/skeleton-loader.component';

@Component({
  selector: 'app-notificaciones-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatCardModule,
    MatButtonModule,
    MatIconModule,
    MatChipsModule,
    MatProgressSpinnerModule,
    SkeletonLoaderComponent
  ],
  templateUrl: './notificaciones-list.component.html',
  styleUrls: ['./notificaciones-list.component.scss']
})
export class NotificacionesListComponent implements OnInit, OnDestroy {
  notificaciones: Notificacion[] = [];
  loading = true;
  error: string | null = null;
  pollingSubscription?: Subscription;

  constructor(private notificacionesService: NotificacionesService) {}

  ngOnInit(): void {
    this.startPolling();
  }

  ngOnDestroy(): void {
    if (this.pollingSubscription) {
      this.pollingSubscription.unsubscribe();
    }
  }

  loadNotificaciones(): void {
    this.loading = true;
    this.error = null;

    this.notificacionesService.list().subscribe({
      next: (response) => {
        this.notificaciones = response.data;
        this.loading = false;
      },
      error: (error) => {
        console.error('Error al cargar notificaciones:', error);
        this.error = 'Error al cargar las notificaciones';
        this.loading = false;
      }
    });
  }

  startPolling(): void {
    this.pollingSubscription = interval(30000)
      .pipe(
        startWith(0),
        switchMap(() => this.notificacionesService.list())
      )
      .subscribe({
        next: (response) => {
          this.notificaciones = response.data;
          this.loading = false;
        },
        error: (error) => {
          console.error('Error en polling:', error);
          this.error = 'Error al cargar las notificaciones';
          this.loading = false;
        }
      });
  }

  trackByNotificacionId(index: number, notificacion: Notificacion): number {
    return notificacion.id;
  }

  marcarLeida(notificacion: Notificacion): void {
    if (notificacion.leida) return;

    this.notificacionesService.marcarLeida(notificacion.id).subscribe({
      next: () => {
        notificacion.leida = true;
        this.navegarAEntidad(notificacion);
      },
      error: (error) => {
        console.error('Error al marcar como leída:', error);
        this.navegarAEntidad(notificacion);
      }
    });
  }

  marcarTodasLeidas(): void {
    this.notificacionesService.marcarTodasLeidas().subscribe({
      next: () => {
        this.notificaciones.forEach(n => n.leida = true);
      },
      error: (error) => {
        console.error('Error al marcar todas como leídas:', error);
      }
    });
  }

  navegarAEntidad(notificacion: Notificacion): void {
    // Navegación según tipo de notificación
    const tiposIntercambio = ['nuevo_intercambio', 'intercambio_aceptado', 'intercambio_rechazado', 'intercambio_completado'];
    
    if (tiposIntercambio.includes(notificacion.tipo) && notificacion.referencia_id) {
      // Navegar a la lista con queryParam para destacar el intercambio específico
      window.location.href = `/intercambios?destacar=${notificacion.referencia_id}`;
    } else if (notificacion.tipo === 'nuevo_mensaje' && notificacion.referencia_id) {
      window.location.href = `/conversaciones/${notificacion.referencia_id}`;
    } else if (notificacion.tipo === 'nueva_valoracion') {
      // Navegar al perfil del usuario
      window.location.href = `/perfil`;
    }
  }

  getIconoNotificacion(tipo: string): string {
    const iconos: { [key: string]: string } = {
      'nuevo_intercambio': 'swap_horiz',
      'intercambio_aceptado': 'check_circle',
      'intercambio_rechazado': 'cancel',
      'intercambio_completado': 'done_all',
      'nueva_valoracion': 'star',
      'nuevo_mensaje': 'chat'
    };
    return iconos[tipo] || 'notifications';
  }

  getColorNotificacion(tipo: string): string {
    const colores: { [key: string]: string } = {
      'nuevo_intercambio': 'primary',
      'intercambio_aceptado': 'accent',
      'intercambio_rechazado': 'warn',
      'intercambio_completado': 'accent',
      'nueva_valoracion': 'accent',
      'nuevo_mensaje': 'primary'
    };
    return colores[tipo] || 'primary';
  }

  getTimeAgo(fecha: string): string {
    const now = new Date();
    const past = new Date(fecha);
    const diffMs = now.getTime() - past.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);

    if (diffMins < 1) return 'Ahora';
    if (diffMins < 60) return `Hace ${diffMins} min`;
    if (diffHours < 24) return `Hace ${diffHours}h`;
    if (diffDays < 7) return `Hace ${diffDays}d`;
    
    return past.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
  }

  get notificacionesNoLeidas(): number {
    return this.notificaciones.filter(n => !n.leida).length;
  }
}
