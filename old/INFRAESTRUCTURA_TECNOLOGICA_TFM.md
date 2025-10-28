# INFRAESTRUCTURA TECNOLÓGICA DEL TFM
## Plataforma de Intercambio de Habilidades "Galitroco"

**Autor:** Antonio Campos  
**Universidad:** UOC (Universitat Oberta de Catalunya)  
**Fecha:** Octubre 2025  
**Versión:** 1.0

---

## 📋 ÍNDICE

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Arquitectura General del Sistema](#arquitectura-general)
3. [Stack Tecnológico Frontend](#frontend)
4. [Stack Tecnológico Backend](#backend)
5. [Base de Datos](#base-de-datos)
6. [Infraestructura Cloud y DevOps](#cloud-devops)
7. [Herramientas de Desarrollo](#herramientas-desarrollo)
8. [Seguridad](#seguridad)
9. [Comunicaciones y Notificaciones](#comunicaciones)
10. [Control de Versiones](#control-versiones)
11. [Monitorización y Testing](#monitorizacion)
12. [Diagrama de Arquitectura](#diagrama-arquitectura)
13. [Flujo de Despliegue](#flujo-despliegue)
14. [Costes y Escalabilidad](#costes-escalabilidad)
15. [Conclusiones Técnicas](#conclusiones)

---

## 1. RESUMEN EJECUTIVO {#resumen-ejecutivo}

El proyecto **Galitroco** es una plataforma web moderna de intercambio de habilidades desarrollada siguiendo arquitecturas contemporáneas basadas en:

- **Separación Frontend-Backend** (arquitectura desacoplada)
- **API RESTful** para comunicación entre servicios
- **Contenedorización** con Docker para el backend
- **Static Site Generation** para el frontend
- **Base de datos PostgreSQL** gestionada en la nube (Supabase)
- **Despliegue multi-servicio** en plataforma cloud (Render.com)

### Tecnologías Clave:
- **Frontend:** Angular 19 + TypeScript + SCSS + Angular Material
- **Backend:** PHP 8.2 + Apache + PDO
- **Base de Datos:** PostgreSQL 15 (Supabase)
- **Contenedorización:** Docker + Docker Compose
- **Cloud Provider:** Render.com (PaaS)
- **Control de Versiones:** Git + GitHub
- **Herramientas de Gestión:** DBeaver, Visual Studio Code

---

## 2. ARQUITECTURA GENERAL DEL SISTEMA {#arquitectura-general}

### 2.1 Patrón Arquitectónico: JAMstack + API Backend

El sistema implementa una arquitectura moderna de **tres capas desacopladas**:

```
┌─────────────────────────────────────────────────────────────┐
│                    CAPA DE PRESENTACIÓN                     │
│   Angular 19 SPA (Static Site) - galitroco-frontend        │
│   https://galitroco-frontend.onrender.com                  │
└─────────────────────┬───────────────────────────────────────┘
                      │ HTTP/HTTPS
                      │ (API REST + JSON)
                      │ CORS Habilitado
┌─────────────────────▼───────────────────────────────────────┐
│                    CAPA DE NEGOCIO                          │
│   PHP 8.2 Backend API (Docker Container)                   │
│   https://render-test-php-1.onrender.com/api.php          │
│   + Apache 2.4                                              │
│   + PDO para conexiones DB                                  │
└─────────────────────┬───────────────────────────────────────┘
                      │ PostgreSQL Protocol
                      │ (Conexión SSL)
┌─────────────────────▼───────────────────────────────────────┐
│                    CAPA DE DATOS                            │
│   PostgreSQL 15 Database (Supabase)                        │
│   db.xxxxxxxxxxx.supabase.co:5432                          │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Características Arquitectónicas

#### **Separación de Responsabilidades**
- **Frontend:** Renderizado, UX/UI, validaciones cliente, gestión de estado
- **Backend:** Lógica de negocio, autenticación, autorización, validaciones servidor
- **Base de Datos:** Persistencia, integridad referencial, consultas optimizadas

#### **Ventajas de esta Arquitectura**
1. ✅ **Escalabilidad Independiente:** Frontend y Backend pueden escalar por separado
2. ✅ **Mantenimiento Facilitado:** Cambios en frontend no afectan backend y viceversa
3. ✅ **Múltiples Frontends:** Posibilidad de crear app móvil usando la misma API
4. ✅ **CDN Optimization:** Frontend estático puede servirse desde CDN
5. ✅ **Seguridad:** Backend no expuesto directamente al usuario final

---

## 3. STACK TECNOLÓGICO FRONTEND {#frontend}

### 3.1 Angular 19 (Framework Principal)

**Versión:** 19.2.0  
**Tipo:** Single Page Application (SPA)  
**Lenguaje:** TypeScript 5.7.2

#### **Características Implementadas:**

##### **3.1.1 Arquitectura de Componentes**
```typescript
src/
├── app/
│   ├── core/                    // Servicios singleton
│   │   ├── guards/              // Protección de rutas
│   │   ├── interceptors/        // HTTP interceptors
│   │   └── services/            // Servicios globales
│   ├── features/                // Módulos funcionales
│   │   ├── auth/                // Autenticación
│   │   ├── habilidades/         // Gestión habilidades
│   │   ├── home/                // Página principal
│   │   └── perfil/              // Perfil usuario
│   ├── layout/                  // Componentes layout
│   │   ├── header/
│   │   ├── footer/
│   │   └── sidebar/
│   └── shared/                  // Componentes compartidos
│       ├── components/
│       ├── directives/
│       └── pipes/
```

##### **3.1.2 Sistema de Rutas**
- **Lazy Loading:** Carga diferida de módulos para optimización
- **Route Guards:** Protección de rutas autenticadas
- **Resolvers:** Pre-carga de datos antes de renderizar componentes

##### **3.1.3 Gestión de Estado**
- **RxJS 7.8:** Programación reactiva con Observables
- **Signals (Angular 19):** Sistema de reactividad fino-granular
- **BehaviorSubjects:** Gestión de estado compartido entre componentes

#### **3.1.4 Dependencias Principales**

```json
{
  "@angular/core": "^19.2.0",           // Framework base
  "@angular/router": "^19.2.0",         // Sistema de rutas
  "@angular/forms": "^19.2.0",          // Formularios reactivos
  "@angular/common": "^19.2.0",         // Pipes, directivas comunes
  "@angular/animations": "^19.2.0",     // Animaciones
  "@angular/material": "^19.2.19",      // Material Design
  "@angular/cdk": "^19.2.19",          // Component Dev Kit
  "rxjs": "~7.8.0",                     // Reactive Extensions
  "zone.js": "~0.15.0",                 // Change Detection
  "typescript": "~5.7.2"                // Lenguaje tipado
}
```

### 3.2 Angular Material (UI Framework)

**Versión:** 19.2.19  
**Design System:** Material Design 3

#### **Componentes Utilizados:**
- ✅ **mat-toolbar:** Barra de navegación superior
- ✅ **mat-sidenav:** Menú lateral responsive
- ✅ **mat-card:** Tarjetas para habilidades
- ✅ **mat-button:** Botones con Material Design
- ✅ **mat-form-field:** Campos de formulario
- ✅ **mat-input:** Inputs de texto
- ✅ **mat-select:** Selectores desplegables
- ✅ **mat-dialog:** Modales y diálogos
- ✅ **mat-snackbar:** Notificaciones tipo toast
- ✅ **mat-icon:** Iconos Material
- ✅ **mat-table:** Tablas de datos
- ✅ **mat-paginator:** Paginación
- ✅ **mat-chip:** Etiquetas de categorías

#### **Temas y Personalización:**
```scss
// Variables personalizadas
$primary-color: #3f51b5;      // Indigo
$accent-color: #ff4081;       // Pink
$warn-color: #f44336;         // Red

// Tema custom Material
@use '@angular/material' as mat;
$custom-theme: mat.define-theme(...);
```

### 3.3 SCSS (Preprocesador CSS)

**Características Implementadas:**

#### **3.3.1 Diseño Responsive**
```scss
// Breakpoints definidos
$breakpoint-mobile: 480px;    // Móvil pequeño
$breakpoint-tablet: 768px;    // Tablet/Móvil grande
$breakpoint-desktop: 960px;   // Desktop pequeño
$breakpoint-large: 1200px;    // Desktop grande

// Media queries mobile-first
@media (max-width: 768px) {
  .toolbar-buttons {
    .button-text { display: none; }  // Solo iconos
    mat-icon { display: inline-block; }
  }
}
```

#### **3.3.2 Variables Globales**
```scss
// Tipografía
$font-family: 'Roboto', 'Helvetica Neue', sans-serif;
$font-size-base: 16px;

// Espaciado
$spacing-unit: 8px;
$padding-mobile: 8px;
$padding-tablet: 12px;
$padding-desktop: 16px;

// Colores
$background-color: #fafafa;
$text-primary: rgba(0, 0, 0, 0.87);
$text-secondary: rgba(0, 0, 0, 0.54);
```

#### **3.3.3 Arquitectura de Estilos**
```
styles/
├── _variables.scss      // Variables globales
├── _mixins.scss         // Mixins reutilizables
├── _typography.scss     // Estilos tipográficos
├── _responsive.scss     // Media queries
└── styles.scss          // Punto de entrada
```

### 3.4 TypeScript (Lenguaje de Programación)

**Versión:** 5.7.2  
**Configuración:** Modo estricto activado

#### **Configuración tsconfig.json:**
```json
{
  "compilerOptions": {
    "target": "ES2022",
    "module": "ES2022",
    "lib": ["ES2022", "dom"],
    "strict": true,
    "strictNullChecks": true,
    "noImplicitAny": true,
    "esModuleInterop": true,
    "skipLibCheck": true
  }
}
```

#### **Ventajas Aplicadas:**
- ✅ **Type Safety:** Detección de errores en tiempo de compilación
- ✅ **Interfaces:** Definición de contratos de datos
- ✅ **Enums:** Constantes tipadas para estados
- ✅ **Generics:** Reutilización de código con tipos
- ✅ **Decoradores:** Metadata para componentes Angular

### 3.5 Build System y Bundling

#### **Angular CLI + esbuild**
- **Builder:** @angular-devkit/build-angular:application
- **Bundler:** esbuild (ultra-rápido)
- **Minificación:** Terser para JavaScript
- **Optimización:** Tree-shaking automático
- **Code Splitting:** Lazy loading de módulos

#### **Scripts de Compilación:**
```json
{
  "build:prod": "ng build --configuration production",
  "build:dev": "ng build --configuration development",
  "start": "ng serve --open"
}
```

#### **Optimizaciones de Producción:**
- ✅ Minificación de JavaScript/CSS
- ✅ Eliminación de código muerto (tree-shaking)
- ✅ Compresión Brotli/Gzip
- ✅ Inlining de estilos críticos
- ✅ Lazy loading de rutas
- ✅ Service Worker para PWA (opcional)

### 3.6 Gestión de Formularios

#### **Reactive Forms**
```typescript
// Validaciones implementadas
loginForm = this.fb.group({
  email: ['', [Validators.required, Validators.email]],
  password: ['', [Validators.required, Validators.minLength(8)]]
});

// Validadores personalizados
export function passwordMatchValidator(control: AbstractControl) {
  const password = control.get('password');
  const confirmPassword = control.get('confirmPassword');
  return password?.value === confirmPassword?.value 
    ? null 
    : { passwordMismatch: true };
}
```

### 3.7 Comunicación HTTP

#### **HttpClient + Interceptors**
```typescript
// Interceptor de autenticación
@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  intercept(req: HttpRequest<any>, next: HttpHandler) {
    const token = localStorage.getItem('token');
    if (token) {
      req = req.clone({
        setHeaders: { Authorization: `Bearer ${token}` }
      });
    }
    return next.handle(req);
  }
}
```

---

## 4. STACK TECNOLÓGICO BACKEND {#backend}

### 4.1 PHP 8.2 (Lenguaje Backend)

**Versión:** 8.2 (última versión estable)  
**Tipo:** Lenguaje interpretado orientado a objetos

#### **Características PHP 8.2 Utilizadas:**

##### **4.1.1 Readonly Classes**
```php
readonly class Usuario {
    public function __construct(
        public int $id,
        public string $email,
        public string $nombre
    ) {}
}
```

##### **4.1.2 Named Arguments**
```php
Response::success(
    data: $usuarios,
    message: 'Usuarios obtenidos correctamente',
    code: 200
);
```

##### **4.1.3 Match Expression**
```php
$mensaje = match($tipo) {
    'exito' => 'Operación exitosa',
    'error' => 'Error en operación',
    default => 'Estado desconocido'
};
```

##### **4.1.4 Null Safe Operator**
```php
$ciudad = $usuario?->ubicacion?->ciudad ?? 'Desconocida';
```

### 4.2 Apache HTTP Server

**Versión:** 2.4 (dentro del contenedor Docker)  
**Servidor Web:** Apache HTTP Server

#### **Configuración Apache:**

##### **4.2.1 mod_rewrite Activado**
```apache
# .htaccess en raíz
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^api/(.*)$ /api.php [QSA,L]
```

##### **4.2.2 Directivas de Seguridad**
```apache
<Directory /var/www/html/>
    Options -Indexes +FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

# Headers de seguridad
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-XSS-Protection "1; mode=block"
```

##### **4.2.3 Configuración CORS (cors.php)**
```php
<?php
// Orígenes permitidos
$allowed_origins = [
    'https://galitroco-frontend.onrender.com',
    'http://localhost:4200',  // Desarrollo local
    'http://localhost:8080'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}

// Responder a preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
```

### 4.3 PDO (PHP Data Objects)

**Driver:** pdo_pgsql (PostgreSQL)

#### **Características de Seguridad:**

##### **4.3.1 Prepared Statements**
```php
// Prevención de SQL Injection
$stmt = $db->prepare("
    SELECT * FROM usuarios 
    WHERE email = :email AND activo = true
");
$stmt->execute(['email' => $email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
```

##### **4.3.2 Configuración PDO**
```php
$pdo = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,  // Prepared statements reales
    PDO::ATTR_TIMEOUT => 5                 // Timeout conexión
]);
```

### 4.4 Arquitectura Backend API REST

#### **4.4.1 Estructura de Directorios**
```
backend/
├── api/                      // Endpoints públicos
│   ├── auth.php              // Autenticación (login/register)
│   ├── usuarios.php          // CRUD usuarios
│   ├── habilidades.php       // CRUD habilidades
│   ├── categorias.php        // Gestión categorías
│   ├── intercambios.php      // Gestión intercambios
│   ├── conversaciones.php    // Sistema mensajería
│   ├── notificaciones.php    // Notificaciones
│   ├── valoraciones.php      // Sistema valoraciones
│   └── reportes.php          // Reportes/denuncias
├── config/                   // Configuraciones
│   ├── database.php          // Conexión BD
│   └── cors.php              // CORS headers
├── utils/                    // Utilidades
│   ├── Auth.php              // Autenticación JWT
│   └── Response.php          // Respuestas estandarizadas
└── models/                   // (Futuro: Clases modelo)
```

#### **4.4.2 Clase Response Estandarizada**
```php
class Response {
    /**
     * Respuesta exitosa
     */
    public static function success($data = null, $message = '', $code = 200) {
        http_response_code($code);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Respuesta de error
     */
    public static function error($message = '', $code = 400, $errors = null) {
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
```

#### **4.4.3 Sistema de Autenticación JWT**
```php
class Auth {
    /**
     * Generar token JWT
     */
    public static function generateToken($userId, $email, $rol) {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode([
            'user_id' => $userId,
            'email' => $email,
            'rol' => $rol,
            'exp' => time() + (7 * 24 * 60 * 60)  // 7 días
        ]));
        
        $signature = hash_hmac('sha256', 
            "$header.$payload", 
            $_ENV['JWT_SECRET'], 
            true
        );
        
        return "$header.$payload." . base64_encode($signature);
    }
}
```

#### **4.4.4 Endpoints Implementados**

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| **Autenticación** |
| POST | `/api/auth/login` | Login usuario |
| POST | `/api/auth/register` | Registro usuario |
| POST | `/api/auth/logout` | Cerrar sesión |
| **Usuarios** |
| GET | `/api/usuarios` | Listar usuarios |
| GET | `/api/usuarios/{id}` | Obtener usuario |
| PUT | `/api/usuarios/{id}` | Actualizar usuario |
| DELETE | `/api/usuarios/{id}` | Eliminar usuario |
| **Habilidades** |
| GET | `/api/habilidades` | Listar habilidades |
| GET | `/api/habilidades/{id}` | Obtener habilidad |
| POST | `/api/habilidades` | Crear habilidad |
| PUT | `/api/habilidades/{id}` | Actualizar habilidad |
| DELETE | `/api/habilidades/{id}` | Eliminar habilidad |
| **Categorías** |
| GET | `/api/categorias` | Listar categorías |
| POST | `/api/categorias` | Crear categoría |
| **Intercambios** |
| GET | `/api/intercambios` | Listar intercambios |
| POST | `/api/intercambios` | Solicitar intercambio |
| PUT | `/api/intercambios/{id}` | Actualizar estado |
| **Conversaciones** |
| GET | `/api/conversaciones` | Listar conversaciones |
| POST | `/api/conversaciones/mensaje` | Enviar mensaje |
| **Notificaciones** |
| GET | `/api/notificaciones` | Obtener notificaciones |
| PUT | `/api/notificaciones/{id}/leer` | Marcar como leída |
| **Valoraciones** |
| POST | `/api/valoraciones` | Crear valoración |
| GET | `/api/valoraciones/usuario/{id}` | Ver valoraciones usuario |
| **Reportes** |
| POST | `/api/reportes` | Crear reporte/denuncia |

### 4.5 Gestión de Sesiones

#### **Sessions PHP Nativas**
```php
// Configuración segura
session_start([
    'cookie_lifetime' => 86400,        // 24 horas
    'cookie_secure' => true,           // Solo HTTPS
    'cookie_httponly' => true,         // No accesible desde JS
    'cookie_samesite' => 'Strict'      // Protección CSRF
]);
```

---

## 5. BASE DE DATOS {#base-de-datos}

### 5.1 PostgreSQL 15

**Versión:** 15.x  
**Provider:** Supabase (DBaaS)  
**Motor:** PostgreSQL (open-source)

#### **Ventajas de PostgreSQL:**
- ✅ **ACID Compliant:** Transacciones seguras
- ✅ **Integridad Referencial:** Foreign keys estrictas
- ✅ **JSON Native Support:** Columnas JSONB
- ✅ **Full Text Search:** Búsqueda avanzada
- ✅ **Performance:** Índices avanzados (B-tree, Hash, GiST, GIN)
- ✅ **Escalabilidad:** Replicación y particionamiento

### 5.2 Supabase (Database-as-a-Service)

**URL Conexión:** `db.xxxxxxxxxxx.supabase.co:5432`  
**Protocolo:** PostgreSQL Wire Protocol (SSL)

#### **Características Supabase:**
- ✅ **Backups Automáticos:** Snapshots diarios
- ✅ **SSL/TLS Encryption:** Conexiones cifradas
- ✅ **Pooling Connection:** pgBouncer integrado
- ✅ **Dashboard Web:** Interface de gestión
- ✅ **API REST Auto-generada:** PostgREST
- ✅ **Realtime Subscriptions:** WebSocket para cambios en tiempo real
- ✅ **Storage:** Almacenamiento de archivos (fotos perfil, etc.)

### 5.3 Esquema de Base de Datos

#### **5.3.1 Tabla: usuarios**
```sql
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    ubicacion VARCHAR(100),
    foto_url TEXT,
    biografia TEXT,
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(20) DEFAULT 'usuario',
    activo BOOLEAN DEFAULT true,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_conexion TIMESTAMP
);

-- Índices para optimización
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_ubicacion ON usuarios(ubicacion);
CREATE INDEX idx_usuarios_activo ON usuarios(activo);
```

#### **5.3.2 Tabla: habilidades**
```sql
CREATE TABLE habilidades (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id) ON DELETE CASCADE,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    categoria_id INTEGER REFERENCES categorias(id),
    tipo VARCHAR(20) CHECK(tipo IN ('ofrezco', 'busco')),
    nivel VARCHAR(20) CHECK(nivel IN ('principiante', 'intermedio', 'avanzado')),
    disponibilidad VARCHAR(50),
    ubicacion VARCHAR(100),
    foto_url TEXT,
    activo BOOLEAN DEFAULT true,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices
CREATE INDEX idx_habilidades_usuario ON habilidades(usuario_id);
CREATE INDEX idx_habilidades_categoria ON habilidades(categoria_id);
CREATE INDEX idx_habilidades_tipo ON habilidades(tipo);
CREATE INDEX idx_habilidades_activo ON habilidades(activo);
```

#### **5.3.3 Tabla: categorias**
```sql
CREATE TABLE categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT,
    icono VARCHAR(50),
    color VARCHAR(7),
    activo BOOLEAN DEFAULT true
);

-- Datos iniciales
INSERT INTO categorias (nombre, descripcion, icono, color) VALUES
('Tecnología', 'Programación, diseño web, redes', 'computer', '#2196F3'),
('Idiomas', 'Inglés, español, francés, etc.', 'language', '#4CAF50'),
('Música', 'Instrumentos, teoría musical, producción', 'music_note', '#9C27B0'),
('Deportes', 'Fitness, yoga, artes marciales', 'sports_soccer', '#FF5722'),
('Arte', 'Pintura, dibujo, escultura', 'palette', '#FF9800'),
('Cocina', 'Cocina internacional, repostería', 'restaurant', '#795548'),
('Fotografía', 'Fotografía digital, edición', 'camera_alt', '#607D8B'),
('Educación', 'Matemáticas, ciencias, historia', 'school', '#3F51B5');
```

#### **5.3.4 Tabla: intercambios**
```sql
CREATE TABLE intercambios (
    id SERIAL PRIMARY KEY,
    usuario_solicitante_id INTEGER REFERENCES usuarios(id),
    usuario_receptor_id INTEGER REFERENCES usuarios(id),
    habilidad_ofrecida_id INTEGER REFERENCES habilidades(id),
    habilidad_solicitada_id INTEGER REFERENCES habilidades(id),
    estado VARCHAR(20) DEFAULT 'pendiente' 
        CHECK(estado IN ('pendiente', 'aceptado', 'rechazado', 'completado', 'cancelado')),
    mensaje_inicial TEXT,
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_respuesta TIMESTAMP,
    fecha_inicio TIMESTAMP,
    fecha_fin TIMESTAMP,
    valoracion_solicitante INTEGER CHECK(valoracion_solicitante BETWEEN 1 AND 5),
    valoracion_receptor INTEGER CHECK(valoracion_receptor BETWEEN 1 AND 5)
);
```

#### **5.3.5 Tabla: conversaciones**
```sql
CREATE TABLE conversaciones (
    id SERIAL PRIMARY KEY,
    intercambio_id INTEGER REFERENCES intercambios(id) ON DELETE CASCADE,
    usuario_emisor_id INTEGER REFERENCES usuarios(id),
    usuario_receptor_id INTEGER REFERENCES usuarios(id),
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT false
);

-- Índice para mensajes no leídos
CREATE INDEX idx_conversaciones_leido ON conversaciones(leido, usuario_receptor_id);
```

#### **5.3.6 Tabla: notificaciones**
```sql
CREATE TABLE notificaciones (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo VARCHAR(50) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    mensaje TEXT,
    enlace VARCHAR(255),
    leida BOOLEAN DEFAULT false,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_notificaciones_usuario ON notificaciones(usuario_id, leida);
```

#### **5.3.7 Tabla: valoraciones**
```sql
CREATE TABLE valoraciones (
    id SERIAL PRIMARY KEY,
    intercambio_id INTEGER REFERENCES intercambios(id),
    usuario_valorador_id INTEGER REFERENCES usuarios(id),
    usuario_valorado_id INTEGER REFERENCES usuarios(id),
    puntuacion INTEGER CHECK(puntuacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha_valoracion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(intercambio_id, usuario_valorador_id)
);
```

#### **5.3.8 Tabla: reportes**
```sql
CREATE TABLE reportes (
    id SERIAL PRIMARY KEY,
    usuario_reportador_id INTEGER REFERENCES usuarios(id),
    usuario_reportado_id INTEGER REFERENCES usuarios(id),
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_reporte TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_resolucion TIMESTAMP,
    accion_tomada TEXT
);
```

### 5.4 DBeaver (Herramienta de Gestión BD)

**Versión:** Community Edition  
**Tipo:** Cliente de base de datos universal

#### **Características Utilizadas:**
- ✅ **Conexión a PostgreSQL:** Gestión visual de Supabase
- ✅ **Editor SQL:** Ejecución de queries complejas
- ✅ **ER Diagrams:** Generación de diagramas entidad-relación
- ✅ **Data Export/Import:** CSV, JSON, SQL
- ✅ **Query Optimization:** EXPLAIN ANALYZE
- ✅ **Schema Browser:** Exploración de estructura
- ✅ **Data Editor:** Modificación directa de registros

#### **Configuración Conexión Supabase:**
```
Host: db.xxxxxxxxxxx.supabase.co
Port: 5432
Database: postgres
User: postgres
Password: [Supabase password]
SSL: Require (SSL Mode: require)
```

---

## 6. INFRAESTRUCTURA CLOUD Y DEVOPS {#cloud-devops}

### 6.1 Docker (Contenedorización)

**Versión:** Docker Engine 24.x  
**Propósito:** Empaquetar backend en contenedor reproducible

#### **6.1.1 Dockerfile Backend**
```dockerfile
# Imagen base PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar extensiones PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar AllowOverride
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/override.conf \
    && a2enconf override

# Copiar código
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Configurar puerto dinámico (para Render)
RUN echo '#!/bin/bash\n\
PORT=${PORT:-80}\n\
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf\n\
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf\n\
apache2-foreground' > /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

EXPOSE 80
CMD ["/usr/local/bin/start-apache.sh"]
```

#### **6.1.2 Ventajas de Docker:**
- ✅ **Portabilidad:** Mismo entorno en local y producción
- ✅ **Aislamiento:** Dependencias encapsuladas
- ✅ **Reproducibilidad:** Build consistente
- ✅ **Escalabilidad:** Fácil replicación de contenedores
- ✅ **Versionado:** Imágenes versionadas (tags)

#### **6.1.3 Docker Compose (Desarrollo Local)**
```yaml
version: '3.8'
services:
  backend:
    build: .
    ports:
      - "8000:80"
    environment:
      - DB_HOST=localhost
      - DB_NAME=galitrocodb
      - DB_USER=postgres
      - DB_PASSWORD=abc123.,
    volumes:
      - ./backend:/var/www/html/backend
```

### 6.2 Render.com (Platform as a Service)

**Tipo:** Cloud Platform (PaaS)  
**Region:** EU (Frankfurt/Paris)  
**Plan:** Free Tier (con limitaciones)

#### **6.2.1 Servicios Desplegados:**

##### **Backend - Web Service (Docker)**
- **Nombre:** galitroco-backend
- **URL:** https://render-test-php-1.onrender.com
- **Runtime:** Docker
- **Build:** Dockerfile en raíz
- **Health Check:** `/backend/info.php`
- **Environment Variables:**
  - `DATABASE_URL` (Supabase connection string)
  - `JWT_SECRET` (para tokens)
  - `ENVIRONMENT=production`

##### **Frontend - Static Site**
- **Nombre:** galitroco-frontend
- **URL:** https://galitroco-frontend.onrender.com
- **Runtime:** Static (HTML/CSS/JS)
- **Build Command:** `cd frontend && npm install && npm run build:prod`
- **Publish Path:** `frontend/dist/frontend/browser`
- **Redirects:** SPA routing con `_redirects` file

#### **6.2.2 render.yaml (Infrastructure as Code)**
```yaml
services:
  # Backend API - PHP en Docker
  - type: web
    name: galitroco-backend
    runtime: docker
    dockerfilePath: ./Dockerfile
    envVars:
      - key: DATABASE_URL
        sync: false  # Variable secreta
      - key: JWT_SECRET
        sync: false
      - key: DB_PORT
        value: 5432
    healthCheckPath: /backend/info.php

  # Frontend Angular - Static Site
  - type: web
    name: galitroco-frontend
    runtime: static
    buildCommand: cd frontend && npm install && npm run build:prod
    staticPublishPath: frontend/dist/frontend/browser
    pullRequestPreviewsEnabled: true
    headers:
      - path: /*
        name: X-Frame-Options
        value: SAMEORIGIN
      - path: /*
        name: X-Content-Type-Options
        value: nosniff
    routes:
      - type: rewrite
        source: /*
        destination: /index.html
```

#### **6.2.3 Características Render:**
- ✅ **Auto-Deploy:** Push a GitHub → Deploy automático
- ✅ **SSL Gratis:** Certificados Let's Encrypt
- ✅ **CDN Global:** Cloudflare integrado
- ✅ **Zero Downtime:** Deploys sin caídas
- ✅ **Health Checks:** Reinicio automático si falla
- ✅ **Logs Centralizados:** Dashboard de logs
- ✅ **Preview Environments:** PR previews
- ✅ **Custom Domains:** Soporte dominios propios

#### **6.2.4 Limitaciones Free Tier:**
- ⚠️ **Sleep después de 15 minutos inactividad**
- ⚠️ **750 horas/mes de compute**
- ⚠️ **100 GB bandwidth/mes**
- ⚠️ **Builds limitados a 500 minutos/mes**

### 6.3 Nginx (Futuro - Alternativa Apache)

**Nota:** Actualmente usando Apache, pero Nginx está considerado para:
- ✅ Mejor performance con archivos estáticos
- ✅ Menor consumo de memoria
- ✅ Reverse proxy más eficiente
- ✅ Load balancing nativo

---

## 7. HERRAMIENTAS DE DESARROLLO {#herramientas-desarrollo}

### 7.1 Visual Studio Code

**Versión:** Latest  
**Tipo:** IDE multiplataforma

#### **Extensiones Instaladas:**

##### **Angular Development:**
- ✅ **Angular Language Service:** IntelliSense para templates
- ✅ **Angular Snippets:** Atajos de código
- ✅ **Prettier:** Formateo automático
- ✅ **ESLint:** Linting TypeScript
- ✅ **Auto Rename Tag:** Sincronización tags HTML

##### **PHP Development:**
- ✅ **PHP Intelephense:** IntelliSense PHP
- ✅ **PHP Debug:** Debugging con Xdebug
- ✅ **PHP DocBlocker:** Documentación automática

##### **Database:**
- ✅ **PostgreSQL:** Cliente PostgreSQL integrado
- ✅ **SQLTools:** Gestión múltiples BD

##### **DevOps:**
- ✅ **Docker:** Gestión contenedores
- ✅ **GitLens:** Git avanzado
- ✅ **Thunder Client:** Testing API REST

### 7.2 Node.js + npm

**Versión Node:** 20.x LTS  
**Versión npm:** 10.x

#### **Propósito:**
- ✅ Angular CLI
- ✅ Gestión dependencias frontend
- ✅ Build tools (esbuild, Webpack)
- ✅ Scripts de desarrollo

### 7.3 Git + GitHub

**Control de Versiones:** Git 2.43.x  
**Repositorio Remoto:** GitHub (tonikampos/render-test-php)

#### **Workflow:**
```bash
# Desarrollo local
git checkout -b feature/nueva-funcionalidad
git add .
git commit -m "feat: nueva funcionalidad X"
git push origin feature/nueva-funcionalidad

# Pull Request → Merge to main
# Render auto-deploys main branch
```

---

## 8. SEGURIDAD {#seguridad}

### 8.1 Autenticación y Autorización

#### **JWT (JSON Web Tokens)**
- ✅ Tokens firmados con HS256
- ✅ Expiración configurable (7 días)
- ✅ Payload con user_id, email, rol

#### **Password Hashing**
```php
// Bcrypt con cost factor 12
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
$valid = password_verify($password, $hash);
```

### 8.2 Protección contra Ataques

#### **SQL Injection**
- ✅ Prepared Statements (PDO)
- ✅ Validación de inputs

#### **XSS (Cross-Site Scripting)**
- ✅ Escape de outputs: `htmlspecialchars()`
- ✅ Content Security Policy headers
- ✅ Angular sanitiza automáticamente

#### **CSRF (Cross-Site Request Forgery)**
- ✅ SameSite cookies
- ✅ CORS estricto
- ✅ Token validation (futuro)

#### **Headers de Seguridad**
```apache
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000
```

### 8.3 HTTPS/SSL

- ✅ **Render:** Certificados Let's Encrypt automáticos
- ✅ **Supabase:** Conexiones SSL/TLS obligatorias
- ✅ **Redirección:** HTTP → HTTPS forzado

---

## 9. COMUNICACIONES Y NOTIFICACIONES {#comunicaciones}

### 9.1 Sistema de Mensajería Interno

**Tabla:** `conversaciones`  
**Tipo:** Mensajería asíncrona entre usuarios

#### **Características:**
- ✅ Mensajes vinculados a intercambios
- ✅ Estado leído/no leído
- ✅ Timestamps de envío
- ✅ Historial completo

### 9.2 Sistema de Notificaciones

**Tabla:** `notificaciones`  
**Tipos:**
- 📧 Nueva solicitud de intercambio
- 📧 Intercambio aceptado/rechazado
- 📧 Nuevo mensaje recibido
- 📧 Valoración recibida

### 9.3 Email (Futuro - No Implementado Aún)

**Opciones Consideradas:**

#### **Brevo (ex-Sendinblue)**
- ✅ 300 emails/día gratis
- ✅ Templates HTML
- ✅ API REST
- ✅ SMTP relay

#### **SendGrid**
- ✅ 100 emails/día gratis
- ✅ Analytics avanzado
- ✅ Validación de emails

#### **Amazon SES**
- ✅ Pay-as-you-go
- ✅ Alta deliverability
- ✅ Integración AWS

**Casos de Uso:**
- 📧 Confirmación de registro
- 📧 Recuperación de contraseña
- 📧 Notificaciones importantes
- 📧 Resumen semanal de actividad

---

## 10. CONTROL DE VERSIONES {#control-versiones}

### 10.1 Git

**Estrategia de Branching:** GitHub Flow simplificado

```
main (producción)
  │
  ├── feature/habilidades
  ├── feature/mensajeria
  ├── bugfix/cors-error
  └── hotfix/production-issue
```

### 10.2 GitHub

**Repositorio:** https://github.com/tonikampos/render-test-php

#### **Features Utilizados:**
- ✅ **Issues:** Tracking de bugs y features
- ✅ **Pull Requests:** Code review
- ✅ **Actions (futuro):** CI/CD pipelines
- ✅ **Webhooks:** Auto-deploy a Render

---

## 11. MONITORIZACIÓN Y TESTING {#monitorizacion}

### 11.1 Logs

#### **Backend Logs (Render):**
```bash
# Logs en tiempo real
render logs --service galitroco-backend --tail
```

#### **PHP Error Logging:**
```php
error_log("Error: " . $e->getMessage());
```

### 11.2 Testing (Futuro)

#### **Frontend:**
- ✅ **Jasmine + Karma:** Unit testing
- ✅ **Protractor/Cypress:** E2E testing

#### **Backend:**
- ✅ **PHPUnit:** Unit testing PHP
- ✅ **Thunder Client/Postman:** API testing

---

## 12. DIAGRAMA DE ARQUITECTURA {#diagrama-arquitectura}

```
┌─────────────────────────────────────────────────────────────────────┐
│                          USUARIO FINAL                               │
│                     (Navegador Web - Chrome/Firefox)                 │
└────────────────────────┬────────────────────────────────────────────┘
                         │
                         │ HTTPS
                         ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    RENDER.COM (PaaS Cloud)                           │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │  FRONTEND - Static Site (CDN)                                 │  │
│  │  ┌─────────────────────────────────────────────────────────┐  │  │
│  │  │  Angular 19 SPA                                          │  │  │
│  │  │  • TypeScript 5.7                                        │  │  │
│  │  │  • Angular Material UI                                   │  │  │
│  │  │  • SCSS Responsive                                       │  │  │
│  │  │  • RxJS State Management                                 │  │  │
│  │  └─────────────────────────────────────────────────────────┘  │  │
│  │  URL: https://galitroco-frontend.onrender.com                │  │
│  └───────────────────────┬───────────────────────────────────────┘  │
│                          │                                           │
│                          │ REST API (JSON)                           │
│                          │ CORS Enabled                              │
│                          ▼                                           │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │  BACKEND - Web Service (Docker Container)                     │  │
│  │  ┌─────────────────────────────────────────────────────────┐  │  │
│  │  │  PHP 8.2 + Apache 2.4                                    │  │  │
│  │  │  • API REST Endpoints                                    │  │  │
│  │  │  • JWT Authentication                                    │  │  │
│  │  │  • PDO Database Layer                                    │  │  │
│  │  │  • CORS Configuration                                    │  │  │
│  │  │  • Session Management                                    │  │  │
│  │  └─────────────────────────────────────────────────────────┘  │  │
│  │  URL: https://render-test-php-1.onrender.com/api.php         │  │
│  └───────────────────────┬───────────────────────────────────────┘  │
└──────────────────────────┼───────────────────────────────────────────┘
                           │
                           │ PostgreSQL Wire Protocol
                           │ SSL/TLS Encrypted
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    SUPABASE (DBaaS)                                  │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │  PostgreSQL 15                                                 │  │
│  │  • 8 Tablas principales                                        │  │
│  │  • Índices optimizados                                         │  │
│  │  • Foreign Keys                                                │  │
│  │  • Backups automáticos                                         │  │
│  │  • Connection Pooling (pgBouncer)                              │  │
│  └───────────────────────────────────────────────────────────────┘  │
│  Host: db.xxxxxxxxxxx.supabase.co:5432                              │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                    HERRAMIENTAS DE DESARROLLO                        │
│  • Visual Studio Code (IDE)                                          │
│  • DBeaver (DB Management)                                           │
│  • Git + GitHub (Version Control)                                    │
│  • Docker Desktop (Local Containers)                                 │
│  • Thunder Client (API Testing)                                      │
│  • Chrome DevTools (Debugging)                                       │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 13. FLUJO DE DESPLIEGUE {#flujo-despliegue}

```
┌──────────────┐
│  Desarrollo  │  Developer escribe código en VS Code
│    Local     │  
└──────┬───────┘
       │
       │ git add . && git commit -m "..."
       ▼
┌──────────────┐
│  Git Local   │  Commit local
│  Repository  │
└──────┬───────┘
       │
       │ git push origin main
       ▼
┌──────────────┐
│   GitHub     │  Repositorio remoto
│  Repository  │  tonikampos/render-test-php
└──────┬───────┘
       │
       │ Webhook trigger
       ▼
┌──────────────────────────────────────────────────┐
│           RENDER.COM - Auto Deploy               │
│  ┌────────────────┐      ┌────────────────────┐ │
│  │   Backend      │      │    Frontend        │ │
│  │   Build        │      │    Build           │ │
│  │ 1. Pull code   │      │ 1. Pull code       │ │
│  │ 2. Docker build│      │ 2. npm install     │ │
│  │ 3. Run tests   │      │ 3. ng build --prod │ │
│  │ 4. Deploy      │      │ 4. Optimize assets │ │
│  └────────┬───────┘      └────────┬───────────┘ │
│           │                       │             │
│           ▼                       ▼             │
│  ┌────────────────┐      ┌────────────────────┐ │
│  │  Production    │      │  Production        │ │
│  │  Container     │      │  CDN               │ │
│  └────────────────┘      └────────────────────┘ │
└──────────────────────────────────────────────────┘
       │                       │
       │                       │
       ▼                       ▼
┌──────────────────────────────────────┐
│       APLICACIÓN EN VIVO             │
│  Frontend: galitroco-frontend.com    │
│  Backend: render-test-php-1.com      │
└──────────────────────────────────────┘
```

**Tiempo de Despliegue:**
- Backend (Docker): ~5-7 minutos
- Frontend (Static): ~2-3 minutos

---

## 14. COSTES Y ESCALABILIDAD {#costes-escalabilidad}

### 14.1 Costes Actuales (Free Tier)

| Servicio | Plan | Coste Mensual |
|----------|------|---------------|
| **Render.com** | Free (2 services) | 0€ |
| **Supabase** | Free (500MB DB) | 0€ |
| **GitHub** | Free (público) | 0€ |
| **DBeaver** | Open Source | 0€ |
| **VS Code** | Open Source | 0€ |
| **TOTAL** | | **0€/mes** |

### 14.2 Costes Escalado (Producción Real)

| Servicio | Plan | Coste Mensual |
|----------|------|---------------|
| **Render.com** | Starter (2 services) | 14€ |
| **Supabase** | Pro (8GB DB) | 25€ |
| **Dominio** | .com/.es | 12€/año |
| **Brevo Email** | 20k emails/mes | 15€ |
| **CDN Cloudflare** | Pro | 20€ |
| **TOTAL** | | **~75€/mes** |

### 14.3 Escalabilidad

#### **Horizontal Scaling (Render):**
- ✅ Aumentar número de instancias (load balancing automático)
- ✅ Auto-scaling basado en CPU/memoria

#### **Database Scaling (Supabase):**
- ✅ Upgrade a planes Pro/Team
- ✅ Read replicas para queries de lectura
- ✅ Connection pooling (pgBouncer)

#### **CDN Optimization:**
- ✅ Static assets en Cloudflare CDN
- ✅ Image optimization (WebP, lazy loading)
- ✅ Brotli compression

---

## 15. CONCLUSIONES TÉCNICAS {#conclusiones}

### 15.1 Fortalezas del Stack Tecnológico

1. **Arquitectura Moderna y Escalable**
   - Separación frontend-backend permite evolución independiente
   - API REST facilita integración futura con app móvil
   - Docker garantiza reproducibilidad

2. **Tecnologías Probadas y Estables**
   - Angular 19: Framework enterprise-grade
   - PHP 8.2: Lenguaje maduro con millones de sitios en producción
   - PostgreSQL: Base de datos de clase mundial

3. **Coste Efectivo**
   - Stack completo gratis para desarrollo y pruebas
   - Escalado gradual según necesidades
   - Open source reduce vendor lock-in

4. **Desarrollo Ágil**
   - Hot reload en desarrollo (ng serve)
   - Auto-deploy en producción (git push)
   - Herramientas visuales (DBeaver, VS Code)

5. **Seguridad Robusta**
   - HTTPS everywhere
   - JWT authentication
   - Prepared statements (SQL injection prevention)
   - CORS configurado correctamente

### 15.2 Áreas de Mejora Futuras

1. **Testing Automatizado**
   - ⚠️ Implementar tests unitarios (PHPUnit, Jasmine)
   - ⚠️ Tests E2E con Cypress
   - ⚠️ CI/CD pipeline con GitHub Actions

2. **Monitorización**
   - ⚠️ APM (Application Performance Monitoring) con New Relic/Datadog
   - ⚠️ Error tracking con Sentry
   - ⚠️ Analytics con Google Analytics/Plausible

3. **Performance**
   - ⚠️ Implementar caching (Redis/Memcached)
   - ⚠️ Database query optimization
   - ⚠️ Lazy loading de imágenes

4. **Features Adicionales**
   - ⚠️ Sistema de emails (Brevo)
   - ⚠️ Notificaciones push
   - ⚠️ Chat en tiempo real (WebSockets)

### 15.3 Lecciones Aprendidas

1. **CORS es Crítico:** Configuración correcta evita dolores de cabeza
2. **Docker Simplifica:** Mismo entorno local y producción
3. **Supabase es Potente:** DBaaS reduce complejidad operacional
4. **Render Funciona:** PaaS simple y efectivo para MVPs
5. **Angular Material Acelera:** UI profesional sin diseñar desde cero

---

## 📊 RESUMEN TECNOLÓGICO VISUAL

```
┌─────────────────────────────────────────────────────────────┐
│                    TECNOLOGÍAS UTILIZADAS                    │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  FRONTEND                                                    │
│  ├─ Angular 19          (Framework SPA)                     │
│  ├─ TypeScript 5.7      (Lenguaje tipado)                   │
│  ├─ Angular Material    (UI Components)                     │
│  ├─ SCSS                (CSS preprocessor)                  │
│  ├─ RxJS 7.8            (Reactive programming)              │
│  └─ esbuild             (Build tool)                        │
│                                                              │
│  BACKEND                                                     │
│  ├─ PHP 8.2             (Lenguaje servidor)                 │
│  ├─ Apache 2.4          (Servidor web)                      │
│  ├─ PDO                 (Database abstraction)              │
│  └─ JWT                 (Autenticación)                     │
│                                                              │
│  BASE DE DATOS                                               │
│  ├─ PostgreSQL 15       (RDBMS)                             │
│  ├─ Supabase            (Database hosting)                  │
│  └─ DBeaver             (DB management tool)                │
│                                                              │
│  INFRAESTRUCTURA                                             │
│  ├─ Docker              (Contenedores)                      │
│  ├─ Render.com          (Cloud platform)                    │
│  ├─ GitHub              (Git hosting)                       │
│  └─ Let's Encrypt       (SSL certificates)                  │
│                                                              │
│  DESARROLLO                                                  │
│  ├─ VS Code             (IDE)                               │
│  ├─ Git 2.43            (Version control)                   │
│  ├─ Node.js 20          (Runtime JS)                        │
│  ├─ npm 10              (Package manager)                   │
│  └─ Chrome DevTools     (Debugging)                         │
│                                                              │
│  FUTURAS                                                     │
│  ├─ Brevo               (Email service)                     │
│  ├─ Redis               (Caching)                           │
│  ├─ GitHub Actions      (CI/CD)                             │
│  └─ Sentry              (Error tracking)                    │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## 📖 BIBLIOGRAFÍA Y RECURSOS

### Documentación Oficial:
- Angular: https://angular.dev
- PHP: https://www.php.net/docs.php
- PostgreSQL: https://www.postgresql.org/docs/
- Docker: https://docs.docker.com
- Render: https://render.com/docs

### Recursos Aprendizaje:
- MDN Web Docs: https://developer.mozilla.org
- Stack Overflow: https://stackoverflow.com
- Angular University: https://angular-university.io

---

**Documento generado para TFM - UOC**  
**Última actualización:** Octubre 2025  
**Autor:** Antonio Campos  
**GitHub:** https://github.com/tonikampos/render-test-php

---

