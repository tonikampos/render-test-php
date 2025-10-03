import { Routes } from '@angular/router';
import { authGuard } from './core/guards/auth.guard';
import { ResetPasswordComponent } from './features/auth/reset-password/reset-password.component';
import { ForgotPasswordComponent } from './features/auth/forgot-password/forgot-password.component';

export const routes: Routes = [
  {
    path: '',
    loadComponent: () => import('./features/home/home.component').then(m => m.HomeComponent)
  },
  {
    path: 'login',
    loadComponent: () => import('./features/auth/login/login.component').then(m => m.LoginComponent)
  },
  {
    path: 'register',
    loadComponent: () => import('./features/auth/register/register.component').then(m => m.RegisterComponent)
  },
  {
    path: 'forgot-password',
    component: ForgotPasswordComponent  // EAGER LOADING - TEST
  },
  {
    path: 'reset-password',
    component: ResetPasswordComponent  // EAGER LOADING - TEST
  },
  {
    path: 'habilidades',
    loadComponent: () => import('./features/habilidades/habilidades-list/habilidades-list.component').then(m => m.HabilidadesListComponent)
  },
  {
    path: 'habilidades/nueva',
    loadComponent: () => import('./features/habilidades/habilidad-form/habilidad-form.component').then(m => m.HabilidadFormComponent),
    canActivate: [authGuard]
  },
  {
    path: 'habilidades/:id',
    loadComponent: () => import('./features/habilidades/habilidad-detail/habilidad-detail.component').then(m => m.HabilidadDetailComponent)
  },
  {
    path: 'perfil',
    loadComponent: () => import('./features/perfil/perfil.component').then(m => m.PerfilComponent),
    canActivate: [authGuard]
  },
  {
    path: '**',
    redirectTo: ''
  }
];
