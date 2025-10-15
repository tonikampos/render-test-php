import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/auth.service';
import { ValoracionesService } from '../../core/services/valoraciones.service'; // <--- 1. Importa o servizo
import { User } from '../../shared/models';
import { Valoracion } from '../../shared/models/valoracion.model';
import { ValoracionesListComponent } from '../../shared/components/valoraciones-list/valoraciones-list.component'; // <--- 2. Importa o compoñente

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [CommonModule, ValoracionesListComponent], // <--- 3. Engade o compoñente aos imports
  templateUrl: './perfil.component.html', // Necesitaremos o HTML deste ficheiro
  styleUrls: ['./perfil.component.scss'] // Necesitaremos o SCSS deste ficheiro
})
export class PerfilComponent implements OnInit {

  usuario: User | null = null;
  valoraciones: Valoracion[] = []; // <--- 4. Crea unha propiedade para as valoracións

  constructor(
    private authService: AuthService,
    private valoracionesService: ValoracionesService // <--- 5. Inxecta o servizo
  ) {}

  ngOnInit(): void {
    this.usuario = this.authService.currentUserValue;

    // 6. Carga as valoracións cando o compoñente se inicia
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