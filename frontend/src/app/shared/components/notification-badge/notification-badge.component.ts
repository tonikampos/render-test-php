import { Component, OnInit, OnDestroy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatIconModule } from '@angular/material/icon';
import { MatBadgeModule } from '@angular/material/badge';
import { MatButtonModule } from '@angular/material/button';
import { Subscription } from 'rxjs';

import { NotificacionesService } from '../../../core/services/notificaciones.service';

@Component({
  selector: 'app-notification-badge',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatIconModule,
    MatBadgeModule,
    MatButtonModule
  ],
  template: `
    <button 
      mat-icon-button 
      routerLink="/notificaciones"
      [matBadge]="noLeidas"
      [matBadgeHidden]="noLeidas === 0"
      matBadgeColor="warn"
      matBadgeSize="small"
      class="notification-button"
      aria-label="Notificaciones">
      <mat-icon>notifications</mat-icon>
    </button>
  `,
  styles: [`
    :host {
      display: flex;
      align-items: center;
    }
    
    .notification-button {
      color: white;
    }
    
    .notification-button mat-icon {
      color: white;
    }
  `]
})
export class NotificationBadgeComponent implements OnInit, OnDestroy {
  noLeidas = 0;
  private pollingSubscription?: Subscription;

  constructor(private notificacionesService: NotificacionesService) {}

  ngOnInit(): void {
    // Polling ya incluye carga inicial con startWith(0), no necesita loadCount() adicional
    this.pollingSubscription = this.notificacionesService.pollNoLeidas().subscribe({
      next: (response) => {
        if (response.success && response.data?.count !== undefined) {
          this.noLeidas = response.data.count;
        }
      }
    });
  }

  ngOnDestroy(): void {
    if (this.pollingSubscription) {
      this.pollingSubscription.unsubscribe();
    }
  }
}
