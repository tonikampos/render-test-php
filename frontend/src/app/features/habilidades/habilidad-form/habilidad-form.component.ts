import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule, ActivatedRoute } from '@angular/router'; // Se añade ActivatedRoute
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { HabilidadesService } from '../../../core/services/habilidades.service';
import { CategoriasService } from '../../../core/services/categorias.service';
import { Categoria } from '../../../shared/models';

@Component({
  selector: 'app-habilidad-form',
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
    MatProgressSpinnerModule,
    MatSnackBarModule
  ],
  templateUrl: './habilidad-form.component.html',
  styleUrl: './habilidad-form.component.scss'
})
export class HabilidadFormComponent implements OnInit {
  habilidadForm: FormGroup;
  categorias: Categoria[] = [];
  submitting = false;

  isEditMode = false;
  habilidadId: number | null = null;

  constructor(
    private fb: FormBuilder,
    private habilidadesService: HabilidadesService,
    private categoriasService: CategoriasService,
    private router: Router,
    private snackBar: MatSnackBar,
    private route: ActivatedRoute
  ) {
    this.habilidadForm = this.fb.group({
      titulo: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(150)]],
      descripcion: ['', [Validators.required, Validators.minLength(20), Validators.maxLength(500)]],
      tipo: ['', Validators.required],
      categoria_id: ['', Validators.required],
      duracion_estimada: ['', [Validators.min(5), Validators.max(1440)]]
    });
  }

  ngOnInit(): void {
    this.loadCategorias();

    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.isEditMode = true;
      this.habilidadId = +id;
      this.loadHabilidadData(this.habilidadId);
    }
  }

  loadHabilidadData(id: number): void {
    this.habilidadesService.getById(id).subscribe({
      next: (response) => {
        if (response.success && response.data) {
          // Rellena el formulario con los datos de la habilidad
          this.habilidadForm.patchValue(response.data);
        } else {
           this.snackBar.open('No se pudieron cargar los datos de la habilidad.', 'Cerrar', { duration: 3000 });
           this.router.navigate(['/habilidades']);
        }
      },
      error: () => {
        this.snackBar.open('Error al cargar la habilidad para editar.', 'Cerrar', { duration: 3000 });
        this.router.navigate(['/habilidades']);
      }
    });
  }

  loadCategorias(): void {
    // Este método no cambia
    this.categoriasService.list().subscribe({
      next: (response) => {
        if (response.success) {
          this.categorias = response.data;
        }
      },
      error: () => {
        this.snackBar.open('Error al cargar categorías', 'Cerrar', { duration: 3000 });
      }
    });
  }

  onSubmit(): void {
    if (this.habilidadForm.invalid) {
      return;
    }

    this.submitting = true;
    const data = this.habilidadForm.value;

    if (data.duracion_estimada) {
      data.duracion_estimada = parseInt(data.duracion_estimada, 10);
    } else {
      data.duracion_estimada = null;
    }

    // 6. Llama a 'update' o 'create' según el modo en el que esté el formulario
    if (this.isEditMode && this.habilidadId) {
      this.habilidadesService.update(this.habilidadId, data).subscribe(this.handleResponse);
    } else {
      this.habilidadesService.create(data).subscribe(this.handleResponse);
    }
  }
  
  // 7. Refactorización para manejar la respuesta de la API y evitar código duplicado
  private handleResponse = {
    next: (response: any) => {
      this.submitting = false;
      if (response.success) {
        const message = this.isEditMode ? '¡Habilidad actualizada con éxito!' : '¡Habilidad creada exitosamente!';
        this.snackBar.open(message, 'Cerrar', { duration: 3000 });
        this.router.navigate(['/habilidades', response.data.id]);
      }
    },
    error: (error: any) => {
      this.submitting = false;
      const action = this.isEditMode ? 'actualizar' : 'crear';
      this.snackBar.open(
        error.message || `Error al ${action} la habilidad. Intenta de nuevo.`,
        'Cerrar',
        { duration: 5000 }
      );
    }
  };

  // Helpers para validación (no cambian)
  get titulo() { return this.habilidadForm.get('titulo'); }
  get descripcion() { return this.habilidadForm.get('descripcion'); }
  get tipo() { return this.habilidadForm.get('tipo'); }
  get categoria_id() { return this.habilidadForm.get('categoria_id'); }
  get duracion_estimada() { return this.habilidadForm.get('duracion_estimada'); }
}