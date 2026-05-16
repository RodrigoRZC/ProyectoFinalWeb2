<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $categoria = $this->route('categoria');
        return $this->user()->can('update', $categoria);
    }

    public function rules(): array
    {
        $categoriaId = $this->route('categoria')->id;

        return [
            'nombre'      => 'required|string|max:255|unique:categorias,nombre,' . $categoriaId,
            'descripcion' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
        ];
    }
}
