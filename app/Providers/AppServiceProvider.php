<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta;
use App\Policies\CategoriaPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\VentaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\Usuario;
use App\Policies\UsuarioPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Registrar Policies
        Gate::policy(Producto::class, ProductoPolicy::class);
        Gate::policy(Categoria::class, CategoriaPolicy::class);
        Gate::policy(Venta::class, VentaPolicy::class);
        Gate::policy(Usuario::class, UsuarioPolicy::class);

        // Gates por rol
        Gate::define('es-administrador', function ($usuario) {
            return $usuario->esAdministrador();
        });

        Gate::define('es-gerente', function ($usuario) {
            return $usuario->esGerente();
        });

        Gate::define('es-cliente', function ($usuario) {
            return $usuario->esCliente();
        });

        Gate::define('administrador-o-gerente', function ($usuario) {
            return $usuario->esAdministrador() || $usuario->esGerente();
        });
    }
}
