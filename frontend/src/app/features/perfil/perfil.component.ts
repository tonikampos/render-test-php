import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/auth.service';
import { ValoracionesService } from '../../core/services/valoraciones.service';
import { User } from '../../shared/models';
import { Valoracion } from '../../shared/models/valoracion.model';
import { ValoracionesListComponent } from '../../shared/components/valoraciones-list/valoraciones-list.component'; 

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [CommonModule, ValoracionesListComponent], 
  templateUrl: './perfil.component.html', 
  styleUrls: ['./perfil.component.scss'] 
})
export class PerfilComponent implements OnInit {

  usuario: User | null = null;
  valoraciones: Valoracion[] = []; 

  constructor(
    private authService: AuthService,
    private valoracionesService: ValoracionesService
  ) {}

  ngOnInit(): void {
    this.usuario = this.authService.currentUserValue;

    if (this.usuario) {
      this.valoracionesService.getValoracionesDeUsuario(this.usuario.id)
        .subscribe(response => {
          if (response.success && response.data) {
            this.valoraciones = response.data;
          }
        });
    }
  }
}