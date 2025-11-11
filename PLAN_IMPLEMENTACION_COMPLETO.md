# 📋 PLAN COMPLETO DE IMPLEMENTACIÓN - FRONTEND PEC3 y PEC4

**Fecha:** 11 de noviembre de 2025  
**Objetivo:** Implementar TODAS las funcionalidades restantes del frontend  
**Estado actual:** 75% (12/16 tests completados)  
**Meta:** 100% (16/16 tests + funcionalidades avanzadas)

---

## 📊 ESTADO ACTUAL

### ✅ **YA IMPLEMENTADO (75%):**
- Autenticación completa
- Habilidades CRUD completo
- Intercambios CRUD completo
- Valoraciones
- Perfiles
- Admin (reportes + usuarios)
- Responsive 100%

### ⏳ **PENDIENTE (25%):**
- Sistema de Conversaciones/Chat
- Sistema de Notificaciones
- Búsqueda avanzada
- Estadísticas de usuario

---

## 🎯 FASE 1: FUNCIONALIDADES ESENCIALES (PEC3)

### **1. SISTEMA DE CONVERSACIONES/CHAT** 🔴 ALTA PRIORIDAD

**Backend disponible:** ✅ SÍ (`conversaciones.php`)

#### **Endpoints disponibles:**
```
GET    /api/conversaciones              - Listar mis conversaciones
GET    /api/conversaciones/:id/mensajes - Obtener mensajes
POST   /api/conversaciones              - Crear conversación
POST   /api/conversaciones/:id/mensaje  - Enviar mensaje
PUT    /api/conversaciones/:id/marcar-leido - Marcar como leído
```

#### **Lo que hay que implementar:**

**A. Servicio (`conversaciones.service.ts`)** - CREAR
```typescript
- list(): Observable<ApiResponse<Conversacion[]>>
- getById(id): Observable<ApiResponse<Conversacion>>
- getMensajes(id): Observable<ApiResponse<Mensaje[]>>
- create(data): Observable<ApiResponse<Conversacion>>
- sendMensaje(conversacionId, texto): Observable<ApiResponse<Mensaje>>
- marcarLeido(conversacionId): Observable<ApiResponse<any>>
```

**B. Modelos (`conversacion.model.ts` y `mensaje.model.ts`)** - CREAR
```typescript
export interface Conversacion {
  id: number;
  usuario1_id: number;
  usuario2_id: number;
  fecha_inicio: string;
  ultimo_mensaje?: string;
  ultimo_mensaje_fecha?: string;
  mensajes_no_leidos?: number;
  // Datos del otro usuario
  otro_usuario_id: number;
  otro_usuario_nombre: string;
  otro_usuario_email?: string;
}

export interface Mensaje {
  id: number;
  conversacion_id: number;
  emisor_id: number;
  receptor_id: number;
  texto: string;
  fecha_envio: string;
  leido: boolean;
  fecha_lectura?: string;
  // Datos del emisor
  emisor_nombre?: string;
}
```

**C. Componente Lista (`conversaciones-list.component`)** - CREAR
- Ubicación: `features/conversaciones/conversaciones-list/`
- Mostrar lista de conversaciones
- Badge con contador de no leídos
- Click → navega a detalle
- Responsive con cards en móvil

**D. Componente Detalle/Chat (`conversacion-detail.component`)** - CREAR
- Ubicación: `features/conversaciones/conversacion-detail/`
- Vista de mensajes (scroll automático al último)
- Formulario para enviar mensaje
- Diferenciar mensajes propios vs. recibidos (align left/right)
- Marcar como leído al abrir
- Polling cada 5 segundos para actualizar (opcional: tiempo real)
- Responsive con input fijo abajo

**E. Rutas** - AÑADIR a `app.routes.ts`
```typescript
{
  path: 'conversaciones',
  loadComponent: () => import('...conversaciones-list.component'),
  canActivate: [authGuard]
},
{
  path: 'conversaciones/:id',
  loadComponent: () => import('...conversacion-detail.component'),
  canActivate: [authGuard]
}
```

**F. Navegación** - AÑADIR al header
- Link "Mensajes" en menú principal
- Badge con contador de no leídos (opcional)

**Tiempo estimado:** 6-8 horas

---

### **2. SISTEMA DE NOTIFICACIONES** 🟡 MEDIA PRIORIDAD

**Backend disponible:** ✅ SÍ (`notificaciones.php`)

#### **Endpoints disponibles:**
```
GET    /api/notificaciones              - Listar mis notificaciones
GET    /api/notificaciones/no-leidas    - Contar no leídas
PUT    /api/notificaciones/:id          - Marcar como leída
PUT    /api/notificaciones/marcar-todas-leidas - Marcar todas
```

