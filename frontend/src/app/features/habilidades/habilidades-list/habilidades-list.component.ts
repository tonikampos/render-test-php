import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatChipsModule } from '@angular/material/chips';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatPaginatorModule, PageEvent } from '@angular/material/paginator';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { HabilidadesService } from '../../../core/services/habilidades.service';
import { CategoriasService } from '../../../core/services/categorias.service';
import { Habilidad, Categoria } from '../../../shared/models';

@Component({
  selector: 'app-habilidades-list',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatButtonModule,
    MatIconModule,
    MatChipsModule,
    MatProgressSpinnerModule,
    MatPaginatorModule,
    MatSnackBarModule
  ],
  templateUrl: './habilidades-list.component.html',
  styleUrl: './habilidades-list.component.scss'
})
export class HabilidadesListComponent implements OnInit {
  habilidades: Habilidad[] = [];
  categorias: Categoria[] = [];
  loading = false;
  filterForm: FormGroup;

  // Paginación
  totalItems = 0;
  pageSize = 12;
  currentPage = 1;
  totalPages = 0;

  constructor(
    private fb: FormBuilder,
    private habilidadesService: HabilidadesService,
    private categoriasService: CategoriasService,
    private snackBar: MatSnackBar
  ) {
    this.filterForm = this.fb.group({
      search: [''],
      tipo: [''],
      categoria: [''],
      ubicacion: ['']
    });
  }

  ngOnInit(): void {
    this.loadCategorias();
    this.loadHabilidades();

    // Recargar cuando cambien los filtros
    this.filterForm.valueChanges.subscribe(() => {
      this.currentPage = 1;
      this.loadHabilidades();
    });
  }

  loadCategorias(): void {
    this.categoriasService.list().subscribe({
      next: (response) => {
        if (response.success) {
          this.categorias = response.data;
        }
      },
      error: (error) => {
        console.error('Error al cargar categorías:', error);
      }
    });
  }

  loadHabilidades(): void {
    this.loading = true;
    const filters = {
      ...this.filterForm.value,
      page: this.currentPage,
      per_page: this.pageSize
    };

    // Limpiar valores vacíos
    Object.keys(filters).forEach(key => {
      if (!filters[key]) delete filters[key];
    });

    this.habilidadesService.list(filters).subscribe({
      next: (response) => {
        this.loading = false;
        if (response.success && response.data) {
          this.habilidades = response.data.items;
          this.totalItems = response.data.pagination.total;
          this.totalPages = response.data.pagination.total_pages;
          this.currentPage = response.data.pagination.current_page;
        }
      },
      error: (error) => {
        this.loading = false;
        this.snackBar.open(
          'Error al cargar habilidades. Intenta de nuevo.',
          'Cerrar',
          { duration: 3000 }
        );
        console.error('Error:', error);
      }
    });
  }

  onPageChange(event: PageEvent): void {
    this.pageSize = event.pageSize;
    this.currentPage = event.pageIndex + 1;
    this.loadHabilidades();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  clearFilters(): void {
    this.filterForm.reset({
      search: '',
      tipo: '',
      categoria: '',
      ubicacion: ''
    });
  }

  getTipoIcon(tipo: string): string {
    return tipo === 'oferta' ? 'volunteer_activism' : 'search';
  }

  getTipoColor(tipo: string): string {
    return tipo === 'oferta' ? 'primary' : 'accent';
  }
}
