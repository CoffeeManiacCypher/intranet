FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    git

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql gd

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configurar directorio de Laravel
WORKDIR /var/www/html
COPY . .

# Permisos y caché de Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurar Vite (para producción)
RUN npm install && npm run build

# Configurar la aplicación
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
