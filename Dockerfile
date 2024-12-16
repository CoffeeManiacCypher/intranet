# Usa una imagen de PHP y Node.js combinada
FROM php:8.2-fpm

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Configurar la carpeta de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . /var/www/html

# Instalar dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --no-dev --optimize-autoloader

# Ejecutar build de npm (si existe package.json)
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando por defecto para ejecutar PHP
CMD ["php-fpm"]
