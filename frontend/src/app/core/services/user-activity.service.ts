import { Injectable, NgZone } from '@angular/core';
import { BehaviorSubject, Observable, fromEvent, merge } from 'rxjs';
import { throttleTime, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class UserActivityService {
  private readonly INACTIVE_THRESHOLD = 5 * 60 * 1000; 
  private lastActivityTime: number = Date.now();
  private isActiveSubject = new BehaviorSubject<boolean>(true);
  public isActive$: Observable<boolean> = this.isActiveSubject.asObservable();

  constructor(private ngZone: NgZone) {
    this.setupActivityListeners();
    this.startInactivityCheck();
  }

  /**
   * Configurar listeners de eventos del usuario
   */
  private setupActivityListeners(): void {
    this.ngZone.runOutsideAngular(() => {
      // Eventos que indican actividad del usuario
      const events = [
        fromEvent(document, 'mousedown'),
        fromEvent(document, 'keydown'),
        fromEvent(document, 'scroll'),
        fromEvent(document, 'touchstart')
      ];

      merge(...events).pipe(
        throttleTime(1000), // Solo procesar 1 evento por segundo
        map(() => Date.now())
      ).subscribe((timestamp) => {
        this.lastActivityTime = timestamp;
        
        // Si estaba inactivo, marcarlo como activo
        if (!this.isActiveSubject.value) {
          this.ngZone.run(() => {
            this.isActiveSubject.next(true);
          });
        }
      });
    });
  }

  /**
   * Verificar cada minuto si el usuario está inactivo
   */
  private startInactivityCheck(): void {
    setInterval(() => {
      const timeSinceLastActivity = Date.now() - this.lastActivityTime;
      const isCurrentlyActive = timeSinceLastActivity < this.INACTIVE_THRESHOLD;
      
      // Solo emitir si cambió el estado
      if (isCurrentlyActive !== this.isActiveSubject.value) {
        this.isActiveSubject.next(isCurrentlyActive);
      }
    }, 60000); // Verificar cada minuto
  }

  /**
   * Obtener estado actual de actividad
   */
  isUserActive(): boolean {
    return this.isActiveSubject.value;
  }

  /**
   * Obtener intervalo recomendado para polling según actividad
   */
  getPollingInterval(): number {
    return this.isActiveSubject.value ? 15000 : 120000; // 15s activo, 120s inactivo
  }
}
