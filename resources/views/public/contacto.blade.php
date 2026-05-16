@extends('layouts.app')
@section('title', 'Contacto')
@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Contáctanos</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">📧 Correo</h3>
            <p class="text-gray-600">contacto@ecommerce.com</p>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">📞 Teléfono</h3>
            <p class="text-gray-600">+52 961 000 0000</p>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">📍 Ubicación</h3>
            <p class="text-gray-600">Tuxtla Gutiérrez, Chiapas, México</p>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">🕐 Horario</h3>
            <p class="text-gray-600">Lunes a Viernes, 9:00 - 18:00</p>
        </div>
    </div>
</div>
@endsection
