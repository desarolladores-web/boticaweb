<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Laboratorio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validar que campos requeridos existan
        if (!isset($row['codigo']) || !isset($row['nombre']) || !isset($row['categoria']) || !isset($row['laboratorio'])) {
            return null; // O lanzar una excepción si lo prefieres
        }

        $categoria = Categoria::firstOrCreate(['nombre' => $row['categoria']]);
        $laboratorio = Laboratorio::firstOrCreate(['nombre' => $row['laboratorio']]);

        return new Producto([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'] ?? null,
            'principio_activo' => $row['prin_a'] ?? null,
            'pvp1' => $row['pvp1'] ?? 0,
            'precio_costo_unitario' => $row['precio_costo_unitario'] ?? 0,
            'stock' => $row['stock'] ?? 0,
            'stock_min' => $row['stock_min'] ?? 0,
            'fecha_vencimiento' => isset($row['f_vencimiento']) ? 
                Date::excelToDateTimeObject($row['f_vencimiento'])->format('Y-m-d') : null,
            'categoria_id' => $categoria->id,
            'laboratorio_id' => $laboratorio->id,
            'presentacion_id' => null,
        ]);
    }
}
