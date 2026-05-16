<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'producto_id' => 'required|integer|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
            'fecha'       => 'required|date',
            'total'       => 'required|numeric|min:0.01',
            'ticket'      => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.required' => 'Debes seleccionar un producto.',
            'producto_id.exists'   => 'El producto seleccionado no existe.',
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.date'           => 'La fecha no tiene un formato válido.',
            'total.required'       => 'El total es obligatorio.',
            'total.numeric'        => 'El total debe ser un número.',
            'total.min'            => 'El total debe ser mayor a 0.',
        ];
    }
}
