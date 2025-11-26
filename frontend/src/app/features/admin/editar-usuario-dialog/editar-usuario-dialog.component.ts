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
import { ApiResponse, User } from '../../../shared/models';

@Component({
  selector: 'app-editar-usuario-dialog',
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
  templateUrl: './editar-usuario-dialog.component.html',
  styleUrls: ['./editar-usuario-dialog.component.scss']
})
export class EditarUsuarioDialogComponent {
  editForm: FormGroup;
  submitting = false;
  roles: string[] = ['usuario', 'administrador'];

  constructor(
    private fb: FormBuilder,
    private adminService: AdminService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<EditarUsuarioDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { usuario: User }
  ) {
    this.editForm = this.fb.group({
      nombre_usuario: [data.usuario.nombre_usuario, [Validators.required, Validators.minLength(2), Validators.maxLength(50)]],
      email: [data.usuario.email, [Validators.required, Validators.email]],
      rol: [data.usuario.rol, Validators.required],
      ubicacion: [data.usuario.ubicacion || '', [Validators.required, Validators.maxLength(100)]],
      biografia: [data.usuario.biografia || '', Validators.maxLength(500)]
    });
  }

  onSubmit(): void {
    if (this.editForm.invalid) {
      return;
    }

    this.submitting = true;
    const updatedData = this.editForm.value;

    this.adminService.actualizarUsuario(this.data.usuario.id, updatedData).subscribe({
      next: (response: ApiResponse<User>) => {
        this.snackBar.open(`Usuario #${this.data.usuario.id} actualizado correctamente.`, 'OK', { duration: 3000 });
        this.dialogRef.close(true);
      },
      error: (err: HttpErrorResponse) => {
        this.submitting = false;
        console.error('Error al actualizar usuario:', err);
        const errorMessage = err.error?.message || 'Error al actualizar el usuario.';
        this.snackBar.open(errorMessage, 'Cerrar', { duration: 5000 });
      }
    });
  }

  onCancel(): void {
    this.dialogRef.close();
  }
}
