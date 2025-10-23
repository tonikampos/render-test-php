# 📊 INSTALACIÓN DE BASE DE DATOS - GaliTroco

> **Instrucciones para tutores/evaluadores de la UOC**  
> Scripts SQL generados automáticamente desde la base de datos de **producción en Supabase**

---

## 🎯 ¿QUÉ CONTIENE ESTA CARPETA?

Esta carpeta contiene los scripts SQL necesarios para replicar la base de datos del proyecto GaliTroco en cualquier instancia de PostgreSQL 15+.

### 📁 Archivos principales (generados desde producción):

| Archivo | Descripción | Uso recomendado |
|---------|-------------|-----------------|
| **`install_complete.sql`** | **Todo en uno**: Esquema + Datos | ⭐ **RECOMENDADO** - Instalación completa en un solo paso |
| **`schema_production.sql`** | Solo estructura de tablas | Si quieres crear la BD vacía |
| **`seeds_production.sql`** | Solo datos de muestra | Si ya tienes el esquema y quieres cargar datos |

### 📄 Archivos auxiliares:

- `extract_schema_supabase.php` - Script PHP que generó los archivos SQL desde Supabase
- `schema.sql`, `seeds.sql`, etc. - Scripts antiguos (pueden estar desactualizados)

---

## 🚀 INSTALACIÓN RÁPIDA (OPCIÓN RECOMENDADA)

### Prerrequisitos:
- PostgreSQL 15 o superior instalado
- Cliente de PostgreSQL (psql, pgAdmin, DBeaver, etc.)
- Permisos para crear bases de datos

### Paso 1: Crear base de datos

```sql
CREATE DATABASE galitrocodb
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'es_ES.UTF-8'
    LC_CTYPE = 'es_ES.UTF-8';
```

> **Nota:** Si tu sistema no tiene el locale `es_ES.UTF-8`, usa `en_US.UTF-8` o el locale por defecto de tu sistema.

### Paso 2: Conectar a la base de datos

```bash
psql -U postgres -d galitrocodb
```

O desde pgAdmin/DBeaver: Click derecho en la conexión → **Set Active Database** → `galitrocodb`

### Paso 3: Ejecutar el script completo

#### Opción A: Desde línea de comandos (psql)

```bash
psql -U postgres -d galitrocodb -f install_complete.sql
```

#### Opción B: Desde pgAdmin/DBeaver

1. Abrir el archivo `install_complete.sql`
2. Ejecutar todo el script (Ctrl + Enter / F5)
3. Verificar que no hay errores

#### Opción C: En Windows con PowerShell

```powershell
cd database
Get-Content install_complete.sql | & "C:\Program Files\PostgreSQL\15\bin\psql.exe" -U postgres -d galitrocodb
```

---

## ✅ VERIFICACIÓN DE LA INSTALACIÓN

Después de ejecutar el script, verifica que todo se creó correctamente:

### 1. Verificar tablas creadas

```sql
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'public' 
AND table_type = 'BASE TABLE'
ORDER BY table_name;
```

**Resultado esperado: 12 tablas**
```
categorias_habilidades
conversaciones
habilidades
intercambios
mensajes
notificaciones
participantes_conversacion
password_resets
reportes
sesiones
usuarios
valoraciones
```

### 2. Verificar tipos ENUM

```sql
SELECT typname FROM pg_type 
WHERE typcategory = 'E' 
ORDER BY typname;
```

**Resultado esperado: 7 tipos ENUM**
```
estado_habilidad
estado_intercambio
estado_reporte
rol_usuario
tipo_contenido_reportado
tipo_habilidad
tipo_notificacion
```

### 3. Verificar datos de muestra

```sql
SELECT 
    (SELECT COUNT(*) FROM usuarios) as usuarios,
    (SELECT COUNT(*) FROM categorias_habilidades) as categorias,
    (SELECT COUNT(*) FROM habilidades) as habilidades,
    (SELECT COUNT(*) FROM intercambios) as intercambios;
```

**Resultado esperado:**
```
usuarios: 8
categorias: 8
habilidades: 10
intercambios: 5
```

---

## 🧪 USUARIOS DE PRUEBA

El script `seeds_production.sql` carga los siguientes usuarios de prueba:

| Usuario | Email | Password | Rol |
|---------|-------|----------|-----|
| maria_garcia | maria@example.com | `password` | usuario |
| juan_lopez | juan@example.com | `password` | usuario |
| ana_martinez | ana@example.com | `password` | usuario |
| pedro_rodriguez | pedro@example.com | `password` | usuario |
| laura_fernandez | laura@example.com | `password` | usuario |
| carlos_sanchez | carlos@example.com | `password` | usuario |
| admin_galitroco | admin@galitroco.com | `password` | **administrador** |
| test_user | test@test.com | `Test123456` | usuario |

