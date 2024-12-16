# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Instala extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto Laravel al contenedor
COPY . /var/www/html

# Configura permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage

# Instala las dependencias del proyecto
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Configura Apache para usar Laravel como base
RUN a2enmod rewrite

# Expone el puerto 80
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
