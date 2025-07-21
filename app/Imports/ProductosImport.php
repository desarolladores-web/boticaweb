<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Laboratorio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buscar o crear el laboratorio por nombre
        $laboratorio = Laboratorio::firstOrCreate(
            ['nombre' => $row['laboratorio']],
            ['descripcion' => $row['laboratorio']]
        );

        return new Producto([
            'nombre' => $row['nombre'],
            'principio_activo' => $row['prin_a'],
            'pvp1' => $row['pvp1'],
            'precio_costo_unitario' => $row['precio_costo_unitario'],
            'stock' => $row['stock'],
            'stock_min' => $row['stock_min'],
            'fecha_vencimiento' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['f_vencimiento']),
            'laboratorio_id' => $laboratorio->id,
        ]);
    }
}
