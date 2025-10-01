# 1. Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Anunciamos que el contenedor escuchará en el puerto 80
EXPOSE 80

# 2. Instalar dependencias del sistema operativo necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalar extensiones de PHP necesarias para PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# 4. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 5. Copiar toda la aplicación
COPY . .

# 6. Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/html