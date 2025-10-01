# 1. Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache
# Anunciamos que el contenedor escuchará en el puerto 80
EXPOSE 80

# 2. Instalar dependencias del sistema operativo necesarias
# (añadimos librerías para PostgreSQL, SSL, curl y zip para Composer)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalar extensiones de PHP necesarias
# - PostgreSQL: pdo, pdo_pgsql
# - SendGrid/PHPMailer: openssl, curl, mbstring
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    curl \
    mbstring

# 3.1. Asegurar que OpenSSL está habilitado (viene por defecto pero lo verificamos)
RUN php -m | grep -i openssl || echo "OpenSSL no encontrado - revisar configuración"

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