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

import { Habilidad } from '../../../shared/models'; // Ou o modelo que represente o contido a reportar
import { ReportesService } from '../../../core/services/reportes.service';

@Component({
  selector: 'app-reportar-dialog',
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
  templateUrl: './reportar-dialog.component.html',
  styleUrls: ['./reportar-dialog.component.scss']
})
export class ReportarDialogComponent {
  reportForm: FormGroup;
  submitting = false;

  constructor(
    private fb: FormBuilder,
    private reportesService: ReportesService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<ReportarDialogComponent>,
    // Recibimos o tipo de contido e o ID
    @Inject(MAT_DIALOG_DATA) public data: { tipoContenido: 'habilidad' | 'usuario', contenidoId: number, tituloContenido: string }
  ) {
    this.reportForm = this.fb.group({
      motivo: ['', [Validators.required, Validators.minLength(10), Validators.maxLength(500)]]
    });
  }

  onSubmit(): void {
    if (this.reportForm.invalid) {
      return;
    }

    this.submitting = true;
    const reportData = {
      tipo_contenido: this.data.tipoContenido,
      contenido_id: this.data.contenidoId,
      motivo: this.reportForm.value.motivo
    };

    this.reportesService.crearReporte(reportData).subscribe({
      next: () => {
        this.snackBar.open('Reporte enviado correctamente. Grazas pola túa axuda!', 'OK', { duration: 3500 });
        this.dialogRef.close(true); // Pecha o diálogo indicando éxito
      },
      error: (err) => {
        this.submitting = false;
        this.snackBar.open(err.message || 'Error ao enviar o reporte.', 'Cerrar', { duration: 5000 });
      }
    });
  }

  onCancel(): void {
    this.dialogRef.close();
  }
}