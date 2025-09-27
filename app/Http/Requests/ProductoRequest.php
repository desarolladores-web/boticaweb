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
            'pvp2' => 'nullable|numeric', // 👈 nuevo
            'precio_caja' => 'nullable|numeric', // 👈 nuevo
            'precio_blister' => 'nullable|numeric', // 👈 nuevo
            'precio_costo_unitario' => 'nullable|numeric',

            'lote' => 'nullable|string|max:100', // 👈 nuevo
            'stock' => 'nullable|integer',
            'stock_min' => 'nullable|integer',
            'fecha_vencimiento' => 'nullable|date',

            'imagen' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,bmp,tiff,tif,svg,ico,heic,heif,avif|max:5120',
            // Nota: pusiste "Máx 2MB" en el comentario pero acá está en 5120 KB = 5 MB

            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'laboratorio_id' => 'nullable|integer|exists:laboratorios,id',
            'presentacion_id' => 'nullable|integer|exists:presentacions,id',
        ];
    }
}
