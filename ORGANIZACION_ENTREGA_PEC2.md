# 📦 GUÍA PRÁCTICA DE ORGANIZACIÓN - ENTREGA PEC2

**Fecha:** 28 de octubre de 2025  
**Estudiante:** Antonio Campos  
**Asignatura:** TFM - UOC  

---

## 🎯 OBJETIVO

Organizar todo lo que ya tienes (código + documentación) en la estructura correcta para entregar la PEC2.

**NO se modificará la aplicación** - Solo organización de archivos.

---

## 📂 ESTRUCTURA DE ENTREGA REQUERIDA

```
PEC2_Campos_Antonio.zip
│
├── 1_DOCUMENTACION/
│   ├── PEC2_mem_Campos_Antonio.pdf          # Tu memoria (la que ya tienes)
│   ├── README_PROYECTO.pdf                   # Guía técnica del proyecto
│   ├── TESTING_BACKEND.pdf                   # Testing backend
│   ├── TESTING_FRONTEND.pdf                  # Testing frontend
│   └── LICENCIAS_TERCEROS.pdf                # Licencias
│
└── 2_PROYECTO/
    ├── README.md                             # Instrucciones generales
    ├── api.php                               # Proxy API (CRÍTICO)
    ├── Dockerfile                            # Config Docker
    ├── render.yaml                           # Config Render
    ├── backend/                              # Código backend completo
    ├── frontend/                             # Código frontend completo
    └── database/                             # Scripts SQL
```

---

## ✅ CHECKLIST DE ARCHIVOS

### 📁 Carpeta 1_DOCUMENTACION/

| Archivo destino | Archivo origen actual | Acción |
|-----------------|----------------------|---------|
| `PEC2_mem_Campos_Antonio.pdf` | (tu memoria ya hecha) | Copiar con este nombre |
| `README_PROYECTO.pdf` | `README_PEC2.pdf` | Copiar y renombrar |
| `TESTING_BACKEND.pdf` | `TESTING_Y_ENDPOINTS_TFM.pdf` | Copiar y renombrar |
| `TESTING_FRONTEND.pdf` | `TESTING_FRONTEND_MANUAL.pdf` | Copiar y renombrar |
| `LICENCIAS_TERCEROS.pdf` | `LICENCIAS_TERCEROS.pdf` | Copiar tal cual |

### 📁 Carpeta 2_PROYECTO/

**Archivos en la raíz:**
- ✅ `README.md` (instrucciones generales)
- ✅ `api.php` (OBLIGATORIO - proxy de la API)
- ✅ `Dockerfile`
- ✅ `render.yaml`
- ✅ `.gitignore` (para referencia)

**Carpetas completas:**
- ✅ `backend/` (toda la carpeta tal cual)
- ✅ `frontend/` (toda la carpeta, **SIN node_modules**)
- ✅ `database/` (solo `schema.sql` y `seeds.sql`)

**❌ NO incluir:**
- ❌ Carpeta `.git/` (muy pesada)
- ❌ Carpeta `node_modules/` (muy pesada, se instala con npm)
- ❌ Carpeta `.angular/` (archivos de compilación)
- ❌ Carpeta `old/` (archivos internos de desarrollo)
- ❌ Archivos `ESTRUCTURA_ENTREGA_PEC2.md/pdf` (son guías internas)
- ❌ Archivos `GUIA_*.md` (son guías internas)

---

## 🚀 SCRIPT POWERSHELL PARA GENERAR LA ENTREGA

Copia y ejecuta este script en PowerShell:

