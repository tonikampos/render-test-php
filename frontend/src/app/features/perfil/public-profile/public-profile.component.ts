import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatSnackBar } from '@angular/material/snack-bar';

import { UsuariosService } from '../../../core/services/usuarios.service';
import { ValoracionesService } from '../../../core/services/valoraciones.service';
import { ConversacionesService } from '../../../core/services/conversaciones.service';
import { AuthService } from '../../../core/services/auth.service';
import { User, Valoracion } from '../../../shared/models';
import { ValoracionesListComponent } from '../../../shared/components/valoraciones-list/valoraciones-list.component';

@Component({
  selector: 'app-public-profile',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    MatCardModule,
    MatProgressSpinnerModule,
    MatIconModule,
    MatButtonModule,
    ValoracionesListComponent 
  ],
  templateUrl: './public-profile.component.html',
  styleUrls: ['./public-profile.component.scss']
})
export class PublicProfileComponent implements OnInit {
  usuario: User | null = null;
  valoraciones: Valoracion[] = [];
  loading = true;
  sendingMessage = false;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private usuariosService: UsuariosService,
    private valoracionesService: ValoracionesService,
    private conversacionesService: ConversacionesService,
    public authService: AuthService,
    private snackBar: MatSnackBar
  ) { }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.loadUserProfile(+id);
      this.loadUserValoraciones(+id);
    }
  }

  loadUserProfile(id: number): void {
    this.usuariosService.getById(id).subscribe({
      next: res => {
        if (res.success) this.usuario = res.data;
        this.loading = false;
      },
      error: () => this.handleError()
    });
  }

  loadUserValoraciones(id: number): void {
    this.valoracionesService.getValoracionesDeUsuario(id).subscribe({
      next: res => {
        if (res.success) this.valoraciones = res.data;
      },
      error: () => this.handleError()
    });
  }

  private handleError(): void {
    this.loading = false;
    this.snackBar.open('Error ao cargar o perfil do usuario.', 'Cerrar', { duration: 3000 });
  }

  get isOwnProfile(): boolean {
    const currentUser = this.authService.currentUserValue;
    return currentUser ? currentUser.id === this.usuario?.id : false;
  }

  get isLoggedIn(): boolean {
    return this.authService.isAuthenticated();
  }

  iniciarConversacion(): void {
    if (!this.usuario) return;
    
    this.sendingMessage = true;
    
    this.conversacionesService.create({
      usuario2_id: this.usuario.id,
      mensaje_inicial: `Hola ${this.usuario.nombre_usuario}. Estoy interesado en contactar contigo.`
    }).subscribe({
      next: (res) => {
        if (res.success) {
          this.snackBar.open('Conversación iniciada', 'Ok', { duration: 2000 });
          // El backend devuelve conversacion_id en data
          const conversacionId = (res.data as any)?.conversacion_id || res.data?.id;
          if (conversacionId) {
            this.router.navigate(['/conversaciones', conversacionId]);
          } else {
            this.router.navigate(['/conversaciones']);
          }
        } else {
          this.snackBar.open(res.message || 'Error al iniciar conversación', 'Cerrar', { duration: 3000 });
        }
        this.sendingMessage = false;
      },
      error: (err) => {
        this.snackBar.open(err.error?.message || 'Error al iniciar conversación', 'Cerrar', { duration: 3000 });
        this.sendingMessage = false;
      }
    });
  }
}