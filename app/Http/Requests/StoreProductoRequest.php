<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Producto::class);
    }

    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'precio'      => 'required|numeric|min:0.01',
            'existencia'  => 'required|integer|min:0',
            'fotos'       => 'nullable|array|max:5',
            'fotos.*'     => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'     => 'El nombre del producto es obligatorio.',
            'nombre.unique'       => 'Ya existe un producto con ese nombre.',
            'precio.required'     => 'El precio es obligatorio.',
            'precio.numeric'      => 'El precio debe ser un número.',
            'precio.min'          => 'El precio debe ser mayor a 0.',
            'existencia.required' => 'La existencia es obligatoria.',
            'existencia.integer'  => 'La existencia debe ser un número entero.',
            'existencia.min'      => 'La existencia no puede ser negativa.',
        ];
    }
}
