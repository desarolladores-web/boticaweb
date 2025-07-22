<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Laboratorio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Evitar insertar si campos clave vienen vacíos
        if (
            empty($row['Nombre']) || 
            empty($row['PVP1']) || 
            empty($row['Precio Costo Unitario']) || 
            empty($row['Stock'])
        ) {
            return null;
        }

        // Crear laboratorio si no existe
        $laboratorio = Laboratorio::firstOrCreate(
            ['nombre' => $row['Laboratorio']],
            ['descripcion' => $row['Laboratorio']]
        );

        return new Producto([
            'codigo' => $row['Codigo'] ?? null,
            'nombre' => $row['Nombre'] ?? null,
            'principio_activo' => $row['Prin A.'] ?? null,
            'pvp1' => $row['PVP1'] ?? null,
            'precio_costo_unitario' => $row['Precio Costo Unitario'] ?? null,
            'stock' => $row['Stock'] ?? null,
            'stock_min' => $row['Stock min'] ?? null,
            'fecha_vencimiento' => isset($row['F. Vencimiento']) 
                ? Date::excelToDateTimeObject($row['F. Vencimiento']) 
                : null,
            'laboratorio_id' => $laboratorio->id,
        ]);
    }
}
