# Análisis de Tablas y Vistas en Base de Datos GaliTroco

**Fecha:** 2024-10-24  
**Base de datos:** Supabase (Producción)

## 📊 Resumen

- **12 tablas** principales
- **7 tipos ENUM**
- **18 foreign keys**
- **27 índices**
- **1 vista** (estadisticas_usuarios)

---

## ✅ Tablas Principales (12)

Todas estas tablas están correctamente incluidas en `schema_production.sql`:

1. `categorias_habilidades` - Categorías para clasificar habilidades
2. `conversaciones` - Conversaciones entre usuarios
3. `habilidades` - Habilidades ofrecidas/demandadas por usuarios
4. `intercambios` - Propuestas e intercambios entre usuarios
5. `mensajes` - Mensajes dentro de conversaciones
6. `notificaciones` - Notificaciones del sistema
7. `participantes_conversacion` - Relación muchos a muchos (conversaciones-usuarios)
8. `password_resets` - Tokens para recuperación de contraseña
9. `reportes` - Reportes de contenido inapropiado
10. `sesiones` - Sesiones activas de usuarios
11. `usuarios` - Usuarios del sistema
12. `valoraciones` - Valoraciones entre usuarios

---

## 👁️ Vistas (1)

### `estadisticas_usuarios`

**Tipo:** VIEW (vista calculada)  
**Propósito:** Calcular estadísticas agregadas para cada usuario

**Campos calculados:**
- `id` - ID del usuario
- `nombre_usuario` - Nombre del usuario
- `ubicacion` - Ubicación del usuario
- `total_habilidades` - Total de habilidades activas
- `ofertas_activas` - Habilidades de tipo 'oferta'
- `demandas_activas` - Habilidades de tipo 'demanda'
- `total_intercambios` - Total de intercambios (propuestos + completados + etc.)
- `intercambios_completados` - Solo intercambios con estado 'completado'
- `valoracion_promedio` - Media de las valoraciones recibidas
- `total_valoraciones` - Número total de valoraciones recibidas

**Uso en el código:**
- `backend/api/usuarios.php` (línea 198) - Endpoint GET `/usuarios/{id}/estadisticas`

**Estado en schema:** ✅ AÑADIDA (commit ed3d78a)

---

## ❌ Tablas NO Encontradas en Supabase

### `visitantes`

**Ubicación:** Solo en código local (`index.php`)  
**Propósito:** Contador de visitas para la landing page  
**Motivo:** Esta tabla solo existe en desarrollo local, **NO** está en Supabase  

**Campos esperados:**
- `id` (INTEGER)
- `contador` (INTEGER)

**Uso en código:**
- `index.php` (líneas 74, 239, 242)

**Acción recomendada:** 
- ❌ **NO AÑADIR** a `schema_production.sql` (no existe en producción)
- ⚠️ Considerar si es necesaria en producción o eliminar el código

---

## 🔧 Correcciones Realizadas

### 1. Campo `ultima_actualizacion` en tabla `habilidades`

**Problema:** El script generado decía `fecha_actualizacion`  
**Correcto:** En Supabase se llama `ultima_actualizacion`  
**Commit:** 3344e80

### 2. Vista `estadisticas_usuarios` faltante

**Problema:** No estaba incluida en el schema  
**Solución:** Añadida con su definición completa  
**Commit:** ed3d78a

---

## 📝 Notas Técnicas

1. **Vistas vs Tablas:**
   - Las **vistas** no almacenan datos, son consultas que se ejecutan dinámicamente
   - `estadisticas_usuarios` se recalcula en cada consulta usando JOINs

2. **Índices:**
   - Todos los índices de las tablas están correctamente documentados
   - Las vistas **NO** tienen índices propios (usan los índices de las tablas base)

3. **Foreign Keys:**
   - Todas las relaciones están correctamente definidas con `ON DELETE CASCADE` donde corresponde

---

## ✅ Estado Final

El archivo `database/schema_production.sql` ahora contiene:

- ✅ Todas las tablas de producción (12)
- ✅ Todos los tipos ENUM (7)
- ✅ Todas las foreign keys (18)
- ✅ Todos los índices (27)
- ✅ La vista `estadisticas_usuarios` (1)
- ✅ Campo corregido: `ultima_actualizacion` en `habilidades`

**Commits realizados:**
1. `3344e80` - Corregir nombre de campo ultima_actualizacion
2. `ed3d78a` - Añadir vista estadisticas_usuarios

**Pendiente de push:** SÍ (commits locales no subidos a GitHub)
