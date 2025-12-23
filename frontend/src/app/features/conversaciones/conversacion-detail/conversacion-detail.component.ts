import { Component, OnInit, OnDestroy, ViewChild, ElementRef, AfterViewChecked } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatDividerModule } from '@angular/material/divider';
import { interval, Subscription } from 'rxjs';

import { ConversacionesService } from '../../../core/services/conversaciones.service';
import { AuthService } from '../../../core/services/auth.service';
import { Conversacion, Mensaje } from '../../../shared/models';
import { SkeletonLoaderComponent } from '../../../shared/components/skeleton-loader/skeleton-loader.component';

@Component({
  selector: 'app-conversacion-detail',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatIconModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatDividerModule,
    SkeletonLoaderComponent
  ],
  templateUrl: './conversacion-detail.component.html',
  styleUrl: './conversacion-detail.component.scss'
})
export class ConversacionDetailComponent implements OnInit, OnDestroy, AfterViewChecked {
  @ViewChild('messagesContainer') private messagesContainer!: ElementRef;

  conversacion: Conversacion | null = null;
  conversacionId: number | null = null;
  otroUsuarioNombre: string = '';
  mensajes: Mensaje[] = [];
  mensajeForm: FormGroup;
  loading = true;
  sending = false;
  currentUserId: number = 0;
  
  private pollingSubscription?: Subscription;
  private shouldScrollToBottom = false;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private fb: FormBuilder,
    private conversacionesService: ConversacionesService,
    private authService: AuthService,
    private snackBar: MatSnackBar
  ) {
    this.mensajeForm = this.fb.group({
      contenido: ['', [Validators.required, Validators.minLength(1), Validators.maxLength(1000)]]
    });
  }

  ngOnInit(): void {
    const currentUser = this.authService.currentUserValue;
    if (currentUser) {
      this.currentUserId = currentUser.id;
    }

    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.conversacionId = +id;
      
      // Obtener nombre del otro usuario del state de navegación
      const navigation = this.router.getCurrentNavigation();
      const state = navigation?.extras?.state || window.history.state;
      this.otroUsuarioNombre = state?.['usuario'] || '';
      
      // No llamamos loadConversacion porque ese endpoint no existe
      this.loadMensajes(this.conversacionId);
      this.marcarComoLeido(this.conversacionId);
      this.startPolling(this.conversacionId);
    }
  }

  ngAfterViewChecked(): void {
    if (this.shouldScrollToBottom) {
      this.scrollToBottom();
      this.shouldScrollToBottom = false;
    }
  }

  ngOnDestroy(): void {
    if (this.pollingSubscription) {
      this.pollingSubscription.unsubscribe();
    }
  }

  // Método comentado - el endpoint GET /conversaciones/:id no existe en el backend
  // loadConversacion(id: number): void {
  //   this.conversacionesService.getById(id).subscribe({
  //     next: (response) => {
  //       if (response.success) {
  //         this.conversacion = response.data;
  //       }
  //       this.loading = false;
  //     },
  //     error: () => {
  //       this.loading = false;
  //       this.snackBar.open('Error al cargar conversación', 'Cerrar', { duration: 3000 });
  //       this.router.navigate(['/conversaciones']);
  //     }
  //   });
  // }

  loadMensajes(conversacionId: number): void {
    this.conversacionesService.getMensajes(conversacionId).subscribe({
      next: (response) => {
        if (response.success) {
          this.mensajes = response.data;
          
          // Si no tenemos el nombre del otro usuario, obtenerlo del primer mensaje
          if (!this.otroUsuarioNombre && this.mensajes.length > 0) {
            const primerMensaje = this.mensajes[0];
            this.otroUsuarioNombre = primerMensaje.emisor_id !== this.currentUserId 
              ? (primerMensaje.emisor_nombre || 'Usuario')
              : (this.mensajes.find(m => m.emisor_id !== this.currentUserId)?.emisor_nombre || 'Usuario');
          }
          
          this.shouldScrollToBottom = true;
        }
        this.loading = false;
      },
      error: () => {
        this.snackBar.open('Error al cargar mensajes', 'Cerrar', { duration: 3000 });
        this.loading = false;
      }
    });
  }

  marcarComoLeido(conversacionId: number): void {
    this.conversacionesService.marcarLeido(conversacionId).subscribe({
      next: () => {
        // Silencioso - solo marcamos como leído
      },
      error: () => {
        // Silencioso - no es crítico
      }
    });
  }

  startPolling(conversacionId: number): void {
    // Polling cada 10 segundos para actualizar mensajes (optimizado para reducir carga)
    this.pollingSubscription = interval(10000).subscribe(() => {
      this.conversacionesService.getMensajes(conversacionId).subscribe({
        next: (response) => {
          if (response.success && response.data.length > this.mensajes.length) {
            this.mensajes = response.data;
            this.shouldScrollToBottom = true;
            this.marcarComoLeido(conversacionId);
          }
        }
      });
    });
  }

  onSubmit(): void {
    if (this.mensajeForm.invalid || !this.conversacionId) {
      return;
    }

    this.sending = true;
    const data = this.mensajeForm.value;

    this.conversacionesService.sendMensaje(this.conversacionId, data).subscribe({
      next: (response) => {
        this.sending = false;
        if (response.success) {
          // En lugar de hacer push, recargamos todos los mensajes
          this.loadMensajes(this.conversacionId!);
          this.mensajeForm.reset();
          this.shouldScrollToBottom = true;
        }
      },
      error: () => {
        this.sending = false;
        this.snackBar.open('Error al enviar mensaje', 'Cerrar', { duration: 3000 });
      }
    });
  }

  isMiMensaje(mensaje: Mensaje): boolean {
    return mensaje.emisor_id === this.currentUserId;
  }

  formatTime(fecha: string): string {
    const date = new Date(fecha);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
  }

  formatDate(fecha: string): string {
    const date = new Date(fecha);
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);

    if (date.toDateString() === today.toDateString()) {
      return 'Hoy';
    } else if (date.toDateString() === yesterday.toDateString()) {
      return 'Ayer';
    } else {
      return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
    }
  }

  shouldShowDateSeparator(index: number): boolean {
    if (index === 0) return true;
    
    const currentDate = new Date(this.mensajes[index].fecha_envio).toDateString();
    const previousDate = new Date(this.mensajes[index - 1].fecha_envio).toDateString();
    
    return currentDate !== previousDate;
  }

  private scrollToBottom(): void {
    try {
      if (this.messagesContainer) {
        this.messagesContainer.nativeElement.scrollTop = this.messagesContainer.nativeElement.scrollHeight;
      }
    } catch (err) {
      // Silencioso
    }
  }

  get contenido() {
    return this.mensajeForm.get('contenido');
  }

  onEnterPress(event: KeyboardEvent): void {
    if (!event.shiftKey) {
      event.preventDefault();
      this.onSubmit();
    }
  }

  trackByMensajeId(index: number, mensaje: Mensaje): number {
    return mensaje.id;
  }
}
