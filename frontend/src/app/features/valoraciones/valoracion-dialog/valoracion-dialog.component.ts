import { Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar } from '@angular/material/snack-bar';

import { Intercambio } from '../../../shared/models';
import { ValoracionesService } from '../../../core/services/valoraciones.service';

@Component({
  selector: 'app-valoracion-dialog',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatDialogModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatIconModule,
    MatProgressSpinnerModule
  ],
  templateUrl: './valoracion-dialog.component.html',
  styleUrls: ['./valoracion-dialog.component.scss']
})
export class ValoracionDialogComponent {
  valoracionForm: FormGroup;
  rating: number = 0; // Para guardar la puntuación seleccionada
  hoverRating: number = 0; // Para el efecto visual de las estrellas
  submitting = false;

  constructor(
    private fb: FormBuilder,
    private valoracionesService: ValoracionesService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<ValoracionDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { intercambio: Intercambio }
  ) {
    this.valoracionForm = this.fb.group({
      puntuacion: [null, Validators.required],
      comentario: ['', Validators.maxLength(500)]
    });
  }

  setRating(newRating: number): void {
    if (newRating >= 1 && newRating <= 5) {
      this.rating = newRating;
      this.valoracionForm.get('puntuacion')?.setValue(newRating);
    }
  }

  onSubmit(): void {
    if (this.valoracionForm.invalid) {
      return;
    }

    this.submitting = true;
    const valoracionData = {
      intercambio_id: this.data.intercambio.id,
      ...this.valoracionForm.value
    };

    this.valoracionesService.crearValoracion(valoracionData).subscribe({
      next: () => {
        this.snackBar.open('¡Valoración enviada correctamente!', 'OK', { duration: 3000 });
        this.dialogRef.close(true); // Pecha o diálogo e indica éxito
      },
      error: (err) => {
        this.submitting = false;
        this.snackBar.open(err.message || 'Error al enviar la valoración.', 'Cerrar', { duration: 5000 });
      }
    });
  }

  onCancel(): void {
    this.dialogRef.close();
  }
}