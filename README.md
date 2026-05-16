# E-Commerce Laravel

Sistema de comercio electrónico desarrollado con Laravel que incluye autenticación de dos factores, manejo de archivos, notificaciones por correo y control de acceso por roles.

## Tecnologías usadas

- **Laravel 13** — Framework PHP
- **PHP 8.3** — Lenguaje de programación
- **MySQL** — Base de datos en producción
- **SQLite** — Base de datos en pruebas y CI
- **GitHub Actions** — Integración continua (CI)
- **Mailtrap** — Servicio de correo en desarrollo
- **Tailwind CSS** — Estilos

## Características principales

- Autenticación manual con 2FA (código OTP por correo)
- Control de acceso por roles: Administrador, Gerente, Cliente
- Policies de Laravel para autorización
- Gestión de archivos: fotos públicas y tickets privados
- Notificaciones por correo al validar ventas
- Dashboard administrativo con estadísticas Eloquent
- CRUD completo: Usuarios, Productos, Categorías, Ventas

## Instalación local

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/TU_REPO.git
cd TU_REPO

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos en .env
# DB_DATABASE=ecommerce
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Crear enlace de almacenamiento
php artisan storage:link

# 7. Compilar assets
npm run dev

# 8. Iniciar servidor
php artisan serve
```

## Ejecución de pruebas

```bash
php artisan test
```

O solo los tests del sistema:

```bash
php artisan test --filter EcommerceTest
```

## Credenciales de prueba

| Rol | Correo | Contraseña |
|-----|--------|------------|
| Administrador | admin@test.com | 123 |
| Gerente | jlopez1@tuxtla.tecnm.mx | 123 |
| Cliente | msanchez2@tuxtla.tecnm.mx | 123 |

## URL pública

[https://TU-APP.onrender.com](https://TU-APP.onrender.com)

> **Nota:** Actualiza esta URL después del despliegue en la nube.
