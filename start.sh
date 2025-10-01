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
# Iniciar Apache en foreground
exec apache2-foreground
