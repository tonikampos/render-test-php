# 📦 Guía de Deploy del Frontend en Render.com

## 🎯 Objetivo
Desplegar el frontend Angular de Galitroco como **Static Site** en Render.com (Free Tier).

---

## ✅ Pre-requisitos

- ✅ Backend ya desplegado en: `https://render-test-php-1.onrender.com`
- ✅ Código del frontend en GitHub: `tonikampos/render-test-php`
- ✅ Cuenta de Render.com vinculada a GitHub
- ✅ Archivo `_redirects` en `frontend/public/` (para SPA routing)

---

## 📋 Paso 1: Crear el Static Site en Render

### 1.1 Acceder a Render Dashboard
1. Entra en: https://dashboard.render.com
2. Click en **"New +"** → **"Static Site"**

### 1.2 Conectar Repositorio
1. **Connect a repository**: Selecciona `tonikampos/render-test-php`
2. Si no aparece, haz click en **"Configure account"** y autoriza el acceso

### 1.3 Configurar el Static Site

Rellena los siguientes campos:

| Campo | Valor |
|-------|-------|
| **Name** | `galitroco-frontend` |
| **Region** | `Frankfurt (EU Central)` o la más cercana |
| **Branch** | `main` |
| **Root Directory** | *(dejar vacío)* |
| **Build Command** | `cd frontend && npm install && npm run build:prod` |
| **Publish Directory** | `frontend/dist/frontend/browser` |

### 1.4 Variables de Entorno (Environment Variables)
**No se necesitan** para un Static Site (las variables están hardcoded en `environment.prod.ts`).

### 1.5 Advanced Settings (Opcional)
- **Auto-Deploy**: ✅ Yes (Deploy automático al hacer push a `main`)
- **Pull Request Previews**: ✅ Yes (Para testear PRs antes de mergear)

### 1.6 Crear el Static Site
- Click en **"Create Static Site"**
- Render empezará a hacer el build automáticamente

---

## 📊 Proceso de Build

Render ejecutará estos pasos:

```bash
# 1. Clone del repositorio
git clone https://github.com/tonikampos/render-test-php.git

# 2. Install de dependencias
cd frontend
npm install

# 3. Build de producción
npm run build:prod
# Genera: frontend/dist/frontend/browser/

# 4. Deploy de archivos estáticos
# Render sirve los archivos desde dist/frontend/browser/
```

**Tiempo estimado**: 3-5 minutos

---

## ✅ Verificación del Deploy

### 1. Check del Build Log
En el dashboard de Render, verás:
```
==> Building...
==> Installing dependencies...
==> Building Angular app...
✔ Browser application bundle generation complete.
✔ Copying assets complete.
✔ Index html generation complete.
==> Build successful!
==> Your site is live at https://galitroco-frontend.onrender.com
```

### 2. Testear la URL
Abre en el navegador:
```
https://galitroco-frontend.onrender.com
```

Deberías ver tu aplicación Angular funcionando.

### 3. Testear la conexión con el Backend
1. Abre las **DevTools** del navegador (F12)
2. Ve a **Network** tab
3. Navega por la app (login, habilidades, etc.)
4. Verifica que las peticiones a `https://render-test-php-1.onrender.com/api.php` funcionen (status 200)

---

## 🔧 Configuración de CORS (Ya está hecha)

El archivo `backend/config/cors.php` ya incluye:

```php
$allowed_origins = [
    'http://localhost:4200',                      // Dev local
    'https://render-test-php-1.onrender.com',     // Backend
    'https://galitroco-frontend.onrender.com',    // Frontend ✅
];
```

**Si cambias el nombre del frontend**, recuerda actualizar este archivo.

---

## 🚀 Workflow de Desarrollo

### Deploy Automático
Cada vez que hagas `git push` a `main`, Render:
1. Detecta cambios en `frontend/`
2. Ejecuta el build automáticamente
3. Despliega la nueva versión (~3-5 min)

### Deploy Manual
Si quieres forzar un redeploy:
1. Ve al dashboard de Render
2. Click en tu Static Site
3. Click en **"Manual Deploy"** → **"Clear build cache & deploy"**

