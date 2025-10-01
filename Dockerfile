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

# 4. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 5. Copiar toda la aplicación
COPY . .

# 6. Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# 7. Copiar Composer e instalar dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader --no-interaction; fi

# 8. Copiar y configurar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 9. Exponer puerto por defecto
EXPOSE 80

# 10. Comando de inicio que configura Apache dinámicamente
CMD ["/start.sh"]