<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CodigoVerificacionMail;
use App\Models\CodigoVerificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    // Muestra el formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Fase 1 — Verifica credenciales y genera OTP
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'clave'  => 'required',
        ]);

        $credenciales = [
            'correo'   => $request->correo,
            'password' => $request->clave,
        ];

        // Intentamos autenticar temporalmente
        if (Auth::attempt($credenciales, false)) {
            $usuario = Auth::user();

            // Log fase 1
            Log::channel('autenticacion')->info('Login correcto fase 1 - pendiente 2FA', [
                'usuario_id' => $usuario->id,
                'correo'     => $usuario->correo,
                'ip'         => $request->ip(),
            ]);

            // Cerramos sesión — no iniciamos hasta validar OTP
            Auth::logout();

            // Invalidamos códigos anteriores
            CodigoVerificacion::where('usuario_id', $usuario->id)
                ->update(['usado' => true]);

            // Generamos código OTP de 6 dígitos
            $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Guardamos en base de datos con expiración de 5 minutos
            CodigoVerificacion::create([
                'usuario_id' => $usuario->id,
                'codigo'     => $codigo,
                'expiracion' => now()->addMinutes(5),
                'usado'      => false,
            ]);

            // Log código generado
            Log::channel('autenticacion')->info('Código 2FA generado', [
                'usuario_id' => $usuario->id,
                'ip'         => $request->ip(),
            ]);

            // Enviamos el correo con el OTP
            Mail::to($usuario->correo)->send(
                new CodigoVerificacionMail($usuario, $codigo)
            );

            // Guardamos el usuario_id en sesión para la fase 2
            session(['2fa_usuario_id' => $usuario->id]);

            return redirect()->route('2fa.show');
        }

        // Log login fallido
        Log::channel('autenticacion')->warning('Login fallido', [
            'correo' => $request->correo,
            'ip'     => $request->ip(),
        ]);

        return back()->withErrors([
            'correo' => 'Las credenciales no son correctas.',
        ])->onlyInput('correo');
    }

    // Muestra formulario para ingresar el código OTP
    public function show2fa()
    {
        // Si no hay sesión de 2FA pendiente, redirige al login
        if (!session('2fa_usuario_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa');
    }

    // Fase 2 — Valida el código OTP
    public function verify2fa(Request $request)
    {
        $request->validate([
            'codigo' => 'required|digits:6',
        ]);

        $usuarioId = session('2fa_usuario_id');

        if (!$usuarioId) {
            return redirect()->route('login')
                ->withErrors(['codigo' => 'Sesión expirada. Inicia sesión nuevamente.']);
        }

        // Buscamos el código más reciente no usado
        $registro = CodigoVerificacion::where('usuario_id', $usuarioId)
            ->where('usado', false)
            ->latest()
            ->first();

        if (!$registro) {
            Log::channel('autenticacion')->warning('Código 2FA inválido', [
                'usuario_id' => $usuarioId,
                'ip'         => $request->ip(),
            ]);

            return back()->withErrors(['codigo' => 'Código inválido.']);
        }

        // Verificamos expiración
        if ($registro->estaExpirado()) {
            $registro->update(['usado' => true]);

            Log::channel('autenticacion')->warning('Código 2FA expirado', [
                'usuario_id' => $usuarioId,
                'ip'         => $request->ip(),
            ]);

            return back()->withErrors(['codigo' => 'El código ha expirado. Inicia sesión nuevamente.']);
        }

        // Verificamos que el código sea correcto
        if ($registro->codigo !== $request->codigo) {
            Log::channel('autenticacion')->warning('Código 2FA incorrecto', [
                'usuario_id' => $usuarioId,
                'ip'         => $request->ip(),
            ]);

            return back()->withErrors(['codigo' => 'El código ingresado es incorrecto.']);
        }

        // Código correcto — marcamos como usado
        $registro->update(['usado' => true]);

        // Cargamos el usuario directamente por id numérico
        $usuario = \App\Models\Usuario::find($usuarioId);

        if (!$usuario) {
            return redirect()->route('login')
                ->withErrors(['codigo' => 'Usuario no encontrado.']);
        }

        // Iniciamos sesión real con el objeto usuario
        Auth::login($usuario);
        session()->forget('2fa_usuario_id');
        $request->session()->regenerate();

        Log::channel('autenticacion')->info('Código 2FA validado correctamente — sesión iniciada', [
            'usuario_id' => $usuario->id,
            'correo'     => $usuario->correo,
            'ip'         => $request->ip(),
        ]);

        return match ($usuario->rol) {
            'administrador' => redirect()->route('admin.dashboard'),
            'gerente'       => redirect()->route('gerente.dashboard'),
            default         => redirect()->route('cliente.dashboard'),
        };
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        $usuario = Auth::user();

        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => $usuario->id,
            'correo'     => $usuario->correo,
            'ip'         => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
