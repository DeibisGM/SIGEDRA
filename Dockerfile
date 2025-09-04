# Usamos una imagen oficial de PHP 8.2 con el servidor web Apache
FROM php:8.2-apache

# 1. Instalamos las dependencias del sistema y extensiones de PHP que Laravel necesita
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# 2. Configuramos Apache para que apunte a la carpeta /public de Laravel
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 3. Instalamos Composer (el manejador de paquetes de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Establecemos el directorio de trabajo
WORKDIR /var/www/html

# 5. Copiamos los archivos de la aplicación
COPY . .

# 6. Instalamos las dependencias de Composer y NPM, y compilamos los assets
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# 7. Ajustamos los permisos de las carpetas de Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# El comando por defecto que se ejecutará al iniciar el contenedor es iniciar Apache
CMD ["apache2-foreground"]
