<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'nullable|string|max:50',
            'nombre' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'principio_activo' => 'nullable|string|max:150',
            'pvp1' => 'nullable|numeric',
            'precio_costo_unitario' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'stock_min' => 'nullable|integer',
            'fecha_vencimiento' => 'nullable|date',

            'imagen' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,bmp,tiff,tif,svg,ico,heic,heif,avif|max:5120', // Máx 2MB  aun con fallas

            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'laboratorio_id' => 'nullable|integer|exists:laboratorios,id',
            'presentacion_id' => 'nullable|integer|exists:presentacions,id',
        ];
    }
}
