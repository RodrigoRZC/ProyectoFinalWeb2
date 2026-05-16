@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')
@section('title', 'Productos')
@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center gap-3">
        <span class="text-2xl">✅</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if(Auth::user()->esCliente())

    {{-- Vista para clientes: tarjetas --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Catálogo de Productos</h2>
        <p class="text-gray-500 mt-1">Explora nuestros productos disponibles</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($productos as $producto)
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden hover:shadow-md transition">
            
            {{-- Encabezado de la tarjeta --}}
            {{-- Foto del producto --}}
            @if($producto->fotos && count($producto->fotos) > 0)
                <img src="{{ Storage::url($producto->fotos[0]) }}"
                     class="w-full h-48 object-cover">
            @else
                <div class="bg-indigo-600 h-48 flex items-center justify-center">
                    <span class="text-white text-5xl">📦</span>
                </div>
            @endif
            {{-- Encabezado de la tarjeta --}}
            <div class="px-5 py-3 border-b">
                <h3 class="font-bold text-lg text-gray-800">{{ $producto->nombre }}</h3>
            </div>

            {{-- Cuerpo de la tarjeta --}}
            <div class="p-5">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-500 text-sm">Precio</span>
                    <span class="text-2xl font-bold text-indigo-600">
                        ${{ number_format($producto->precio, 2) }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">Existencia</span>
                    @if($producto->existencia > 0)
                        <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">
                            {{ $producto->existencia }} disponibles
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full font-medium">
                            Sin stock
                        </span>
                    @endif
                </div>

                {{-- Categorías --}}
                <div>
                    <span class="text-gray-500 text-sm block mb-2">Categorías</span>
                    <div class="flex flex-wrap gap-1">
                        @forelse($producto->categorias as $cat)
                            <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full">
                                {{ $cat->nombre }}
                            </span>
                        @empty
                            <span class="text-gray-400 text-xs">Sin categoría</span>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Botón comprar --}}
            @if($producto->existencia > 0)
            <div class="px-5 pb-5">
                <a href="{{ route('ventas.create') }}?producto={{ $producto->id }}"
                   class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                    🛒 Comprar
                </a>
            </div>
            @endif

        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-400">
            No hay productos disponibles por el momento.
        </div>
        @endforelse
    </div>

@else

    {{-- Vista para administrador y gerente: tabla --}}
    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Productos</h2>
            @can('create', App\Models\Producto::class)
                <a href="{{ route('productos.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + Nuevo producto
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
                    <th class="p-3 text-left border-b">Precio</th>
                    <th class="p-3 text-left border-b">Existencia</th>
                    <th class="p-3 text-left border-b">Vendedor</th>
                    <th class="p-3 text-left border-b">Categorías</th>
                    <th class="p-3 text-left border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $producto->nombre }}</td>
                    <td class="p-3">${{ number_format($producto->precio, 2) }}</td>
                    <td class="p-3">{{ $producto->existencia }}</td>
                    <td class="p-3">{{ $producto->usuario->nombre }}</td>
                    <td class="p-3">
                        @foreach($producto->categorias as $cat)
                            <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full">
                                {{ $cat->nombre }}
                            </span>
                        @endforeach
                    </td>
                    <td class="p-3 flex gap-2">
                        @can('update', $producto)
                            <a href="{{ route('productos.edit', $producto) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                Editar
                            </a>
                        @endcan
                        @can('delete', $producto)
                            <form action="{{ route('productos.destroy', $producto) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
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

@endif
@endsection
