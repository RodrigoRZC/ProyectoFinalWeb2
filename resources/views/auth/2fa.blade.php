@extends('layouts.app')
@section('title', 'Verificación de dos factores')
@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-md mx-auto">

    <div class="text-center mb-6">
        <div class="text-5xl mb-3">📧</div>
        <h2 class="text-2xl font-bold text-gray-800">Verificación en dos pasos</h2>
        <p class="text-gray-500 mt-2 text-sm">
            Hemos enviado un código de 6 dígitos a tu correo electrónico.<br>
            El código expira en <strong>5 minutos</strong>.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2 text-center">
                Ingresa tu código de verificación
            </label>
            <input type="text" name="codigo" maxlength="6" autocomplete="off"
                   placeholder="000000"
                   class="w-full border-2 border-indigo-300 rounded-lg px-4 py-4
                          text-center text-3xl font-bold tracking-widest
                          focus:outline-none focus:ring-2 focus:ring-indigo-400"
                   autofocus>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg
                       hover:bg-indigo-700 font-medium text-lg">
            Verificar código
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Volver al inicio de sesión
        </a>
    </div>
</div>
@endsection
