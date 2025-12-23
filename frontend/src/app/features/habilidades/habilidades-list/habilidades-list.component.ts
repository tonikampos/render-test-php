import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged } from 'rxjs/operators';
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
import { MatExpansionModule } from '@angular/material/expansion';
import { MatSliderModule } from '@angular/material/slider';
import { HabilidadesService } from '../../../core/services/habilidades.service';
import { CategoriasService } from '../../../core/services/categorias.service';
import { AuthService } from '../../../core/services/auth.service';
import { Habilidad, Categoria } from '../../../shared/models';
import { SkeletonLoaderComponent } from '../../../shared/components/skeleton-loader/skeleton-loader.component';

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
    MatSnackBarModule,
    MatExpansionModule,
    MatSliderModule,
    SkeletonLoaderComponent
  ],
  templateUrl: './habilidades-list.component.html',
  styleUrl: './habilidades-list.component.scss'
})
export class HabilidadesListComponent implements OnInit {
  habilidades: Habilidad[] = [];
  categorias: Categoria[] = [];
  loading = false;
  filterForm: FormGroup;
  filtersExpanded = false;

  // Paginación
  totalItems = 0;
  pageSize = 12;
  currentPage = 1;
  totalPages = 0;

  // Opciones de filtros avanzados
  duracionOptions = [
    { value: '0-30', label: 'Hasta 30 min' },
    { value: '30-60', label: '30 min - 1 hora' },
    { value: '60-120', label: '1 - 2 horas' },
    { value: '120-999', label: 'Más de 2 horas' }
  ];

  modalidadOptions = [
    { value: 'presencial', label: 'Presencial' },
    { value: 'online', label: 'Online' },
    { value: 'ambas', label: 'Ambas' }
  ];

  ordenOptions = [
    { value: 'recientes', label: 'Más recientes' },
    { value: 'antiguos', label: 'Más antiguos' },
    { value: 'valoracion', label: 'Mejor valorados' },
    { value: 'nombre_asc', label: 'Nombre A-Z' },
    { value: 'nombre_desc', label: 'Nombre Z-A' }
  ];

  private readonly STORAGE_KEY = 'habilidades_filters';

  constructor(
    private fb: FormBuilder,
    private habilidadesService: HabilidadesService,
    private categoriasService: CategoriasService,
    private snackBar: MatSnackBar,
    public authService: AuthService
  ) {
    // Cargar filtros desde LocalStorage
    const savedFilters = this.loadFiltersFromStorage();
    
    this.filterForm = this.fb.group({
      search: [savedFilters.search || ''],
      tipo: [savedFilters.tipo || ''],
      categoria: [savedFilters.categoria || ''],
      ubicacion: [savedFilters.ubicacion || ''],
      duracion: [savedFilters.duracion || ''],
      modalidad: [savedFilters.modalidad || ''],
      orden: [savedFilters.orden || 'recientes']
    });
  }

  ngOnInit(): void {
    this.loadCategorias();
    this.loadHabilidades();

    // Recargar cuando cambien los filtros (con debounce para optimizar búsqueda)
    this.filterForm.valueChanges.pipe(
      debounceTime(400),
      distinctUntilChanged()
    ).subscribe(() => {
      this.currentPage = 1;
      this.saveFiltersToStorage();
      this.loadHabilidades();
    });
  }

  loadFiltersFromStorage(): any {
    try {
      const saved = localStorage.getItem(this.STORAGE_KEY);
      return saved ? JSON.parse(saved) : {};
    } catch (error) {
      console.error('Error al cargar filtros del storage:', error);
      return {};
    }
  }

  saveFiltersToStorage(): void {
    try {
      localStorage.setItem(this.STORAGE_KEY, JSON.stringify(this.filterForm.value));
    } catch (error) {
      console.error('Error al guardar filtros en storage:', error);
    }
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
    const formValues = this.filterForm.value;
    const filters: any = {
      page: this.currentPage,
      per_page: this.pageSize
    };

    // Agregar filtros básicos
    if (formValues.search) filters.search = formValues.search;
    if (formValues.tipo) filters.tipo = formValues.tipo;
    if (formValues.categoria) filters.categoria = formValues.categoria;
    if (formValues.ubicacion) filters.ubicacion = formValues.ubicacion;
    if (formValues.modalidad) filters.modalidad = formValues.modalidad;

    // Agregar filtro de duración (min-max)
    if (formValues.duracion) {
      const [min, max] = formValues.duracion.split('-');
      filters.duracion_min = min;
      filters.duracion_max = max;
    }

    // Agregar ordenamiento
    if (formValues.orden) {
      filters.orden = formValues.orden;
    }

    this.habilidadesService.list(filters).subscribe({
      next: (response) => {
        this.loading = false;
        if (response.success && response.data) {
          this.habilidades = this.ordenarHabilidades(response.data.items, formValues.orden);
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

  ordenarHabilidades(habilidades: Habilidad[], orden: string): Habilidad[] {
    if (!orden || orden === 'recientes') {
      return habilidades; // Ya viene ordenado del backend
    }

    const sorted = [...habilidades];

    switch (orden) {
      case 'antiguos':
        return sorted.reverse();
      
      case 'nombre_asc':
        return sorted.sort((a, b) => a.titulo.localeCompare(b.titulo));
      
      case 'nombre_desc':
        return sorted.sort((a, b) => b.titulo.localeCompare(a.titulo));
      
      case 'valoracion':
        // Ordenar por valoración promedio (si existe en el modelo)
        return sorted.sort((a: any, b: any) => {
          const valA = a.valoracion_promedio || 0;
          const valB = b.valoracion_promedio || 0;
          return valB - valA;
        });
      
      default:
        return sorted;
    }
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
      ubicacion: '',
      duracion: '',
      modalidad: '',
      orden: 'recientes'
    });
    localStorage.removeItem(this.STORAGE_KEY);
  }

  get activeFiltersCount(): number {
    const values = this.filterForm.value;
    let count = 0;
    
    if (values.search) count++;
    if (values.tipo) count++;
    if (values.categoria) count++;
    if (values.ubicacion) count++;
    if (values.duracion) count++;
    if (values.modalidad) count++;
    
    return count;
  }

  toggleFilters(): void {
    this.filtersExpanded = !this.filtersExpanded;
  }

  getTipoIcon(tipo: string): string {
    return tipo === 'oferta' ? 'volunteer_activism' : 'search';
  }

  getTipoColor(tipo: string): string {
    return tipo === 'oferta' ? 'primary' : 'accent';
  }

  trackByHabilidadId(index: number, habilidad: Habilidad): number {
    return habilidad.id;
  }
}
