# Usa una imagen base oficial de PHP con FPM y Composer
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libmcrypt-dev \
    libicu-dev \
    g++ \
    libpq-dev \
    nodejs \
    npm

# Instala extensiones de PHP incluyendo zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    soap

# Copia Composer desde una imagen oficial de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia el archivo composer.json y composer.lock
COPY composer.json composer.lock ./

# Instala dependencias de PHP
RUN composer install --no-scripts --no-autoloader --no-interaction --optimize-autoloader --ignore-platform-reqs

# Copia el resto del código de la aplicación
COPY . .

# Instala dependencias de NPM
RUN npm install

# Configura permisos
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Corre optimización de Composer
RUN composer dump-autoload --optimize

# Exponer el puerto 8000 y el puerto 5173 para Vite
EXPOSE 8080
EXPOSE 5173

# Comando de inicio del contenedor
CMD ["sh", "-c", "composer install & npm install & php artisan optimize &  php artisan config:cache & php artisan route:cache & php artisan view:cache & php artisan migrate:refresh --seed & php artisan serve --host=0.0.0.0 --port=8080 & npm run dev"]

