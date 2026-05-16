<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Producto::class);
        $productos = Producto::with('usuario', 'categorias')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $fotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('productos', 'public');
                $fotos[] = $path;
            }
        }

        $producto = Producto::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'existencia'  => $request->existencia,
            'usuario_id'  => Auth::user()->id,
            'fotos'       => $fotos,
        ]);

        if ($request->has('categorias')) {
            $producto->categorias()->sync($request->categorias);
        }

        Log::channel('productos')->info('Producto creado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::user()->id,
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $fotos = $producto->fotos ?? [];

        if ($request->hasFile('fotos')) {
            // Elimina fotos anteriores del disco público
            foreach ($fotos as $fotoVieja) {
                Storage::disk('public')->delete($fotoVieja);
            }
            $fotos = [];
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('productos', 'public');
                $fotos[] = $path;
            }
        }

        $producto->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'existencia'  => $request->existencia,
            'fotos'       => $fotos,
        ]);

        if ($request->has('categorias')) {
            $producto->categorias()->sync($request->categorias);
        } else {
            $producto->categorias()->detach();
        }

        Log::channel('productos')->info('Producto editado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::user()->id,
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        Log::channel('productos')->warning('Producto eliminado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::user()->id,
        ]);

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado.');
    }
}