#### **Lo que hay que implementar:**

**A. Servicio (`notificaciones.service.ts`)** - CREAR
```typescript
- list(): Observable<ApiResponse<Notificacion[]>>
- countNoLeidas(): Observable<ApiResponse<{count: number}>>
- marcarLeida(id): Observable<ApiResponse<any>>
- marcarTodasLeidas(): Observable<ApiResponse<any>>
```

**B. Modelo (`notificacion.model.ts`)** - CREAR
```typescript
export interface Notificacion {
  id: number;
  usuario_id: number;
  tipo: 'intercambio_propuesto' | 'intercambio_aceptado' | 'intercambio_rechazado' | 
        'intercambio_completado' | 'valoracion_recibida';
  titulo: string;
  mensaje: string;
  entidad_tipo: 'intercambio' | 'valoracion';
  entidad_id: number;
  leida: boolean;
  fecha_creacion: string;
  fecha_lectura?: string;
}
```

**C. Componente Badge en Header (`notification-badge.component`)** - CREAR
- Ubicación: `shared/components/notification-badge/`
- Icono de campana con badge de contador
- Click → abre dropdown con últimas 5 notificaciones
- Botón "Ver todas" → navega a lista completa
- Polling cada 30 segundos para actualizar contador

**D. Componente Lista (`notificaciones-list.component`)** - CREAR
- Ubicación: `features/notificaciones/notificaciones-list/`
- Lista completa de notificaciones
- Diferenciar leídas (fondo gris) vs no leídas (fondo blanco)
- Click en notificación → marca como leída + navega a entidad relacionada
- Botón "Marcar todas como leídas"
- Responsive

**E. Rutas** - AÑADIR
```typescript
{
  path: 'notificaciones',
  loadComponent: () => import('...notificaciones-list.component'),
  canActivate: [authGuard]
}
```

**Tiempo estimado:** 4-6 horas

---

## 🚀 FASE 2: MEJORAS DE UX (PEC4)

### **3. BÚSQUEDA AVANZADA** 🟢 BAJA PRIORIDAD

**Backend:** Ya soporta filtros en `GET /habilidades`

#### **Lo que hay que implementar:**

**A. Mejorar `habilidades-list.component`**
- Añadir más filtros:
  - Rango de duración (min-max slider)
  - Ordenar por: fecha, nombre, duración
  - Filtro por ubicación (autocompletado)
- Guardar filtros en localStorage
- Botón "Limpiar filtros"
- Panel de filtros colapsable en móvil

**B. Componente de Búsqueda Global (opcional)**
- Barra de búsqueda en header
- Búsqueda en tiempo real (debounce)
- Resultados tipo dropdown
- Búsqueda en: habilidades, usuarios

**Tiempo estimado:** 3-4 horas

---

### **4. ESTADÍSTICAS DE USUARIO** 🟢 BAJA PRIORIDAD

#### **Lo que hay que implementar:**

**A. Mejorar `perfil.component`**
- Card de estadísticas:
  - Total de habilidades publicadas
  - Total de intercambios realizados
  - Valoración promedio (estrellas)
  - Total de valoraciones recibidas
  - Miembro desde (fecha registro)
- Gráfico simple (opcional): intercambios por mes

**B. Backend:** 
- Crear endpoint `GET /usuarios/:id/estadisticas` (si no existe)
- O calcular en frontend desde datos existentes

**Tiempo estimado:** 2-3 horas

---

### **5. PAUSAR/ACTIVAR HABILIDAD** 🟢 BAJA PRIORIDAD

**Backend:** Campo `estado` ya soporta 'activa', 'pausada', 'inactiva'

#### **Lo que hay que implementar:**

**A. Añadir a `habilidad-detail.component`**
- Toggle switch en card "Tus Acciones"
- Estados: Activa (verde) / Pausada (naranja)
- Confirmación antes de pausar
- Al pausar: no aparece en búsquedas públicas
- Al activar: vuelve a aparecer

**B. Mostrar estado en `habilidades-list`**
- Chip visual: "PAUSADA" en habilidades propias

**Tiempo estimado:** 2 horas

---

### **6. MEJORAS GENERALES DE UX** 🟢 BAJA PRIORIDAD

#### **A. Loading States**
- Skeleton loaders en lugar de spinners
- Transiciones suaves entre páginas

#### **B. Empty States**
- Ilustraciones personalizadas para "Sin resultados"
- Call-to-action en estados vacíos

