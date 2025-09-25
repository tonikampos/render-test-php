# 1. Empezamos con una imagen oficial que ya tiene PHP 8.2 y el servidor web Apache
FROM php:8.2-apache

# 2. Habilitamos las extensiones de PHP necesarias para conectar a la base de datos PostgreSQL
# Esto es crucial para que PDO funcione
RUN docker-php-ext-install pdo pdo_pgsql

# 3. Copiamos todos los archivos de nuestro proyecto (index.php, composer.json)
# a la carpeta donde Apache sirve las páginas web dentro del contenedor
COPY . /var/www/html/