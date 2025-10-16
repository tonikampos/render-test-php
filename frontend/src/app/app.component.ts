import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

// 1. Importa el nuevo MainLayoutComponent
import { MainLayoutComponent } from './layout/main-layout/main-layout.component';

@Component({
  selector: 'app-root',
  standalone: true, // Asegúrate de que este componente sea standalone
  imports: [
    CommonModule,
    // 2. Añade MainLayoutComponent a los imports. Se eliminan los demás.
    MainLayoutComponent
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'GaliTroco';

  // 3. El constructor ahora está vacío y se ha eliminado el método logout.
  constructor() {}
}