---

## 📁 Estructura de Archivos Importantes

```
probatfm/
├── frontend/
│   ├── src/
│   │   └── environments/
│   │       └── environment.prod.ts  ← URL del backend
│   ├── public/
│   │   └── _redirects               ← Routing SPA (/*  /index.html  200)
│   ├── angular.json                 ← Output path
│   └── package.json                 ← Build scripts
├── backend/
│   └── config/
│       └── cors.php                 ← Orígenes permitidos
└── render.yaml                      ← Configuración de Render (opcional)
```

---

## 🐛 Troubleshooting

### Problema 1: "Build failed"
**Posible causa**: Error en `npm install` o `ng build`

**Solución**:
1. Revisa el **Build Log** en Render
2. Si falla `npm install`, verifica que `package.json` tenga todas las dependencias
3. Si falla `ng build`, testea localmente:
   ```powershell
   cd frontend
   npm install
   npm run build:prod
   ```

### Problema 2: "404 Not Found" en rutas de Angular
**Posible causa**: Falta el archivo `_redirects`

**Solución**:
1. Verifica que `frontend/public/_redirects` existe
2. Contenido: `/*    /index.html   200`
3. Redeploy en Render

### Problema 3: "CORS Error" en consola del navegador
**Posible causa**: Backend no acepta el origen del frontend

**Solución**:
1. Abre `backend/config/cors.php`
2. Añade la URL del frontend a `$allowed_origins`:
   ```php
   'https://tu-frontend.onrender.com',
   ```
3. Haz `git push` para redeploy del backend

### Problema 4: "White screen" al cargar la app
**Posible causa**: Angular no encuentra `index.html`

**Solución**:
1. Verifica el **Publish Directory** en Render:
   - Debe ser: `frontend/dist/frontend/browser`
2. Haz un build local para verificar la ruta:
   ```powershell
   cd frontend
   npm run build:prod
   ls dist/frontend/browser  # Debe mostrar index.html
   ```

---

## 📊 URLs Finales

| Servicio | URL | Tipo |
|----------|-----|------|
| **Backend API** | https://render-test-php-1.onrender.com/api.php | Web Service (Docker) |
| **Frontend** | https://galitroco-frontend.onrender.com | Static Site |
| **GitHub Repo** | https://github.com/tonikampos/render-test-php | Repositorio |

---

## 🎓 Notas para el TFM

### Arquitectura Desacoplada
- **Frontend**: Static Site (CDN de Render)
  - Angular 19 SPA
  - Archivos estáticos (HTML/CSS/JS)
  - Consumidor de API REST
  
- **Backend**: Web Service (Docker)
  - PHP 8.2 + Apache
  - API REST
  - Base de datos PostgreSQL (Supabase)

### Ventajas de esta Arquitectura
1. **Escalabilidad independiente**: Puedes escalar frontend y backend por separado
2. **Despliegue independiente**: Cambios en el frontend no afectan al backend
3. **Optimización**: CDN de Render sirve el frontend ultra rápido
4. **Coste**: Free Tier de Render cubre ambos servicios
5. **Mantenimiento**: Separación clara de responsabilidades

### Patrón JAMstack
- **J**avaScript (Angular)
- **A**PIs (Backend PHP)
- **M**arkup (HTML estático precompilado)

---

## ✅ Checklist Final

Antes de dar por terminado el deploy:

- [ ] Frontend desplegado en Render
- [ ] URL del frontend funcionando
- [ ] Login funciona (conexión con backend OK)
- [ ] CORS configurado correctamente
- [ ] Routing de Angular funciona (rutas sin 404)
- [ ] DevTools sin errores de consola
- [ ] Auto-deploy activado en Render
- [ ] URLs documentadas en el README

---

## 🔗 Recursos Adicionales

- [Render Static Sites Docs](https://render.com/docs/static-sites)
- [Angular Build for Production](https://angular.dev/tools/cli/build)
- [SPA Routing en Render](https://render.com/docs/deploy-create-react-app#using-client-side-routing)

---

**✅ ¡Listo para producción!**

Última actualización: 2 de octubre de 2025
