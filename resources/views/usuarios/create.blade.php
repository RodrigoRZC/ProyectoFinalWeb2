@extends('layouts.app')
@section('title', 'Nuevo Usuario')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-8 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nuevo Usuario</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Apellidos</label>
            <input type="text" name="apellidos" value="{{ old('apellidos') }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Contraseña</label>
            <input type="password" name="clave" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Confirmar contraseña</label>
            <input type="password" name="clave_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Rol</label>
            <select name="rol" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Selecciona --</option>
                <option value="administrador" {{ old('rol')=='administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="gerente"       {{ old('rol')=='gerente'       ? 'selected' : '' }}>Gerente</option>
                <option value="cliente"       {{ old('rol')=='cliente'       ? 'selected' : '' }}>Cliente</option>
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Guardar
            </button>
            <a href="{{ route('usuarios.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
