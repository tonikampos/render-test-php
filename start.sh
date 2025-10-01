#!/bin/bash
set -e

# Configurar el puerto (usar el de Render o 80 por defecto)
export PORT=${PORT:-80}

echo "🚀 Configurando Apache para puerto $PORT en todas las interfaces (0.0.0.0)..."

# Configurar Apache ports.conf para escuchar en todas las interfaces
echo "Listen 0.0.0.0:$PORT" > /etc/apache2/ports.conf

# Configurar VirtualHost
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:$PORT>
    ServerName localhost
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

echo "✅ Apache configurado en puerto $PORT"

# Iniciar Apache
exec apache2-foreground
