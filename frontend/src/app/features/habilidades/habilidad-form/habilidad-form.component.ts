import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
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
  loading = false;
  submitting = false;

  constructor(
    private fb: FormBuilder,
    private habilidadesService: HabilidadesService,
    private categoriasService: CategoriasService,
    private router: Router,
    private snackBar: MatSnackBar
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
  }

  loadCategorias(): void {
    this.loading = true;
    this.categoriasService.list().subscribe({
      next: (response) => {
        this.loading = false;
        if (response.success) {
          this.categorias = response.data;
        }
      },
      error: (error) => {
        this.loading = false;
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

    // Convertir duracion_estimada a número o null
    if (data.duracion_estimada) {
      data.duracion_estimada = parseInt(data.duracion_estimada, 10);
    } else {
      data.duracion_estimada = null;
    }

    this.habilidadesService.create(data).subscribe({
      next: (response) => {
        this.submitting = false;
        if (response.success) {
          this.snackBar.open('¡Habilidad creada exitosamente!', 'Cerrar', { duration: 3000 });
          this.router.navigate(['/habilidades', response.data.id]);
        }
      },
      error: (error) => {
        this.submitting = false;
        this.snackBar.open(
          error.message || 'Error al crear la habilidad. Intenta de nuevo.',
          'Cerrar',
          { duration: 5000 }
        );
      }
    });
  }

  // Helpers para validación
  get titulo() { return this.habilidadForm.get('titulo'); }
  get descripcion() { return this.habilidadForm.get('descripcion'); }
  get tipo() { return this.habilidadForm.get('tipo'); }
  get categoria_id() { return this.habilidadForm.get('categoria_id'); }
  get duracion_estimada() { return this.habilidadForm.get('duracion_estimada'); }
}