```powershell
# =============================================================================
# SCRIPT DE ORGANIZACIÓN ENTREGA PEC2
# =============================================================================

# Configuración
$origen = "d:\xampUOC\htdocs\probatfm"
$destino = "D:\PEC2_Campos_Antonio"
$destinoZip = "D:\PEC2_Campos_Antonio.zip"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "ORGANIZACIÓN ENTREGA PEC2" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Paso 1: Limpiar destino si existe
Write-Host "[1/6] Limpiando destino..." -ForegroundColor Yellow
if (Test-Path $destino) {
    Remove-Item -Recurse -Force $destino
}
if (Test-Path $destinoZip) {
    Remove-Item -Force $destinoZip
}

# Paso 2: Crear estructura
Write-Host "[2/6] Creando estructura de carpetas..." -ForegroundColor Yellow
New-Item -ItemType Directory -Path "$destino\1_DOCUMENTACION" -Force | Out-Null
New-Item -ItemType Directory -Path "$destino\2_PROYECTO" -Force | Out-Null

# Paso 3: Copiar documentación
Write-Host "[3/6] Copiando documentación..." -ForegroundColor Yellow

# Memoria principal (debes tenerla preparada con este nombre)
if (Test-Path "$origen\PEC2_mem_Campos_Antonio.pdf") {
    Copy-Item "$origen\PEC2_mem_Campos_Antonio.pdf" "$destino\1_DOCUMENTACION\"
    Write-Host "  ✓ Memoria principal copiada" -ForegroundColor Green
} else {
    Write-Host "  ⚠ FALTA: PEC2_mem_Campos_Antonio.pdf" -ForegroundColor Red
}

# Documentación técnica (renombrada)
Copy-Item "$origen\README_PEC2.pdf" "$destino\1_DOCUMENTACION\README_PROYECTO.pdf"
Write-Host "  ✓ README_PROYECTO.pdf" -ForegroundColor Green

Copy-Item "$origen\TESTING_Y_ENDPOINTS_TFM.pdf" "$destino\1_DOCUMENTACION\TESTING_BACKEND.pdf"
Write-Host "  ✓ TESTING_BACKEND.pdf" -ForegroundColor Green

Copy-Item "$origen\TESTING_FRONTEND_MANUAL.pdf" "$destino\1_DOCUMENTACION\TESTING_FRONTEND.pdf"
Write-Host "  ✓ TESTING_FRONTEND.pdf" -ForegroundColor Green

Copy-Item "$origen\LICENCIAS_TERCEROS.pdf" "$destino\1_DOCUMENTACION\"
Write-Host "  ✓ LICENCIAS_TERCEROS.pdf" -ForegroundColor Green

# Paso 4: Copiar proyecto (excluyendo archivos innecesarios)
Write-Host "[4/6] Copiando código del proyecto..." -ForegroundColor Yellow

# Archivos raíz
Copy-Item "$origen\README.md" "$destino\2_PROYECTO\"
Copy-Item "$origen\api.php" "$destino\2_PROYECTO\"
Copy-Item "$origen\Dockerfile" "$destino\2_PROYECTO\"
Copy-Item "$origen\render.yaml" "$destino\2_PROYECTO\"
Copy-Item "$origen\.gitignore" "$destino\2_PROYECTO\" -ErrorAction SilentlyContinue
Write-Host "  ✓ Archivos raíz copiados" -ForegroundColor Green

# Backend completo
Copy-Item "$origen\backend" "$destino\2_PROYECTO\backend" -Recurse
Write-Host "  ✓ Backend copiado" -ForegroundColor Green

# Frontend (sin node_modules ni .angular)
$excludeFrontend = @('node_modules', '.angular')
Get-ChildItem "$origen\frontend" -Recurse -Exclude $excludeFrontend | 
    Where-Object { $_.FullName -notmatch 'node_modules|\.angular' } |
    Copy-Item -Destination {
        $path = $_.FullName.Replace("$origen\frontend", "$destino\2_PROYECTO\frontend")
        if ($_.PSIsContainer) {
            New-Item -ItemType Directory -Path $path -Force | Out-Null
        }
        $path
    } -Force

Write-Host "  ✓ Frontend copiado (sin node_modules)" -ForegroundColor Green

# Database (solo schema.sql y seeds.sql)
New-Item -ItemType Directory -Path "$destino\2_PROYECTO\database" -Force | Out-Null
Copy-Item "$origen\database\schema.sql" "$destino\2_PROYECTO\database\"
Copy-Item "$origen\database\seeds.sql" "$destino\2_PROYECTO\database\"
Write-Host "  ✓ Database copiado (schema.sql + seeds.sql)" -ForegroundColor Green

# Paso 5: Crear ZIP
Write-Host "[5/6] Creando archivo ZIP..." -ForegroundColor Yellow
Compress-Archive -Path "$destino\*" -DestinationPath $destinoZip -Force
Write-Host "  ✓ ZIP creado" -ForegroundColor Green

# Paso 6: Verificación final
Write-Host "[6/6] Verificando contenido..." -ForegroundColor Yellow

$zipSize = (Get-Item $destinoZip).Length / 1MB
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✓ ENTREGA COMPLETADA" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Archivo creado: $destinoZip" -ForegroundColor Cyan
Write-Host "Tamaño: $([math]::Round($zipSize, 2)) MB" -ForegroundColor Cyan
Write-Host ""

# Listar contenido
Write-Host "Contenido del ZIP:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1_DOCUMENTACION/" -ForegroundColor White
Get-ChildItem "$destino\1_DOCUMENTACION" | ForEach-Object {
    $size = [math]::Round($_.Length / 1KB, 0)
    Write-Host "  - $($_.Name) ($size KB)" -ForegroundColor Gray
}

Write-Host ""
Write-Host "2_PROYECTO/" -ForegroundColor White
Get-ChildItem "$destino\2_PROYECTO" -File | ForEach-Object {
    Write-Host "  - $($_.Name)" -ForegroundColor Gray
}
Get-ChildItem "$destino\2_PROYECTO" -Directory | ForEach-Object {
    Write-Host "  - $($_.Name)/" -ForegroundColor Gray
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Siguiente paso: Revisar que todo está OK" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
```

