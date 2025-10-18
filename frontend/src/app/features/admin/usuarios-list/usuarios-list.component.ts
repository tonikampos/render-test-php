import { Component, OnInit, AfterViewInit, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { ReactiveFormsModule, FormBuilder, FormGroup } from '@angular/forms';
import { HttpErrorResponse } from '@angular/common/http';
import { debounceTime, distinctUntilChanged } from 'rxjs/operators';

// Angular Material
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatSort, MatSortModule } from '@angular/material/sort';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { MatCardModule } from '@angular/material/card'; // <-- Engadir este import

// Servizos e Modelos
import { AdminService } from '../../../core/services/admin.service';
import { ApiResponse, User, PaginatedResponse } from '../../../shared/models';

@Component({
  selector: 'app-usuarios-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatIconModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatTooltipModule,
    MatSlideToggleModule,
    MatCardModule // <-- E engadilo aquí no array de imports
  ],
  templateUrl: './usuarios-list.component.html',
  styleUrls: ['./usuarios-list.component.scss']
})
export class UsuariosListComponent implements OnInit, AfterViewInit {
  loading = true;
  dataSource = new MatTableDataSource<User>();
  displayedColumns: string[] = ['id', 'nombre_usuario', 'email', 'ubicacion', 'activo', 'rol', 'fecha_registro', 'acciones'];

  totalItems = 0;
  pageSize = 10;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  filterForm: FormGroup;

  constructor(
    private adminService: AdminService,
    private snackBar: MatSnackBar,
    private fb: FormBuilder
  ) {
    this.filterForm = this.fb.group({
      search: [''],
      ubicacion: ['']
    });
  }

  ngOnInit(): void {
    // A lóxica non cambia...
    this.loadUsuarios();
    this.filterForm.valueChanges.pipe(
      debounceTime(500),
      distinctUntilChanged()
    ).subscribe(() => {
      if (this.paginator) this.paginator.pageIndex = 0;
      this.loadUsuarios();
    });
  }

  ngAfterViewInit(): void {
    // A lóxica non cambia...
    if (this.paginator) {
        this.dataSource.paginator = this.paginator;
        this.paginator.page.subscribe(() => this.loadUsuarios());
    }
    if (this.sort) this.dataSource.sort = this.sort;
  }

  loadUsuarios(): void {
    // A lóxica non cambia...
    this.loading = true;
    const pageIndex = this.paginator ? this.paginator.pageIndex : 0;
    const pageSize = this.paginator ? this.paginator.pageSize : this.pageSize;
    const filters = this.filterForm.value;

    const params = {
      page: pageIndex + 1,
      per_page: pageSize,
      search: filters.search || undefined,
      ubicacion: filters.ubicacion || undefined
    };

    this.adminService.getUsuarios(params).subscribe({
      next: (response: ApiResponse<PaginatedResponse<User>>) => {
        if (response.success && response.data) {
          this.dataSource.data = response.data.items;
          this.totalItems = response.data.pagination.total;
        } else {
          this.dataSource.data = [];
          this.totalItems = 0;
        }
        this.loading = false;
      },
      error: (error: HttpErrorResponse) => {
        this.loading = false;
        this.snackBar.open('Error al cargar la lista de usuarios.', 'Cerrar', { duration: 3000 });
      }
    });
  }

  editarUsuario(id: number): void {
    // A lóxica non cambia...
    this.snackBar.open(`Funcionalidad Editar Usuario #${id} pendiente.`, 'OK', { duration: 2000 });
  }

  toggleActivo(usuario: User): void {
    // A lóxica non cambia...
    this.snackBar.open(`Funcionalidad Activar/Desactivar Usuario #${usuario.id} pendiente.`, 'OK', { duration: 2000 });
     // É importante reverter o estado visual ata que a API confirme
     // ou implementar un estado de 'cargando' no toggle.
     // Por agora, simplemente recargamos para ver o estado real da API:
     setTimeout(() => this.loadUsuarios(), 500); // Recargar despois dun pequeno retardo
  }
}