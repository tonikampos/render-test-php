import { Component, Inject, OnInit } from '@angular/core';
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

import { Habilidad } from '../../../shared/models';
import { HabilidadesService } from '../../../core/services/habilidades.service';
import { IntercambiosService } from '../../../core/services/intercambios.service';
import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-proponer-intercambio-dialog',
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
  templateUrl: './proponer-intercambio-dialog.component.html',
  styleUrls: ['./proponer-intercambio-dialog.component.scss']
})
export class ProponerIntercambioDialogComponent implements OnInit {
  proposalForm: FormGroup;
  userSkills: Habilidad[] = []; // Habilidades del usuario logueado
  submitting = false;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private habilidadesService: HabilidadesService,
    private intercambiosService: IntercambiosService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<ProponerIntercambioDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { habilidadDeseada: Habilidad }
  ) {
    this.proposalForm = this.fb.group({
      habilidad_ofrecida_id: ['', Validators.required],
      mensaje_propuesta: ['', [Validators.required, Validators.minLength(10)]]
    });
  }

  ngOnInit(): void {
    this.loadUserSkills();
  }

  // Carga las habilidades que el usuario actual puede ofrecer
  loadUserSkills(): void {
    const currentUser = this.authService.currentUserValue;
    if (currentUser) {
      this.habilidadesService.getByUser(currentUser.id).subscribe(response => {
        if (response.success) {
          // Filtramos para mostrar solo las habilidades que el usuario OFRECE
          this.userSkills = response.data.filter(skill => skill.tipo === 'oferta');
        }
      });
    }
  }

  onSubmit(): void {
    if (this.proposalForm.invalid) {
      return;
    }

    this.submitting = true;
    const proposalData = {
      ...this.proposalForm.value,
      habilidad_solicitada_id: this.data.habilidadDeseada.id
    };

    this.intercambiosService.proponer(proposalData).subscribe({
      next: () => {
        this.snackBar.open('¡Propuesta enviada con éxito!', 'Cerrar', { duration: 3000 });
        this.dialogRef.close(true); // Cierra el diálogo y devuelve 'true'
      },
      error: (error) => {
        this.submitting = false;
        this.snackBar.open(error.message || 'Error al enviar la propuesta.', 'Cerrar', { duration: 5000 });
      }
    });
  }

  onCancel(): void {
    this.dialogRef.close(); // Cierra el diálogo sin devolver nada
  }
}