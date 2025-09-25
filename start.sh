#!/bin/sh

# Set the port in the NGINX configuration
sed -i "s/listen 80;/listen ${PORT:-80};/g" /etc/nginx/sites-available/default

# Start PHP-FPM
php-fpm &

# Start Nginx
nginx -g 'daemon off;'
