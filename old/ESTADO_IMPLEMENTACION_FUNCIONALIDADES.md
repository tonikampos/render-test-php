# 📊 ESTADO DE IMPLEMENTACIÓN DE FUNCIONALIDADES
## Proyecto: GaliTroco - Plataforma de Intercambio de Habilidades

**Fecha de Análisis:** 3 de Octubre de 2025  
**Autor:** Antonio Campos  
**Universidad:** UOC - Trabajo Final de Máster

---

## 📋 ÍNDICE

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Épica 1: Gestión de Cuentas y Perfiles](#epica-1)
3. [Épica 2: Gestión de Habilidades](#epica-2)
4. [Épica 3: Búsqueda y Descubrimiento](#epica-3)
5. [Épica 4: Interacción y Mensajería](#epica-4)
6. [Épica 5: Sistema de Reputación](#epica-5)
7. [Épica 6: Panel de Administración](#epica-6)
8. [Requisitos No Funcionales](#requisitos-no-funcionales)
9. [Plan de Implementación Sugerido](#plan-implementacion)
10. [Checklist Pre-Entrega TFM](#checklist-tfm)

---

## 1. RESUMEN EJECUTIVO {#resumen-ejecutivo}

### 🎯 Estado General del Proyecto

```
┌──────────────────────────────────────────────────────────┐
│  PROGRESO GLOBAL:  ████████████░░░░░░░░░  60%           │
└──────────────────────────────────────────────────────────┘

✅ Funcionalidades Completas:     40%
⚠️  Funcionalidades Parciales:    35%
❌ Funcionalidades Pendientes:    25%
```

### 📊 Desglose por Épicas

| Épica | Progreso | Estado |
|-------|----------|--------|
| **1. Gestión de Cuentas** | 80% | 🟢 Casi completa |
| **2. Gestión de Habilidades** | 100% | ✅ Completa |
| **3. Búsqueda y Descubrimiento** | 60% | 🟡 Parcial |
| **4. Interacción y Mensajería** | 20% | 🔴 Crítico |
| **5. Sistema de Reputación** | 30% | 🔴 Pendiente |
| **6. Panel de Administración** | 25% | 🔴 Pendiente |

### ⚠️ **FUNCIONALIDADES CRÍTICAS PARA MVP**
Estas funcionalidades son IMPRESCINDIBLES para presentar el TFM:

1. 🔴 **Sistema de Mensajería** - Sin esto, no hay forma de contactar entre usuarios
2. 🔴 **Gestión de Intercambios** - El núcleo del negocio (proponer/aceptar)
3. 🟡 **Búsqueda Funcional** - Necesaria para encontrar habilidades
4. 🟡 **Panel Admin Básico** - Requerido por el tribunal

---

## 2. ÉPICA 1: Gestión de Cuentas y Perfiles de Usuario {#epica-1}

**Progreso:** ████████████████░░ 80%

### ✅ **RF-1.1: Registro de Usuario**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Frontend: `frontend/src/app/features/auth/register/register.component.ts`
- ✅ Backend: `backend/api/auth.php` (endpoint POST `/api/auth/register`)
- ✅ Base de Datos: Tabla `usuarios` con todos los campos requeridos
- ✅ Validaciones: Email único, contraseña mínima 8 caracteres
- ✅ Seguridad: Bcrypt hash de contraseñas (cost factor 12)

**Campos del Registro:**
```typescript
- nombre_usuario (único)
- email (único, validación formato)
- contraseña (hash bcrypt)
- ubicación (opcional)
```

---

### ✅ **RF-1.2: Inicio y Cierre de Sesión**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Frontend: `frontend/src/app/features/auth/login/login.component.ts`
- ✅ Backend: 
  - Login: `backend/api/auth.php` POST `/api/auth/login`
  - Logout: `backend/api/auth.php` POST `/api/auth/logout`
- ✅ Autenticación: JWT tokens con expiración 7 días
- ✅ Seguridad: 
  - Tokens firmados con HS256
  - Sesiones almacenadas en tabla `sesiones`
  - Validación de contraseña con `password_verify()`

**Flujo de Login:**
```
Usuario → Login Component → Backend API → Verificar credenciales 
→ Generar JWT → Guardar en localStorage → Redirigir a /home
```

---

### ✅ **RF-1.3: Editar Perfil Público**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Frontend: `frontend/src/app/features/perfil/perfil.component.ts`
- ✅ Backend: `backend/api/usuarios.php` PUT `/api/usuarios/:id`
- ✅ Campos editables:
  - Foto de perfil (`foto_url`)
  - Biografía (`biografia`)
  - Ubicación (`ubicacion`)
  - Teléfono (`telefono` - opcional en BD)

**Validaciones:**
- Solo el propietario puede editar su perfil
- Validación de tipos de archivo para fotos (futuro: implementar upload)

---

### ⚠️ **RF-1.4: Recuperación de Contraseña**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (30%)**

**Implementado:**
- ✅ Base de Datos: Tabla `password_resets` creada con:
  - `email`, `token`, `fecha_creacion`, `fecha_expiracion`, `usado`
  - Tokens expiran en 1 hora
  - Índices optimizados

**Pendiente:**
- ❌ Backend: Endpoint `POST /api/auth/forgot-password`
- ❌ Backend: Endpoint `POST /api/auth/reset-password/:token`
- ❌ Frontend: Componente `password-recovery.component.ts`
- ❌ Frontend: Formulario "¿Olvidaste tu contraseña?"
- ❌ Email: Integración con Brevo/SendGrid para enviar email con token
- ❌ Email: Plantilla HTML del correo de recuperación

**Ruta de Implementación:**
```typescript
// 1. Usuario solicita reset
POST /api/auth/forgot-password
Body: { email: "user@example.com" }

// 2. Backend genera token y envía email
- Crear token aleatorio seguro (bin2hex(random_bytes(32)))
- Insertar en password_resets
- Enviar email con link: https://app.com/reset-password?token=XXX

// 3. Usuario hace click y resetea
GET /reset-password?token=XXX
POST /api/auth/reset-password
Body: { token: "XXX", new_password: "nueva123" }
```

**Prioridad:** 🟡 MEDIA (importante para UX, pero no crítico para MVP)

---

### ✅ **RF-1.5: Ver Perfiles Públicos de Otros Usuarios**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/usuarios.php` GET `/api/usuarios/:id`
- ✅ Base de Datos: Vista `estadisticas_usuarios` que incluye:
  - Total de habilidades
  - Ofertas activas
  - Demandas activas
  - Intercambios completados
  - Valoración promedio
  - Total de valoraciones
- ✅ Datos públicos mostrados:
  - Nombre de usuario
  - Biografía
  - Foto
  - Ubicación
  - Estadísticas de reputación

**Endpoint:**
```
GET /api/usuarios/5
Response: {
  "id": 5,
  "nombre_usuario": "maria_tech",
  "biografia": "Desarrolladora web...",
  "ubicacion": "Barcelona",
  "total_habilidades": 8,
  "valoracion_promedio": 4.7,
  ...
}
```

---

## 3. ÉPICA 2: Gestión de Habilidades (El "Troco") {#epica-2}

**Progreso:** ████████████████████ 100%

### ✅ **RF-2.1: Añadir Habilidades Ofrecidas**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/habilidades.php` POST `/api/habilidades`
- ✅ Base de Datos: Tabla `habilidades` con campo `tipo = 'oferta'`
- ✅ Campos requeridos:
  ```json
  {
    "titulo": "Clases de programación en Python",
    "descripcion": "Enseño Python desde nivel básico...",
    "categoria_id": 2,
    "tipo": "oferta",
    "duracion_estimada": 60
  }
  ```
- ✅ Validaciones: Usuario autenticado, categoría válida

---

### ✅ **RF-2.2: Añadir Habilidades Buscadas**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Mismo endpoint que RF-2.1 con `tipo = 'demanda'`
- ✅ Enum en BD: `CREATE TYPE tipo_habilidad AS ENUM ('oferta', 'demanda')`
- ✅ Filtrado por tipo en listados

---

### ✅ **RF-2.3: Editar Habilidades Publicadas**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/habilidades.php` PUT `/api/habilidades/:id`
- ✅ Validación de propiedad: Solo el dueño puede editar
- ✅ Campos editables: Todos excepto `usuario_id` y `fecha_publicacion`
- ✅ Trigger automático: Actualiza `fecha_actualizacion`

---

### ✅ **RF-2.4: Eliminar Habilidades Publicadas**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/habilidades.php` DELETE `/api/habilidades/:id`
- ✅ Soft delete: Marca `estado = 'inactiva'` (no borra físicamente)
- ✅ Validación de propiedad
- ✅ Las habilidades inactivas no aparecen en listados públicos

**Ventaja del Soft Delete:**
- Mantiene integridad referencial con `intercambios`
- Permite restaurar si fue error
- Auditoría de actividad

---

### ✅ **RF-2.5: Categorización de Habilidades**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/categorias.php` GET `/api/categorias`
- ✅ Base de Datos: Tabla `categorias_habilidades` con 8 categorías:
  1. 🏠 Hogar y Bricolaje
  2. 💻 Tecnología e Informática
  3. 📚 Clases y Formación
  4. 🎨 Arte y Creatividad
  5. 💆 Cuidado Personal y Bienestar
  6. 📁 Gestiones y Trámites
  7. 🚚 Transporte y Logística
  8. 🍳 Cocina y Alimentación

**Uso en Frontend:**
```typescript
// Dropdown de categorías en formulario
this.categoriaService.getCategorias().subscribe(cats => {
  this.categorias = cats;
});
```

---

## 4. ÉPICA 3: Búsqueda y Descubrimiento {#epica-3}

**Progreso:** ████████████░░░░░░░░ 60%

### ⚠️ **RF-3.1: Búsqueda por Palabras Clave**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (50%)**

**Implementado:**
- ✅ Backend: `backend/api/habilidades.php` GET `/api/habilidades?search=palabra`
- ✅ Búsqueda en campos: `titulo` y `descripcion`
- ✅ SQL optimizado con `ILIKE` (case-insensitive)
  ```sql
  WHERE (h.titulo ILIKE '%palabra%' OR h.descripcion ILIKE '%palabra%')
  ```

**Pendiente:**
- ❌ Frontend: Componente `busqueda.component.ts` o `search.component.ts`
- ❌ Frontend: Barra de búsqueda en navbar (toolbar principal)
- ❌ Frontend: Página de resultados `/buscar?q=...`
- ❌ Frontend: Destacar términos encontrados en resultados
- ❌ Sugerencias: Autocompletado mientras escribe (opcional)

**Diseño Propuesto:**
```html
<!-- En toolbar -->
<mat-form-field appearance="outline" class="search-bar">
  <mat-icon matPrefix>search</mat-icon>
  <input matInput placeholder="Buscar habilidades..." 
         [(ngModel)]="searchQuery"
         (keyup.enter)="buscar()">
</mat-form-field>
```

**Prioridad:** 🟡 ALTA (necesaria para usabilidad)

---

### ✅ **RF-3.2: Filtro por Categoría**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/habilidades.php?categoria_id=2`
- ✅ Frontend puede consumirlo (falta integrar en UI de filtros)

**Ejemplo de Uso:**
```typescript
// Obtener habilidades de "Tecnología"
this.habilidadesService.getHabilidades({ categoria_id: 2 })
  .subscribe(habilidades => { ... });
```

---

### ⚠️ **RF-3.3: Filtro por Proximidad Geográfica**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (40%)**

**Implementado:**
- ✅ Backend: `backend/api/habilidades.php?ubicacion=Barcelona`
- ✅ Base de Datos: Campo `ubicacion` indexado en `usuarios`
- ✅ Filtro implementado en query

**Pendiente:**
- ❌ Frontend: Dropdown/select de provincias/ciudades españolas
- ❌ Frontend: Filtro "Cerca de mí" (usando geolocalización navegador)
- ❌ Backend: Lista predefinida de provincias/ciudades
- ❌ UX: Combinar con mapa visual (Google Maps API - opcional)

**Lista de Provincias Sugerida:**
```typescript
const PROVINCIAS_ESPANA = [
  'A Coruña', 'Álava', 'Albacete', 'Alicante', 'Almería',
  'Asturias', 'Ávila', 'Badajoz', 'Barcelona', 'Burgos',
  // ... resto de provincias
];
```

**Prioridad:** 🟡 MEDIA (mejora UX, no crítico para MVP)

---

### ✅ **RF-3.4: Página Principal con Últimas Habilidades**
**Estado:** ✅ **COMPLETADO**

**Implementación:**
- ✅ Backend: `backend/api/habilidades.php` (orden por `fecha_publicacion DESC`)
- ✅ Frontend: Componente `frontend/src/app/features/home/`
- ✅ Paginación: Soporte de `limit` y `offset`
- ✅ Diseño: Grid de cards con Angular Material

**Endpoint:**
```
GET /api/habilidades?limit=12&offset=0
Response: {
  "total": 156,
  "data": [ ... 12 habilidades ... ]
}
```

---

## 5. ÉPICA 4: Interacción y Sistema de Mensajería {#epica-4}

**Progreso:** ████░░░░░░░░░░░░░░░░ 20%

### ❌ **RF-4.1: Iniciar Conversación Privada**
**Estado:** ❌ **NO IMPLEMENTADO**

**Estructura de BD Preparada:**
- ✅ Tabla `conversaciones` (id, intercambio_id, fechas)
- ✅ Tabla `participantes_conversacion` (conversacion_id, usuario_id)
- ✅ Tabla `mensajes` (id, conversacion_id, emisor_id, contenido, leido)
- ✅ Índices optimizados para queries de mensajería

**Backend Existente:**
- ⚠️ Archivo `backend/api/conversaciones.php` existe (revisar implementación)

**Pendiente de Implementar:**

#### **Backend:**
```php
// 1. Crear nueva conversación
POST /api/conversaciones
Body: {
  "receptor_id": 15,
  "mensaje_inicial": "Hola, me interesa tu habilidad..."
}
Response: { "conversacion_id": 42 }

// 2. Enviar mensaje en conversación existente
POST /api/conversaciones/:id/mensaje
Body: { "contenido": "¿Cuándo podemos quedar?" }

// 3. Obtener mensajes de conversación
GET /api/conversaciones/:id/mensajes

// 4. Listar todas mis conversaciones
GET /api/conversaciones
```

#### **Frontend:**
```typescript
// Componentes necesarios:
- frontend/src/app/features/mensajes/
  - mensajes-lista.component.ts     // Bandeja de entrada
  - conversacion.component.ts       // Chat individual
  - nuevo-mensaje.modal.ts          // Modal para iniciar chat

// Servicios:
- frontend/src/app/core/services/
  - mensajes.service.ts
  - conversaciones.service.ts
```

#### **UI/UX:**
```
┌─────────────────────────────────────────────┐
│ Mis Conversaciones              [+ Nuevo]   │
├─────────────────────────────────────────────┤
│ 🟢 María García                    2 min    │
│    "Perfecto, nos vemos mañana..."          │
├─────────────────────────────────────────────┤
│    Juan López                      1 hora   │
│    "Gracias por tu interés..."              │
├─────────────────────────────────────────────┤
│    Ana Martínez                    2 días   │
│    "¿Sigues disponible para..."            │
└─────────────────────────────────────────────┘
```

**Características Adicionales:**
- ❌ Badge con número de mensajes no leídos
- ❌ Notificación en tiempo real (opcional: WebSockets)
- ❌ Marcar como leído al abrir conversación
- ❌ Eliminar conversación

**Prioridad:** 🔴 CRÍTICA - Sin mensajería no hay forma de contactar

---

### ❌ **RF-4.2: Bandeja de Entrada y Notificaciones**
**Estado:** ❌ **NO IMPLEMENTADO**

**Depende de:** RF-4.1 (Iniciar Conversación)

**Pendiente:**
- ❌ Lista de conversaciones ordenada por última actividad
- ❌ Contador de mensajes no leídos (badge rojo)
- ❌ Notificación push o in-app de nuevos mensajes
- ❌ Sonido de notificación (opcional)
- ❌ Ruta `/mensajes` o `/inbox` en app

**Prioridad:** 🔴 CRÍTICA

---

### ❌ **RF-4.3: Marcar Conversación como "Acuerdo Cerrado"**
**Estado:** ❌ **NO IMPLEMENTADO**

**Relación con Intercambios:**
Este RF está ligado a la tabla `intercambios`:

```sql
CREATE TABLE intercambios (
    id SERIAL PRIMARY KEY,
    habilidad_ofrecida_id INT NOT NULL,
    habilidad_solicitada_id INT NOT NULL,
    proponente_id INT NOT NULL,
    receptor_id INT NOT NULL,
    estado estado_intercambio DEFAULT 'propuesto',
    -- Estados: 'propuesto', 'aceptado', 'rechazado', 'completado', 'cancelado'
    fecha_completado TIMESTAMP
);
```

**Flujo de Intercambio Completo:**
```
1. Usuario A propone intercambio desde habilidad de Usuario B
   → Backend crea registro en `intercambios` con estado='propuesto'
   → Backend crea conversación vinculada
   
2. Usuario B recibe notificación y revisa propuesta
   → Puede aceptar (estado='aceptado') o rechazar (estado='rechazado')
   
3. Si aceptado, ambos coordinan el intercambio vía mensajería
   
4. Una vez realizado el intercambio:
   → Cualquiera de los dos marca como completado (estado='completado')
   → Se desbloquea opción de valorar al otro usuario
   → Se actualizan estadísticas de ambos perfiles
```

**Pendiente de Implementar:**

#### **Backend:**
```php
// 1. Proponer intercambio
POST /api/intercambios
Body: {
  "habilidad_ofrecida_id": 23,    // Mi habilidad que ofrezco
  "habilidad_solicitada_id": 45,  // Habilidad del otro que me interesa
  "mensaje_propuesta": "Me interesa mucho tu habilidad..."
}

// 2. Aceptar/Rechazar intercambio
PUT /api/intercambios/:id
Body: { "estado": "aceptado" }  // o "rechazado"

// 3. Marcar como completado
PUT /api/intercambios/:id/completar

// 4. Obtener mis intercambios
GET /api/intercambios?usuario_id=5&estado=aceptado
```

#### **Frontend:**
```typescript
// Componentes necesarios:
- intercambio-propuesta.modal.ts   // Modal para proponer
- intercambios-lista.component.ts  // Mis intercambios
- intercambio-detalle.component.ts // Ver detalles
```

#### **UI en Mensajería:**
```
┌─────────────────────────────────────────────┐
│ Conversación con María García               │
├─────────────────────────────────────────────┤
│ 📦 Intercambio Propuesto:                   │
│    María ofrece: "Clases de Piano"          │
│    Tú ofreces: "Programación Web"           │
│    Estado: Aceptado ✅                       │
│    [Marcar como Completado]                 │
└─────────────────────────────────────────────┘
```

**Prioridad:** 🔴 CRÍTICA - Es el núcleo del negocio

---

### ⚠️ **RF-4.4: Reportar Perfil o Habilidad Inapropiada**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (40%)**

**Implementado:**
- ✅ Base de Datos: Tabla `reportes` con campos:
  ```sql
  - reportador_id
  - tipo_contenido (enum: 'perfil', 'habilidad')
  - contenido_id (ID del perfil o habilidad)
  - motivo (TEXT)
  - estado (enum: 'pendiente', 'revisado', 'resuelto')
  - fecha_reporte, fecha_revision
  - revisor_id (admin que lo gestionó)
  ```
- ✅ Backend: Archivo `backend/api/reportes.php` existe

**Pendiente:**
- ❌ Frontend: Botón "Reportar" en perfiles de usuario
- ❌ Frontend: Botón "Reportar" en cards de habilidades
- ❌ Frontend: Modal/formulario de reporte con:
  - Selector de motivo (spam, contenido ofensivo, estafa, otro)
  - Campo de texto para detalles
- ❌ Backend: Endpoint POST `/api/reportes`
- ❌ Email: Notificar a administradores de nuevo reporte

**Diseño Modal de Reporte:**
```typescript
// reporte.modal.ts
interface Reporte {
  tipo_contenido: 'perfil' | 'habilidad';
  contenido_id: number;
  motivo_categoria: string;  // 'spam' | 'ofensivo' | 'estafa' | 'otro'
  motivo_detalle: string;
}
```

**Prioridad:** 🟡 MEDIA (importante para moderación)

---

## 6. ÉPICA 5: Sistema de Reputación {#epica-5}

**Progreso:** ██████░░░░░░░░░░░░░░ 30%

### ⚠️ **RF-5.1: Dejar Valoración (1-5 Estrellas y Comentario)**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (30%)**

**Implementado:**
- ✅ Base de Datos: Tabla `valoraciones` con:
  ```sql
  - evaluador_id
  - evaluado_id
  - intercambio_id (vincular con intercambio completado)
  - puntuacion (1-5)
  - comentario (TEXT)
  - fecha_valoracion
  CONSTRAINT: no_autoevaluacion
  UNIQUE: valoracion_unica por intercambio
  ```
- ✅ Backend: Archivo `backend/api/valoraciones.php` existe

**Pendiente:**

#### **Backend:**
```php
// 1. Crear valoración
POST /api/valoraciones
Body: {
  "evaluado_id": 15,
  "intercambio_id": 42,
  "puntuacion": 5,
  "comentario": "Excelente persona, muy profesional..."
}

// 2. Obtener valoraciones recibidas
GET /api/valoraciones/usuario/:id

// 3. Verificar si puedo valorar (intercambio completado)
GET /api/valoraciones/puede-valorar/:intercambio_id
```

#### **Frontend:**
```typescript
// Componentes necesarios:
- valoracion.modal.ts              // Modal para dejar valoración
- valoraciones-lista.component.ts  // Lista de valoraciones en perfil
- estrellas-rating.component.ts    // Widget de estrellas (1-5)

// Servicios:
- valoraciones.service.ts
```

#### **UI - Modal de Valoración:**
```
┌─────────────────────────────────────────────┐
│ Valorar a María García                      │
├─────────────────────────────────────────────┤
│ ¿Cómo fue tu experiencia?                   │
│                                             │
│ ⭐⭐⭐⭐⭐  (Haz click para valorar)          │
│                                             │
│ Comentario público (opcional):              │
│ ┌─────────────────────────────────────────┐ │
│ │ María fue muy profesional y puntual...  │ │
│ │                                         │ │
│ └─────────────────────────────────────────┘ │
│                                             │
│          [Cancelar]  [Enviar Valoración]    │
└─────────────────────────────────────────────┘
```

**Lógica de Negocio:**
- Solo se puede valorar después de completar un intercambio
- Una valoración por intercambio (no duplicados)
- No se puede autovalorar
- Valoración es pública y permanente

**Prioridad:** 🟡 ALTA (importante para confianza)

---

### ⚠️ **RF-5.2: Mostrar Valoración Media en Perfil**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (50%)**

**Implementado:**
- ✅ Base de Datos: Vista `estadisticas_usuarios` calcula:
  ```sql
  valoracion_promedio,
  total_valoraciones
  ```
- ✅ Backend: Endpoint `GET /api/usuarios/:id` devuelve estas estadísticas

**Pendiente:**
- ❌ Frontend: Widget de estrellas en componente `perfil.component.ts`
- ❌ Frontend: Mostrar promedio numérico (ej: "4.7 ★")
- ❌ Frontend: Mostrar total de valoraciones (ej: "(23 valoraciones)")
- ❌ Diseño: Estrellas rellenas proporcionales (ej: 4.5 estrellas = 4 completas + 1 media)

**Diseño en Perfil:**
```html
<div class="user-rating">
  <span class="stars">⭐⭐⭐⭐⭐</span>
  <span class="rating-number">4.7</span>
  <span class="rating-count">(23 valoraciones)</span>
</div>
```

**Prioridad:** 🟡 ALTA

---

### ❌ **RF-5.3: Mostrar Comentarios Públicos en Perfil**
**Estado:** ❌ **NO IMPLEMENTADO**

**Implementado:**
- ✅ Base de Datos: Campo `comentario` en tabla `valoraciones`
- ✅ Backend puede devolver comentarios

**Pendiente:**
- ❌ Frontend: Sección "Valoraciones Recibidas" en perfil
- ❌ Frontend: Lista de comentarios con:
  - Nombre del evaluador
  - Fecha de valoración
  - Puntuación (estrellas)
  - Comentario completo
- ❌ Paginación: Si hay muchas valoraciones
- ❌ Filtros: Ordenar por fecha/puntuación

**Diseño en Perfil:**
```
┌─────────────────────────────────────────────┐
│ Valoraciones Recibidas (23)                 │
├─────────────────────────────────────────────┤
│ ⭐⭐⭐⭐⭐  Juan López • hace 2 días          │
│ "Excelente experiencia, muy profesional"    │
├─────────────────────────────────────────────┤
│ ⭐⭐⭐⭐☆  Ana García • hace 1 semana         │
│ "Buen intercambio, aunque llegó tarde"      │
├─────────────────────────────────────────────┤
│              [Ver más valoraciones]          │
└─────────────────────────────────────────────┘
```

**Prioridad:** 🟡 MEDIA

---

## 7. ÉPICA 6: Panel de Administración {#epica-6}

**Progreso:** █████░░░░░░░░░░░░░░░ 25%

### ⚠️ **RF-6.1: Panel de Control con Vista General**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (30%)**

**Implementado:**
- ✅ Base de Datos: Campo `rol` en tabla `usuarios` (enum: 'usuario', 'administrador')
- ✅ Frontend: Guard `admin.guard.ts` existe para proteger rutas

**Pendiente:**
- ❌ Frontend: Componente `admin-dashboard.component.ts`
- ❌ Frontend: Ruta `/admin` protegida con `canActivate: [AdminGuard]`
- ❌ Backend: Endpoints de estadísticas globales:
  ```php
  GET /api/admin/stats
  Response: {
    "total_usuarios": 256,
    "usuarios_activos_mes": 123,
    "total_habilidades": 478,
    "intercambios_completados": 89,
    "reportes_pendientes": 5
  }
  ```

**Diseño Dashboard:**
```
┌─────────────────────────────────────────────────────────┐
│ Panel de Administración                    👤 Admin     │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────┐ │
│  │ Usuarios │  │Habilidad.│  │Intercamb.│  │Reportes│ │
│  │   256    │  │   478    │  │    89    │  │   5 ⚠️  │ │
│  └──────────┘  └──────────┘  └──────────┘  └────────┘ │
│                                                         │
│  📊 Actividad Reciente                                  │
│  ┌─────────────────────────────────────────────────┐   │
│  │ [Gráfico de actividad últimos 30 días]          │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  ⚠️  Reportes Pendientes de Revisión (5)               │
│  • Usuario "spam_bot123" reportado 3 veces             │
│  • Habilidad "Contenido inapropiado" reportada         │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

**Prioridad:** 🔴 ALTA (requerido por tribunal)

---

### ⚠️ **RF-6.2 y RF-6.3: Buscar, Ver, Editar y Eliminar Usuarios**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (40%)**

**Implementado:**
- ✅ Backend: Endpoints CRUD completos en `usuarios.php`
  - GET `/api/usuarios` (listar con búsqueda)
  - GET `/api/usuarios/:id` (ver detalle)
  - PUT `/api/usuarios/:id` (editar)
  - Soft delete: `activo = false`

**Pendiente:**
- ❌ Frontend: Componente `admin-usuarios.component.ts`
- ❌ Frontend: Tabla de usuarios con Angular Material (`mat-table`)
- ❌ Frontend: Filtros y búsqueda en tabla
- ❌ Frontend: Acciones por fila:
  - [Ver Perfil]
  - [Editar]
  - [Desactivar/Activar]
  - [Eliminar]

**Diseño Tabla Admin:**
```
┌───────────────────────────────────────────────────────────────┐
│ Gestión de Usuarios                [🔍 Buscar...]  [+ Crear]  │
├───────────────────────────────────────────────────────────────┤
│ ID │ Usuario      │ Email             │ Rol   │ Estado │ ...  │
├────┼──────────────┼───────────────────┼───────┼────────┼──────┤
│ 1  │ juan_perez   │ juan@email.com    │ User  │ ✅     │ [⋮]  │
│ 2  │ maria_admin  │ maria@email.com   │ Admin │ ✅     │ [⋮]  │
│ 3  │ spam_bot     │ spam@bot.com      │ User  │ ❌     │ [⋮]  │
└────┴──────────────┴───────────────────┴───────┴────────┴──────┘
```

**Prioridad:** 🔴 ALTA

---

### ⚠️ **RF-6.4: Moderar Contenido (Habilidades y Comentarios)**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (30%)**

**Implementado:**
- ✅ Backend: Endpoints CRUD de `habilidades.php`
- ✅ Backend: Soft delete de habilidades

**Pendiente:**
- ❌ Frontend: Componente `admin-contenido.component.ts`
- ❌ Frontend: Vista de todas las habilidades (incluidas inactivas)
- ❌ Frontend: Acciones de moderación:
  - [Aprobar]
  - [Pausar]
  - [Eliminar]
  - [Ver reportes relacionados]

**Prioridad:** 🟡 MEDIA

---

### ⚠️ **RF-6.5: Gestionar Reportes de Usuarios**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (25%)**

**Implementado:**
- ✅ Base de Datos: Tabla `reportes` con estados
- ✅ Backend: Archivo `reportes.php` existe

**Pendiente:**
- ❌ Backend: Endpoints de gestión:
  ```php
  GET /api/admin/reportes?estado=pendiente
  PUT /api/admin/reportes/:id/resolver
  Body: {
    "estado": "resuelto",
    "notas_revision": "Usuario advertido",
    "accion_tomada": "warning"  // 'warning', 'ban', 'delete_content', 'ignore'
  }
  ```
- ❌ Frontend: Componente `admin-reportes.component.ts`
- ❌ Frontend: Lista de reportes con detalles:
  - Qué se reportó (perfil/habilidad)
  - Quién reportó
  - Motivo
  - Fecha
  - Estado
  - Acciones

**Diseño Gestión de Reportes:**
```
┌───────────────────────────────────────────────────────────┐
│ Reportes Pendientes de Revisión (5)                       │
├───────────────────────────────────────────────────────────┤
│ 🚩 Usuario "spam_bot123" reportado por "usuario_real"    │
│    Motivo: Spam - "Envía mensajes masivos"               │
│    Fecha: 2 oct 2025                                      │
│    [Ver Perfil] [Advertir] [Banear] [Ignorar]            │
├───────────────────────────────────────────────────────────┤
│ 🚩 Habilidad "Contenido inapropiado"                     │
│    Reportado por: "usuario_molesto"                      │
│    Motivo: Contenido ofensivo                            │
│    [Ver Habilidad] [Eliminar] [Ignorar]                  │
└───────────────────────────────────────────────────────────┘
```

**Prioridad:** 🟡 ALTA (importante para moderación)

---

## 8. REQUISITOS NO FUNCIONALES {#requisitos-no-funcionales}

### ✅ **RNF-1: Usabilidad y Diseño Responsive**
**Estado:** ✅ **IMPLEMENTADO**

**Detalles:**
- ✅ SCSS con 3 breakpoints responsive:
  - 480px (móvil pequeño)
  - 768px (tablet/móvil grande)
  - 960px (desktop pequeño)
- ✅ Angular Material (responsive por defecto)
- ✅ Media queries en `styles.scss` y componentes
- ✅ Grid system con Flexbox/CSS Grid
- ✅ Mobile-first approach

**Áreas Testeadas:**
- ✅ Toolbar/navbar se adapta a móvil
- ✅ Cards de habilidades en grid responsive
- ✅ Formularios usables en móvil

---

### ⚠️ **RNF-2: Accesibilidad WCAG 2.1 Nivel AA**
**Estado:** ⚠️ **PARCIALMENTE IMPLEMENTADO (30%)**

**Implementado:**
- ✅ Angular Material tiene buena accesibilidad base
- ✅ Estructura semántica HTML5

**Pendiente Auditoría:**
- ❌ **ARIA labels** en elementos interactivos
- ❌ **Alt text** en todas las imágenes
- ❌ **Contraste de colores** validado (mínimo 4.5:1 para texto normal)
- ❌ **Navegación por teclado** completa (Tab, Enter, Esc)
- ❌ **Focus visible** en todos los elementos
- ❌ **Screen reader testing** con NVDA/JAWS
- ❌ **Textos de error** descriptivos y accesibles
- ❌ **Formularios** con labels asociados correctamente

**Herramientas de Auditoría Recomendadas:**
```bash
# Chrome DevTools Lighthouse
# axe DevTools (extensión)
# WAVE (Web Accessibility Evaluation Tool)
```

**Acciones Requeridas:**
1. Ejecutar auditoría con Lighthouse
2. Corregir issues críticos (contraste, ARIA, alt text)
3. Testing manual con teclado
4. Testing con lector de pantalla
5. Documentar nivel de conformidad alcanzado

**Prioridad:** 🔴 CRÍTICA si es requisito indispensable del TFM

---

### ✅ **RNF-3: Seguridad**
**Estado:** ✅ **BIEN IMPLEMENTADO (85%)**

**Implementado:**
- ✅ **Hash de contraseñas:** Bcrypt con cost factor 12
- ✅ **SQL Injection:** Prepared statements con PDO
- ✅ **XSS:** Angular sanitiza automáticamente
- ✅ **CORS:** Configurado correctamente
- ✅ **HTTPS:** Certificados SSL en producción (Render)
- ✅ **Headers de seguridad:**
  ```
  X-Content-Type-Options: nosniff
  X-Frame-Options: SAMEORIGIN
  X-XSS-Protection: 1; mode=block
  ```
- ✅ **JWT:** Tokens firmados con HS256

**Mejoras Recomendadas:**
- ⚠️ **CSRF Protection:** Tokens CSRF en formularios
- ⚠️ **Rate Limiting:** Limitar intentos de login
- ⚠️ **Input Validation:** Validación más estricta en backend
- ⚠️ **Content Security Policy:** Headers CSP más restrictivos

**Prioridad Mejoras:** 🟡 MEDIA (lo básico está cubierto)

---

### ⚠️ **RNF-4: Rendimiento**
**Estado:** ⚠️ **ACEPTABLE (70%)**

**Implementado:**
- ✅ **Lazy Loading:** Módulos Angular cargados bajo demanda
- ✅ **Índices BD:** Optimizados en PostgreSQL
- ✅ **Paginación:** Implementada en listados
- ✅ **Minificación:** Build de producción con esbuild

**Optimizaciones Pendientes:**
- ❌ **Caching:** Redis/Memcached para queries frecuentes
- ❌ **CDN:** Assets estáticos en CDN (Cloudflare)
- ❌ **Compresión imágenes:** WebP, lazy loading de imágenes
- ❌ **Database pooling:** Optimizar conexiones PostgreSQL
- ❌ **Query optimization:** EXPLAIN ANALYZE de queries lentas

**Métricas Objetivo:**
- First Contentful Paint: < 1.5s
- Time to Interactive: < 3.5s
- Lighthouse Performance Score: > 90

**Prioridad:** 🟡 BAJA (optimización post-MVP)

---

## 9. PLAN DE IMPLEMENTACIÓN SUGERIDO {#plan-implementacion}

### 🔴 **FASE 1: MVP CRÍTICO (2-3 semanas)**
**Objetivo:** Funcionalidades mínimas para presentar TFM

#### **Semana 1: Sistema de Mensajería e Intercambios**
1. **Backend - Mensajería**
   - [ ] Implementar POST `/api/conversaciones` (crear conversación)
   - [ ] Implementar POST `/api/conversaciones/:id/mensaje` (enviar mensaje)
   - [ ] Implementar GET `/api/conversaciones` (listar mis conversaciones)
   - [ ] Implementar GET `/api/conversaciones/:id/mensajes` (obtener mensajes)
   - [ ] Testing endpoints con Thunder Client/Postman

2. **Backend - Intercambios**
   - [ ] Implementar POST `/api/intercambios` (proponer intercambio)
   - [ ] Implementar PUT `/api/intercambios/:id` (aceptar/rechazar)
   - [ ] Implementar PUT `/api/intercambios/:id/completar` (marcar completado)
   - [ ] Implementar GET `/api/intercambios` (mis intercambios)

3. **Frontend - Mensajería**
   - [ ] Crear servicio `mensajes.service.ts`
   - [ ] Crear componente `mensajes-lista.component.ts` (bandeja entrada)
   - [ ] Crear componente `conversacion.component.ts` (chat individual)
   - [ ] Crear modal `nuevo-mensaje.modal.ts`
   - [ ] Añadir ruta `/mensajes`
   - [ ] Badge de mensajes no leídos en navbar

#### **Semana 2: Búsqueda y Panel Admin Básico**
4. **Frontend - Búsqueda**
   - [ ] Barra de búsqueda en toolbar
   - [ ] Componente `busqueda.component.ts`
   - [ ] Página de resultados `/buscar`
   - [ ] Filtros por categoría
   - [ ] Filtro por ubicación (dropdown provincias)

5. **Frontend - Panel Admin**
   - [ ] Crear `admin-dashboard.component.ts`
   - [ ] Dashboard con estadísticas básicas
   - [ ] Componente `admin-usuarios.component.ts`
   - [ ] Tabla de usuarios con acciones (ver, editar, desactivar)
   - [ ] Proteger rutas con `AdminGuard`

6. **Backend - Admin**
   - [ ] Endpoint GET `/api/admin/stats` (estadísticas globales)
   - [ ] Middleware de verificación de rol admin

#### **Semana 3: Sistema de Valoraciones**
7. **Backend - Valoraciones**
   - [ ] Implementar POST `/api/valoraciones`
   - [ ] Implementar GET `/api/valoraciones/usuario/:id`
   - [ ] Validar que intercambio esté completado antes de valorar

8. **Frontend - Valoraciones**
   - [ ] Crear modal `valoracion.modal.ts`
   - [ ] Widget de estrellas en perfil
   - [ ] Lista de comentarios en perfil
   - [ ] Botón "Valorar" después de completar intercambio

---

### 🟡 **FASE 2: MEJORAS IMPORTANTES (1-2 semanas)**
**Objetivo:** Completar funcionalidades para TFM robusto

#### **Semana 4: Recuperación Contraseña y Reportes**
9. **Recuperación de Contraseña**
   - [ ] Backend: POST `/api/auth/forgot-password`
   - [ ] Backend: POST `/api/auth/reset-password/:token`
   - [ ] Frontend: Componente `password-recovery.component.ts`
   - [ ] Integrar Brevo para envío de emails
   - [ ] Plantilla HTML de email

10. **Sistema de Reportes**
    - [ ] Backend: POST `/api/reportes`
    - [ ] Frontend: Botón "Reportar" en perfiles
    - [ ] Frontend: Modal de reporte
    - [ ] Frontend Admin: Vista de reportes pendientes
    - [ ] Backend: Endpoints de gestión de reportes

#### **Semana 5: Pulido y Testing**
11. **Mejoras UX/UI**
    - [ ] Notificaciones visuales (snackbars)
    - [ ] Loading spinners
    - [ ] Estados vacíos (empty states)
    - [ ] Mensajes de error descriptivos

12. **Testing**
    - [ ] Testing manual de todos los flujos
    - [ ] Corrección de bugs encontrados
    - [ ] Testing responsive en diferentes dispositivos
    - [ ] Testing de accesibilidad (Lighthouse)

---

### 🟢 **FASE 3: OPTIMIZACIONES (Opcional - Post TFM)**
**Objetivo:** Mejoras de rendimiento y features avanzados

13. **Rendimiento**
    - [ ] Implementar caching con Redis
    - [ ] Optimizar queries lentas
    - [ ] Compresión de imágenes
    - [ ] CDN para assets estáticos

14. **Features Avanzados**
    - [ ] Chat en tiempo real (WebSockets)
    - [ ] Notificaciones push
    - [ ] Sistema de notificaciones por email
    - [ ] Geolocalización con mapa

15. **Accesibilidad WCAG 2.1 AA**
    - [ ] Auditoría completa con Lighthouse
    - [ ] Corrección de issues de contraste
    - [ ] ARIA labels completos
    - [ ] Testing con lector de pantalla

---

## 10. CHECKLIST PRE-ENTREGA TFM {#checklist-tfm}

### ✅ **FUNCIONALIDADES MÍNIMAS OBLIGATORIAS**

#### **Gestión de Usuarios**
- [ ] Registro de usuarios funcional
- [ ] Login/Logout funcional
- [ ] Edición de perfil
- [ ] Recuperación de contraseña (IMPORTANTE)
- [ ] Ver perfiles públicos con estadísticas

#### **Habilidades**
- [ ] Crear habilidades (oferta/demanda)
- [ ] Editar habilidades propias
- [ ] Eliminar habilidades propias
- [ ] Listar habilidades en home

#### **Búsqueda**
- [ ] Búsqueda por palabras clave funcional
- [ ] Filtro por categoría
- [ ] Filtro por ubicación (al menos provincias)

#### **Mensajería e Intercambios** (CRÍTICO)
- [ ] Iniciar conversación con otro usuario
- [ ] Enviar y recibir mensajes
- [ ] Bandeja de entrada de mensajes
- [ ] Proponer intercambio
- [ ] Aceptar/Rechazar intercambio
- [ ] Marcar intercambio como completado

#### **Valoraciones** (IMPORTANTE)
- [ ] Dejar valoración (estrellas + comentario)
- [ ] Ver valoración media en perfil
- [ ] Ver comentarios públicos en perfil

#### **Panel Administración** (REQUERIDO POR TRIBUNAL)
- [ ] Dashboard con estadísticas básicas
- [ ] Gestión de usuarios (ver, editar, desactivar)
- [ ] Gestión de reportes (ver y resolver)
- [ ] Cuenta de administrador de prueba para tribunal

---

### ✅ **REQUISITOS NO FUNCIONALES**

#### **Diseño**
- [ ] Responsive en móvil, tablet y desktop
- [ ] Angular Material implementado correctamente
- [ ] Diseño consistente en toda la app

#### **Accesibilidad** (SI ES REQUISITO INDISPENSABLE)
- [ ] Lighthouse Accessibility Score > 90
- [ ] Contraste de colores WCAG AA
- [ ] ARIA labels en elementos interactivos
- [ ] Navegación por teclado funcional
- [ ] Alt text en imágenes

#### **Seguridad**
- [ ] Contraseñas hasheadas (Bcrypt)
- [ ] Prepared statements (sin SQL Injection)
- [ ] CORS configurado
- [ ] HTTPS en producción
- [ ] Headers de seguridad

#### **Rendimiento**
- [ ] Lighthouse Performance Score > 70
- [ ] Tiempo de carga aceptable (< 3s)
- [ ] Sin errores en consola

---

### ✅ **DOCUMENTACIÓN TFM**

#### **Documentos Técnicos**
- [x] INFRAESTRUCTURA_TECNOLOGICA_TFM.md (COMPLETADO)
- [x] ESTADO_IMPLEMENTACION_FUNCIONALIDADES.md (ESTE DOCUMENTO)
- [x] ARQUITECTURA_DEPLOY.md
- [x] DEPLOY_FRONTEND_RENDER.md
- [ ] Manual de usuario (capturas de pantalla)
- [ ] Manual de administrador

#### **Memoria TFM**
- [ ] Introducción y justificación del proyecto
- [ ] Objetivos y alcance
- [ ] Estado del arte (análisis de competidores)
- [ ] Metodología de desarrollo
- [ ] Arquitectura del sistema (diagramas)
- [ ] Implementación (tecnologías usadas)
- [ ] Pruebas y validación
- [ ] Conclusiones y trabajo futuro
- [ ] Bibliografía

#### **Capturas de Pantalla**
- [ ] Página principal (home)
- [ ] Listado de habilidades
- [ ] Búsqueda y filtros
- [ ] Detalle de habilidad
- [ ] Perfil público de usuario
- [ ] Sistema de mensajería
- [ ] Propuesta de intercambio
- [ ] Sistema de valoraciones
- [ ] Panel de administración
- [ ] Versión móvil (responsive)

---

### ✅ **DESPLIEGUE Y PRUEBAS**

#### **Entorno de Producción**
- [x] Backend desplegado en Render.com
- [x] Frontend desplegado en Render.com
- [x] Base de datos en Supabase
- [x] HTTPS configurado
- [x] CORS funcionando
- [ ] Cuenta de administrador creada para tribunal

#### **Testing Pre-Entrega**
- [ ] Registro de nuevo usuario
- [ ] Login con usuario registrado
- [ ] Crear habilidad ofrecida
- [ ] Crear habilidad buscada
- [ ] Buscar habilidades
- [ ] Iniciar conversación
- [ ] Proponer intercambio
- [ ] Aceptar intercambio
- [ ] Completar intercambio
- [ ] Dejar valoración
- [ ] Acceder al panel admin
- [ ] Gestionar usuario como admin
- [ ] Revisar reporte como admin

---

## 📊 MÉTRICAS DE PROGRESO

### Funcionalidades Implementadas vs Pendientes

```
TOTAL FUNCIONALIDADES: 25

✅ Completadas:     10  (40%)
⚠️  Parciales:       9  (36%)
❌ Pendientes:       6  (24%)

CRÍTICAS PENDIENTES: 4
  - Sistema de Mensajería completo
  - Gestión de Intercambios completo
  - Panel Administración completo
  - Recuperación de contraseña
```

### Tiempo Estimado Restante

```
FASE 1 (MVP Crítico):           80-120 horas  (2-3 semanas full-time)
FASE 2 (Mejoras Importantes):   40-60 horas   (1-1.5 semanas)
FASE 3 (Optimizaciones):        20-40 horas   (Opcional)

TOTAL MÍNIMO TFM COMPLETO:      120-180 horas (3-4.5 semanas)
```

---

## 🎯 RECOMENDACIONES FINALES

### **Para Presentar TFM con Éxito:**

1. **PRIORIZA FUNCIONALIDADES CRÍTICAS**
   - Mensajería e Intercambios son el CORAZÓN del negocio
   - Sin ellos, no hay plataforma de intercambio real

2. **PANEL ADMIN ES OBLIGATORIO**
   - El tribunal necesita acceder con cuenta admin
   - Implementa al menos: ver usuarios, ver reportes, estadísticas básicas

3. **ACCESIBILIDAD SI ES REQUISITO INDISPENSABLE**
   - Dedica tiempo a auditoría y corrección
   - No subestimes WCAG 2.1 AA

4. **DOCUMENTACIÓN ES CLAVE**
   - Memoria TFM bien redactada
   - Capturas de pantalla profesionales
   - Diagramas claros de arquitectura

5. **TESTING EXHAUSTIVO**
   - Prueba todos los flujos de usuario
   - No presentes con bugs críticos
   - Testing en producción (Render)

### **Cronograma Sugerido:**

```
Semanas 1-3:  Implementación FASE 1 (MVP Crítico)
Semana 4:     Implementación FASE 2 (Mejoras)
Semana 5:     Testing, corrección bugs, documentación
Semana 6:     Redacción memoria TFM, capturas, preparación presentación
```

---

## 📞 SOPORTE Y RECURSOS

### **Documentación de Referencia:**
- Este documento (ESTADO_IMPLEMENTACION_FUNCIONALIDADES.md)
- INFRAESTRUCTURA_TECNOLOGICA_TFM.md
- ARQUITECTURA_DEPLOY.md

### **Herramientas Recomendadas:**
- **Testing API:** Thunder Client, Postman
- **DB Management:** DBeaver (ya usas)
- **Accessibility:** Lighthouse, axe DevTools
- **Email Testing:** Mailtrap (desarrollo), Brevo (producción)

---

**Última Actualización:** 3 de Octubre de 2025  
**Próxima Revisión:** Después de completar FASE 1

---

*Este documento es un living document. Actualízalo conforme avances en la implementación.*

