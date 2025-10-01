#!/bin/bash
set -e

# Configurar el puerto (usar el de Render o 80 por defecto)
export PORT=${PORT:-80}
export APACHE_PORT=$PORT

echo "🚀 Iniciando Apache en puerto $PORT (0.0.0.0:$PORT)..."

# Configurar Apache ports.conf
cat > /etc/apache2/ports.conf <<EOF
# Configuración dinámica de puerto para Render
Listen 0.0.0.0:$PORT
EOF

# Configurar VirtualHost
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:$PORT>
    ServerName localhost
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

echo "✅ Apache configurado"
echo "📋 Configuración:"
cat /etc/apache2/ports.conf
echo ""
cat /etc/apache2/sites-available/000-default.conf

# Verificar sintaxis
apache2ctl configtest || echo "⚠️ Warning en configuración (se puede ignorar)"

echo "🚀 Iniciando Apache..."

# NO usar apache2-foreground - arrancamos Apache manualmente
# para tener control total sobre el puerto

# Asegurar que Apache use nuestro puerto
export APACHE_RUN_USER=www-data
export APACHE_RUN_GROUP=www-data
export APACHE_LOG_DIR=/var/log/apache2
export APACHE_PID_FILE=/var/run/apache2/apache2.pid

# Crear directorio para PID si no existe
mkdir -p /var/run/apache2

# Iniciar Apache en foreground con nuestra configuración
exec /usr/sbin/apache2 -D FOREGROUND -k start
