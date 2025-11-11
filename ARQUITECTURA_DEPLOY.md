# 🏗️ Arquitectura de Deploy - Backend Docker vs Frontend Static

**Documento para TFM** - Explicación de decisiones arquitectónicas

---

## 📋 Índice

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Backend: Web Service con Docker](#backend-web-service-con-docker)
3. [Frontend: Static Site](#frontend-static-site)
4. [Comparativa Técnica](#comparativa-técnica)
5. [Flujo de Comunicación](#flujo-de-comunicación)
6. [Ventajas de esta Arquitectura](#ventajas-de-esta-arquitectura)
7. [Alternativas Descartadas](#alternativas-descartadas)
8. [Justificación para el TFM](#justificación-para-el-tfm)

---

## 🎯 Resumen Ejecutivo

**Decisión arquitectónica**: Usar **Docker para el backend** y **Static Site para el frontend**.

**Razón principal**: Cada tecnología se despliega de la forma más eficiente según su naturaleza:
- **Backend (PHP)**: Requiere runtime activo → Docker
- **Frontend (Angular)**: Genera archivos estáticos → CDN/Static Site

**Resultado**: Arquitectura moderna, escalable y eficiente en recursos.

---

## 🐳 Backend: Web Service con Docker

### ¿Qué es?

El backend es un **Web Service** en Render que ejecuta un contenedor Docker 24/7.

### ¿Por qué Docker?

#### 1. Necesita Runtime Activo
```
Usuario → HTTP Request → Apache → PHP 8.2 → PostgreSQL
                         ↓
                   Procesa código
                   Consulta BD
                   Devuelve JSON
```

El backend **procesa** cada petición dinámicamente:
- Ejecuta código PHP
- Conecta a base de datos
- Valida autenticación (Sesiones PHP + tokens hexadecimales)
- Genera respuestas personalizadas

#### 2. Dependencias del Sistema
```dockerfile
FROM php:8.2-apache

# Extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_pgsql

# Configuración de Apache
RUN a2enmod rewrite headers

# Variables de entorno
ENV DB_HOST=...
ENV DB_NAME=...
```

Docker garantiza:
- ✅ PHP 8.2 con extensiones específicas
- ✅ Apache configurado correctamente
- ✅ Mismo entorno en dev y producción
- ✅ Aislamiento de dependencias

#### 3. Estado y Conexiones
- **Conexiones persistentes** a PostgreSQL
- **Sesiones** de usuario
- **Pools de conexión** a BD
- **Logs** en tiempo real
- **Procesamiento** de lógica de negocio

### Recursos Consumidos
- **CPU**: Procesa cada petición
- **RAM**: 512 MB (Free Tier Render)
- **Almacenamiento**: ~500 MB (Docker image)
- **Red**: Tráfico bidireccional constante

---

## 📦 Frontend: Static Site

### ¿Qué es?

El frontend es un **Static Site** en Render que sirve archivos HTML/CSS/JS pregenerados.

### ¿Por qué NO Docker?

#### 1. No Necesita Runtime en el Servidor

```bash
# Build (una sola vez)
npm run build:prod
↓
dist/frontend/browser/
├── index.html        (5 KB)
├── main.js          (200 KB minificado)
├── styles.css       (50 KB)
└── assets/          (imágenes, etc.)

# Deploy
Render sirve estos archivos directamente (como un CDN)
```

El código **NO se ejecuta en el servidor**:
- JavaScript se ejecuta en el **navegador del usuario**
- HTML/CSS son solo archivos estáticos
- No hay procesamiento en el servidor

#### 2. Build-Time vs Runtime

| Aspecto | Backend (Docker) | Frontend (Static) |
|---------|------------------|-------------------|
| **Cuándo se genera** | Runtime (cada petición) | Build-time (una sola vez) |
| **Qué hace el servidor** | Ejecuta código PHP | Solo sirve archivos |
| **Dónde se ejecuta el código** | Servidor (Render) | Navegador del usuario |
| **Consumo de recursos** | Constante | ~0 (solo almacenamiento) |

#### 3. CDN y Performance

```
Usuario en España
    ↓
CDN de Render (Nodo en Frankfurt)
    ↓
Archivos estáticos servidos en <100ms
```

Ventajas del Static Site:
- ✅ **CDN global**: Archivos distribuidos geográficamente
- ✅ **Caché agresivo**: Navegadores cachean HTML/CSS/JS
- ✅ **Sin overhead**: No hay Docker, PHP, ni servidor web
- ✅ **Ultra rápido**: Tiempo de respuesta <100ms

### Recursos Consumidos
- **CPU**: 0 (solo sirve archivos)
- **RAM**: 0 (no hay proceso ejecutándose)
- **Almacenamiento**: ~5 MB (archivos compilados)
- **Red**: Solo tráfico de descarga (una vez por usuario)

---

## 📊 Comparativa Técnica

### Tabla Comparativa Completa

| Aspecto | Backend (Web Service) | Frontend (Static Site) |
|---------|----------------------|------------------------|
| **Tecnología** | PHP 8.2 + Apache | Angular 19 (compilado) |
| **Deploy** | Docker container | Archivos estáticos |
| **Ejecución** | Servidor (24/7) | Navegador del usuario |
| **Procesamiento** | Runtime (dinámico) | Build-time (estático) |
| **CPU en servidor** | Alta | Nula |
| **RAM en servidor** | 512 MB | 0 MB |
| **Tamaño en disco** | ~500 MB | ~5 MB |
| **Velocidad de respuesta** | 100-500ms | <100ms (CDN) |
| **Escalabilidad** | Vertical (más CPU/RAM) | Horizontal (CDN) |
| **Coste en Render** | 1 Web Service (Free Tier) | 1 Static Site (Free Tier) |
| **Auto-deploy** | Desde GitHub | Desde GitHub |
| **Mantenimiento** | Actualizar image Docker | Rebuild del bundle |

### Costes en Render Free Tier

```
Free Tier de Render:
├── 1 Web Service (Backend Docker)     ← 750 horas/mes
├── 1 Static Site (Frontend)           ← Ilimitado
└── Total: GRATIS ✅
```

**⚠️ Limitación importante del Free Tier:**
- **Cold Start:** Tras 15 minutos de inactividad, el backend entra en "sleep mode"
- **Primera petición:** Tarda 30-90 segundos en "despertar" el servicio
- **Peticiones posteriores:** Respuesta normal (<500ms) mientras esté activo
- **Solución:** Acceder a `/api.php?resource=health` antes de usar la aplicación

Si pusieras **ambos en Docker**:
- ❌ Necesitarías 2 Web Services
- ❌ Free Tier solo incluye 1 Web Service
- ❌ Tendrías que pagar por el segundo

---

## 🔄 Flujo de Comunicación

### Diagrama de Arquitectura

```
┌─────────────────────────────────────────────────┐
│              USUARIO (Navegador)                │
│  - Ejecuta JavaScript de Angular                │
│  - Renderiza HTML/CSS                           │
│  - Mantiene estado de la aplicación            │
└────────┬────────────────────────────────────────┘
         │
         │ 1. Carga inicial (una vez)
         ├──────────────────────────────────────────►
         │            Frontend (Static Site)         
         │            https://galitroco-frontend.onrender.com
         │            - Render CDN
         │            - HTML + CSS + JS minificados
         │            - ~5 MB descargados
         │
         │ 2. Peticiones API (muchas veces)
         └──────────────────────────────────────────►
                      Backend (Docker)               
                      https://render-test-php-1.onrender.com/api.php
                      - PHP 8.2 + Apache
                      - Procesa lógica de negocio
                      - Conecta a PostgreSQL
                      - Devuelve JSON
                      ↓
                ┌─────────────────┐
                │   PostgreSQL    │
                │   (Supabase)    │
                └─────────────────┘
```

### Flujo Detallado

#### Paso 1: Usuario accede a la aplicación
```
1. Usuario → https://galitroco-frontend.onrender.com
2. Render CDN sirve index.html + main.js + styles.css
3. Navegador descarga archivos (~5 MB, una sola vez)
4. Angular inicia en el navegador del usuario
```

#### Paso 2: Usuario hace login
```
1. Usuario rellena formulario de login
2. Angular (en navegador) → POST /api.php/auth/login
   ↓
3. Backend (Docker) recibe petición
4. PHP valida credenciales en PostgreSQL
5. PHP genera token hexadecimal (64 caracteres, SHA-256)
6. PHP crea sesión con cookies (SameSite=None; Secure)
7. Backend → JSON con token y datos de usuario
   ↓
8. Angular guarda token en localStorage
9. Angular actualiza UI (muestra usuario logueado)
```

#### Paso 3: Usuario lista habilidades
```
1. Angular → GET /api.php/habilidades
   (con cookies de sesión PHP automáticas)
   ↓
2. Backend valida sesión PHP ($_SESSION['user_id'])
3. Backend consulta PostgreSQL
4. Backend → JSON con lista de habilidades
   ↓
5. Angular actualiza la vista con los datos
```

### CORS (Cross-Origin Resource Sharing)

El frontend y backend están en **dominios diferentes**:
- **Frontend**: `https://galitroco-frontend.onrender.com`
- **Backend**: `https://render-test-php-1.onrender.com`

Por eso necesitamos CORS configurado en `backend/config/cors.php`:

```php
$allowed_origins = [
    'http://localhost:4200',                      // Dev local
    'https://render-test-php-1.onrender.com',     // Backend
    'https://galitroco-frontend.onrender.com',    // Frontend ✅
];
```

**Configuración crítica de cookies para autenticación cross-domain:**

```php
session_set_cookie_params([
    'lifetime' => 86400,      // 1 día
    'path' => '/',
    'domain' => '',           // Vacío para localhost, dominio específico para producción
    'secure' => true,         // Solo HTTPS (obligatorio para SameSite=None)
    'httponly' => true,       // No accesible desde JavaScript (seguridad)
    'samesite' => 'None'      // Permite cookies cross-domain (crítico)
]);
```

**Headers CORS necesarios:**
- `Access-Control-Allow-Origin`: Dominio específico del frontend (no '*')
- `Access-Control-Allow-Credentials: true` (obligatorio para cookies)
- `Access-Control-Allow-Methods`: GET, POST, PUT, DELETE, OPTIONS
- `Access-Control-Allow-Headers`: Content-Type, Authorization, X-Requested-With

---

## 🏆 Ventajas de esta Arquitectura

### 1. Separación de Responsabilidades (SoC)

```
Frontend (Presentación)           Backend (Lógica + Datos)
├── UI/UX                         ├── API REST
├── Routing (Angular)             ├── Autenticación (Sesiones PHP + cookies)
├── Validación de formularios     ├── Validación de negocio
├── Estado de la aplicación       ├── Consultas a BD
└── Interacción con el usuario    └── Procesamiento de datos
```

**Ventaja**: Equipos pueden trabajar independientemente.

### 2. Escalabilidad Independiente

```
Frontend (Static Site)
├── Escala automáticamente (CDN)
├── Soporta 1M usuarios sin cambios
└── Coste: $0 (archivos estáticos)

Backend (Docker)
├── Escala verticalmente (más CPU/RAM)
├── Escala horizontalmente (más instancias)
└── Coste: Proporcional al uso
```

**Ventaja**: Puedes escalar solo lo que necesites.

### 3. Deploy Independiente

```
Cambio en el Frontend
├── git push → Render redeploy Static Site
├── Tiempo: 3-5 minutos
├── Backend NO afectado
└── Usuarios siguen usando la app

Cambio en el Backend
├── git push → Render redeploy Web Service
├── Tiempo: 5-8 minutos
├── Frontend NO afectado (solo API calls)
└── Deploy sin downtime (con Health Checks)
```

**Ventaja**: Menos riesgo en cada deploy.

### 4. Performance Optimizado

```
Frontend
├── Archivos servidos desde CDN
├── Caché del navegador agresivo
├── HTTP/2, compresión gzip/brotli
└── Tiempo de carga: <2 segundos

Backend
├── Solo procesa API calls
├── Sin overhead de servir HTML/CSS/JS
├── Optimizado para JSON
└── Tiempo de respuesta: 100-300ms
```

**Ventaja**: Experiencia de usuario superior.

### 5. Coste Optimizado

```
Opción A: Backend Docker + Frontend Static (ACTUAL)
├── Backend: 1 Web Service (Free Tier) ✅
├── Frontend: 1 Static Site (Free Tier) ✅
└── Total: $0/mes

Opción B: Ambos en Docker (ALTERNATIVA)
├── Backend: 1 Web Service (Free Tier)
├── Frontend: 1 Web Service (necesitarías pagar) ❌
└── Total: $7/mes (por el segundo Web Service)
```

**Ventaja**: Ahorro de $84/año.

### 6. Desarrollo Moderno (JAMstack)

```
JAMstack Architecture
├── J = JavaScript (Angular)
│   └── Se ejecuta en el cliente
├── A = APIs (PHP REST)
│   └── Backend desacoplado
└── M = Markup (HTML precompilado)
    └── Servido estáticamente
```

**Ventaja**: Arquitectura estándar de la industria.

---

## 🚫 Alternativas Descartadas

### Alternativa 1: Frontend también en Docker

#### Cómo sería:
```dockerfile
# Dockerfile para frontend
FROM node:20 AS build
WORKDIR /app
COPY frontend/ .
RUN npm install && npm run build

FROM nginx:alpine
COPY --from=build /app/dist/frontend/browser /usr/share/nginx/html
COPY nginx.conf /etc/nginx/nginx.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
```

#### Problemas:
1. ❌ **Overhead innecesario**: nginx ejecutándose 24/7 solo para servir archivos
2. ❌ **Consumo de recursos**: CPU + RAM del contenedor
3. ❌ **Más lento**: No CDN, latencia del servidor
4. ❌ **Más complejo**: Mantenimiento de nginx config
5. ❌ **Coste**: Necesitarías pagar por segundo Web Service
6. ❌ **Sin ventajas**: nginx no aporta nada que CDN no haga mejor

#### Cuándo SÍ usar Docker para frontend:
- Si necesitas **SSR** (Server-Side Rendering) con Angular Universal
- Si necesitas **lógica de servidor** (redirects complejos, A/B testing)
- Si tienes **requisitos de seguridad** específicos (custom headers)

**Veredicto**: No aplica a este proyecto.

---

### Alternativa 2: Monolito (Todo junto)

#### Cómo sería:
```
Backend sirve el frontend
├── /api/* → PHP procesa API
└── /* → PHP sirve archivos estáticos de Angular
```

#### Problemas:
1. ❌ **Acoplamiento**: Frontend y backend en el mismo deploy
2. ❌ **Escalabilidad limitada**: Todo escala junto
3. ❌ **Overhead**: PHP sirviendo archivos estáticos (ineficiente)
4. ❌ **Deploy arriesgado**: Un cambio en frontend requiere redeploy del backend
5. ❌ **No es moderno**: Patrón antiguo (pre-2015)

#### Cuándo SÍ usar monolito:
- Proyectos **muy pequeños** (MVP, prototipo)
- **Poco tráfico** esperado
- Equipo **muy reducido** (1 desarrollador)

**Veredicto**: No apto para TFM universitario.

---

### Alternativa 3: Serverless (Functions)

#### Cómo sería:
```
Backend → AWS Lambda / Vercel Functions
Frontend → Vercel / Netlify
```

#### Ventajas:
- ✅ Ultra escalable
- ✅ Pay-per-use

#### Problemas para este proyecto:
- ❌ **PHP no es ideal** para serverless (cold starts lentos)
- ❌ **Complejidad**: Múltiples plataformas (AWS + Vercel)
- ❌ **Coste**: PostgreSQL externo (Supabase) + Lambda
- ❌ **Curva de aprendizaje**: Más complejo para TFM

**Veredicto**: Over-engineering para este caso.

---

## 🎓 Justificación para el TFM

### ¿Por qué esta arquitectura es IDEAL para tu TFM?

#### 1. Demuestra Conocimientos Modernos
```
✅ Docker y containerización
✅ Arquitecturas desacopladas (microservicios)
✅ JAMstack (tendencia actual)
✅ CI/CD (auto-deploy desde GitHub)
✅ Cloud-native (optimizado para cloud)
✅ CORS y seguridad web
```

#### 2. Buenas Prácticas de Ingeniería
- **Separation of Concerns** (SoC)
- **Single Responsibility Principle** (SRP)
- **DRY** (Don't Repeat Yourself)
- **Scalability by design**
- **Cost optimization**

#### 3. Escalabilidad Real
```
Tráfico bajo (inicio)
├── Backend: 1 instancia (512 MB RAM)
├── Frontend: CDN global
└── Coste: $0/mes

Tráfico medio (100 usuarios/día)
├── Backend: 1 instancia (1 GB RAM)
├── Frontend: CDN global (sin cambios)
└── Coste: $7/mes

Tráfico alto (10,000 usuarios/día)
├── Backend: 3 instancias (load balancer)
├── Frontend: CDN global (sin cambios)
└── Coste: $25/mes
```

#### 4. Documentable para la Memoria
Puedes incluir secciones como:
- **Justificación de decisiones arquitectónicas** ← Este documento
- **Comparativa de alternativas** ← Sección de alternativas
- **Análisis de costes** ← Tabla de costes
- **Diagramas de arquitectura** ← Diagramas incluidos
- **Performance benchmarks** ← Métricas de CDN vs Docker

#### 5. Fácil de Defender
```
Pregunta del tribunal: "¿Por qué no pusiste todo en Docker?"

Respuesta:
"El frontend no necesita runtime en el servidor, ya que Angular 
genera archivos estáticos que se ejecutan en el navegador del 
usuario. Usar Docker sería overhead innecesario que consumiría 
recursos sin aportar valor. Además, un Static Site con CDN es 
más rápido y escalable que nginx en Docker."

Resultado: ✅ Nota alta por decisión fundamentada
```

---

## 📚 Conceptos Clave para la Memoria del TFM

### 1. JAMstack Architecture
- **Definición**: JavaScript (cliente) + APIs (servidor) + Markup (estático)
- **Ventaja**: Desacoplamiento completo entre frontend y backend
- **Referencia**: [jamstack.org](https://jamstack.org/)

### 2. Static Site Generation (SSG)
- **Definición**: Pre-generar HTML/CSS/JS en tiempo de build
- **Ventaja**: Sin procesamiento en el servidor, máxima velocidad
- **Ejemplo**: Tu aplicación Angular

### 3. Content Delivery Network (CDN)
- **Definición**: Red de servidores distribuidos geográficamente
- **Ventaja**: Archivos servidos desde el nodo más cercano al usuario
- **Ejemplo**: Render CDN para tu frontend

### 4. Containerización con Docker
- **Definición**: Empaquetar aplicación con sus dependencias
- **Ventaja**: "Funciona en mi máquina" = "Funciona en producción"
- **Ejemplo**: Tu backend PHP

### 5. RESTful API
- **Definición**: API basada en HTTP con recursos (GET, POST, PUT, DELETE)
- **Ventaja**: Estándar de la industria, fácil de consumir
- **Ejemplo**: Tu backend PHP

---

## 📊 Métricas de Éxito

### Performance
- **Tiempo de carga inicial**: <3 segundos
- **Tiempo de respuesta API**: <500ms
- **First Contentful Paint (FCP)**: <1.5 segundos
- **Time to Interactive (TTI)**: <3 segundos

### Escalabilidad
- **Usuarios concurrentes soportados**: 1,000+ (con Free Tier)
- **Requests/segundo**: 100+ (backend)
- **Bandwidth**: Ilimitado (frontend CDN)

### Costes
- **Free Tier**: $0/mes (hasta 750 horas backend)
- **Paid Tier**: $7/mes (backend 24/7)
- **Coste por usuario**: <$0.01/mes

---

## 🔗 Referencias y Recursos

### Documentación Oficial
- [Render Static Sites](https://render.com/docs/static-sites)
- [Render Web Services](https://render.com/docs/web-services)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)
- [Angular Deployment](https://angular.dev/tools/cli/deployment)

### Arquitectura y Patrones
- [JAMstack](https://jamstack.org/)
- [The Twelve-Factor App](https://12factor.net/)
- [Microservices Architecture](https://microservices.io/)

### Performance
- [Web Vitals](https://web.dev/vitals/)
- [CDN Benefits](https://www.cloudflare.com/learning/cdn/what-is-a-cdn/)

---

## 🎯 Conclusión

**Decisión tomada**: Backend en Docker + Frontend como Static Site

**Justificación**: 
- Cada componente se despliega de la forma más eficiente según su naturaleza
- Arquitectura moderna, escalable y cost-effective
- Demuestra conocimiento de buenas prácticas de ingeniería de software
- Ideal para documentar y defender en un TFM

**Resultado esperado**:
- ✅ Aplicación rápida y responsive
- ✅ Costes optimizados (Free Tier)
- ✅ Escalabilidad futura garantizada
- ✅ Documentación técnica sólida para la memoria del TFM

---

**Autor**: Antonio Campos  
**Proyecto**: Galitroco - Plataforma de Intercambio de Habilidades  
**Universidad**: UOC (Universitat Oberta de Catalunya)  
**Documento**: Arquitectura de Deploy  
**Fecha**: 28 de octubre de 2025 (última revisión)
