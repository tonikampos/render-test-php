# 1. Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# 2. Instalar dependencias del sistema operativo necesarias
# (añadimos zip y unzip, que Composer a veces necesita)
RUN apt-get update && apt-get install -y libpq-dev zip unzip

# 3. Instalar las extensiones de PHP para PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# --- NUEVOS PASOS PARA COMPOSER ---
# 4. Copiar Composer desde su imagen oficial (método moderno y limpio)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 6. Copiar solo los archivos de dependencias primero para optimizar la caché de Docker
COPY composer.json composer.lock* ./

# 7. Instalar las dependencias de PHP (PHPMailer) con optimizaciones para producción
RUN composer install --no-dev --optimize-autoloader
# --- FIN DE LOS NUEVOS PASOS ---

# 8. Copiar el resto del código de la aplicación (index.php, etc.)
COPY . .