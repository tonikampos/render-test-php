import { Component, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatSidenavModule, MatSidenav } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatDividerModule } from '@angular/material/divider';
import { MatBadgeModule } from '@angular/material/badge';

import { HeaderComponent } from '../header/header.component';
import { AuthService } from '../../core/services/auth.service';
import { NotificationBadgeComponent } from '../../shared/components/notification-badge/notification-badge.component';

@Component({
  selector: 'app-main-layout',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    HeaderComponent,
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    MatDividerModule,
    MatBadgeModule,
    NotificationBadgeComponent
  ],
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss']
})
export class MainLayoutComponent {
  @ViewChild('sidenav') sidenav!: MatSidenav;
  @ViewChild('header') header!: HeaderComponent;

  constructor(public authService: AuthService) {}

  get mensajesNoLeidos(): number {
    return this.header?.mensajesNoLeidos ?? 0;
  }


  toggleSidenav(): void {
    this.sidenav.toggle();
  }

  closeSidenav(): void {
    this.sidenav.close();
  }

  logout(): void {
    this.authService.logout().subscribe();
    this.closeSidenav();
  }
}