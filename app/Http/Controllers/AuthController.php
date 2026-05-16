<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Muestra formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirige según el rol
            return match (Auth::user()->role) {
                'gerente'  => redirect()->route('gerente.dashboard'),
                'empleado' => redirect()->route('empleado.dashboard'),
                default    => redirect()->route('cliente.dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    // Muestra formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesa el registro
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8|confirmed',
            'role'                  => 'required|in:cliente,empleado,gerente',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        Auth::login($user);

        return match ($user->role) {
            'gerente'  => redirect()->route('gerente.dashboard'),
            'empleado' => redirect()->route('empleado.dashboard'),
            default    => redirect()->route('cliente.dashboard'),
        };
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
