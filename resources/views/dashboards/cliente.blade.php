@extends('layouts.app')
@section('title', 'Dashboard Cliente')
@section('content')

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mb-4">
    <h2 class="text-2xl font-bold text-gray-800">Panel de Cliente</h2>
    <p class="text-gray-500 mt-1">Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <a href="{{ route('productos.index') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
        <div class="text-4xl mb-3">🛍️</div>
        <h3 class="font-semibold text-gray-800 text-lg mb-1">Ver productos</h3>
        <p class="text-gray-400 text-sm">Explora el catálogo disponible</p>
    </a>

    <a href="{{ route('ventas.create') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
        <div class="text-4xl mb-3">🛒</div>
        <h3 class="font-semibold text-gray-800 text-lg mb-1">Comprar</h3>
        <p class="text-gray-400 text-sm">Realizar una nueva compra</p>
    </a>

</div>
@endsection
