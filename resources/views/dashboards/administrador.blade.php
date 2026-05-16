@extends('layouts.app')
@section('title', 'Dashboard Administrador')
@section('content')

<div class="bg-white shadow-sm sm:rounded-lg p-8 mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Panel de Administrador</h2>
    <p class="text-gray-500 mt-1">Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</p>
</div>

{{-- Tarjetas de estadísticas --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
        <div class="text-4xl font-bold text-indigo-600">{{ $totalUsuarios }}</div>
        <div class="text-gray-500 mt-1">Total de usuarios</div>
    </div>
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
        <div class="text-4xl font-bold text-green-600">{{ $totalVendedores }}</div>
        <div class="text-gray-500 mt-1">Vendedores (gerentes)</div>
    </div>
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
        <div class="text-4xl font-bold text-blue-600">{{ $totalCompradores }}</div>
        <div class="text-gray-500 mt-1">Compradores (clientes)</div>
    </div>
</div>

{{-- Fila de estadísticas detalladas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    {{-- Producto más vendido --}}
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Producto más vendido</h3>
        @if($productoMasVendido && $productoMasVendido->producto)
            <div class="flex items-center gap-4">
                <div class="text-4xl">📦</div>
                <div>
                    <div class="font-bold text-gray-800 text-lg">
                        {{ $productoMasVendido->producto->nombre }}
                    </div>
                    <div class="text-gray-500 text-sm">
                        {{ $productoMasVendido->total_ventas }} ventas registradas
                    </div>
                    <div class="text-indigo-600 text-sm font-medium">
                        ${{ number_format($productoMasVendido->producto->precio, 2) }} por unidad
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-400">No hay ventas registradas aún.</p>
        @endif
    </div>

    {{-- Comprador más frecuente --}}
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🛒 Comprador más frecuente</h3>
        @if($compradorMasFrecuente && $compradorMasFrecuente->cliente)
            <div class="flex items-center gap-4">
                <div class="text-4xl">👤</div>
                <div>
                    <div class="font-bold text-gray-800 text-lg">
                        {{ $compradorMasFrecuente->cliente->nombre }}
                        {{ $compradorMasFrecuente->cliente->apellidos }}
                    </div>
                    <div class="text-gray-500 text-sm">
                        {{ $compradorMasFrecuente->total_compras }} compras realizadas
                    </div>
                    <div class="text-gray-400 text-sm">
                        {{ $compradorMasFrecuente->cliente->correo }}
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-400">No hay compras registradas aún.</p>
        @endif
    </div>

</div>



{{-- Comprador más frecuente por categoría --}}
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        🏆 Comprador más frecuente por categoría
    </h3>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-3 text-left border-b">Categoría</th>
                <th class="p-3 text-left border-b">Comprador</th>
                <th class="p-3 text-left border-b">Correo</th>
                <th class="p-3 text-left border-b">Compras en esta categoría</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compradorPorCategoria as $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">
                    <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full">
                        {{ $item['categoria'] }}
                    </span>
                </td>
                @if($item['comprador'] && $item['comprador']['cliente'])
                    <td class="p-3 font-medium">
                        {{ $item['comprador']['cliente']->nombre }}
                        {{ $item['comprador']['cliente']->apellidos }}
                    </td>
                    <td class="p-3 text-gray-500 text-sm">
                        {{ $item['comprador']['cliente']->correo }}
                    </td>
                    <td class="p-3">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">
                            {{ $item['comprador']['total_compras'] }} compras
                        </span>
                    </td>
                @else
                    <td colspan="3" class="p-3 text-gray-400 text-sm">
                        Sin compras registradas
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>





{{-- Productos por categoría --}}
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">🏷️ Productos por categoría</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        @foreach($categorias as $categoria)
            <div class="bg-indigo-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">
                    {{ $categoria->productos_count }}
                </div>
                <div class="text-gray-600 text-sm mt-1">{{ $categoria->nombre }}</div>
            </div>
        @endforeach
    </div>
</div>

{{-- Categorías por vendedor (hasManyThrough) --}}
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        👥 Categorías por vendedor
        <span class="text-xs text-gray-400 font-normal ml-2">(hasManyThrough)</span>
    </h3>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-3 text-left border-b">Vendedor</th>
                <th class="p-3 text-left border-b">Productos</th>
                <th class="p-3 text-left border-b">Categorías que maneja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendedores as $vendedor)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 font-medium">
                    {{ $vendedor->nombre }} {{ $vendedor->apellidos }}
                </td>
                <td class="p-3 text-gray-500">
                    {{ $vendedor->productos->count() }} productos
                </td>
                <td class="p-3">
                    @php
                        $cats = $vendedor->productos->flatMap->categorias->unique('id');
                    @endphp
                    @forelse($cats as $cat)
                        <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full mr-1">
                            {{ $cat->nombre }}
                        </span>
                    @empty
                        <span class="text-gray-400 text-sm">Sin categorías</span>
                    @endforelse
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Accesos rápidos --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <a href="{{ route('usuarios.index') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block text-center">
        <div class="text-3xl mb-2">👥</div>
        <div class="font-medium text-gray-700">Usuarios</div>
    </a>
    <a href="{{ route('productos.index') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block text-center">
        <div class="text-3xl mb-2">📦</div>
        <div class="font-medium text-gray-700">Productos</div>
    </a>
    <a href="{{ route('categorias.index') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block text-center">
        <div class="text-3xl mb-2">🏷️</div>
        <div class="font-medium text-gray-700">Categorías</div>
    </a>
    <a href="{{ route('ventas.index') }}"
       class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block text-center">
        <div class="text-3xl mb-2">💰</div>
        <div class="font-medium text-gray-700">Ventas</div>
    </a>
</div>

@endsection
