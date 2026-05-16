@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ Auth::user()->esCliente() ? 'Mis compras' : 'Ventas' }}
        </h2>
        @can('create', App\Models\Venta::class)
            <a href="{{ route('ventas.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Nueva venta
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
                <th class="p-3 text-left border-b">Producto</th>
                <th class="p-3 text-left border-b">Cliente</th>
                @if(!Auth::user()->esCliente())
                    <th class="p-3 text-left border-b">Vendedor</th>
                @endif
                <th class="p-3 text-left border-b">Fecha</th>
                <th class="p-3 text-left border-b">Total</th>
                <th class="p-3 text-left border-b">Estado</th>
                <th class="p-3 text-left border-b">Ticket</th>
                @if(!Auth::user()->esCliente())
                    <th class="p-3 text-left border-b">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $venta->producto->nombre }}</td>
                <td class="p-3">{{ $venta->cliente->nombre }}</td>
                @if(!Auth::user()->esCliente())
                    <td class="p-3">{{ $venta->vendedor->nombre }}</td>
                @endif
                <td class="p-3">{{ $venta->fecha }}</td>
                <td class="p-3">${{ number_format($venta->total, 2) }}</td>
                <td class="p-3">
                    @if($venta->validada)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">
                            ✅ Validada
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">
                            ⏳ Pendiente
                        </span>
                    @endif
                </td>
                <td class="p-3">
                    @if($venta->ticket)
                        <a href="{{ route('ventas.ticket', $venta) }}"
                           target="_blank"
                           class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm hover:bg-indigo-200">
                            🧾 Ver ticket
                        </a>
                    @else
                        <span class="text-gray-400 text-sm">Sin ticket</span>
                    @endif
                </td>
                @if(!Auth::user()->esCliente())
                    <td class="p-3 flex gap-2 flex-wrap">
                        {{-- Botón validar para gerente --}}
                        @if(Auth::user()->esGerente() && !$venta->validada)
                            <form action="{{ route('ventas.validar', $venta) }}"
                                  method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    Validar
                                </button>
                            </form>
                        @endif
                        {{-- Botón eliminar para administrador --}}
                        @can('delete', $venta)
                            <form action="{{ route('ventas.destroy', $venta) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar esta venta?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    Eliminar
                                </button>
                            </form>
                        @endcan
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
