# Usa una imagen base oficial de PHP con FPM
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Instala extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia el archivo composer.json y composer.lock
COPY composer.json composer.lock ./

# Instala dependencias de PHP
RUN composer install --no-scripts --no-autoloader --no-interaction --optimize-autoloader

# Copia el resto del código de la aplicación
COPY . .

# Configura permisos
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Corre optimización de Composer
RUN composer dump-autoload --optimize

# Exponer el puerto 9000 y ejecutar el comando de PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
