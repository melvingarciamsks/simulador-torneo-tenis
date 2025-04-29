# Imagen base para PHP con FPM
FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    supervisor \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN apt-get update && apt-get install -y procps

# Instalar mod para quitar el header Server de Nginx
RUN apt-get install libnginx-mod-http-headers-more-filter

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración de la carpeta de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --optimize-autoloader

ENV APP_KEY=base64:3l7qCPv3HlkG9EsoZn5nLt0tPMVYdLLF6194pjWt4PI=
# Generar el archivo APP_KEY
RUN php artisan key:generate

# Establecer permisos para las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copiar configuración de Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Copiar configuración de Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exponer el puerto 8080 para Cloud Run
EXPOSE 8080

# Comando de inicio con Supervisor (maneja PHP-FPM y Nginx)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]