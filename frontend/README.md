# 🎨 GALITROCO - Frontend Angular# 🎨 GALITROCO - Frontend Angular# Frontend



**Autor:** Antonio Campos  

**Universidad:** Universitat Oberta de Catalunya (UOC)  

**Asignatura:** Trabajo Final de Máster (PEC2)  **Autor:** Antonio Campos  This project was generated using [Angular CLI](https://github.com/angular/angular-cli) version 19.2.0.

**Fecha:** Octubre-Noviembre 2025

**Universidad:** Universitat Oberta de Catalunya (UOC)  

---

**Asignatura:** Trabajo Final de Máster (PEC2)  ## Development server

## 📋 DESCRIPCIÓN

**Fecha:** Octubre-Noviembre 2025

Frontend web desarrollado en **Angular 19** para GaliTroco, una plataforma de intercambio de habilidades y servicios. Consume la API REST del backend para gestionar usuarios, habilidades, intercambios, mensajería y valoraciones.

To start a local development server, run:

**Estado del frontend:** ✅ **95% implementado** (todas las funcionalidades principales operativas)

---

---

```bash

## 🛠️ STACK TECNOLÓGICO FRONTEND

## 📋 DESCRIPCIÓNng serve

| Componente | Tecnología | Versión |

|------------|------------|---------|```

| **Framework** | Angular | 19.2.0 |

| **Lenguaje** | TypeScript | 5.7.2 |Frontend web desarrollado en **Angular 19** para GaliTroco, una plataforma de intercambio de habilidades y servicios. Consume la API REST del backend para gestionar usuarios, habilidades, intercambios, mensajería y valoraciones.

| **UI Library** | Angular Material | 19.2.19 |

| **HTTP Client** | HttpClient | Con RxJS 7.8 |Once the server is running, open your browser and navigate to `http://localhost:4200/`. The application will automatically reload whenever you modify any of the source files.

| **Routing** | Angular Router | 19.2.0 |

| **Forms** | Reactive Forms | Angular Forms |**Estado del frontend:** ✅ **95% implementado** (todas las funcionalidades principales operativas)

| **Build Tool** | Angular CLI | 19.2.0 |

| **Package Manager** | npm | 10.9.2 |## Code scaffolding

| **Node Runtime** | Node.js | 18.20.5 |

| **Hosting** | Render.com | Static Site |---



### Características principales:Angular CLI includes powerful code scaffolding tools. To generate a new component, run:

- ✅ **Diseño responsive** (Mobile, Tablet, Desktop)

- ✅ **Material Design** (componentes Angular Material)## 🛠️ STACK TECNOLÓGICO FRONTEND

- ✅ **Autenticación persistente** (guards y interceptores)

- ✅ **Recuperación de contraseña segura** mediante correo electrónico```bash

- ✅ **Lazy Loading** de módulos por rutas

- ✅ **Reactive Forms** con validación en tiempo real| Componente | Tecnología | Versión |ng generate component component-name

- ✅ **RxJS** para gestión de estado y observables

- ✅ **Interceptores HTTP** para manejo de errores y autenticación|------------|------------|---------|```



---| **Framework** | Angular | 19.2.0 |



## 🌐 URL DEL FRONTEND DESPLEGADO| **Lenguaje** | TypeScript | 5.7.2 |For a complete list of available schematics (such as `components`, `directives`, or `pipes`), run:



### Producción (Render.com) - **RECOMENDADO PARA PRUEBAS PEC2**| **UI Library** | Angular Material | 19.2.19 |



```| **HTTP Client** | HttpClient | Con RxJS 7.8 |```bash

https://galitroco-frontend.onrender.com

```| **Routing** | Angular Router | 19.2.0 |ng generate --help



**Estado:** ✅ Operativo 24/7  | **Forms** | Reactive Forms | Angular Forms |```

**Deploy:** Automático desde GitHub (branch `main`)  

**Backend API:** https://render-test-php-1.onrender.com/api.php| **Build Tool** | Angular CLI | 19.2.0 |



> **Nota:** El frontend consume la API REST del backend desplegada en Render.| **Package Manager** | npm | 10.9.2 |## Building



---| **Node Runtime** | Node.js | 18.20.5 |



## 👤 CREDENCIALES DE PRUEBA| **Hosting** | Render.com | Static Site |To build the project run:



Utiliza estos usuarios para probar la aplicación:



### Usuario A (Intercambios)### Características principales:```bash

```

Email:    test_6937@testmail.com- ✅ **Diseño responsive** (Mobile, Tablet, Desktop)ng build

Password: Pass123456

ID:       21- ✅ **Material Design** (componentes Angular Material)```

Rol:      usuario

```- ✅ **Autenticación persistente** (guards y interceptores)



### Usuario B (Intercambios)- ✅ **Lazy Loading** de módulos por rutasThis will compile your project and store the build artifacts in the `dist/` directory. By default, the production build optimizes your application for performance and speed.

```

Email:    userB_6566@testing.com- ✅ **Reactive Forms** con validación en tiempo real

Password: Pass123456

ID:       23- ✅ **RxJS** para gestión de estado y observables## Running unit tests

Rol:      usuario

```- ✅ **Interceptores HTTP** para manejo de errores y autenticación



### Administrador (Panel Admin)To execute unit tests with the [Karma](https://karma-runner.github.io) test runner, use the following command:

```

Email:    admin@galitroco.com---

Password: Admin123456

Rol:      administrador```bash

```

## 🌐 URL DEL FRONTEND DESPLEGADOng test

---

```

## 🧪 CÓMO PROBAR EL FRONTEND (RECOMENDADO PARA PEC2)

### Producción (Render.com) - **RECOMENDADO PARA PRUEBAS PEC2**

### ⚡ Opción 1: Acceso Directo a Producción - **MÁS RÁPIDO**

## Running end-to-end tests

**No requiere instalación local.** Simplemente abre el navegador:

```

```

https://galitroco-frontend.onrender.comhttps://galitroco-frontend.onrender.comFor end-to-end (e2e) testing, run:

```

```

#### Ventajas:

- ✅ **Cero configuración** - Solo necesitas un navegador```bash

- ✅ **Datos reales** - Base de datos Supabase con datos de prueba

- ✅ **Última versión** - Auto-deploy desde GitHub**Estado:** ✅ Operativo 24/7  ng e2e

- ⏱️ **Tiempo de prueba:** 20-30 minutos (flujo completo)

**Deploy:** Automático desde GitHub (branch `main`)  ```

---

**Backend API:** https://render-test-php-1.onrender.com/api.php

## 📋 GUÍA DE PRUEBAS PASO A PASO

Angular CLI does not come with an end-to-end testing framework by default. You can choose one that suits your needs.

### 🔐 1. AUTENTICACIÓN (3 minutos)

> **Nota:** El frontend consume la API REST del backend desplegada en Render.

#### 1.1 Probar Login

1. Ir a: `https://galitroco-frontend.onrender.com/login`## Additional Resources

2. Ingresar credenciales:

   - Email: `test_6937@testmail.com`---

   - Password: `Pass123456`

3. Click en **"Iniciar sesión"**For more information on using the Angular CLI, including detailed command references, visit the [Angular CLI Overview and Command Reference](https://angular.dev/tools/cli) page.

4. **Resultado esperado:** Redirección al dashboard

## 👤 CREDENCIALES DE PRUEBA

#### 1.2 Probar Registro

1. Ir a: `https://galitroco-frontend.onrender.com/registro`Utiliza estos usuarios para probar la aplicación:

2. Completar formulario:

   - Nombre de usuario: `evaluador_test_` + timestamp### Usuario A (Intercambios)

   - Email: `evaluador@test.com````

   - Contraseña: `Test123456`Email:    test_6937@testmail.com

   - Confirmar contraseña: `Test123456`Password: Pass123456

   - Ubicación: `A Coruña`ID:       21

3. Click en **"Registrarse"**Rol:      usuario

4. **Resultado esperado:** Registro exitoso + redirección al login```



#### 1.3 Verificar Persistencia de Sesión### Usuario B (Intercambios)

1. Cerrar navegador completamente```

2. Abrir navegador y volver a: `https://galitroco-frontend.onrender.com`Email:    userB_6566@testing.com

3. **Resultado esperado:** Usuario sigue autenticado (sesión persiste)Password: Pass123456

ID:       23

#### 1.4 Probar LogoutRol:      usuario

1. Click en icono de usuario (esquina superior derecha)```

2. Click en **"Cerrar sesión"**

3. **Resultado esperado:** Redirección a login + sesión cerrada### Administrador (Panel Admin)

```

---Email:    admin@galitroco.com

Password: Admin123456

### 🔑 2. RECUPERACIÓN DE CONTRASEÑA (3 minutos)Rol:      administrador

```

**Funcionalidad completa de recuperación de contraseña mediante email.**

---

#### 2.1 Solicitar Recuperación

1. Ir a: `https://galitroco-frontend.onrender.com/login`## 🧪 CÓMO PROBAR EL FRONTEND (RECOMENDADO PARA PEC2)

2. Click en el enlace **"¿Olvidaste tu contraseña?"**

3. En la página de recuperación, ingresar email:### ⚡ Opción 1: Acceso Directo a Producción - **MÁS RÁPIDO**

   - Email: `test_6937@testmail.com`

4. Click en **"Enviar instrucciones"****No requiere instalación local.** Simplemente abre el navegador:

5. **Resultado esperado:**

   - Mensaje de confirmación: "Si el email está registrado, recibirás instrucciones"```

   - Email enviado al correo registradohttps://galitroco-frontend.onrender.com

```

#### 2.2 Recibir Email de Recuperación

1. Revisar la bandeja de entrada del email registrado#### Ventajas:

2. **Resultado esperado:**- ✅ **Cero configuración** - Solo necesitas un navegador

   - Email recibido con asunto: "Recuperación de Contraseña - GaliTroco"- ✅ **Datos reales** - Base de datos Supabase con datos de prueba

   - Contiene un enlace del tipo: `https://galitroco-frontend.onrender.com/reset-password?token=abc123...`- ✅ **Última versión** - Auto-deploy desde GitHub

   - El enlace es válido por **1 hora**- ⏱️ **Tiempo de prueba:** 20-30 minutos (flujo completo)



#### 2.3 Restablecer Contraseña---

1. Click en el enlace del email (o copiar/pegar en navegador)

2. Serás redirigido a: `https://galitroco-frontend.onrender.com/reset-password?token=...`## 📋 GUÍA DE PRUEBAS PASO A PASO

3. En el formulario de reseteo, ingresar:

   - Nueva contraseña: `NuevaPass123456`### 🔐 1. AUTENTICACIÓN (3 minutos)

   - Confirmar contraseña: `NuevaPass123456`

4. Click en **"Cambiar contraseña"**#### 1.1 Probar Login

5. **Resultado esperado:**1. Ir a: `https://galitroco-frontend.onrender.com/login`

   - Mensaje de éxito: "Contraseña actualizada correctamente"2. Ingresar credenciales:

   - Redirección automática al login   - Email: `test_6937@testmail.com`

   - Password: `Pass123456`

#### 2.4 Probar Login con Nueva Contraseña3. Click en **"Iniciar sesión"**

1. En la página de login, ingresar:4. **Resultado esperado:** Redirección al dashboard

   - Email: `test_6937@testmail.com`

   - Password: `NuevaPass123456` (la nueva)#### 1.2 Probar Registro

2. Click en **"Iniciar sesión"**1. Ir a: `https://galitroco-frontend.onrender.com/registro`

3. **Resultado esperado:**2. Completar formulario:

   - Login exitoso con la nueva contraseña   - Nombre de usuario: `evaluador_test_` + timestamp

   - Acceso completo a la aplicación   - Email: `evaluador@test.com`

   - Contraseña: `Test123456`

**✅ Funcionalidad Validada:**   - Confirmar contraseña: `Test123456`

- ✅ Email enviado correctamente (vía Resend API)   - Ubicación: `A Coruña`

- ✅ Token único y seguro3. Click en **"Registrarse"**

- ✅ Validación de expiración (1 hora)4. **Resultado esperado:** Registro exitoso + redirección al login

- ✅ Formulario de reseteo con validaciones

- ✅ Contraseña actualizada en base de datos#### 1.3 Verificar Persistencia de Sesión

- ✅ Login inmediato con nueva contraseña1. Cerrar navegador completamente

2. Abrir navegador y volver a: `https://galitroco-frontend.onrender.com`

---3. **Resultado esperado:** Usuario sigue autenticado (sesión persiste)



### 🎯 3. GESTIÓN DE HABILIDADES (5 minutos)#### 1.4 Probar Logout

1. Click en icono de usuario (esquina superior derecha)

#### 3.1 Ver Catálogo Público2. Click en **"Cerrar sesión"**

1. Login como `test_6937@testmail.com`3. **Resultado esperado:** Redirección a login + sesión cerrada

2. Ir a: **"Explorar Habilidades"** (menú lateral o navbar)

3. **Resultado esperado:** ---

   - Lista de habilidades públicas

   - Filtros por categoría### 🎯 2. GESTIÓN DE HABILIDADES (5 minutos)

   - Buscador por palabra clave

   - Tarjetas con información (título, categoría, usuario, ubicación)#### 2.1 Ver Catálogo Público

1. Login como `test_6937@testmail.com`

#### 3.2 Filtrar por Categoría2. Ir a: **"Explorar Habilidades"** (menú lateral o navbar)

1. En "Explorar Habilidades", seleccionar categoría: `Tecnología e Informática`3. **Resultado esperado:** 

2. **Resultado esperado:** Solo habilidades de esa categoría   - Lista de habilidades públicas

   - Filtros por categoría

#### 3.3 Buscar por Palabra Clave   - Buscador por palabra clave

1. En el buscador, escribir: `inglés`   - Tarjetas con información (título, categoría, usuario, ubicación)

2. **Resultado esperado:** Habilidades que contengan "inglés" en título o descripción

#### 2.2 Filtrar por Categoría

#### 3.4 Ver Detalle de Habilidad1. En "Explorar Habilidades", seleccionar categoría: `Tecnología e Informática`

1. Click en una tarjeta de habilidad2. **Resultado esperado:** Solo habilidades de esa categoría

2. **Resultado esperado:** 

   - Modal/página con información completa#### 2.3 Buscar por Palabra Clave

   - Título, descripción, categoría, duración estimada1. En el buscador, escribir: `inglés`

   - Información del usuario propietario2. **Resultado esperado:** Habilidades que contengan "inglés" en título o descripción

   - Botón **"Proponer Intercambio"** (si no es tuya)

#### 2.4 Ver Detalle de Habilidad

#### 3.5 Crear Nueva Habilidad1. Click en una tarjeta de habilidad

1. Ir a: **"Mis Habilidades"** → **"Nueva Habilidad"**2. **Resultado esperado:** 

2. Completar formulario:   - Modal/página con información completa

   - Tipo: `Oferta`   - Título, descripción, categoría, duración estimada

   - Categoría: `Tecnología e Informática`   - Información del usuario propietario

   - Título: `Clases de Python para principiantes`   - Botón **"Proponer Intercambio"** (si no es tuya)

   - Descripción: `Enseño programación en Python desde cero, orientado a objetos y aplicaciones web`

   - Duración estimada: `60` minutos#### 2.5 Crear Nueva Habilidad

3. Click en **"Publicar"**1. Ir a: **"Mis Habilidades"** → **"Nueva Habilidad"**

4. **Resultado esperado:** 2. Completar formulario:

   - Mensaje de éxito   - Tipo: `Oferta`

   - Habilidad visible en "Mis Habilidades"   - Categoría: `Tecnología e Informática`

   - Estado: `Activa`   - Título: `Clases de Python para principiantes`

   - Descripción: `Enseño programación en Python desde cero, orientado a objetos y aplicaciones web`

#### 3.6 Editar Habilidad   - Duración estimada: `60` minutos

1. En "Mis Habilidades", click en **icono de editar** (lápiz) de la habilidad recién creada3. Click en **"Publicar"**

2. Modificar el título: `Clases de Python avanzado + Django`4. **Resultado esperado:** 

3. Click en **"Guardar cambios"**   - Mensaje de éxito

4. **Resultado esperado:** Cambios reflejados inmediatamente   - Habilidad visible en "Mis Habilidades"

   - Estado: `Activa`

#### 3.7 Pausar/Activar Habilidad

1. Click en botón **"Pausar"** de una habilidad#### 2.6 Editar Habilidad

2. **Resultado esperado:** 1. En "Mis Habilidades", click en **icono de editar** (lápiz) de la habilidad recién creada

   - Estado cambia a `Pausada`2. Modificar el título: `Clases de Python avanzado + Django`

   - No visible en búsquedas públicas3. Click en **"Guardar cambios"**

   - Chip/badge muestra "Pausada"4. **Resultado esperado:** Cambios reflejados inmediatamente

3. Click en **"Activar"** nuevamente

4. **Resultado esperado:** Estado vuelve a `Activa`#### 2.7 Pausar/Activar Habilidad

1. Click en botón **"Pausar"** de una habilidad

---2. **Resultado esperado:** 

   - Estado cambia a `Pausada`

### 🔄 4. SISTEMA DE INTERCAMBIOS COMPLETO (10 minutos)   - No visible en búsquedas públicas

   - Chip/badge muestra "Pausada"

#### 4.1 Proponer Intercambio (Usuario A)3. Click en **"Activar"** nuevamente

1. Login como `test_6937@testmail.com`4. **Resultado esperado:** Estado vuelve a `Activa`

2. Ir a **"Explorar Habilidades"**

3. Buscar una habilidad que te interese (de otro usuario)---

4. Click en la habilidad → **"Proponer Intercambio"**

5. En el diálogo:### 🔄 3. SISTEMA DE INTERCAMBIOS COMPLETO (10 minutos)

   - Seleccionar **tu habilidad** a ofrecer (dropdown)

   - Escribir mensaje: `Hola, me interesa tu habilidad. ¿Podemos intercambiar?`#### 3.1 Proponer Intercambio (Usuario A)

6. Click en **"Enviar Propuesta"**1. Login como `test_6937@testmail.com`

7. **Resultado esperado:**2. Ir a **"Explorar Habilidades"**

   - Mensaje de confirmación3. Buscar una habilidad que te interese (de otro usuario)

   - Propuesta visible en **"Mis Intercambios"** → Pestaña **"Enviados"**4. Click en la habilidad → **"Proponer Intercambio"**

   - Estado: `Propuesto`5. En el diálogo:

   - Seleccionar **tu habilidad** a ofrecer (dropdown)

#### 4.2 Ver Propuestas Recibidas (Usuario B)   - Escribir mensaje: `Hola, me interesa tu habilidad. ¿Podemos intercambiar?`

1. **Cerrar sesión** de Usuario A6. Click en **"Enviar Propuesta"**

2. Login como `userB_6566@testing.com`7. **Resultado esperado:**

3. Ir a **"Mis Intercambios"** → Pestaña **"Recibidos"**   - Mensaje de confirmación

4. **Resultado esperado:**   - Propuesta visible en **"Mis Intercambios"** → Pestaña **"Enviados"**

   - Ver la propuesta recibida   - Estado: `Propuesto`

   - Información completa: habilidades, usuario proponente, mensaje

   - Botones: **"Aceptar"** y **"Rechazar"**#### 3.2 Ver Propuestas Recibidas (Usuario B)

1. **Cerrar sesión** de Usuario A

#### 4.3 Aceptar Propuesta2. Login como `userB_6566@testing.com`

1. Click en **"Aceptar"** en la propuesta recibida3. Ir a **"Mis Intercambios"** → Pestaña **"Recibidos"**

2. Confirmar en el diálogo4. **Resultado esperado:**

3. **Resultado esperado:**   - Ver la propuesta recibida

   - Estado cambia a `Aceptado`   - Información completa: habilidades, usuario proponente, mensaje

   - Chip/badge color verde   - Botones: **"Aceptar"** y **"Rechazar"**

   - Aparece botón **"Ver Conversación"**

   - Aparece botón **"Marcar como Completado"**#### 3.3 Aceptar Propuesta

1. Click en **"Aceptar"** en la propuesta recibida

#### 4.4 Completar Intercambio2. Confirmar en el diálogo

1. En un intercambio **Aceptado**, click en **"Marcar como Completado"**3. **Resultado esperado:**

2. Confirmar acción   - Estado cambia a `Aceptado`

3. **Resultado esperado:**   - Chip/badge color verde

   - Estado cambia a `Completado`   - Aparece botón **"Ver Conversación"**

   - Chip/badge color azul   - Aparece botón **"Marcar como Completado"**

   - Aparece botón **"Valorar Usuario"**

#### 3.4 Completar Intercambio

#### 4.5 Valorar Usuario1. En un intercambio **Aceptado**, click en **"Marcar como Completado"**

1. Click en **"Valorar Usuario"**2. Confirmar acción

2. En el diálogo de valoración:3. **Resultado esperado:**

   - Seleccionar puntuación: **5 estrellas** (click en las estrellas)   - Estado cambia a `Completado`

   - Escribir comentario: `Excelente experiencia, muy profesional y puntual`   - Chip/badge color azul

3. Click en **"Enviar Valoración"**   - Aparece botón **"Valorar Usuario"**

4. **Resultado esperado:**

   - Mensaje de éxito#### 3.5 Valorar Usuario

   - Valoración registrada1. Click en **"Valorar Usuario"**

   - Ya no se puede valorar de nuevo2. En el diálogo de valoración:

   - Seleccionar puntuación: **5 estrellas** (click en las estrellas)

---   - Escribir comentario: `Excelente experiencia, muy profesional y puntual`

3. Click en **"Enviar Valoración"**

### 🔍 5. BÚSQUEDA Y FILTROS (3 minutos)4. **Resultado esperado:**

   - Mensaje de éxito

#### 5.1 Filtrar por Tipo (Oferta/Demanda)   - Valoración registrada

1. En "Explorar Habilidades", seleccionar filtro: `Solo Ofertas`   - Ya no se puede valorar de nuevo

2. **Resultado esperado:** Solo habilidades tipo "Oferta"

---

#### 5.2 Filtrar por Ubicación

1. Seleccionar: `Santiago de Compostela`### 🔍 4. BÚSQUEDA Y FILTROS (3 minutos)

2. **Resultado esperado:** Solo usuarios de Santiago

#### 4.1 Filtrar por Tipo (Oferta/Demanda)

#### 5.3 Combinar Filtros1. En "Explorar Habilidades", seleccionar filtro: `Solo Ofertas`

1. Seleccionar categoría: `Clases y Formación`2. **Resultado esperado:** Solo habilidades tipo "Oferta"

2. Escribir en buscador: `inglés`

3. Tipo: `Oferta`#### 4.2 Filtrar por Ubicación

4. **Resultado esperado:** Habilidades que cumplan todos los criterios1. Seleccionar: `Santiago de Compostela`

2. **Resultado esperado:** Solo usuarios de Santiago

---

#### 4.3 Combinar Filtros

### 👮 6. PANEL DE ADMINISTRACIÓN (Solo Admin - 5 minutos)1. Seleccionar categoría: `Clases y Formación`

2. Escribir en buscador: `inglés`

#### 6.1 Acceso al Panel3. Tipo: `Oferta`

1. **Cerrar sesión** de usuario normal4. **Resultado esperado:** Habilidades que cumplan todos los criterios

2. Login como `admin@galitroco.com` / `Admin123456`

3. Ir a **"Panel de Administración"** (menú lateral)---

4. **Resultado esperado:** 

   - Acceso permitido (solo admins)### 👮 5. PANEL DE ADMINISTRACIÓN (Solo Admin - 5 minutos)

   - Dashboard con widgets de estadísticas

#### 5.1 Acceso al Panel

#### 6.2 Ver Estadísticas1. **Cerrar sesión** de usuario normal

1. En el dashboard admin, verificar widgets:2. Login como `admin@galitroco.com` / `Admin123456`

   - **Total de usuarios registrados**3. Ir a **"Panel de Administración"** (menú lateral)

   - **Total de habilidades publicadas**4. **Resultado esperado:** 

   - **Intercambios completados**   - Acceso permitido (solo admins)

   - **Valoración promedio de la plataforma**   - Dashboard con widgets de estadísticas

2. **Resultado esperado:** Estadísticas en tiempo real desde la BD

#### 5.2 Ver Estadísticas

#### 6.3 Gestionar Usuarios1. En el dashboard admin, verificar widgets:

1. Ir a pestaña **"Usuarios"** en el panel admin   - **Total de usuarios registrados**

2. **Resultado esperado:**   - **Total de habilidades publicadas**

   - Tabla con todos los usuarios   - **Intercambios completados**

   - Columnas: ID, Nombre, Email, Rol, Estado, Fecha registro   - **Valoración promedio de la plataforma**

   - Filtros y buscador2. **Resultado esperado:** Estadísticas en tiempo real desde la BD



---#### 5.3 Gestionar Usuarios

1. Ir a pestaña **"Usuarios"** en el panel admin

## ✅ CHECKLIST DE VERIFICACIÓN FRONTEND2. **Resultado esperado:**

   - Tabla con todos los usuarios

Marca cada funcionalidad después de probarla:   - Columnas: ID, Nombre, Email, Rol, Estado, Fecha registro

   - Filtros y buscador

### **Autenticación:**

- [ ] Login con credenciales correctas---

- [ ] Registro de nuevo usuario

- [ ] Recuperación de contraseña (solicitar)## ✅ CHECKLIST DE VERIFICACIÓN FRONTEND

- [ ] Reseteo de contraseña (con token)

- [ ] Validación de formularios (campos vacíos, email inválido, etc.)Marca cada funcionalidad después de probarla:

- [ ] Persistencia de sesión (refresh de página)

- [ ] Logout funciona correctamente### **Autenticación:**

- [ ] Login con credenciales correctas

### **Habilidades:**- [ ] Registro de nuevo usuario

- [ ] Ver catálogo público (sin login)- [ ] Validación de formularios (campos vacíos, email inválido, etc.)

- [ ] Crear nueva habilidad (tipo oferta/demanda)- [ ] Persistencia de sesión (refresh de página)

- [ ] Editar habilidad propia- [ ] Logout funciona correctamente

- [ ] Pausar/Activar habilidad

- [ ] Ver detalle de habilidad### **Habilidades:**

- [ ] Filtrar por categoría- [ ] Ver catálogo público (sin login)

- [ ] Buscar por palabra clave- [ ] Crear nueva habilidad (tipo oferta/demanda)

- [ ] Editar habilidad propia

### **Intercambios:**- [ ] Pausar/Activar habilidad

- [ ] Proponer intercambio- [ ] Ver detalle de habilidad

- [ ] Ver propuestas enviadas- [ ] Filtrar por categoría

- [ ] Ver propuestas recibidas- [ ] Buscar por palabra clave

- [ ] Aceptar propuesta (solo receptor)

- [ ] Rechazar propuesta (solo receptor)### **Intercambios:**

- [ ] Marcar como completado- [ ] Proponer intercambio

- [ ] Estados visuales correctos (chips de colores)- [ ] Ver propuestas enviadas

- [ ] Ver propuestas recibidas

### **Valoraciones:**- [ ] Aceptar propuesta (solo receptor)

- [ ] Valorar usuario después de intercambio completado- [ ] Rechazar propuesta (solo receptor)

- [ ] Sistema de estrellas (1-5) funciona- [ ] Marcar como completado

- [ ] Comentario se guarda correctamente- [ ] Estados visuales correctos (chips de colores)

- [ ] No se puede valorar dos veces el mismo intercambio

### **Valoraciones:**

### **Panel Admin:**- [ ] Valorar usuario después de intercambio completado

- [ ] Solo admins acceden al panel- [ ] Sistema de estrellas (1-5) funciona

- [ ] Usuarios normales ven error 403- [ ] Comentario se guarda correctamente

- [ ] Estadísticas se calculan correctamente- [ ] No se puede valorar dos veces el mismo intercambio

- [ ] Listar todos los usuarios

### **Panel Admin:**

### **UI/UX:**- [ ] Solo admins acceden al panel

- [ ] Diseño responsive (móvil, tablet, desktop)- [ ] Usuarios normales ven error 403

- [ ] Material Design consistente- [ ] Estadísticas se calculan correctamente

- [ ] Validación de formularios en tiempo real- [ ] Listar todos los usuarios

- [ ] Mensajes de error/éxito claros

### **UI/UX:**

---- [ ] Diseño responsive (móvil, tablet, desktop)

- [ ] Material Design consistente

## 🔧 INSTALACIÓN LOCAL (Opcional)- [ ] Validación de formularios en tiempo real

- [ ] Mensajes de error/éxito claros

### Prerrequisitos:

- Node.js 18+ (recomendado: 18.20.5)---

- npm 10+

- Git## 🔧 INSTALACIÓN LOCAL (Opcional)



### Pasos:### Prerrequisitos:

- Node.js 18+ (recomendado: 18.20.5)

#### 1. Clonar repositorio- npm 10+

```bash- Git

git clone https://github.com/tonikampos/render-test-php.git

cd render-test-php/frontend### Pasos:

```

#### 1. Clonar repositorio

#### 2. Instalar dependencias```bash

```bashgit clone https://github.com/tonikampos/render-test-php.git

npm installcd render-test-php/frontend

``````



**Tiempo estimado:** 2-3 minutos#### 2. Instalar dependencias

```bash

#### 3. Configurar URL del backend (Opcional)npm install

```

El frontend está configurado para usar el backend de **producción** por defecto.

**Tiempo estimado:** 2-3 minutos

**Archivo:** `src/environments/environment.ts`

#### 3. Configurar URL del backend (Opcional)

```typescript

export const environment = {El frontend está configurado para usar el backend de **producción** por defecto.

  production: false,

  // Backend en Render (por defecto)**Archivo:** `src/environments/environment.ts`

  apiUrl: 'https://render-test-php-1.onrender.com/api.php'

  ```typescript

  // O backend local (si lo tienes corriendo):export const environment = {

  // apiUrl: 'http://localhost/probatfm/backend/api/api.php'  production: false,

};  // Backend en Render (por defecto)

```  apiUrl: 'https://render-test-php-1.onrender.com/api.php'

  

#### 4. Iniciar servidor de desarrollo  // O backend local (si lo tienes corriendo):

```bash  // apiUrl: 'http://localhost/probatfm/backend/api/api.php'

npm start};

``````



**O bien:**#### 4. Iniciar servidor de desarrollo

```bash```bash

ng servenpm start

``````



El frontend estará disponible en: `http://localhost:4200`**O bien:**

```bash

**Auto-reload:** El navegador se recarga automáticamente al guardar cambios.ng serve

```

#### 5. Build de producción (Opcional)

```bashEl frontend estará disponible en: `http://localhost:4200`

npm run build:prod

```**Auto-reload:** El navegador se recarga automáticamente al guardar cambios.



**Output:** Archivos estáticos en `dist/frontend/browser/`#### 5. Build de producción (Opcional)

```bash

---npm run build:prod

```

## 🏗️ ARQUITECTURA DEL FRONTEND

**Output:** Archivos estáticos en `dist/frontend/browser/`

```

frontend/src/---

├── app/

│   ├── core/                      # Servicios singleton y guards## 🏗️ ARQUITECTURA DEL FRONTEND

│   │   ├── services/

│   │   │   ├── auth.service.ts    # Autenticación```

│   │   │   ├── habilidades.service.tsfrontend/src/

│   │   │   ├── intercambios.service.ts├── app/

│   │   │   └── valoraciones.service.ts│   ├── core/                      # Servicios singleton y guards

│   │   ├── guards/│   │   ├── services/

│   │   │   ├── auth.guard.ts      # Protege rutas privadas│   │   │   ├── auth.service.ts    # Autenticación

│   │   │   └── admin.guard.ts     # Protege rutas admin│   │   │   ├── habilidades.service.ts

│   │   └── interceptors/│   │   │   ├── intercambios.service.ts

│   │       └── http.interceptor.ts # Manejo de errores HTTP│   │   │   └── valoraciones.service.ts

│   ├── shared/                    # Componentes compartidos│   │   ├── guards/

│   │   ├── navbar/│   │   │   ├── auth.guard.ts      # Protege rutas privadas

│   │   ├── sidebar/│   │   │   └── admin.guard.ts     # Protege rutas admin

│   │   └── ...│   │   └── interceptors/

│   ├── features/                  # Módulos por funcionalidad│   │       └── http.interceptor.ts # Manejo de errores HTTP

│   │   ├── auth/│   ├── shared/                    # Componentes compartidos

│   │   ├── habilidades/│   │   ├── navbar/

│   │   ├── intercambios/│   │   ├── sidebar/

│   │   ├── valoraciones/│   │   └── ...

│   │   └── admin/│   ├── features/                  # Módulos por funcionalidad

│   └── app.routes.ts              # Configuración de rutas│   │   ├── auth/

├── assets/                        # Imágenes, iconos, etc.│   │   ├── habilidades/

├── environments/                  # Configuración de entornos│   │   ├── intercambios/

└── styles.scss                    # Estilos globales│   │   ├── valoraciones/

│   │   └── admin/

package.json                       # Dependencias y scripts│   └── app.routes.ts              # Configuración de rutas

angular.json                       # Configuración Angular CLI├── assets/                        # Imágenes, iconos, etc.

tsconfig.json                      # Configuración TypeScript├── environments/                  # Configuración de entornos

```└── styles.scss                    # Estilos globales



---package.json                       # Dependencias y scripts

angular.json                       # Configuración Angular CLI

## 📦 DEPENDENCIAS PRINCIPALEStsconfig.json                      # Configuración TypeScript

```

```json

{---

  "@angular/core": "^19.2.0",

  "@angular/material": "^19.2.19",## 📦 DEPENDENCIAS PRINCIPALES

  "@angular/router": "^19.2.0",

  "@angular/forms": "^19.2.0",```json

  "rxjs": "^7.8.0",{

  "typescript": "~5.7.2"  "@angular/core": "^19.2.0",

}  "@angular/material": "^19.2.19",

```  "@angular/router": "^19.2.0",

  "@angular/forms": "^19.2.0",

---  "rxjs": "^7.8.0",

  "typescript": "~5.7.2"

## 🔍 TROUBLESHOOTING}

```

### Problema: "Cannot GET /"

---

**Causa:** El servidor de desarrollo no está corriendo.

## 🔍 TROUBLESHOOTING

**Solución:**

```bash### Problema: "Cannot GET /"

npm start

```**Causa:** El servidor de desarrollo no está corriendo.



---**Solución:**

```bash

### Problema: "Error al conectar con el backend"npm start

```

**Causa:** Backend no disponible o URL incorrecta.

---

**Solución:**

1. Verificar que el backend esté corriendo: `https://render-test-php-1.onrender.com/api.php?resource=categorias`### Problema: "Error al conectar con el backend"

2. Revisar `environment.ts` → `apiUrl`

**Causa:** Backend no disponible o URL incorrecta.

---

**Solución:**

### Problema: "Module not found" después de `git pull`1. Verificar que el backend esté corriendo: `https://render-test-php-1.onrender.com/api.php?resource=categorias`

2. Revisar `environment.ts` → `apiUrl`

**Causa:** Nuevas dependencias añadidas.

---

**Solución:**

```bash### Problema: "Module not found" después de `git pull`

npm install

```**Causa:** Nuevas dependencias añadidas.



---**Solución:**

```bash

### Problema: "Port 4200 already in use"npm install

```

**Causa:** Otro proceso usa el puerto 4200.

---

**Solución:**

```bash### Problema: "Port 4200 already in use"

# Opción 1: Usar otro puerto

ng serve --port 4201**Causa:** Otro proceso usa el puerto 4200.



# Opción 2: Matar proceso en puerto 4200 (Windows)**Solución:**

netstat -ano | findstr :4200```bash

taskkill /PID <PID> /F# Opción 1: Usar otro puerto

```ng serve --port 4201



---# Opción 2: Matar proceso en puerto 4200 (Windows)

netstat -ano | findstr :4200

## 📊 ESTADO DEL PROYECTO (PEC2)taskkill /PID <PID> /F

```

### Frontend: ✅ **95% IMPLEMENTADO**

---

**Módulos completados:**

- ✅ **Autenticación completa** (login, registro, guards, interceptores)## 📊 ESTADO DEL PROYECTO (PEC2)

- ✅ **Recuperación de contraseña** (solicitud email + reseteo con token)

- ✅ **CRUD Habilidades** (crear, editar, pausar, eliminar, filtros)### Frontend: ✅ **95% IMPLEMENTADO**

- ✅ **Sistema de Intercambios end-to-end** (proponer, aceptar, rechazar, completar)

- ✅ **Sistema de Valoraciones** (modal con estrellas, comentarios, validación)**Módulos completados:**

- ✅ **Mensajería** (conversaciones, enviar mensajes)- ✅ **Autenticación completa** (login, registro, guards, interceptores)

- ✅ **Panel Administración** (usuarios, reportes, estadísticas)- ✅ **CRUD Habilidades** (crear, editar, pausar, eliminar, filtros)

- ✅ **Notificaciones** (lista, marcar leídas, badge contador)- ✅ **Sistema de Intercambios end-to-end** (proponer, aceptar, rechazar, completar)

- ✅ **Responsive Design** (móvil, tablet, desktop)- ✅ **Sistema de Valoraciones** (modal con estrellas, comentarios, validación)

- ✅ **Material Design** (componentes Angular Material)- ✅ **Mensajería** (conversaciones, enviar mensajes)

- ✅ **Lazy Loading** (módulos cargados bajo demanda)- ✅ **Panel Administración** (usuarios, reportes, estadísticas)

- ✅ **Reactive Forms** (validación en tiempo real)- ✅ **Notificaciones** (lista, marcar leídas, badge contador)

- ✅ **Responsive Design** (móvil, tablet, desktop)

---- ✅ **Material Design** (componentes Angular Material)

- ✅ **Lazy Loading** (módulos cargados bajo demanda)

## 📚 DOCUMENTACIÓN ADICIONAL- ✅ **Reactive Forms** (validación en tiempo real)



### Documentos técnicos incluidos:---



| Documento | Descripción |## 📚 DOCUMENTACIÓN ADICIONAL

|-----------|-------------|

| **`../README_PEC2.md`** | Guía general del proyecto completo |### Documentos técnicos incluidos:

| **`../backend/README.md`** | Documentación del backend API |

| **`../TESTING_Y_ENDPOINTS_TFM.md`** | Testing exhaustivo de endpoints || Documento | Descripción |

|-----------|-------------|

### Recursos externos:| **`../README_PEC2.md`** | Guía general del proyecto completo |

| **`../backend/README.md`** | Documentación del backend API |

- [Angular Docs](https://angular.dev)| **`../TESTING_Y_ENDPOINTS_TFM.md`** | Testing exhaustivo de endpoints |

- [Angular Material](https://material.angular.io/)

- [TypeScript Docs](https://www.typescriptlang.org/docs/)### Recursos externos:

- [RxJS](https://rxjs.dev/)

- [Angular Docs](https://angular.dev)

---- [Angular Material](https://material.angular.io/)

- [TypeScript Docs](https://www.typescriptlang.org/docs/)

## 📞 CONTACTO Y SOPORTE- [RxJS](https://rxjs.dev/)



**Autor:** Antonio Campos  ---

**Email:** toni.vendecasa@gmail.com  

**Universidad:** Universitat Oberta de Catalunya (UOC)  ## 📞 CONTACTO Y SOPORTE

**Proyecto:** Trabajo Final de Máster (TFM)  

**Asignatura:** Desarrollo de Sitios y Aplicaciones Web  **Autor:** Antonio Campos  

**Periodo:** Octubre-Noviembre 2025**Email:** toni.vendecasa@gmail.com  

**Universidad:** Universitat Oberta de Catalunya (UOC)  

**Repositorio GitHub:** [tonikampos/render-test-php](https://github.com/tonikampos/render-test-php)**Proyecto:** Trabajo Final de Máster (TFM)  

**Asignatura:** Desarrollo de Sitios y Aplicaciones Web  

---**Periodo:** Octubre-Noviembre 2025



## ⚖️ LICENCIA**Repositorio GitHub:** [tonikampos/render-test-php](https://github.com/tonikampos/render-test-php)



Este proyecto es un Trabajo Final de Máster para la UOC con fines académicos.---



- **Código fuente:** Propiedad de Antonio Campos## ⚖️ LICENCIA

- **Uso:** Exclusivamente educativo

- **Redistribución:** No permitida sin autorizaciónEste proyecto es un Trabajo Final de Máster para la UOC con fines académicos.



---- **Código fuente:** Propiedad de Antonio Campos

- **Uso:** Exclusivamente educativo

**🎓 Desarrollado como parte del Trabajo Final de Máster (TFM) - PEC2**- **Redistribución:** No permitida sin autorización



**Estado:** ✅ Frontend operativo y listo para evaluación---


**🎓 Desarrollado como parte del Trabajo Final de Máster (TFM) - PEC2**

**Estado:** ✅ Frontend operativo y listo para evaluación
