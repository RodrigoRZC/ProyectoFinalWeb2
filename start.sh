#!/bin/bash

# Crear directorio de datos
mkdir -p /var/data
mkdir -p storage/logs
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache

# Crear base de datos SQLite
if [ ! -f /var/data/database.sqlite ]; then
    touch /var/data/database.sqlite
fi

# Generar clave si no existe
php artisan key:generate --force 2>/dev/null || true

# Limpiar cache
php artisan config:clear
php artisan view:clear

# Ejecutar migraciones
php artisan migrate --force

# Poblar datos
php artisan db:seed --force 2>/dev/null || true

# Enlace de storage
php artisan storage:link 2>/dev/null || true

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