---

## 📋 VERIFICACIÓN MANUAL ANTES DE ENTREGAR

### 1. Descomprime el ZIP en una ubicación temporal
```powershell
Expand-Archive -Path "D:\PEC2_Campos_Antonio.zip" -DestinationPath "D:\VERIFICACION_PEC2" -Force
```

### 2. Verifica que existen estas carpetas y archivos:

```
✓ 1_DOCUMENTACION/
  ✓ PEC2_mem_Campos_Antonio.pdf
  ✓ README_PROYECTO.pdf
  ✓ TESTING_BACKEND.pdf
  ✓ TESTING_FRONTEND.pdf
  ✓ LICENCIAS_TERCEROS.pdf

✓ 2_PROYECTO/
  ✓ README.md
  ✓ api.php
  ✓ Dockerfile
  ✓ render.yaml
  ✓ backend/
    ✓ api/ (10 archivos PHP)
    ✓ config/
    ✓ models/
    ✓ utils/
  ✓ frontend/
    ✓ src/
    ✓ angular.json
    ✓ package.json
    ✓ tsconfig.json
    ❌ NO debe haber node_modules/
  ✓ database/
    ✓ schema.sql
    ✓ seeds.sql
```

### 3. Verifica el tamaño del ZIP
- ✅ Si es **< 50 MB**: Perfecto
- ⚠️ Si es **50-100 MB**: Revisar si hay archivos innecesarios
- ❌ Si es **> 100 MB**: HAY node_modules o .git (eliminarlos)

### 4. Checklist final:

- [ ] El ZIP se llama exactamente `PEC2_Campos_Antonio.zip`
- [ ] Tiene 2 carpetas: `1_DOCUMENTACION` y `2_PROYECTO`
- [ ] La memoria principal está en `1_DOCUMENTACION/`
- [ ] El archivo `api.php` está en `2_PROYECTO/` (raíz)
- [ ] NO hay carpeta `.git/`
- [ ] NO hay carpeta `node_modules/`
- [ ] NO hay carpeta `old/`
- [ ] El tamaño total es razonable (< 50 MB ideal)

---

## 🎯 RESUMEN RÁPIDO

### Paso 1: Prepara tu memoria
Asegúrate de tener tu memoria con el nombre:
```
PEC2_mem_Campos_Antonio.pdf
```

### Paso 2: Ejecuta el script
Copia todo el script PowerShell de arriba y ejecútalo.

### Paso 3: Verifica el resultado
Descomprime el ZIP y verifica que todo está correcto.

### Paso 4: Entregar
Sube el archivo `PEC2_Campos_Antonio.zip` al aula virtual.

---

## ⚠️ PROBLEMAS COMUNES

### Problema 1: "El ZIP pesa más de 100 MB"
**Solución:** node_modules no se eliminó correctamente.
```powershell
# Elimina manualmente antes de ejecutar el script:
Remove-Item -Recurse -Force "d:\xampUOC\htdocs\probatfm\frontend\node_modules"
Remove-Item -Recurse -Force "d:\xampUOC\htdocs\probatfm\frontend\.angular"
```

### Problema 2: "Falta el archivo PEC2_mem_Campos_Antonio.pdf"
**Solución:** Renombra tu memoria con ese nombre exacto y ponla en la raíz:
```powershell
Copy-Item "ruta\a\tu\memoria.pdf" "d:\xampUOC\htdocs\probatfm\PEC2_mem_Campos_Antonio.pdf"
```

### Problema 3: "No se copia bien el frontend"
**Solución:** Usa este comando alternativo:
```powershell
robocopy "d:\xampUOC\htdocs\probatfm\frontend" "D:\PEC2_Campos_Antonio\2_PROYECTO\frontend" /E /XD node_modules .angular
```

---

## ✅ CHECKLIST FINAL ANTES DE ENTREGAR

- [ ] He ejecutado el script sin errores
- [ ] He descomprimido el ZIP para verificar
- [ ] La estructura tiene 2 carpetas (1_DOCUMENTACION y 2_PROYECTO)
- [ ] Están todos los PDFs en 1_DOCUMENTACION
- [ ] El archivo api.php está en 2_PROYECTO
- [ ] El código backend está completo
- [ ] El código frontend está completo (sin node_modules)
- [ ] Los scripts SQL están en database/
- [ ] El tamaño del ZIP es razonable (< 50 MB)
- [ ] He probado abrir todos los PDFs
- [ ] El nombre del ZIP es exactamente: `PEC2_Campos_Antonio.zip`

---

**¡LISTO PARA ENTREGAR!** 🚀
