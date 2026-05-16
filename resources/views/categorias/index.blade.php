@extends('layouts.app')
@section('title', 'Categorías')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Categorías</h2>
        @can('create', App\Models\Categoria::class)
            <a href="{{ route('categorias.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Nueva categoría
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
                <th class="p-3 text-left border-b">Descripción</th>
                <th class="p-3 text-left border-b">Productos</th>
                <th class="p-3 text-left border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $categoria->nombre }}</td>
                <td class="p-3">{{ $categoria->descripcion ?? '—' }}</td>
                <td class="p-3">{{ $categoria->productos_count }}</td>
                <td class="p-3">
                    @can('update', $categoria)
                        <a href="{{ route('categorias.edit', $categoria) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                            Editar
                        </a>
                    @endcan
                    @can('delete', $categoria)
                        <form action="{{ route('categorias.destroy', $categoria) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar esta categoría?')">
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
