<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    // Helper para crear usuario autenticado
    private function crearUsuario(string $rol = 'cliente'): Usuario
    {
        return Usuario::create([
            'nombre'    => 'Test',
            'apellidos' => 'Usuario',
            'correo'    => $rol . '@test.com',
            'clave'     => Hash::make('123'),
            'rol'       => $rol,
        ]);
    }

    // ── TEST 1: Página principal responde correctamente ──────
    public function test_pagina_principal_responde_correctamente(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('E-Commerce');
    }

    // ── TEST 2: Página login responde correctamente ──────────
    public function test_pagina_login_responde_correctamente(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Iniciar');
    }

    // ── TEST 3: Dashboard requiere autenticación ─────────────
    public function test_dashboard_requiere_autenticacion(): void
    {
        $response = $this->get('/dashboard/cliente');
        $response->assertRedirect('/login');
    }

    // ── TEST 4: Login incorrecto muestra error ───────────────
    public function test_login_incorrecto_muestra_error(): void
    {
        $response = $this->post('/login', [
            'correo' => 'noexiste@test.com',
            'clave'  => 'incorrecta',
        ]);
        $response->assertSessionHasErrors('correo');
    }

    // ── TEST 5: Credenciales correctas redirigen a 2FA ───────
    public function test_login_correcto_redirige_a_2fa(): void
    {
        $this->crearUsuario('cliente');

        $response = $this->post('/login', [
            'correo' => 'cliente@test.com',
            'clave'  => '123',
        ]);

        $response->assertRedirect('/2fa');
    }

    // ── TEST 6: Usuario autenticado accede a su dashboard ────
    public function test_usuario_autenticado_accede_a_dashboard(): void
    {
        $usuario = $this->crearUsuario('cliente');

        $response = $this->actingAs($usuario)
            ->get('/dashboard/cliente');

        $response->assertStatus(200);
    }

    // ── TEST 7: Administrador puede acceder a lista de usuarios
    public function test_administrador_puede_listar_usuarios(): void
    {
        $admin = $this->crearUsuario('administrador');

        $response = $this->actingAs($admin)
            ->get('/usuarios');

        $response->assertStatus(200);
    }

    // ── TEST 8: Cliente NO puede acceder a lista de usuarios ─
    public function test_cliente_no_puede_listar_usuarios(): void
    {
        $cliente = $this->crearUsuario('cliente');

        $response = $this->actingAs($cliente)
            ->get('/usuarios');

        $response->assertStatus(403);
    }

    // ── TEST 9: Producto se guarda en base de datos ──────────
    public function test_administrador_puede_crear_producto(): void
    {
        $admin = $this->crearUsuario('administrador');

        $categoria = Categoria::create([
            'nombre'      => 'Electronica',
            'descripcion' => 'Categoria de prueba',
        ]);

        $response = $this->actingAs($admin)
            ->post('/productos', [
                'nombre'      => 'Teclado Mecanico',
                'descripcion' => 'Teclado de prueba',
                'precio'      => 500,
                'existencia'  => 10,
                'categorias'  => [$categoria->id],
            ]);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Teclado Mecanico',
        ]);
    }

    // ── TEST 10: Cliente NO puede crear producto ─────────────
    public function test_cliente_no_puede_crear_producto(): void
    {
        $cliente = $this->crearUsuario('cliente');

        $response = $this->actingAs($cliente)
            ->post('/productos', [
                'nombre'     => 'Producto No Permitido',
                'precio'     => 100,
                'existencia' => 5,
            ]);

        $this->assertDatabaseMissing('productos', [
            'nombre' => 'Producto No Permitido',
        ]);
    }

    // ── TEST 11: Ruta 2FA existe y responde ──────────────────
    public function test_ruta_2fa_responde_correctamente(): void
    {
        // Simulamos sesión de 2FA pendiente
        $response = $this->withSession(['2fa_usuario_id' => 1])
            ->get('/2fa');

        $response->assertStatus(200);
    }

    // ── TEST 12: Páginas públicas responden correctamente ────
    public function test_paginas_publicas_responden_correctamente(): void
    {
        $this->get('/quienes-somos')->assertStatus(200);
        $this->get('/mision-vision')->assertStatus(200);
        $this->get('/contacto')->assertStatus(200);
    }
}
