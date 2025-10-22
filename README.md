# 🤝 Galitroco - Plataforma de Intercambio de Habilidades

**TFM (Trabajo Final de Máster)** - Plataforma web para intercambiar habilidades entre usuarios mediante un sistema de trueque basado en tiempo.

---

## 🚀 Características

### Frontend (Angular 19)
- ✅ Sistema de autenticación (registro/login)
- ✅ Gestión de habilidades (crear, editar, buscar)
- ✅ Sistema de intercambios entre usuarios
- ✅ Valoraciones y reputación
- ✅ Chat/Conversaciones
- ✅ Notificaciones
- ✅ Panel de administración
- ✅ Diseño responsive con Angular Material

### Backend (PHP 8.2 + API REST)
- ✅ API REST completa
- ✅ Autenticación con JWT + recuperación de contraseña
- ✅ CRUD de usuarios, habilidades, intercambios
- ✅ Sistema de valoraciones
- ✅ Gestión de conversaciones (con transacciones ACID)
- ✅ Sistema de reportes
- ✅ Categorías de habilidades
- ✅ CORS configurado
- ✅ Código optimizado y libre de debug logs

### Base de Datos (PostgreSQL - Supabase)
- ✅ Esquema completo con relaciones
- ✅ Triggers y funciones automáticas
- ✅ Seeds de datos de prueba
- ✅ Gestión de timestamps

---

## 🛠️ Tecnologías Utilizadas

### Frontend
- **Angular 19**: Framework principal
- **Angular Material**: Componentes UI
- **TypeScript 5.7**: Lenguaje
- **RxJS 7.8**: Programación reactiva
- **SCSS**: Estilos

### Backend
- **PHP 8.2**: Lenguaje del servidor
- **Apache**: Servidor web
- **PDO**: Acceso a base de datos
- **JWT**: Autenticación

### Base de Datos
- **PostgreSQL 15**: Base de datos relacional
- **Supabase**: Hosting de PostgreSQL

### Deploy
- **Render.com**: Hosting (Free Tier)
  - Web Service (Backend - Docker)
  - Static Site (Frontend)
- **GitHub Actions**: CI/CD
- **Docker**: Containerización del backend

---

## 📋 Requisitos de Desarrollo Local

### Backend
- PHP 8.2 o superior
- Composer
- PostgreSQL 15 o Supabase
- Apache o nginx

### Frontend
- Node.js 20 o superior
- npm 10 o superior
- Angular CLI 19

---

## ⚙️ Configuración para Desarrollo Local

## ⚙️ Configuración para Desarrollo Local

### 1. Clonar el repositorio
```bash
git clone https://github.com/tonikampos/render-test-php.git
cd render-test-php
```

### 2. Configurar el Backend

```bash
# Copiar configuración de ejemplo
cp backend/config/database.php.example backend/config/database.php

# Editar con tus credenciales de Supabase o PostgreSQL local
# DB_HOST, DB_NAME, DB_USER, DB_PASSWORD, DB_PORT
```

#### Crear el esquema de base de datos:
```bash
# Usando psql
psql -U tu_usuario -d tu_base_datos -f database/schema.sql
psql -U tu_usuario -d tu_base_datos -f database/seeds.sql

# O desde Supabase SQL Editor
# Copiar y ejecutar database/schema.sql y database/seeds.sql
```

#### Iniciar servidor PHP local (XAMPP, WAMP, MAMP o PHP built-in):
```bash
# Opción 1: PHP built-in server
php -S localhost:8000 -t .

# Opción 2: XAMPP
# Copiar proyecto a htdocs/ y acceder desde http://localhost/probatfm/
```

### 3. Configurar el Frontend

```bash
cd frontend

# Instalar dependencias
npm install

# Configurar entorno de desarrollo
# Editar src/environments/environment.ts
# apiUrl: 'http://localhost:8000/api.php'

# Iniciar servidor de desarrollo
npm start
# o
ng serve

# Acceder a: http://localhost:4200
```

---

## 🌐 Despliegue en Producción (Render.com)

### 🔹 Backend (Ya desplegado)
- **URL**: https://render-test-php-1.onrender.com
- **Tipo**: Web Service (Docker)
- **Auto-deploy**: Activado desde `main` branch

### 🔹 Frontend (Static Site)
- **URL prevista**: https://galitroco-frontend.onrender.com
- **Tipo**: Static Site
- **Build**: `cd frontend && npm install && npm run build:prod`
- **Publish Directory**: `frontend/dist/frontend/browser`
- **Auto-deploy**: Activado desde `main` branch

---

## 📁 Estructura del Proyecto

