# E-Commerce Laravel

Sistema de comercio electrónico desarrollado con Laravel que incluye autenticación
de dos factores, manejo de archivos, notificaciones por correo y control de acceso
por roles.

## 🌐 URL pública

[https://proyectofinalweb2-zvus.onrender.com](https://proyectofinalweb2-zvus.onrender.com)

## 🛠 Tecnologías usadas

- **Laravel 13** — Framework PHP
- **PHP 8.3** — Lenguaje de programación
- **SQLite** — Base de datos
- **GitHub Actions** — Integración continua (CI)
- **Docker** — Contenedor para despliegue
- **Render.com** — Plataforma cloud de despliegue
- **Mailtrap** — Servicio de correo en desarrollo
- **Tailwind CSS** — Estilos
- **Vite** — Compilador de assets

## ✨ Características principales

- Autenticación manual con 2FA (código OTP enviado por correo)
- Control de acceso por roles: Administrador, Gerente, Cliente
- Policies de Laravel para autorización
- Gates de autorización por rol
- Gestión de archivos: fotos públicas de productos y tickets privados de ventas
- Notificaciones por correo al validar ventas (vendedor y comprador)
- Dashboard administrativo con estadísticas usando Eloquent
- CRUD completo: Usuarios, Productos, Categorías, Ventas
- Bitácoras del sistema (autenticacion.log, productos.log, ventas.log)
- Seeders y Factory con 100 usuarios generados

## 📦 Instalación local

```bash
# 1. Clonar el repositorio
git clone https://github.com/RodrigoRZC/ProyectoFinalWeb2.git
cd ProyectoFinalWeb2

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar base de datos en .env
# DB_CONNECTION=mysql
# DB_DATABASE=ecommerce
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Crear enlace de almacenamiento
php artisan storage:link

# 8. Compilar assets
npm run dev

# 9. Iniciar servidor
php artisan serve
```

## ⚙️ Variables de entorno requeridas

```env
APP_NAME=E-Commerce
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ecommerce.com
MAIL_FROM_NAME=E-Commerce
```

## 🧪 Ejecución de pruebas

```bash
# Ejecutar todas las pruebas
php artisan test

# Ejecutar solo las pruebas del sistema
php artisan test --filter EcommerceTest
```

## 👤 Credenciales de prueba

| Rol | Correo | Contraseña |
|-----|--------|------------|
| Administrador | admin@test.com | 123 |
| Gerente | jlopez1@tuxtla.tecnm.mx | 123 |
| Cliente | msanchez2@tuxtla.tecnm.mx | 123 |

> **Nota:** El login requiere verificación 2FA. El código se envía al correo
> del usuario. En desarrollo usar Mailtrap para interceptar los correos.

## 🔄 Pipeline CI/CD

El proyecto usa **GitHub Actions** para integración continua. El pipeline
se ejecuta automáticamente en cada push a `main` y realiza:

1. Clonar repositorio
2. Instalar PHP 8.3
3. Instalar dependencias Composer
4. Instalar dependencias Node y compilar assets
5. Configurar entorno con SQLite
6. Ejecutar migraciones
7. Ejecutar seeders
8. Ejecutar 12 pruebas automáticas

## ☁️ Despliegue

La aplicación está desplegada en **Render.com** usando Docker.

El despliegue se activa automáticamente con cada push a `main`.

## 📁 Estructura del proyecto

```
├── app/
│   ├── Http/Controllers/     — Controladores
│   ├── Http/Requests/        — FormRequests con validaciones
│   ├── Mail/                 — Mailables
│   ├── Models/               — Modelos Eloquent
│   └── Policies/             — Policies de autorización
├── database/
│   ├── factories/            — UsuarioFactory
│   ├── migrations/           — Migraciones
│   └── seeders/              — Seeders
├── resources/views/          — Vistas Blade
├── routes/web.php            — Rutas
├── tests/Feature/            — Pruebas automáticas
├── .github/workflows/        — Pipeline GitHub Actions
├── Dockerfile                — Configuración Docker
└── render.yaml               — Configuración Render.com
```
