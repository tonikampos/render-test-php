#!/bin/bash
set -e

# Configurar el puerto de Render
export PORT=${PORT:-8000}

echo "🚀 Iniciando servidor PHP en 0.0.0.0:$PORT..."

# Usar el servidor PHP integrado que SIEMPRE funciona en Render
cd /var/www/html
exec php -S 0.0.0.0:$PORT -t /var/www/html
