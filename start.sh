#!/bin/bash

# Crear directorio de datos si no existe
mkdir -p /var/data

# Crear base de datos SQLite si no existe
if [ ! -f /var/data/database.sqlite ]; then
    touch /var/data/database.sqlite
fi

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders solo si la base de datos está vacía
php artisan db:seed --force 2>/dev/null || true

# Crear enlace de almacenamiento
php artisan storage:link 2>/dev/null || true

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=$PORT
