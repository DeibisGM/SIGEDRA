# --- Base Stage ---
FROM php:8.2-apache as base

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Configure Apache for Render
# Render sets a PORT environment variable, which we use to configure Apache.
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# --- Composer Dependencies Stage ---
FROM composer:latest as composer_deps

WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY database/ database/
COPY composer.json composer.lock ./ 
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist

# --- NPM Dependencies Stage ---
FROM node:18 as npm_deps

WORKDIR /var/www/html

# Copy package.json and install dependencies
COPY package.json package-lock.json ./ 
RUN npm install

# Copy the rest of the frontend files and build
COPY vite.config.js tailwind.config.js postcss.config.js ./ 
COPY resources/ resources/
RUN npm run build

# --- Final Stage ---
FROM base

WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy installed dependencies
COPY --from=composer_deps /var/www/html/vendor/ vendor/
COPY --from=npm_deps /var/www/html/public/build/ public/build/

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Set the port for Apache
ENV APACHE_PORT=${PORT:-80}

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]
