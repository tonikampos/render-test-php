# 🔄 RESETEO DE BASE DE DATOS

Este documento explica cómo usar el script de reseteo de base de datos de forma segura.

---

## ⚠️ ADVERTENCIAS IMPORTANTES

### 🔴 **ESTE SCRIPT ES DESTRUCTIVO**
- ❌ Elimina **TODOS los datos** de todas las tablas
- ❌ Los datos eliminados **NO SE PUEDEN RECUPERAR**
- ❌ NO ejecutar en producción sin backup

### ✅ **LO QUE SÍ HACE:**
- ✅ Mantiene la estructura de la BD (tablas, columnas, relaciones)
- ✅ Mantiene los tipos ENUM
- ✅ Mantiene las foreign keys
- ✅ Mantiene los índices
- ✅ Reinicia las secuencias (IDs comienzan desde 1)
- ✅ Crea usuarios de prueba básicos
- ✅ Crea categorías de habilidades básicas

### ❌ **LO QUE NO HACE:**
- ❌ NO elimina tablas
- ❌ NO modifica la estructura
- ❌ NO afecta al código de la aplicación

---

## 🚀 CÓMO USAR EL SCRIPT

### Opción 1: Ejecución interactiva (RECOMENDADO)

```bash
cd database
php reset_database.php
```

El script te pedirá confirmación:
```
¿Estás seguro de que deseas continuar? (escribe 'SI' para confirmar):
```

Escribe exactamente `SI` (mayúsculas) y presiona Enter.

---

## 📊 QUÉ HACE EL SCRIPT (paso a paso)

### Paso 1: Deshabilitar restricciones
- Prepara la BD para eliminar datos respetando foreign keys

### Paso 2: Eliminar datos (orden correcto)
El script elimina datos en este orden (de dependientes a independientes):

1. `valoraciones` (depende de usuarios e intercambios)
2. `notificaciones` (depende de usuarios)
3. `mensajes` (depende de conversaciones)
4. `participantes_conversacion` (depende de conversaciones y usuarios)
5. `conversaciones` (depende de intercambios)
6. `intercambios` (depende de habilidades y usuarios)
7. `reportes` (depende de usuarios)
8. `habilidades` (depende de usuarios y categorías)
9. `password_resets` (tokens de recuperación)
10. `sesiones` (sesiones de usuarios)
11. `usuarios` (tabla principal)
12. `categorias_habilidades` (tabla base)

### Paso 3: Crear datos mínimos

#### Categorías creadas (8):
1. 💻 Tecnología e Informática
2. 🌍 Idiomas
3. 🎵 Música
4. ⚽ Deportes y Fitness
5. 🍳 Cocina y Gastronomía
6. 🎨 Arte y Diseño
7. 📚 Clases y Formación
8. 🔧 Otros

#### Usuarios creados (3):

**Administrador:**
```
Email:    admin@galitroco.com
Password: Pass123456
Rol:      administrador
```

**Usuario Demo:**
```
Email:    demo@galitroco.com
Password: Pass123456
Rol:      usuario
```

**Usuario Test:**
```
Email:    test@galitroco.com
Password: Pass123456
Rol:      usuario
```

---

## ✅ VERIFICACIÓN POST-RESETEO

Después de ejecutar el script, verifica que la aplicación funciona:

### 1. Backend API
```bash
# Probar login con usuario admin
curl -X POST https://render-test-php-1.onrender.com/api.php?resource=auth&action=login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@galitroco.com","password":"Pass123456"}'
```

### 2. Frontend
1. Ve a: `https://galitroco-frontend.onrender.com`
2. Login con: `admin@galitroco.com` / `Pass123456`
3. Deberías poder acceder sin problemas

### 3. Funcionalidades básicas
- ✅ Login funciona
- ✅ Registro de nuevos usuarios funciona
- ✅ Crear habilidades funciona (hay 8 categorías disponibles)
- ✅ Panel de administración accesible (usuario admin)

---

## 🔒 SEGURIDAD

### ¿Es seguro ejecutar este script?

**SÍ, si:**
- ✅ Estás en un entorno de desarrollo/pruebas
- ✅ Tienes un backup de los datos importantes
- ✅ Entiendes que los datos se perderán
- ✅ No estás en producción con usuarios reales

**NO, si:**
- ❌ Estás en producción con datos reales
- ❌ No tienes backup
- ❌ No estás seguro de lo que hace

### Características de seguridad del script:

1. ✅ **Confirmación requerida:** No se ejecuta sin tu confirmación explícita
2. ✅ **Transacciones:** Usa BEGIN/COMMIT (rollback automático si hay error)
3. ✅ **Orden correcto:** Respeta foreign keys
4. ✅ **No destructivo de estructura:** Solo elimina datos, no tablas
5. ✅ **Reinicia secuencias:** IDs comienzan desde 1 limpiamente

