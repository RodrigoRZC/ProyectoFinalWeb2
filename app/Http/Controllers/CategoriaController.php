<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Categoria::class);
        $categorias = Categoria::withCount('productos')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $this->authorize('create', Categoria::class);
        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create($request->validated());
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);
        $categoria->delete();
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada.');
    }
}
