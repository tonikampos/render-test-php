import { Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatDialogRef, MAT_DIALOG_DATA, MatDialogModule } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';

export interface ConfirmDialogData {
  title: string;
  message: string;
  confirmText?: string;
  cancelText?: string;
  confirmColor?: 'primary' | 'accent' | 'warn';
}

@Component({
  selector: 'app-confirm-dialog',
  standalone: true,
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule,
    MatIconModule
  ],
  template: `
    <div class="confirm-dialog">
      <h2 mat-dialog-title>
        <mat-icon color="warn">warning</mat-icon>
        {{ data.title }}
      </h2>
      
      <mat-dialog-content>
        <p>{{ data.message }}</p>
      </mat-dialog-content>
      
      <mat-dialog-actions align="end">
        <button 
          mat-button 
          (click)="onCancel()">
          {{ data.cancelText || 'Cancelar' }}
        </button>
        <button 
          mat-raised-button 
          [color]="data.confirmColor || 'warn'" 
          (click)="onConfirm()">
          {{ data.confirmText || 'Confirmar' }}
        </button>
      </mat-dialog-actions>
    </div>
  `,
  styles: [`
    .confirm-dialog {
      h2 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        
        mat-icon {
          font-size: 28px;
          width: 28px;
          height: 28px;
        }
      }
      
      mat-dialog-content {
        padding: 1.5rem 0;
        
        p {
          margin: 0;
          font-size: 1rem;
          line-height: 1.5;
        }
      }
      
      mat-dialog-actions {
        padding: 0;
        margin-top: 1rem;
        gap: 0.5rem;
      }
    }
    
    @media (max-width: 600px) {
      .confirm-dialog {
        h2 {
          font-size: 1.25rem;
          
          mat-icon {
            font-size: 24px;
            width: 24px;
            height: 24px;
          }
        }
        
        mat-dialog-content p {
          font-size: 0.95rem;
        }
        
        mat-dialog-actions {
          flex-direction: column-reverse;
          
          button {
            width: 100%;
          }
        }
      }
    }
  `]
})
export class ConfirmDialogComponent {
  constructor(
    public dialogRef: MatDialogRef<ConfirmDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: ConfirmDialogData
  ) {}

  onConfirm(): void {
    this.dialogRef.close(true);
  }

  onCancel(): void {
    this.dialogRef.close(false);
  }
}
