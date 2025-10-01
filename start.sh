#!/bin/bash
set -e

# Configurar el puerto de Render
export PORT=${PORT:-80}

echo "🚀 Configurando Apache para puerto $PORT..."

# Source variables de Apache
. /etc/apache2/envvars

# Configurar puerto usando sed para modificar archivos existentes
sed -i "s/Listen 80/Listen 0.0.0.0:$PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

echo "✅ Apache configurado en 0.0.0.0:$PORT"

# Iniciar Apache
exec apache2-foreground