> **Nota:** Las contraseñas están hasheadas con bcrypt (cost 10). La contraseña plana es `password` para todos excepto `test_user` que usa `Test123456`.

---

## 🔧 INSTALACIÓN PASO A PASO (AVANZADO)

Si prefieres ejecutar el proceso en pasos separados:

### Paso 1: Crear tipos ENUM

```bash
psql -U postgres -d galitrocodb -c "$(sed -n '/CREATE TYPE/,/;/p' schema_production.sql)"
```

### Paso 2: Crear tablas

```bash
psql -U postgres -d galitrocodb -f schema_production.sql
```

### Paso 3: Cargar datos de muestra

```bash
psql -U postgres -d galitrocodb -f seeds_production.sql
```

---

## 📦 ESTRUCTURA DE LA BASE DE DATOS

### Tablas principales:

```
usuarios                    → Usuarios del sistema
  ├── sesiones              → Sesiones de autenticación (JWT)
  ├── password_resets       → Tokens de recuperación de contraseña
  └── habilidades           → Habilidades ofrecidas/demandadas
      ├── categorias_habilidades → Categorías (Hogar, Tecnología, etc.)
      └── intercambios      → Propuestas de intercambio
          ├── conversaciones → Chats entre usuarios
          │   ├── participantes_conversacion
          │   └── mensajes
          └── valoraciones  → Ratings después de intercambio
notificaciones              → Sistema de notificaciones
reportes                    → Reportes de contenido/usuarios
```

### Tipos de datos personalizados:

- **rol_usuario:** `usuario` | `administrador`
- **tipo_habilidad:** `oferta` | `demanda`
- **estado_habilidad:** `activa` | `pausada` | `intercambiada`
- **estado_intercambio:** `propuesto` | `aceptado` | `rechazado` | `completado` | `cancelado`
- **estado_reporte:** `pendiente` | `revisado` | `resuelto`
- **tipo_contenido_reportado:** `perfil` | `habilidad`
- **tipo_notificacion:** `nuevo_intercambio` | `intercambio_aceptado` | etc.

---

## 🛠️ REGENERAR LOS SCRIPTS SQL

Si necesitas regenerar los scripts desde Supabase:

```bash
cd database
php extract_schema_supabase.php
```

Este script se conecta a Supabase en producción y extrae:
- Esquema completo (tipos ENUM, tablas, foreign keys, índices)
- Datos de muestra (primeros 10 registros de cada tabla)

**Requisitos:**
- PHP 8.2+
- Extensión PDO PostgreSQL
- Variables de entorno configuradas (`DATABASE_URL` o credenciales locales)

---

## 🔍 TROUBLESHOOTING

### Error: "role 'postgres' does not exist"

Cambiar el usuario en los comandos:
```bash
psql -U tu_usuario -d galitrocodb -f install_complete.sql
```

### Error: "database galitrocodb already exists"

La BD ya existe. Puedes:
1. Conectarte directamente: `psql -U postgres -d galitrocodb`
2. O eliminarla y recrearla:
```sql
DROP DATABASE IF EXISTS galitrocodb;
CREATE DATABASE galitrocodb;
```

### Error: "locale es_ES.UTF-8 not found"

Usar el locale por defecto del sistema:
```sql
CREATE DATABASE galitrocodb WITH ENCODING = 'UTF8';
```

### Error: "type estado_habilidad already exists"

Los tipos ENUM ya existen. Opciones:
1. **Eliminar y recrear:**
```sql
DROP TYPE IF EXISTS estado_habilidad CASCADE;
-- (repetir para cada tipo ENUM)
```

2. **O ejecutar solo la parte de tablas** (comentar la sección de CREATE TYPE)

---

## 📞 SOPORTE

- **Proyecto:** GaliTroco - Sistema de Intercambio de Habilidades
- **Autor:** Antonio Campos
- **Email:** toni.vendecasa@gmail.com
- **TFM:** Máster Desarrollo de Sitios y Aplicaciones Web (UOC)
- **Fecha generación scripts:** 23 de octubre de 2025

---

## 📝 NOTAS ADICIONALES

- Los scripts fueron generados automáticamente desde la **base de datos de producción en Supabase**
- El esquema está **validado y operativo** (92% de cobertura en 25 tests de integración)
- Los datos de muestra incluyen:
  - 8 usuarios (6 normales + 1 admin + 1 test)
  - 8 categorías de habilidades
  - 10 habilidades publicadas
  - 5 intercambios en diferentes estados
  - 2 conversaciones con mensajes
  - 3 valoraciones completadas
  - 7 notificaciones de ejemplo

---

**🎓 Este proyecto es parte del Trabajo Final de Máster (TFM) - PEC2**
