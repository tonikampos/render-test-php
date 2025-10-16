import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { MatCardModule } from '@angular/material/card';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatIconModule } from '@angular/material/icon';
import { MatSnackBar } from '@angular/material/snack-bar';

import { UsuariosService } from '../../../core/services/usuarios.service';
import { ValoracionesService } from '../../../core/services/valoraciones.service';
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
    ValoracionesListComponent // Reutilizamos o compoñente que xa tiñas
  ],
  templateUrl: './public-profile.component.html',
  styleUrls: ['./public-profile.component.scss']
})
export class PublicProfileComponent implements OnInit {
  usuario: User | null = null;
  valoraciones: Valoracion[] = [];
  loading = true;

  constructor(
    private route: ActivatedRoute,
    private usuariosService: UsuariosService,
    private valoracionesService: ValoracionesService,
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
}