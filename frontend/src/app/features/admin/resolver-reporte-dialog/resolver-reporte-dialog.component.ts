import { Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select'; 
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar } from '@angular/material/snack-bar';
import { HttpErrorResponse } from '@angular/common/http'; 

import { AdminService } from '../../../core/services/admin.service';
import { ApiResponse, Reporte } from '../../../shared/models';

@Component({
  selector: 'app-resolver-reporte-dialog',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatDialogModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule, 
    MatButtonModule,
    MatIconModule,
    MatProgressSpinnerModule
  ],
  templateUrl: './resolver-reporte-dialog.component.html',
  styleUrls: ['./resolver-reporte-dialog.component.scss']
})
export class ResolverReporteDialogComponent {
  resolveForm: FormGroup;
  submitting = false;
  // Define los posibles estados de resolución según tu modelo Reporte
  resolutionStates: string[] = ['revisado', 'desestimado', 'accion_tomada']; 

  constructor(
    private fb: FormBuilder,
    private adminService: AdminService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<ResolverReporteDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { reporte: Reporte }
  ) {
    this.resolveForm = this.fb.group({
      decision: ['', Validators.required], 
      notas_revision: ['', [Validators.required, Validators.minLength(10), Validators.maxLength(500)]]
    });
  }

  onSubmit(): void {
    if (this.resolveForm.invalid) {
      return;
    }

    this.submitting = true;
    const { decision, notas_revision } = this.resolveForm.value;

    this.adminService.resolverReporte(this.data.reporte.id, decision, notas_revision).subscribe({
      // Añadir tipo explícito a 'response'
      next: (response: ApiResponse<Reporte>) => {
        this.snackBar.open(`Reporte #${this.data.reporte.id} resuelto como "${decision}".`, 'OK', { duration: 3000 });
        this.dialogRef.close(true); // Cerrar diálogo indicando éxito
      },
       // Añadir tipo explícito a 'err'
      error: (err: HttpErrorResponse) => {
        this.submitting = false;
        const errorMessage = err.error?.message || 'Error al resolver el reporte.';
        this.snackBar.open(errorMessage, 'Cerrar', { duration: 5000 });
      }
    });
  }

  onCancel(): void {
    this.dialogRef.close();
  }
}