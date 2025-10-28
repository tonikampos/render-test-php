# 📦 GUÍA PARA PREPARAR ENTREGA PEC2

**Proyecto:** GaliTroco TFM  
**Autor:** Antonio Campos  
**Fecha límite PEC2:** 2 de noviembre de 2025

---

## 🎯 RESUMEN: QUÉ ENTREGAR

### Opción 1: Dos archivos separados
1. **`PEC2_mem_Campos_Antonio.pdf`** → Memoria del proyecto
2. **`PEC2_pry_Campos_Antonio.zip`** → Todo el código fuente

### Opción 2: Un único ZIP (RECOMENDADO)
**`PEC2_Campos_Antonio.zip`** conteniendo:
- `/documentacion/` → Memoria PDF + docs técnicas
- `/proyecto/` → Todo el código fuente

---

## 📋 PASO 1: PREPARAR LA ESTRUCTURA DEL ZIP

### 1.1 Crear carpeta temporal

```powershell
# En Windows PowerShell
cd D:\
mkdir PEC2_Entrega_Temporal
cd PEC2_Entrega_Temporal
```

### 1.2 Crear estructura de carpetas

```powershell
mkdir proyecto
mkdir documentacion
```

---

## 📁 PASO 2: COPIAR EL CÓDIGO FUENTE

### 2.1 Copiar backend (EXCLUIR archivos innecesarios)

```powershell
# Copiar toda la carpeta backend
xcopy "D:\xampUOC\htdocs\probatfm\backend" "D:\PEC2_Entrega_Temporal\proyecto\backend\" /E /I /H

# Eliminar archivos de test/diagnóstico (si aún existen)
cd D:\PEC2_Entrega_Temporal\proyecto\backend
del /S test.php diagnose.php test_*.php
```

**✅ Incluir:**
- `/api/` (todos los endpoints)
- `/config/` (configuración EXCEPTO credenciales reales)
- `/models/` (modelos de datos)
- `/utils/` (utilidades)
- `Dockerfile`
- `.htaccess`

**❌ EXCLUIR:**
- Archivos con extensión `.log`
- Archivos temporales (`.tmp`, `.bak`)
- Credenciales reales en `config/database.php` (usar placeholder)

### 2.2 Copiar frontend (EXCLUIR node_modules)

```powershell
# Copiar frontend SIN node_modules
xcopy "D:\xampUOC\htdocs\probatfm\frontend" "D:\PEC2_Entrega_Temporal\proyecto\frontend\" /E /I /H /EXCLUDE:exclude.txt
```

**Crear archivo `exclude.txt`:**
```
node_modules
dist
.angular
.vscode
```

**✅ Incluir:**
- `/src/` (todo el código fuente)
- `package.json`
- `package-lock.json`
- `angular.json`
- `tsconfig.json`
- `README_FRONTEND.md`

**❌ EXCLUIR:**
- `/node_modules/` (muy pesado, se instala con `npm install`)
- `/dist/` (build generado)
- `/.angular/` (caché de Angular)

### 2.3 Copiar base de datos

```powershell
# Copiar scripts SQL
xcopy "D:\xampUOC\htdocs\probatfm\database" "D:\PEC2_Entrega_Temporal\proyecto\database\" /E /I
```

**✅ Incluir:**
- `schema.sql` (esquema completo)
- `seeds.sql` (datos de prueba)
- `README_DATABASE.md`

---

## 📝 PASO 3: COPIAR DOCUMENTACIÓN

### 3.1 Copiar documentos técnicos

```powershell
# Copiar docs técnicas
copy "D:\xampUOC\htdocs\probatfm\TESTING_Y_ENDPOINTS_TFM.md" "D:\PEC2_Entrega_Temporal\documentacion\"
copy "D:\xampUOC\htdocs\probatfm\ARQUITECTURA_DEPLOY.md" "D:\PEC2_Entrega_Temporal\documentacion\"
copy "D:\xampUOC\htdocs\probatfm\GUIA_RECUPERACION_PASSWORD.md" "D:\PEC2_Entrega_Temporal\documentacion\"
```

