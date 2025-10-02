# ✅ Checklist de Deploy - Galitroco Frontend

## 📦 Pre-Deploy (Ya completado)

- [x] Backend desplegado en Render
- [x] Base de datos Supabase configurada
- [x] CORS configurado con URL del frontend
- [x] `environment.prod.ts` con URL del backend
- [x] Archivo `_redirects` para SPA routing
- [x] Script `build:prod` en package.json
- [x] `render.yaml` configurado
- [x] Documentación creada

---

## 🚀 Deploy en Render.com

### Paso 1: Crear Static Site
- [ ] Acceder a https://dashboard.render.com
- [ ] Click en "New +" → "Static Site"
- [ ] Conectar repositorio: `tonikampos/render-test-php`
- [ ] Autorizar acceso si es necesario

### Paso 2: Configuración Básica
- [ ] **Name**: `galitroco-frontend`
- [ ] **Region**: Frankfurt (EU Central) o la más cercana
- [ ] **Branch**: `main`
- [ ] **Root Directory**: *(dejar vacío)*

### Paso 3: Build Settings
- [ ] **Build Command**: `cd frontend && npm install && npm run build:prod`
- [ ] **Publish Directory**: `frontend/dist/frontend/browser`

### Paso 4: Advanced Settings
- [ ] **Auto-Deploy**: YES ✅
- [ ] **Pull Request Previews**: YES ✅ (opcional)

### Paso 5: Deploy
- [ ] Click en "Create Static Site"
- [ ] Esperar build (~3-5 minutos)
- [ ] Verificar logs de build

---

## ✅ Verificación Post-Deploy

### 1. Acceso
- [ ] Frontend carga: https://galitroco-frontend.onrender.com
- [ ] No hay errores 404
- [ ] Estilos cargan correctamente
- [ ] Favicon visible

### 2. Navegación
- [ ] Página Home funciona
- [ ] Routing funciona (cambiar de página sin 404)
- [ ] Refresh en ruta profunda no da 404 (gracias a `_redirects`)

### 3. Backend Connection
- [ ] Abrir DevTools (F12) → Network
- [ ] Intentar login
- [ ] Ver petición a `https://render-test-php-1.onrender.com/api.php`
- [ ] Status 200 (no CORS error)

### 4. Funcionalidades Críticas
- [ ] **Login**: Funciona
- [ ] **Registro**: Funciona
- [ ] **Listar habilidades**: Se cargan desde backend
- [ ] **Crear habilidad**: Se guarda en backend
- [ ] **Ver detalle**: Navega correctamente

---

## 🔧 Si algo falla...

### Build failed
1. [ ] Revisar logs de build en Render
2. [ ] Verificar que localmente funciona: `npm run build:prod`
3. [ ] Verificar que `package.json` tiene todas las deps
4. [ ] Hacer "Clear build cache & deploy"

### CORS Error
1. [ ] Verificar `backend/config/cors.php` incluye URL del frontend
2. [ ] Si cambiaste el nombre del frontend, actualizar cors.php
3. [ ] Git push para redeploy del backend

### 404 en rutas
1. [ ] Verificar `frontend/public/_redirects` existe
2. [ ] Contenido: `/*    /index.html   200`
3. [ ] Redeploy en Render

### White screen
1. [ ] Verificar "Publish Directory" en Render: `frontend/dist/frontend/browser`
2. [ ] Build local y comprobar ruta: `ls frontend/dist/frontend/browser`
3. [ ] Debe contener `index.html`

---

## 📊 Métricas de Éxito

- [ ] Build time < 5 minutos
- [ ] Deploy exitoso sin errores
- [ ] Lighthouse Score > 90 (opcional, pero recomendable)
- [ ] No errores en consola del navegador
- [ ] Todas las peticiones a backend con status 200

---

## 🎉 Post-Deploy

### Actualizar Documentación
- [ ] Añadir URL real del frontend al README.md
- [ ] Capturar screenshots para el TFM
- [ ] Documentar el proceso en memoria del TFM

### Git & GitHub
- [ ] Commit de cambios de CORS
- [ ] Push a `main` para trigger auto-deploy
- [ ] Tag de versión (opcional): `git tag v1.0.0 && git push --tags`

### Compartir
- [ ] Probar en móvil
- [ ] Probar en diferentes navegadores
- [ ] Compartir URL con tutor/profesor si es necesario

---

## 📌 URLs de Referencia

- **Frontend**: https://galitroco-frontend.onrender.com *(cambiar si usas otro nombre)*
- **Backend**: https://render-test-php-1.onrender.com/api.php
- **Render Dashboard**: https://dashboard.render.com
- **GitHub Repo**: https://github.com/tonikampos/render-test-php

---

**✅ Deploy completado**: __/__/____  
**Tiempo total**: _____ minutos
