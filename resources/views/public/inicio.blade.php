@extends('layouts.app')
@section('title', 'Inicio')
@section('content')

{{-- Hero --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center mb-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a E-Commerce</h1>
    <p class="text-gray-500 text-lg mb-8">Tu tienda en línea de confianza</p>
    @guest
        <a href="{{ route('login') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Iniciar sesión
        </a>
    @endguest
</div>

{{-- Secciones públicas --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <a href="{{ route('quienes-somos') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
        <div class="text-4xl mb-3">🏢</div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Quiénes somos</h3>
        <p class="text-gray-400 text-sm">Conoce nuestra historia y valores</p>
    </a>

    <a href="{{ route('mision-vision') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
        <div class="text-4xl mb-3">🎯</div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Misión y Visión</h3>
        <p class="text-gray-400 text-sm">Nuestros objetivos y propósito</p>
    </a>

    <a href="{{ route('contacto') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
        <div class="text-4xl mb-3">📬</div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Contáctanos</h3>
        <p class="text-gray-400 text-sm">Estamos para ayudarte</p>
    </a>

</div>
@endsection
