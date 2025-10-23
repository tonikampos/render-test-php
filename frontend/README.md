# 🎨 GALITROCO - Frontend Angular# Frontend



**Autor:** Antonio Campos  This project was generated using [Angular CLI](https://github.com/angular/angular-cli) version 19.2.0.

**Universidad:** Universitat Oberta de Catalunya (UOC)  

**Asignatura:** Trabajo Final de Máster (PEC2)  ## Development server

**Fecha:** Octubre-Noviembre 2025

To start a local development server, run:

---

```bash

## 📋 DESCRIPCIÓNng serve

```

Frontend web desarrollado en **Angular 19** para GaliTroco, una plataforma de intercambio de habilidades y servicios. Consume la API REST del backend para gestionar usuarios, habilidades, intercambios, mensajería y valoraciones.

Once the server is running, open your browser and navigate to `http://localhost:4200/`. The application will automatically reload whenever you modify any of the source files.

**Estado del frontend:** ✅ **95% implementado** (todas las funcionalidades principales operativas)

## Code scaffolding

---

Angular CLI includes powerful code scaffolding tools. To generate a new component, run:

## 🛠️ STACK TECNOLÓGICO FRONTEND

```bash

| Componente | Tecnología | Versión |ng generate component component-name

|------------|------------|---------|```

| **Framework** | Angular | 19.2.0 |

| **Lenguaje** | TypeScript | 5.7.2 |For a complete list of available schematics (such as `components`, `directives`, or `pipes`), run:

| **UI Library** | Angular Material | 19.2.19 |

| **HTTP Client** | HttpClient | Con RxJS 7.8 |```bash

| **Routing** | Angular Router | 19.2.0 |ng generate --help

| **Forms** | Reactive Forms | Angular Forms |```

| **Build Tool** | Angular CLI | 19.2.0 |

| **Package Manager** | npm | 10.9.2 |## Building

| **Node Runtime** | Node.js | 18.20.5 |

| **Hosting** | Render.com | Static Site |To build the project run:



### Características principales:```bash

- ✅ **Diseño responsive** (Mobile, Tablet, Desktop)ng build

- ✅ **Material Design** (componentes Angular Material)```

- ✅ **Autenticación persistente** (guards y interceptores)

- ✅ **Lazy Loading** de módulos por rutasThis will compile your project and store the build artifacts in the `dist/` directory. By default, the production build optimizes your application for performance and speed.

- ✅ **Reactive Forms** con validación en tiempo real

- ✅ **RxJS** para gestión de estado y observables## Running unit tests

- ✅ **Interceptores HTTP** para manejo de errores y autenticación

To execute unit tests with the [Karma](https://karma-runner.github.io) test runner, use the following command:

---

```bash

## 🌐 URL DEL FRONTEND DESPLEGADOng test

```

### Producción (Render.com) - **RECOMENDADO PARA PRUEBAS PEC2**

## Running end-to-end tests

```

https://galitroco-frontend.onrender.comFor end-to-end (e2e) testing, run:

```

```bash

**Estado:** ✅ Operativo 24/7  ng e2e

**Deploy:** Automático desde GitHub (branch `main`)  ```

**Backend API:** https://render-test-php-1.onrender.com/api.php

Angular CLI does not come with an end-to-end testing framework by default. You can choose one that suits your needs.

> **Nota:** El frontend consume la API REST del backend desplegada en Render.

## Additional Resources

---

For more information on using the Angular CLI, including detailed command references, visit the [Angular CLI Overview and Command Reference](https://angular.dev/tools/cli) page.

## 👤 CREDENCIALES DE PRUEBA

Utiliza estos usuarios para probar la aplicación:

### Usuario A (Intercambios)
```
Email:    test_6937@testmail.com
Password: Pass123456
ID:       21
Rol:      usuario
```

### Usuario B (Intercambios)
```
Email:    userB_6566@testing.com
Password: Pass123456
ID:       23
Rol:      usuario
```

### Administrador (Panel Admin)
```
Email:    admin@galitroco.com
Password: Admin123456
Rol:      administrador
```

---

## 🧪 CÓMO PROBAR EL FRONTEND (RECOMENDADO PARA PEC2)

### ⚡ Opción 1: Acceso Directo a Producción - **MÁS RÁPIDO**

**No requiere instalación local.** Simplemente abre el navegador:

```
https://galitroco-frontend.onrender.com
```

#### Ventajas:
- ✅ **Cero configuración** - Solo necesitas un navegador
- ✅ **Datos reales** - Base de datos Supabase con datos de prueba
- ✅ **Última versión** - Auto-deploy desde GitHub
- ⏱️ **Tiempo de prueba:** 20-30 minutos (flujo completo)

---

## 📋 GUÍA DE PRUEBAS PASO A PASO

### 🔐 1. AUTENTICACIÓN (3 minutos)

#### 1.1 Probar Login
1. Ir a: `https://galitroco-frontend.onrender.com/login`
2. Ingresar credenciales:
   - Email: `test_6937@testmail.com`
   - Password: `Pass123456`
3. Click en **"Iniciar sesión"**
4. **Resultado esperado:** Redirección al dashboard

#### 1.2 Probar Registro
1. Ir a: `https://galitroco-frontend.onrender.com/registro`
2. Completar formulario:
   - Nombre de usuario: `evaluador_test_` + timestamp
   - Email: `evaluador@test.com`
   - Contraseña: `Test123456`
   - Confirmar contraseña: `Test123456`
   - Ubicación: `A Coruña`
3. Click en **"Registrarse"**
4. **Resultado esperado:** Registro exitoso + redirección al login

#### 1.3 Verificar Persistencia de Sesión
1. Cerrar navegador completamente
2. Abrir navegador y volver a: `https://galitroco-frontend.onrender.com`
3. **Resultado esperado:** Usuario sigue autenticado (sesión persiste)

#### 1.4 Probar Logout
1. Click en icono de usuario (esquina superior derecha)
2. Click en **"Cerrar sesión"**
3. **Resultado esperado:** Redirección a login + sesión cerrada

---

### 🎯 2. GESTIÓN DE HABILIDADES (5 minutos)

#### 2.1 Ver Catálogo Público
1. Login como `test_6937@testmail.com`
2. Ir a: **"Explorar Habilidades"** (menú lateral o navbar)
3. **Resultado esperado:** 
   - Lista de habilidades públicas
   - Filtros por categoría
   - Buscador por palabra clave
   - Tarjetas con información (título, categoría, usuario, ubicación)

#### 2.2 Filtrar por Categoría
1. En "Explorar Habilidades", seleccionar categoría: `Tecnología e Informática`
2. **Resultado esperado:** Solo habilidades de esa categoría

#### 2.3 Buscar por Palabra Clave
1. En el buscador, escribir: `inglés`
2. **Resultado esperado:** Habilidades que contengan "inglés" en título o descripción

#### 2.4 Ver Detalle de Habilidad
1. Click en una tarjeta de habilidad
2. **Resultado esperado:** 
   - Modal/página con información completa
   - Título, descripción, categoría, duración estimada
   - Información del usuario propietario
   - Botón **"Proponer Intercambio"** (si no es tuya)

#### 2.5 Crear Nueva Habilidad
1. Ir a: **"Mis Habilidades"** → **"Nueva Habilidad"**
2. Completar formulario:
   - Tipo: `Oferta`
   - Categoría: `Tecnología e Informática`
   - Título: `Clases de Python para principiantes`
   - Descripción: `Enseño programación en Python desde cero, orientado a objetos y aplicaciones web`
   - Duración estimada: `60` minutos
3. Click en **"Publicar"**
4. **Resultado esperado:** 
   - Mensaje de éxito
   - Habilidad visible en "Mis Habilidades"
   - Estado: `Activa`

#### 2.6 Editar Habilidad
1. En "Mis Habilidades", click en **icono de editar** (lápiz) de la habilidad recién creada
2. Modificar el título: `Clases de Python avanzado + Django`
3. Click en **"Guardar cambios"**
4. **Resultado esperado:** Cambios reflejados inmediatamente

#### 2.7 Pausar/Activar Habilidad
1. Click en botón **"Pausar"** de una habilidad
2. **Resultado esperado:** 
   - Estado cambia a `Pausada`
   - No visible en búsquedas públicas
   - Chip/badge muestra "Pausada"
3. Click en **"Activar"** nuevamente
4. **Resultado esperado:** Estado vuelve a `Activa`

---

### 🔄 3. SISTEMA DE INTERCAMBIOS COMPLETO (10 minutos)

#### 3.1 Proponer Intercambio (Usuario A)
1. Login como `test_6937@testmail.com`
2. Ir a **"Explorar Habilidades"**
3. Buscar una habilidad que te interese (de otro usuario)
4. Click en la habilidad → **"Proponer Intercambio"**
5. En el diálogo:
   - Seleccionar **tu habilidad** a ofrecer (dropdown)
   - Escribir mensaje: `Hola, me interesa tu habilidad. ¿Podemos intercambiar?`
6. Click en **"Enviar Propuesta"**
7. **Resultado esperado:**
   - Mensaje de confirmación
   - Propuesta visible en **"Mis Intercambios"** → Pestaña **"Enviados"**
   - Estado: `Propuesto`

#### 3.2 Ver Propuestas Recibidas (Usuario B)
1. **Cerrar sesión** de Usuario A
2. Login como `userB_6566@testing.com`
3. Ir a **"Mis Intercambios"** → Pestaña **"Recibidos"**
4. **Resultado esperado:**
   - Ver la propuesta recibida
   - Información completa: habilidades, usuario proponente, mensaje
   - Botones: **"Aceptar"** y **"Rechazar"**

#### 3.3 Aceptar Propuesta
1. Click en **"Aceptar"** en la propuesta recibida
2. Confirmar en el diálogo
3. **Resultado esperado:**
   - Estado cambia a `Aceptado`
   - Chip/badge color verde
   - Aparece botón **"Ver Conversación"**
   - Aparece botón **"Marcar como Completado"**

#### 3.4 Completar Intercambio
1. En un intercambio **Aceptado**, click en **"Marcar como Completado"**
2. Confirmar acción
3. **Resultado esperado:**
   - Estado cambia a `Completado`
   - Chip/badge color azul
   - Aparece botón **"Valorar Usuario"**

#### 3.5 Valorar Usuario
1. Click en **"Valorar Usuario"**
2. En el diálogo de valoración:
   - Seleccionar puntuación: **5 estrellas** (click en las estrellas)
   - Escribir comentario: `Excelente experiencia, muy profesional y puntual`
3. Click en **"Enviar Valoración"**
4. **Resultado esperado:**
   - Mensaje de éxito
   - Valoración registrada
   - Ya no se puede valorar de nuevo

---

### 🔍 4. BÚSQUEDA Y FILTROS (3 minutos)

#### 4.1 Filtrar por Tipo (Oferta/Demanda)
1. En "Explorar Habilidades", seleccionar filtro: `Solo Ofertas`
2. **Resultado esperado:** Solo habilidades tipo "Oferta"

#### 4.2 Filtrar por Ubicación
1. Seleccionar: `Santiago de Compostela`
2. **Resultado esperado:** Solo usuarios de Santiago

#### 4.3 Combinar Filtros
1. Seleccionar categoría: `Clases y Formación`
2. Escribir en buscador: `inglés`
3. Tipo: `Oferta`
4. **Resultado esperado:** Habilidades que cumplan todos los criterios

---

### 👮 5. PANEL DE ADMINISTRACIÓN (Solo Admin - 5 minutos)

#### 5.1 Acceso al Panel
1. **Cerrar sesión** de usuario normal
2. Login como `admin@galitroco.com` / `Admin123456`
3. Ir a **"Panel de Administración"** (menú lateral)
4. **Resultado esperado:** 
   - Acceso permitido (solo admins)
   - Dashboard con widgets de estadísticas

#### 5.2 Ver Estadísticas
1. En el dashboard admin, verificar widgets:
   - **Total de usuarios registrados**
   - **Total de habilidades publicadas**
   - **Intercambios completados**
   - **Valoración promedio de la plataforma**
2. **Resultado esperado:** Estadísticas en tiempo real desde la BD

#### 5.3 Gestionar Usuarios
1. Ir a pestaña **"Usuarios"** en el panel admin
2. **Resultado esperado:**
   - Tabla con todos los usuarios
   - Columnas: ID, Nombre, Email, Rol, Estado, Fecha registro
   - Filtros y buscador

---

## ✅ CHECKLIST DE VERIFICACIÓN FRONTEND

Marca cada funcionalidad después de probarla:

### **Autenticación:**
- [ ] Login con credenciales correctas
- [ ] Registro de nuevo usuario
- [ ] Validación de formularios (campos vacíos, email inválido, etc.)
- [ ] Persistencia de sesión (refresh de página)
- [ ] Logout funciona correctamente

### **Habilidades:**
- [ ] Ver catálogo público (sin login)
- [ ] Crear nueva habilidad (tipo oferta/demanda)
- [ ] Editar habilidad propia
- [ ] Pausar/Activar habilidad
- [ ] Ver detalle de habilidad
- [ ] Filtrar por categoría
- [ ] Buscar por palabra clave

### **Intercambios:**
- [ ] Proponer intercambio
- [ ] Ver propuestas enviadas
- [ ] Ver propuestas recibidas
- [ ] Aceptar propuesta (solo receptor)
- [ ] Rechazar propuesta (solo receptor)
- [ ] Marcar como completado
- [ ] Estados visuales correctos (chips de colores)

### **Valoraciones:**
- [ ] Valorar usuario después de intercambio completado
- [ ] Sistema de estrellas (1-5) funciona
- [ ] Comentario se guarda correctamente
- [ ] No se puede valorar dos veces el mismo intercambio

### **Panel Admin:**
- [ ] Solo admins acceden al panel
- [ ] Usuarios normales ven error 403
- [ ] Estadísticas se calculan correctamente
- [ ] Listar todos los usuarios

### **UI/UX:**
- [ ] Diseño responsive (móvil, tablet, desktop)
- [ ] Material Design consistente
- [ ] Validación de formularios en tiempo real
- [ ] Mensajes de error/éxito claros

---

## 🔧 INSTALACIÓN LOCAL (Opcional)

### Prerrequisitos:
- Node.js 18+ (recomendado: 18.20.5)
- npm 10+
- Git

### Pasos:

#### 1. Clonar repositorio
```bash
git clone https://github.com/tonikampos/render-test-php.git
cd render-test-php/frontend
```

#### 2. Instalar dependencias
```bash
npm install
```

**Tiempo estimado:** 2-3 minutos

#### 3. Configurar URL del backend (Opcional)

El frontend está configurado para usar el backend de **producción** por defecto.

**Archivo:** `src/environments/environment.ts`

```typescript
export const environment = {
  production: false,
  // Backend en Render (por defecto)
  apiUrl: 'https://render-test-php-1.onrender.com/api.php'
  
  // O backend local (si lo tienes corriendo):
  // apiUrl: 'http://localhost/probatfm/backend/api/api.php'
};
```

#### 4. Iniciar servidor de desarrollo
```bash
npm start
```

**O bien:**
```bash
ng serve
```

El frontend estará disponible en: `http://localhost:4200`

**Auto-reload:** El navegador se recarga automáticamente al guardar cambios.

#### 5. Build de producción (Opcional)
```bash
npm run build:prod
```

**Output:** Archivos estáticos en `dist/frontend/browser/`

---

## 🏗️ ARQUITECTURA DEL FRONTEND

```
frontend/src/
├── app/
│   ├── core/                      # Servicios singleton y guards
│   │   ├── services/
│   │   │   ├── auth.service.ts    # Autenticación
│   │   │   ├── habilidades.service.ts
│   │   │   ├── intercambios.service.ts
│   │   │   └── valoraciones.service.ts
│   │   ├── guards/
│   │   │   ├── auth.guard.ts      # Protege rutas privadas
│   │   │   └── admin.guard.ts     # Protege rutas admin
│   │   └── interceptors/
│   │       └── http.interceptor.ts # Manejo de errores HTTP
│   ├── shared/                    # Componentes compartidos
│   │   ├── navbar/
│   │   ├── sidebar/
│   │   └── ...
│   ├── features/                  # Módulos por funcionalidad
│   │   ├── auth/
│   │   ├── habilidades/
│   │   ├── intercambios/
│   │   ├── valoraciones/
│   │   └── admin/
│   └── app.routes.ts              # Configuración de rutas
├── assets/                        # Imágenes, iconos, etc.
├── environments/                  # Configuración de entornos
└── styles.scss                    # Estilos globales

package.json                       # Dependencias y scripts
angular.json                       # Configuración Angular CLI
tsconfig.json                      # Configuración TypeScript
```

---

## 📦 DEPENDENCIAS PRINCIPALES

```json
{
  "@angular/core": "^19.2.0",
  "@angular/material": "^19.2.19",
  "@angular/router": "^19.2.0",
  "@angular/forms": "^19.2.0",
  "rxjs": "^7.8.0",
  "typescript": "~5.7.2"
}
```

---

## 🔍 TROUBLESHOOTING

### Problema: "Cannot GET /"

**Causa:** El servidor de desarrollo no está corriendo.

**Solución:**
```bash
npm start
```

---

### Problema: "Error al conectar con el backend"

**Causa:** Backend no disponible o URL incorrecta.

**Solución:**
1. Verificar que el backend esté corriendo: `https://render-test-php-1.onrender.com/api.php?resource=categorias`
2. Revisar `environment.ts` → `apiUrl`

---

### Problema: "Module not found" después de `git pull`

**Causa:** Nuevas dependencias añadidas.

**Solución:**
```bash
npm install
```

---

### Problema: "Port 4200 already in use"

**Causa:** Otro proceso usa el puerto 4200.

**Solución:**
```bash
# Opción 1: Usar otro puerto
ng serve --port 4201

# Opción 2: Matar proceso en puerto 4200 (Windows)
netstat -ano | findstr :4200
taskkill /PID <PID> /F
```

---

## 📊 ESTADO DEL PROYECTO (PEC2)

### Frontend: ✅ **95% IMPLEMENTADO**

**Módulos completados:**
- ✅ **Autenticación completa** (login, registro, guards, interceptores)
- ✅ **CRUD Habilidades** (crear, editar, pausar, eliminar, filtros)
- ✅ **Sistema de Intercambios end-to-end** (proponer, aceptar, rechazar, completar)
- ✅ **Sistema de Valoraciones** (modal con estrellas, comentarios, validación)
- ✅ **Mensajería** (conversaciones, enviar mensajes)
- ✅ **Panel Administración** (usuarios, reportes, estadísticas)
- ✅ **Notificaciones** (lista, marcar leídas, badge contador)
- ✅ **Responsive Design** (móvil, tablet, desktop)
- ✅ **Material Design** (componentes Angular Material)
- ✅ **Lazy Loading** (módulos cargados bajo demanda)
- ✅ **Reactive Forms** (validación en tiempo real)

---

## 📚 DOCUMENTACIÓN ADICIONAL

### Documentos técnicos incluidos:

| Documento | Descripción |
|-----------|-------------|
| **`../README_PEC2.md`** | Guía general del proyecto completo |
| **`../backend/README.md`** | Documentación del backend API |
| **`../TESTING_Y_ENDPOINTS_TFM.md`** | Testing exhaustivo de endpoints |

### Recursos externos:

- [Angular Docs](https://angular.dev)
- [Angular Material](https://material.angular.io/)
- [TypeScript Docs](https://www.typescriptlang.org/docs/)
- [RxJS](https://rxjs.dev/)

---

## 📞 CONTACTO Y SOPORTE

**Autor:** Antonio Campos  
**Email:** toni.vendecasa@gmail.com  
**Universidad:** Universitat Oberta de Catalunya (UOC)  
**Proyecto:** Trabajo Final de Máster (TFM)  
**Asignatura:** Desarrollo de Sitios y Aplicaciones Web  
**Periodo:** Octubre-Noviembre 2025

**Repositorio GitHub:** [tonikampos/render-test-php](https://github.com/tonikampos/render-test-php)

---

## ⚖️ LICENCIA

Este proyecto es un Trabajo Final de Máster para la UOC con fines académicos.

- **Código fuente:** Propiedad de Antonio Campos
- **Uso:** Exclusivamente educativo
- **Redistribución:** No permitida sin autorización

---

**🎓 Desarrollado como parte del Trabajo Final de Máster (TFM) - PEC2**

**Estado:** ✅ Frontend operativo y listo para evaluación
