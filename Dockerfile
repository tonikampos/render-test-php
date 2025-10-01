# 1. Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Anunciamos que el contenedor escuchará en el puerto 80
EXPOSE 80

# 2. Instalar dependencias del sistema operativo necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_pgsql mbstring

# 4. Copiar Composer desde su imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 6. Copiar archivos de dependencias primero (para optimizar caché de Docker)
COPY composer.json composer.lock* ./

# 7. Instalar dependencias PHP (solo si existen)
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader --no-interaction; fi

# 8. Copiar toda la aplicación
COPY . .

# 9. Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/html