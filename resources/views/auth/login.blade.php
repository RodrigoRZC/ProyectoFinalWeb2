@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Iniciar sesión</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Correo electrónico</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Contraseña</label>
            <input type="password" name="clave" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="flex items-center gap-3 mb-6">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-gray-600 text-sm">Recordarme</label>
        </div>
        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
            Entrar
        </button>
    </form>
</div>
@endsection
