# Usa la imagen base de PHP con Apache
FROM php:8.2-apache

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && apt-get install -y nodejs

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-client \
    libmariadb-dev

# Instalar y habilitar pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Configurar la carpeta de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar Composer y dependencias
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Ejecutar build de npm si existe package.json
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Configurar Apache DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Ejecutar migraciones y seeders automáticamente
RUN php artisan config:cache
RUN php artisan migrate --force || true
RUN php artisan db:seed --force || true

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]

