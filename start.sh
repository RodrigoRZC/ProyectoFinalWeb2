#!/bin/bash

mkdir -p /var/data
mkdir -p storage/logs
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data

# Base de datos SQLite
if [ ! -f /var/data/database.sqlite ]; then
    touch /var/data/database.sqlite
fi

# Permisos
chmod -R 775 storage bootstrap/cache

# Limpiar cache
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Migraciones
php artisan migrate --force

# Seeders
php artisan db:seed --force 2>/dev/null || true

# Storage link — apunta public/storage a storage/app/public
php artisan storage:link 2>/dev/null || true

# Forzar HTTPS
php artisan config:cache

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
