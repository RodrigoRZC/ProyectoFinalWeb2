@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
        @can('create', App\Models\Usuario::class)
            <a href="{{ route('usuarios.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Nuevo usuario
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-3 text-left border-b">Nombre</th>
                <th class="p-3 text-left border-b">Apellidos</th>
                <th class="p-3 text-left border-b">Correo</th>
                <th class="p-3 text-left border-b">Rol</th>
                <th class="p-3 text-left border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $usuario->nombre }}</td>
                <td class="p-3">{{ $usuario->apellidos }}</td>
                <td class="p-3">{{ $usuario->correo }}</td>
                <td class="p-3">
                    <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full">
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </td>
                <td class="p-3 flex gap-2">
                    @can('update', $usuario)
                        <a href="{{ route('usuarios.edit', $usuario) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                            Editar
                        </a>
                    @endcan
                    @can('delete', $usuario)
                        <form action="{{ route('usuarios.destroy', $usuario) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