### 3.2 Copiar READMEs

```powershell
# README principal
copy "D:\xampUOC\htdocs\probatfm\README_PEC2.md" "D:\PEC2_Entrega_Temporal\proyecto\README.md"

# Licencias
copy "D:\xampUOC\htdocs\probatfm\LICENCIAS_TERCEROS.md" "D:\PEC2_Entrega_Temporal\proyecto\"
```

### 3.3 Añadir memoria TFM (cuando esté lista)

```powershell
# Copiar memoria (PDF)
copy "D:\ruta\a\tu\memoria\PEC2_Memoria_TFM.pdf" "D:\PEC2_Entrega_Temporal\documentacion\PEC2_mem_Campos_Antonio.pdf"
```

---

## 🔒 PASO 4: PROTEGER CREDENCIALES

### 4.1 Editar backend/config/database.php

Reemplazar credenciales reales por placeholders:

```php
<?php
return [
    'host' => 'TU_HOST_AQUI',  // Ej: aws-0-us-east-1.pooler.supabase.com
    'port' => '5432',
    'dbname' => 'TU_NOMBRE_BD_AQUI',
    'user' => 'TU_USUARIO_AQUI',
    'password' => 'TU_PASSWORD_AQUI'
];
```

### 4.2 Verificar que NO incluyes:

❌ API Keys reales (Resend, Supabase)  
❌ Contraseñas de base de datos  
❌ Tokens JWT secretos  
❌ Credenciales de email  

**Nota:** En el README incluir instrucciones de cómo configurar estas credenciales.

---

## ✅ PASO 5: VERIFICAR CONTENIDO

### 5.1 Estructura final debe ser:

```
PEC2_Entrega_Temporal/
│
├── /documentacion/
│   ├── PEC2_mem_Campos_Antonio.pdf       ← Memoria TFM
│   ├── TESTING_Y_ENDPOINTS_TFM.md        ← Testing backend
│   ├── ARQUITECTURA_DEPLOY.md            ← Arquitectura
│   └── GUIA_RECUPERACION_PASSWORD.md     ← Guía password
│
└── /proyecto/
    ├── README.md                         ← Instrucciones principales
    ├── LICENCIAS_TERCEROS.md             ← Licencias
    │
    ├── /backend/
    │   ├── /api/
    │   ├── /config/
    │   ├── /models/
    │   ├── /utils/
    │   ├── Dockerfile
    │   └── README_BACKEND.md
    │
    ├── /frontend/
    │   ├── /src/
    │   ├── package.json
    │   ├── angular.json
    │   └── README_FRONTEND.md
    │
    └── /database/
        ├── schema.sql
        ├── seeds.sql
        └── README_DATABASE.md
```

### 5.2 Checklist de verificación

```powershell
# Verificar tamaños de carpetas
cd D:\PEC2_Entrega_Temporal
Get-ChildItem -Recurse | Measure-Object -Property Length -Sum
```

**Tamaños esperados:**
- `/backend/` → ~5-10 MB
- `/frontend/` (sin node_modules) → ~5-15 MB
- `/database/` → <1 MB
- `/documentacion/` → ~5-10 MB (con PDF)
- **Total:** ~20-40 MB

**Si el ZIP supera 100 MB:** ❌ Algo está mal (probablemente node_modules incluido)

---

## 📦 PASO 6: CREAR EL ZIP

### Opción A: Windows Explorer (Recomendado)

1. **Navegar a:** `D:\PEC2_Entrega_Temporal`
2. **Seleccionar ambas carpetas:** `documentacion` y `proyecto`
3. **Click derecho** → "Enviar a" → "Carpeta comprimida (en zip)"
4. **Renombrar el ZIP:** `PEC2_Campos_Antonio.zip`

### Opción B: PowerShell

```powershell
# Comprimir todo en un ZIP
Compress-Archive -Path "D:\PEC2_Entrega_Temporal\*" -DestinationPath "D:\PEC2_Campos_Antonio.zip"
```

### Opción C: 7-Zip (si tienes instalado)

