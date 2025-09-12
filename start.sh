#!/bin/sh

# Set the port in the Apache configuration
sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf
echo "Listen ${PORT:-80}" >> /etc/apache2/ports.conf

# Start Apache
apache2-foreground
