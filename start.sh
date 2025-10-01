#!/bin/bash
set -e

# Configurar el puerto de Render
export PORT=${PORT:-8000}

echo "🚀 Iniciando servidor PHP en 0.0.0.0:$PORT..."
echo "📁 Directorio: /var/www/html"

# Verificar que los archivos existen
ls -la /var/www/html/

echo "✅ Archivos verificados"

# Usar el servidor PHP integrado con router para logging
cd /var/www/html
echo "🎯 Ejecutando: php -S 0.0.0.0:$PORT router.php"
exec php -S 0.0.0.0:$PORT router.php