```powershell
# Con 7-Zip (mayor compresión)
& "C:\Program Files\7-Zip\7z.exe" a -tzip "D:\PEC2_Campos_Antonio.zip" "D:\PEC2_Entrega_Temporal\*"
```

---

## 🧪 PASO 7: PROBAR EL ZIP (IMPORTANTE)

### 7.1 Extraer en otra carpeta

```powershell
# Crear carpeta de prueba
mkdir D:\TEST_PEC2
cd D:\TEST_PEC2

# Extraer el ZIP
Expand-Archive "D:\PEC2_Campos_Antonio.zip" -DestinationPath "D:\TEST_PEC2\"
```

### 7.2 Verificar que funciona

```powershell
# Ir a frontend
cd D:\TEST_PEC2\proyecto\frontend

# Instalar dependencias
npm install

# Verificar que arranca
npm start
```

**Si arranca correctamente:** ✅ El ZIP está bien preparado

**Si falla:** ❌ Revisar qué archivos faltan

---

## 📤 PASO 8: SUBIR A LA UOC

### 8.1 Acceder al aula virtual

1. Ir a: https://cv.uoc.edu
2. Entrar en asignatura TFM
3. Ir a pestaña "Evaluación" → "PEC2"

### 8.2 Subir archivos

**Opción 1 (ZIP único):**
- Subir: `PEC2_Campos_Antonio.zip`

**Opción 2 (separado):**
- Subir: `PEC2_mem_Campos_Antonio.pdf`
- Subir: `PEC2_pry_Campos_Antonio.zip`

### 8.3 Verificar subida

✅ Archivo subido correctamente  
✅ Tamaño correcto (~20-40 MB)  
✅ Nombre correcto  
✅ Antes de la fecha límite

---

## 📊 PASO 9: CHECKLIST FINAL

### Antes de entregar, verifica:

- [ ] Memoria PDF incluida y completa
- [ ] Código backend completo (sin archivos test)
- [ ] Código frontend completo (sin node_modules)
- [ ] Scripts SQL de base de datos
- [ ] README.md con instrucciones claras
- [ ] LICENCIAS_TERCEROS.md completo
- [ ] Documentación técnica (TESTING, ARQUITECTURA)
- [ ] Credenciales protegidas (placeholders)
- [ ] ZIP funciona al extraer y probar
- [ ] Tamaño razonable (<100 MB)
- [ ] Nombre de archivo correcto
- [ ] Entregado antes del 2 de noviembre 2025

---

## ⚠️ ERRORES COMUNES A EVITAR

### ❌ NO incluir:

- `node_modules/` (1 GB de peso innecesario)
- Archivos de configuración personal (`.vscode/`, `.idea/`)
- Archivos temporales (`.log`, `.tmp`, `.bak`)
- Credenciales reales en el código
- Builds compilados (`/dist/`, `/build/`)
- Backups de archivos
- Capturas de pantalla sueltas (deben ir en la memoria)

### ❌ NO olvidar:

- Instrucciones de instalación en README
- Listado de licencias de terceros
- Documentación técnica del backend
- Scripts SQL de la base de datos
- `package.json` y `package-lock.json` del frontend

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### Problema 1: ZIP demasiado grande (>100 MB)

**Causa:** Probablemente incluiste `node_modules/`

**Solución:**
```powershell
# Verificar qué ocupa espacio
Get-ChildItem -Recurse | Sort-Object Length -Descending | Select-Object -First 20
```

### Problema 2: Frontend no arranca tras extraer ZIP

**Causa:** Falta `package.json` o está corrupto

**Solución:** Verificar que `package.json` está incluido y es correcto

### Problema 3: Backend no conecta a BD

**Causa:** Credenciales no configuradas

**Solución:** Normal, el evaluador debe configurar sus propias credenciales siguiendo el README

---

## 📞 CONTACTO

**Autor:** Antonio Campos  
**Email UOC:** _(incluir tu email)_  
**Consultor:** _(incluir nombre)_

---

**Última actualización:** 23 de octubre de 2025  
**Versión:** 1.0  
**Estado:** ✅ Lista para usar
