@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')
@section('title', 'Editar Producto')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-8 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Producto</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Descripción</label>
            <textarea name="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Precio</label>
            <input type="number" name="precio" step="0.01" min="0.01"
                   value="{{ old('precio', $producto->precio) }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Existencia</label>
            <input type="number" name="existencia" min="0"
                   value="{{ old('existencia', $producto->existencia) }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Categorías</label>
            <div class="border border-gray-300 rounded-lg p-3 max-h-40 overflow-y-auto">
                @foreach($categorias as $categoria)
                    <label class="flex items-center gap-2 mb-1">
                        <input type="checkbox" name="categorias[]"
                               value="{{ $categoria->id }}"
                               {{ $producto->categorias->contains($categoria->id) ? 'checked' : '' }}>
                        {{ $categoria->nombre }}
                    </label>
                @endforeach
            </div>
        </div>


        {{-- Fotos actuales --}}
        @if($producto->fotos && count($producto->fotos) > 0)
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Fotos actuales</label>
            <div class="flex gap-2 flex-wrap">
                @foreach($producto->fotos as $foto)
                    <img src="{{ Storage::url($foto) }}"
                         class="w-24 h-24 object-cover rounded-lg border">
                @endforeach
            </div>
        </div>
        @endif

        {{-- Nuevas fotos --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">
                Cambiar fotos (máximo 5)
            </label>
            <input type="file" name="fotos[]" multiple accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
            <p class="text-gray-400 text-xs mt-1">Si subes nuevas fotos, se reemplazarán las anteriores.</p>
        </div>



        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Actualizar
            </button>
            <a href="{{ route('productos.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
