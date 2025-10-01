# 1. Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# 2. Instalar dependencias del sistema operativo necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_pgsql mbstring

# 4. Configurar Apache para usar el puerto de Render
RUN echo "Listen \${PORT:-80}" > /etc/apache2/ports.conf
RUN echo '<VirtualHost *:${PORT:-80}>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# 5. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 6. Copiar toda la aplicación
COPY . .

# 7. Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# 8. Copiar Composer e instalar dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader --no-interaction; fi

# 9. Configurar script de inicio que use el puerto correcto
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'export PORT=${PORT:-80}' >> /start.sh && \
    echo 'apache2-foreground' >> /start.sh && \
    chmod +x /start.sh

# 10. Exponer el puerto
EXPOSE ${PORT:-80}

# 11. Comando de inicio
CMD ["/start.sh"]