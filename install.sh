#!/bin/bash

echo "🚀 Instalando SIGEDRA con dependencias completas..."

# Verificar sistema operativo
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    echo "✅ Sistema Linux detectado"
elif [[ "$OSTYPE" == "darwin"* ]]; then
    echo "🍎 Sistema macOS detectado"
    echo "❌ Este script es para Linux. En macOS usa brew para instalar PHP"
    exit 1
else
    echo "❌ Sistema no compatible"
    exit 1
fi

# Actualizar repositorios
echo "📦 Actualizando repositorios..."
sudo apt-get update

# Instalar PHP 8.2 y extensiones REQUERIDAS
echo "🐘 Instalando PHP 8.2 y extensiones necesarias..."
sudo apt-get install -y php8.2 php8.2-cli php8.2-common php8.2-mysql 
sudo apt-get install -y php8.2-zip php8.2-gd php8.2-mbstring php8.2-xml
sudo apt-get install -y php8.2-curl php8.2-intl php8.2-bcmath

# Verificar instalación de PHP
echo "🔍 Verificando instalación de PHP..."
php -v
echo "📋 Extensiones instaladas:"
php -m | grep -E "(gd|zip|mysql|mbstring|xml)"

# Instalar Composer si no existe
if ! command -v composer &> /dev/null; then
    echo "📦 Instalando Composer..."
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    echo "✅ Composer instalado"
else
    echo "✅ Composer ya está instalado"
fi

# Instalar dependencias del proyecto
echo "� Instalando dependencias del proyecto..."
composer install --no-dev --optimize-autoloader

# Configurar aplicación
echo "🔧 Configurando aplicación..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
    echo "🔑 Clave de aplicación generada"
fi

# Configurar permisos
echo "📁 Configurando permisos..."
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
mkdir -p storage/app/exports
chmod -R 775 storage/app/exports

# Configurar base de datos
echo "🗄️  Configuración de base de datos:"
echo "❗ IMPORTANTE: Configura la base de datos en el archivo .env antes de continuar"
echo "   - DB_CONNECTION=mysql"
echo "   - DB_HOST=tu_servidor"
echo "   - DB_DATABASE=db_sigedra"
echo "   - DB_USERNAME=tu_usuario"
echo "   - DB_PASSWORD=tu_password"
echo ""

read -p "¿Ya configuraste la base de datos en .env? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🔄 Ejecutando migraciones..."
    php artisan migrate
    echo "✅ Migraciones completadas"
else
    echo "⚠️  Recuerda ejecutar 'php artisan migrate' después de configurar .env"
fi

echo ""
echo "🎉 ¡Instalación completada exitosamente!"
echo ""
echo "📝 Próximos pasos:"
echo "   1. Configura la base de datos en .env (si no lo hiciste)"
echo "   2. Ejecuta: php artisan migrate (si no lo hiciste)"
echo "   3. Inicia el servidor: php artisan serve --host=0.0.0.0 --port=8000"
echo "   4. Accede a: http://localhost:8000"
echo ""
echo "🔐 Usuario por defecto (si existe): 703030132 / 703030132"