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
    $filasSinCabecera = array_slice($filas, 1);

    // Dividir en bloques de 200 filas
    $bloques = array_chunk($filasSinCabecera, 200);

    foreach ($bloques as $bloque) {
        foreach ($bloque as $fila) {
            if (!is_numeric($fila[5]) || !is_numeric($fila[7])) {
                continue;
            }

            $categoria = Categoria::firstOrCreate(['nombre' => $fila[1]]);
            $laboratorio = Laboratorio::firstOrCreate(['nombre_laboratorio' => $fila[2]]);

            $fecha = null;
            if (!empty($fila[12])) {
                try {
                    if (is_numeric($fila[12])) {
                        $carbonDate = Date::excelToDateTimeObject($fila[12]);
                        if ($carbonDate->format('Y') >= 1900) {
                            $fecha = $carbonDate->format('Y-m-d');
                        }
                    } else {
                        $carbonDate = Carbon::parse($fila[12]);
                        if ($carbonDate->format('Y') >= 1900) {
                            $fecha = $carbonDate->format('Y-m-d');
                        }
                    }
                } catch (\Exception $e) {
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
    }

    return redirect()->back()->with('success', 'Productos importados correctamente en bloques de 200 registros.');
}

}