#### **C. Error Handling**
- Página de error 404 personalizada
- Toast notifications más informativas
- Retry automático en errores de red

#### **D. Confirmaciones**
- Usar `ConfirmDialogComponent` en todas las acciones destructivas
- Mensajes más descriptivos

**Tiempo estimado:** 3-4 horas

---

## 📅 CRONOGRAMA SUGERIDO

### **Opción A: Solo PEC3 (Core Features)**
```
Día 1-2:  Conversaciones (lista + detalle)
Día 3:    Notificaciones (badge + lista)
Día 4:    Testing y ajustes
Día 5:    Documentación PEC3
Total: 5 días laborables
```

### **Opción B: PEC3 + Inicio PEC4**
```
Semana 1:
  - Día 1-2: Conversaciones
  - Día 3: Notificaciones
  - Día 4-5: Testing + Docs

Semana 2:
  - Día 1: Búsqueda avanzada
  - Día 2: Estadísticas
  - Día 3: Pausar/Activar
  - Día 4-5: Mejoras UX

Total: 10 días laborables
```

### **Opción C: TODO de una vez (Completo)**
```
Sprint de 2 semanas intensivas:
  - Semana 1: Funcionalidades core (Conversaciones + Notificaciones)
  - Semana 2: Mejoras y pulido (Búsqueda + Stats + UX)
  - Weekend final: Testing exhaustivo y documentación
```

---

## 🎯 PRIORIZACIÓN RECOMENDADA

### **IMPRESCINDIBLE para aprobar TFM:**
1. ✅ Autenticación (HECHO)
2. ✅ Habilidades CRUD (HECHO)
3. ✅ Intercambios completos (HECHO)
4. ✅ Responsive (HECHO)
5. ⏳ **Conversaciones básicas** (FALTA)

### **MUY RECOMENDADO:**
6. ⏳ **Notificaciones** (FALTA)
7. ✅ Panel Admin (HECHO)

### **DESEABLE (mejora nota):**
8. ⏳ Búsqueda avanzada (FALTA)
9. ⏳ Estadísticas (FALTA)
10. ⏳ Pausar habilidades (FALTA)

### **OPCIONAL (pulido):**
11. ⏳ Mejoras UX (FALTA)
12. ⏳ PWA features (FALTA)
13. ⏳ Testing E2E (FALTA)

---

## 📊 IMPACTO EN PORCENTAJES

| Implementación | Tests | % Frontend | Estado |
|----------------|-------|------------|--------|
| **ACTUAL** | 12/16 | 75% | ✅ Funcional |
| + Conversaciones | 13/16 | 81% | 🎯 Recomendado |
| + Notificaciones | 14/16 | 87.5% | 🎯 Recomendado |
| + Búsqueda avanzada | 15/16 | 93.75% | ⭐ Excelente |
| + Estadísticas | 16/16 | **100%** | 🏆 Completo |

---

## 🔥 RECOMENDACIÓN FINAL

### **Para PEC3 (Diciembre 2025):**
✅ **IMPLEMENTAR:**
1. **Conversaciones** (lista + chat básico)
2. **Notificaciones** (badge + lista)

Con esto llegas al **87.5%** → **Suficiente para excelente nota en PEC3**

### **Para PEC4/Entrega Final (Enero-Febrero 2026):**
✅ **IMPLEMENTAR:**
3. Búsqueda avanzada
4. Estadísticas de usuario
5. Pausar/Activar habilidades
6. Mejoras UX generales

Con esto llegas al **100%** → **TFM completo y pulido**

---

## 🚀 SIGUIENTE PASO INMEDIATO

¿Qué quieres implementar AHORA?

### **Opción 1: CONVERSACIONES (6-8h)** 🔴 CRÍTICO
- Sistema completo de chat
- Lista de conversaciones
- Vista de mensajes
- Enviar/recibir mensajes

### **Opción 2: NOTIFICACIONES (4-6h)** 🟡 IMPORTANTE
- Badge en header con contador
- Lista de notificaciones
- Marcar como leídas
- Navegación a entidades

### **Opción 3: AMBAS (10-14h)** ⭐ RECOMENDADO
- Conversaciones primero
- Notificaciones después
- Testing al final

### **Opción 4: TODO (20-25h)** 🏆 COMPLETO
- Sprint completo de 2-3 días
- Implementar TODAS las funcionalidades
- Testing exhaustivo
- Documentación completa

---

**¿Por cuál empezamos?** 🚀

---

**Documento creado:** 11 de noviembre de 2025  
**Estado:** Plan completo de implementación  
**Próxima decisión:** Usuario elige qué implementar
