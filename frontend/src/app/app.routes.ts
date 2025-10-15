import { adminGuard } from './core/guards/admin.guard'; 
import { Routes } from '@angular/router';
import { authGuard } from './core/guards/auth.guard';

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
    loadComponent: () => import('./features/auth/forgot-password/forgot-password.component').then(m => m.ForgotPasswordComponent)
  },
  {
    path: 'reset-password',
    loadComponent: () => import('./features/auth/reset-password/reset-password.component').then(m => m.ResetPasswordComponent)
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
    path: 'admin/reportes',
    loadComponent: () => import('./features/admin/reportes-list/reportes-list.component').then(m => m.ReportesListComponent),
    canActivate: [authGuard, adminGuard] 
  },
  {
    path: '**',
    redirectTo: ''
  }
];
