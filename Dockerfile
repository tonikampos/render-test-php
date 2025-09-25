# 1. Empezamos con una imagen oficial que ya tiene PHP 8.2 y el servidor web Apache
FROM php:8.2-apache

# 2. (NUEVO PASO) Instalamos las herramientas de desarrollo de PostgreSQL
# Este es el "manual de instrucciones" que le faltaba al sistema.
RUN apt-get update && apt-get install -y libpq-dev

# 3. AHORA SÍ, habilitamos las extensiones de PHP para PostgreSQL
# Con el manual ya instalado, este paso funcionará.
RUN docker-php-ext-install pdo pdo_pgsql

# 4. Copiamos todos los archivos de nuestro proyecto
COPY . /var/www/html/