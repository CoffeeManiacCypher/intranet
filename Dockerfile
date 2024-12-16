# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema necesarias para Laravel y Node.js
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libonig5 \
    nodejs \
    npm

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Configurar carpeta de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar dependencias de Composer y npm
RUN composer install --no-dev --no-scripts --optimize-autoloader
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar Apache DocumentRoot para apuntar a la carpeta 'public'
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para las rutas amigables de Laravel
RUN a2enmod rewrite

# Eliminar archivos innecesarios (mejora el tamaño final de la imagen)
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
CMD php artisan migrate --force && apache2-foreground

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
