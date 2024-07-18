# Usa una imagen base oficial de PHP con FPM y Composer
FROM php:8.2-fpm

# Actualiza los repositorios y limpia la cache
RUN apt-get update && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala dependencias del sistema por separado para identificar errores
RUN apt-get update && apt-get install -y libzip-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y unzip && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y git && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y curl && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libpng-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libjpeg62-turbo-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libfreetype6-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libonig-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libxml2-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libicu-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y g++ && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y libpq-dev && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y nodejs && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y npm && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y supervisor && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y netcat-openbsd && apt-get clean && rm -rf /var/lib/apt/lists/*

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

# Instala Vite globalmente
RUN npm install -g vite

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

# Copia el archivo de configuración de Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configura permisos
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Corre optimización de Composer
RUN composer dump-autoload --optimize

# Exponer el puerto 8080 y el puerto 5173 para Vite
EXPOSE 8080
EXPOSE 5173

# Comando de inicio del contenedor
CMD ["sh", "-c", "composer install & npm install && npm run build && php artisan serve --host=0.0.0.0 --port=8080 "]