import { Component, Inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatDialogModule, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { UsuariosService } from '../../../core/services/usuarios.service';
import { User } from '../../../shared/models';

@Component({
  selector: 'app-editar-perfil-dialog',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatDialogModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    MatSnackBarModule
  ],
  template: `
    <h2 mat-dialog-title>Editar Perfil</h2>
    
    <mat-dialog-content>
      <form [formGroup]="form">
        <mat-form-field appearance="outline" class="w-100">
          <mat-label>Nombre de usuario</mat-label>
          <input matInput formControlName="nombre_usuario" placeholder="Tu nombre de usuario" readonly>
          <mat-hint>El nombre de usuario no se puede modificar</mat-hint>
        </mat-form-field>

        <mat-form-field appearance="outline" class="w-100">
          <mat-label>Ubicación</mat-label>
          <input matInput formControlName="ubicacion" placeholder="Ciudad, País">
        </mat-form-field>

        <mat-form-field appearance="outline" class="w-100">
          <mat-label>Biografía</mat-label>
          <textarea 
            matInput 
            formControlName="biografia" 
            rows="4"
            placeholder="Cuéntanos sobre ti...">
          </textarea>
        </mat-form-field>

        <mat-form-field appearance="outline" class="w-100">
          <mat-label>URL de foto de perfil</mat-label>
          <input matInput formControlName="foto_url" placeholder="https://...">
        </mat-form-field>
      </form>
    </mat-dialog-content>

    <mat-dialog-actions align="end">
      <button mat-button (click)="onCancel()" [disabled]="loading">
        Cancelar
      </button>
      <button 
        mat-raised-button 
        color="primary" 
        (click)="onSave()"
        [disabled]="loading">
        <mat-spinner diameter="20" *ngIf="loading" style="display: inline-block; margin-right: 8px;"></mat-spinner>
        {{ loading ? 'Guardando...' : 'Guardar' }}
      </button>
    </mat-dialog-actions>
  `,
  styles: [`
    mat-form-field {
      width: 100%;
      margin-bottom: 16px;
    }

    mat-dialog-content {
      min-width: 500px;
      max-width: 600px;
    }

    .w-100 {
      width: 100%;
    }
  `]
})
export class EditarPerfilDialogComponent implements OnInit {
  form!: FormGroup;
  loading = false;

  constructor(
    private fb: FormBuilder,
    private usuariosService: UsuariosService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<EditarPerfilDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { usuario: User }
  ) {}

  ngOnInit(): void {
    this.form = this.fb.group({
      nombre_usuario: [{value: this.data.usuario.nombre_usuario, disabled: true}],
      ubicacion: [this.data.usuario.ubicacion || ''],
      biografia: [this.data.usuario.biografia || ''],
      foto_url: [this.data.usuario.foto_url || '']
    });
  }

  onCancel(): void {
    this.dialogRef.close();
  }

  onSave(): void {
    if (this.form.invalid) return;

    this.loading = true;

    const data = this.form.value;

    this.usuariosService.update(this.data.usuario.id, data).subscribe({
      next: (response) => {
        this.loading = false;
        if (response.success) {
          this.snackBar.open('Perfil actualizado exitosamente', 'Cerrar', { duration: 3000 });
          this.dialogRef.close(response.data); // Devolver usuario actualizado
        }
      },
      error: (error) => {
        this.loading = false;
        const mensaje = error.error?.message || 'Error al actualizar perfil';
        this.snackBar.open(mensaje, 'Cerrar', { duration: 5000 });
      }
    });
  }
}