---

## 🆘 TROUBLESHOOTING

### Problema: "Foreign key constraint violation"
**Causa:** El orden de eliminación no respeta dependencias.  
**Solución:** El script ya usa el orden correcto con TRUNCATE CASCADE.

### Problema: "Cannot truncate a table referenced in a foreign key constraint"
**Causa:** PostgreSQL protege las relaciones.  
**Solución:** El script usa `TRUNCATE ... CASCADE` que elimina en cascada.

### Problema: "Sequence does not exist"
**Causa:** Las secuencias no se resetearon correctamente.  
**Solución:** El script usa `RESTART IDENTITY` que resetea secuencias automáticamente.

### Problema: "La aplicación no funciona después del reseteo"
**Causa:** Probablemente falta algo en los datos mínimos.  
**Solución:** 
1. Verifica que se crearon los 3 usuarios
2. Verifica que se crearon las 8 categorías
3. Prueba hacer login con `admin@galitroco.com`

---

## 🔄 ALTERNATIVAS AL RESETEO COMPLETO

Si solo quieres limpiar ciertas tablas:

### Eliminar solo intercambios y relacionados:
```sql
TRUNCATE TABLE valoraciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE mensajes RESTART IDENTITY CASCADE;
TRUNCATE TABLE participantes_conversacion CASCADE;
TRUNCATE TABLE conversaciones RESTART IDENTITY CASCADE;
TRUNCATE TABLE intercambios RESTART IDENTITY CASCADE;
```

### Eliminar solo habilidades:
```sql
TRUNCATE TABLE habilidades RESTART IDENTITY CASCADE;
```

### Eliminar solo usuarios (⚠️ elimina todo lo relacionado):
```sql
TRUNCATE TABLE usuarios RESTART IDENTITY CASCADE;
```

---

## 📝 BACKUP ANTES DE RESETEAR

Si estás en Supabase, puedes hacer backup con:

```bash
php database/extract_schema_supabase.php
```

Esto generará:
- `schema_production.sql` (estructura)
- `seeds_production.sql` (datos actuales)
- `install_complete.sql` (estructura + datos)

Así podrás restaurar si algo sale mal.

---

## ⚙️ DESPUÉS DEL RESETEO

### Pasos recomendados:

1. **Cambiar contraseñas de usuarios de prueba:**
   - Login como admin
   - Cambiar contraseña desde la aplicación

2. **Crear tus propios datos de prueba:**
   - Login con cualquier usuario
   - Crear habilidades
   - Proponer intercambios
   - Probar el flujo completo

3. **Verificar funcionalidades:**
   - Autenticación ✅
   - CRUD de habilidades ✅
   - Sistema de intercambios ✅
   - Sistema de mensajería ✅
   - Panel de administración ✅

---

## 🎯 CASOS DE USO COMUNES

### Caso 1: "Quiero empezar desde cero con datos limpios"
```bash
cd database
php reset_database.php
# Escribe: SI
```

### Caso 2: "Quiero datos de prueba más realistas"
Después del reseteo:
1. Login con los 3 usuarios creados
2. Cada uno crea 2-3 habilidades
3. Propon intercambios entre ellos
4. Completa algunos intercambios
5. Valora a los usuarios

### Caso 3: "Necesito probar el sistema desde cero para evaluación"
Perfecto para PEC2/PEC3:
1. Ejecuta `reset_database.php`
2. Tienes BD limpia con usuarios básicos
3. Puedes demostrar todas las funcionalidades desde cero
4. Los evaluadores tienen credenciales fijas para probar

---

## ❓ PREGUNTAS FRECUENTES

**P: ¿Puedo ejecutar este script múltiples veces?**  
R: Sí, sin problemas. Cada ejecución limpia todo y vuelve a crear los datos mínimos.

**P: ¿Se pierden las tablas?**  
R: No, solo los datos. La estructura permanece intacta.

**P: ¿Funciona en Supabase?**  
R: Sí, funciona perfectamente en Supabase (PostgreSQL).

**P: ¿Funciona en PostgreSQL local?**  
R: Sí, funciona en cualquier PostgreSQL.

**P: ¿Puedo modificar las contraseñas de prueba?**  
R: Sí, edita el script en la línea donde dice `password_hash('Pass123456', ...)`.

**P: ¿Puedo añadir más usuarios de prueba?**  
R: Sí, añade más elementos al array `$usuarios` en el script.

---

## 📞 SOPORTE

Si tienes problemas con el script:

1. Verifica que tienes conexión a la BD
2. Verifica que tu usuario tiene permisos de escritura
3. Revisa los logs de error en el terminal
4. Si el error persiste, revisa la transacción (se hace rollback automático)

---

**Última actualización:** Octubre 2025  
**Versión del script:** 1.0  
**Compatibilidad:** PostgreSQL 12+, Supabase
