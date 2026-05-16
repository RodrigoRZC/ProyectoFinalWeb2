@extends('layouts.app')
@section('title', 'Nueva Venta')
@section('content')
<div class="bg-white shadow-sm sm:rounded-lg p-8 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Comprar Producto</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.store') }}" id="form-compra" enctype="multipart/form-data">
        @csrf

        {{-- Producto --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Producto</label>
            <select name="producto_id" id="producto_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Selecciona un producto --</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}"
                            data-precio="{{ $producto->precio }}"
                            {{ old('producto_id', request('producto')) == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }} — ${{ number_format($producto->precio, 2) }}
                        ({{ $producto->existencia }} disponibles)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Cantidad --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad"
                   value="{{ old('cantidad', 1) }}" min="1" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>

        {{-- Fecha --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Fecha</label>
            <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
        </div>

        {{-- Total calculado automáticamente --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Total a pagar</label>
            <div class="w-full border border-indigo-300 bg-indigo-50 rounded-lg px-3 py-2 text-indigo-700 font-bold text-xl">
                $<span id="total-display">0.00</span>
            </div>
            <input type="hidden" name="total" id="total" value="0">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">
                Comprobante de pago (opcional)
            </label>
            <input type="file" name="ticket" accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
            <p class="text-gray-400 text-xs mt-1">Sube una imagen de tu comprobante. Se guardará de forma privada.</p>
        </div>


        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Confirmar compra
            </button>
            <a href="{{ route('productos.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectProducto = document.getElementById('producto_id');
    const inputCantidad  = document.getElementById('cantidad');
    const totalDisplay   = document.getElementById('total-display');
    const totalInput     = document.getElementById('total');
    const form           = document.getElementById('form-compra');

    function calcularTotal() {
        const option   = selectProducto.options[selectProducto.selectedIndex];
        const precio   = parseFloat(option.dataset.precio) || 0;
        const cantidad = parseInt(inputCantidad.value) || 0;
        const total    = precio * cantidad;
        totalDisplay.textContent = total.toFixed(2);
        totalInput.value         = total.toFixed(2);
    }

    selectProducto.addEventListener('change', calcularTotal);
    inputCantidad.addEventListener('input', calcularTotal);
    calcularTotal();

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!selectProducto.value) {
            alert('Por favor selecciona un producto.');
            return;
        }

        const nombreProducto = selectProducto.options[selectProducto.selectedIndex].text;
        const cantidad       = inputCantidad.value;
        const total          = totalDisplay.textContent;

        const confirmar = confirm(
            '¿Confirmar compra?\n\n' +
            'Producto: ' + nombreProducto + '\n' +
            'Cantidad: ' + cantidad + '\n' +
            'Total: $' + total
        );

        if (confirmar) {
            form.submit();
        }
    });
});
</script>
@endsection
