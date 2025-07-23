<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ProductoImportController extends Controller
{
    public function importarExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls',
        ]);

        $archivo = $request->file('archivo');
        $spreadsheet = IOFactory::load($archivo->getPathname());
        $hoja = $spreadsheet->getActiveSheet();
        $filas = $hoja->toArray();

        // Saltar la cabecera
    foreach (array_slice($filas, 1) as $fila) {
    if (!is_numeric($fila[5]) || !is_numeric($fila[7])) {
        continue;
    }

    $categoria = Categoria::firstOrCreate(['nombre' => $fila[1]]);
    $laboratorio = Laboratorio::firstOrCreate(['nombre_laboratorio' => $fila[2]]);
$fecha = null; // valor por defecto

if (!empty($fila[12])) {
    try {
        // Si es un número (tipo Excel)
        if (is_numeric($fila[12])) {
            $carbonDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fila[12]);

            // Asegúrate de que el año no sea inválido
            if ($carbonDate->format('Y') >= 1900) {
                $fecha = $carbonDate->format('Y-m-d');
            }
        } else {
            // Si ya viene como string tipo fecha (ej: "2025-08-20")
            $carbonDate = \Carbon\Carbon::parse($fila[12]);

            if ($carbonDate->format('Y') >= 1900) {
                $fecha = $carbonDate->format('Y-m-d');
            }
        }
    } catch (\Exception $e) {
        // Si hay error al convertir, deja la fecha como null
        $fecha = null;
    }
}

    Producto::create([
        'codigo' => $fila[0],
        'categoria_id' => $categoria->id,
        'laboratorio_id' => $laboratorio->id,
        'nombre' => $fila[3],
        'pvp1' => floatval($fila[5]),
        'precio_costo_unitario' => floatval($fila[7]),
        'stock' => intval($fila[9]),
        'stock_min' => intval($fila[10]),
        'fecha_vencimiento' => $fecha,
        'principio_activo' => $fila[13],
    ]);
        }

        return redirect()->back()->with('success', 'Productos importados correctamente');
    }
}
