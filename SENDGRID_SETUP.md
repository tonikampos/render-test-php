# 🔧 Guía para configurar Sen**IMPORTANTE**: El email en `setFrom()` debe estar verificado en SendGrid:
1. Ve a Settings → Sender Authentication
2. Verifica tu dominio O single sender verification
3. El email `kampos@gmail.com` debe aparecer como verificadod en Render

## Pasos para resolver el problema de pantalla en blanco

### 1. **Verificar variables de entorno en Render**

Ve a tu dashboard de Render:
1. Entra en tu servicio web
2. Ve a **Environment** (Variables de entorno)
3. Asegúrate de tener configuradas:

```
DATABASE_URL=postgresql://user:pass@host:port/database
SENDGRID_API_KEY=SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**IMPORTANTE**: La API key de SendGrid debe empezar con `SG.` y tener unos 69 caracteres.

### 2. **Obtener tu API Key de SendGrid**

Si no tienes la API key:
1. Ve a [SendGrid Dashboard](https://app.sendgrid.com/)
2. Settings → API Keys
3. Create API Key
4. Selecciona "Full Access" o "Restricted Access" con permisos de Mail Send
5. Copia la key (solo se muestra UNA vez)

### 3. **Verificar email verificado en SendGrid**

CRÍTICO: El email en `setFrom()` debe estar verificado en SendGrid:
1. Ve a Settings → Sender Authentication
2. Verifica tu dominio O single sender verification
3. El email `TONI.KAMPOS@gmail.com` debe aparecer como verificado

### 4. **Debugging paso a paso**

He modificado tu código para mostrar exactamente dónde falla:

1. **Sube los cambios** a GitHub:
   ```bash
   git add .
   git commit -m "Add debugging and fix Docker extensions"
   git push
   ```

2. **Despliega en Render** (automático)

3. **Visita primero**: `https://tu-app.onrender.com/debug.php`
   - Esto te mostrará qué extensiones faltan
   - Si las variables están configuradas
   - Si PHPMailer se carga correctamente

4. **Luego visita**: `https://tu-app.onrender.com/index.php`
   - Verás en el código fuente HTML los comentarios de debug
   - Te dirá exactamente en qué paso falla

### 5. **Problemas comunes y soluciones**

#### Problema: "Class PHPMailer not found"
**Solución**: El autoload no se está cargando. Verifica que `composer install` funcione en el Dockerfile.

#### Problema: "SMTP Error: Could not authenticate"
**Solución**: 
- API Key incorrecta
- API Key sin permisos de envío
- Username debe ser exactamente `apikey`

#### Problema: "From address not verified"
**Solución**: Verifica el email en SendGrid Sender Authentication

#### Problema: Pantalla completamente en blanco
**Solución**: Error fatal de PHP. Revisa:
- Extensiones PHP faltantes (openssl, curl, mbstring)
- Memoria insuficiente
- Timeout de ejecución

### 6. **Configuración de producción**

Una vez que funcione, cambia en `index.php`:
```php
ini_set('display_errors', 0); // Ocultar errores en producción
```

## 🚨 PASOS INMEDIATOS

1. Configura `SENDGRID_API_KEY` en Render
2. Verifica email en SendGrid
3. Sube los cambios (`git push`)
4. Visita `/debug.php` en tu app desplegada
5. Envíame la salida del debug para ayudarte más