<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Usuario::class);
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $this->authorize('create', Usuario::class);
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Usuario::class);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo'    => 'required|email|unique:usuarios,correo',
            'clave'     => 'required|min:8|confirmed',
            'rol'       => 'required|in:administrador,gerente,cliente',
        ]);

        Usuario::create([
            'nombre'    => $request->nombre,
            'apellidos' => $request->apellidos,
            'correo'    => $request->correo,
            'clave'     => Hash::make($request->clave),
            'rol'       => $request->rol,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        $this->authorize('update', $usuario);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $this->authorize('update', $usuario);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo'    => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'rol'       => 'required|in:administrador,gerente,cliente',
        ]);

        $usuario->update($request->only('nombre', 'apellidos', 'correo', 'rol'));

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy(Usuario $usuario)
    {
        $this->authorize('delete', $usuario);
        $usuario->delete();
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado.');
    }
}
