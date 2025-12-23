import { Component, Output, EventEmitter, OnInit, OnDestroy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatMenuModule } from '@angular/material/menu';
import { MatBadgeModule } from '@angular/material/badge';

import { AuthService } from '../../core/services/auth.service';
import { NotificationBadgeComponent } from '../../shared/components/notification-badge/notification-badge.component';
import { ConversacionesService } from '../../core/services/conversaciones.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatTooltipModule,
    MatMenuModule,
    NotificationBadgeComponent,
    MatBadgeModule
  ],
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnDestroy {
  @Output() menuToggle = new EventEmitter<void>();
  mensajesNoLeidos = 0;
  private pollingSubscription?: Subscription;

  constructor(
    public authService: AuthService, 
    private router: Router,
    private conversacionesService: ConversacionesService
  ) {}

  ngOnInit(): void {
    // Suscribirse a cambios de autenticación (ya emite valor inicial)
    this.authService.currentUser$.subscribe(user => {
      if (user) {
        this.startPolling(); // Ya incluye carga inicial con startWith(0)
      } else {
        this.mensajesNoLeidos = 0;
        this.stopPolling();
      }
    });
  }

  ngOnDestroy(): void {
    this.stopPolling();
  }

  private loadMensajesCount(): void {
    this.conversacionesService.countMensajesNoLeidos().subscribe({
      next: (response) => {
        if (response.success && response.data?.count !== undefined) {
          this.mensajesNoLeidos = response.data.count;
        }
      },
      error: (error) => {
        console.error('Error al cargar mensajes no leídos:', error);
      }
    });
  }

  private startPolling(): void {
    this.pollingSubscription = this.conversacionesService.pollMensajesNoLeidos().subscribe({
      next: (response) => {
        if (response.success && response.data?.count !== undefined) {
          this.mensajesNoLeidos = response.data.count;
        }
      }
    });
  }

  private stopPolling(): void {
    if (this.pollingSubscription) {
      this.pollingSubscription.unsubscribe();
    }
  }

  logout(): void {
    this.authService.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }

  toggleSidenav(): void {
    this.menuToggle.emit();
  }
}