```
probatfm/
├── backend/                    # API REST en PHP
│   ├── api/                    # Endpoints de la API
│   │   ├── auth.php           # Login/Register
│   │   ├── usuarios.php       # CRUD usuarios
│   │   ├── habilidades.php    # CRUD habilidades
│   │   ├── intercambios.php   # Gestión de intercambios
│   │   ├── valoraciones.php   # Sistema de reputación
│   │   ├── conversaciones.php # Chat
│   │   ├── notificaciones.php # Notificaciones
│   │   ├── categorias.php     # Categorías
│   │   └── reportes.php       # Reportes/denuncias
│   ├── config/                # Configuración
│   │   ├── database.php       # Conexión a PostgreSQL
│   │   └── cors.php           # CORS settings
│   └── utils/                 # Utilidades
│       ├── Auth.php           # JWT & autenticación
│       └── Response.php       # Respuestas estandarizadas
│
├── frontend/                   # SPA en Angular 19
│   ├── src/
│   │   ├── app/
│   │   │   ├── core/          # Servicios core, guards, interceptors
│   │   │   ├── features/      # Módulos principales
│   │   │   │   ├── auth/      # Login/Register
│   │   │   │   ├── habilidades/ # Gestión de habilidades
│   │   │   │   ├── home/      # Página principal
│   │   │   │   └── perfil/    # Perfil de usuario
│   │   │   ├── layout/        # Header, footer
│   │   │   └── shared/        # Componentes y modelos compartidos
│   │   └── environments/      # Configuración por entorno
│   ├── public/
│   │   └── _redirects         # SPA routing para Render
│   └── angular.json           # Configuración Angular
│
├── database/                   # Scripts SQL
│   ├── schema.sql             # Estructura completa de BD
│   ├── schema_supabase.sql    # Versión para Supabase
│   └── seeds.sql              # Datos de prueba
│
├── Dockerfile                          # Docker para backend
├── render.yaml                         # Configuración multi-servicio Render
├── ARQUITECTURA_DEPLOY.md              # Arquitectura de despliegue
├── ESTADO_IMPLEMENTACION_FUNCIONALIDADES.md  # Estado del proyecto
├── INFRAESTRUCTURA_TECNOLOGICA_TFM.md  # Infraestructura técnica
└── README.md                           # Este archivo
```

---

## � URLs de Producción

| Servicio | URL | Estado |
|----------|-----|--------|
| **Backend API** | https://render-test-php-1.onrender.com/api.php | ✅ Desplegado |
| **Frontend** | https://galitroco-frontend.onrender.com | 🔜 Por desplegar |
| **GitHub** | https://github.com/tonikampos/render-test-php | ✅ Activo |
| **Base de Datos** | Supabase (PostgreSQL) | ✅ Activo |

---

## 🧪 Testing

### Backend
```bash
# Test de autenticación
curl -X POST https://render-test-php-1.onrender.com/api.php/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@test.com","password":"password"}'

# Test de habilidades
curl https://render-test-php-1.onrender.com/api.php/habilidades
```

### Frontend
```bash
cd frontend

# Tests unitarios
npm test

# Tests e2e (requiere configuración adicional)
# ng e2e
```

---

## 📖 Documentación Adicional

- **Arquitectura**: Ver `ARQUITECTURA_DEPLOY.md` para detalles del despliegue
- **Infraestructura**: Ver `INFRAESTRUCTURA_TECNOLOGICA_TFM.md` para stack técnico completo
- **Estado del Proyecto**: Ver `ESTADO_IMPLEMENTACION_FUNCIONALIDADES.md`
- **API Backend**: Ver `backend/API_DOCUMENTATION.md` para endpoints completos

---

## 🐛 Troubleshooting

### CORS errors en desarrollo
```javascript
// Asegúrate de que cors.php incluye http://localhost:4200
$allowed_origins = [
    'http://localhost:4200',
    // ...
];
```

### Build de producción falla
```bash
# Limpiar cache de Angular
rm -rf frontend/.angular
rm -rf frontend/node_modules
cd frontend && npm install
npm run build:prod
```

### Base de datos no conecta
```bash
# Verificar variables de entorno en backend/config/database.php
# O en Render: Settings → Environment → DB_HOST, DB_NAME, etc.
```

---

## 🎓 Información del TFM

- **Universidad**: UOC (Universitat Oberta de Catalunya)
- **Programa**: Máster (TFM)
- **Proyecto**: Galitroco - Plataforma de Intercambio de Habilidades
- **Tecnologías**: Angular + PHP + PostgreSQL + Render
- **Arquitectura**: Frontend desacoplado (JAMstack)
- **Año**: 2024-2025

---

## 📝 Licencia

Proyecto académico para TFM - Todos los derechos reservados.

---

## 👨‍💻 Autor

**Toni Kampos**  
GitHub: [@tonikampos](https://github.com/tonikampos)  
Repositorio: [render-test-php](https://github.com/tonikampos/render-test-php)

---

## 🔄 Historial de Cambios Recientes

### Octubre 2025 - Limpieza y Optimización para PEC2
- ✅ **Eliminados 16 archivos obsoletos** (docs redundantes, tests, diagnósticos)
- ✅ **Bug crítico corregido**: POST /conversaciones ahora usa transacciones ACID
- ✅ **Código optimizado**: Eliminados 100+ líneas de logs de debug
- ✅ **Mejora de seguridad**: Transacciones garantizan consistencia de datos
- ✅ **Documentación actualizada**: Reflejando el estado actual del proyecto

---

**Última actualización**: 22 de octubre de 2025