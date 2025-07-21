<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Laboratorio;
use App\Models\Presentacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductosImport;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $productos = Producto::paginate();

        return view('producto.index', compact('productos'))
            ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $producto = new Producto();
        $categorias = Categoria::all();
        $laboratorios = Laboratorio::all();
        $presentaciones = Presentacion::all();

        return view('producto.create', compact('producto', 'categorias', 'laboratorios', 'presentaciones'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request): RedirectResponse
    {



        // Buscar o crear la categoría
        $categoria = null;
        if ($request->filled('categoria_nombre')) {
            $categoria = Categoria::firstOrCreate(
                ['nombre' => $request->input('categoria_nombre')],
                ['descripcion' => null] // Puedes cambiar esto si necesitas
            );
        }

        // Buscar o crear el laboratorio
        $laboratorio = null;
        if ($request->filled('laboratorio_nombre')) {
            $laboratorio = Laboratorio::firstOrCreate(
                ['nombre_laboratorio' => $request->input('laboratorio_nombre')]
            );
        }

        // Buscar o crear la presentación
        $presentacion = null;
        if ($request->filled('presentacion_tipo')) {
            $presentacion = Presentacion::firstOrCreate(
                ['tipo_presentacion' => $request->input('presentacion_tipo')]
            );
        }

        // Subir imagen (si se adjunta)
        $rutaImagen = null;

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $archivo = $request->file('imagen');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('storage/imagenes_productos'), $nombreArchivo);
            $rutaImagen = 'imagenes_productos/' . $nombreArchivo;
        }



        // Crear el producto
        $producto = Producto::create([
            'codigo' => $request->input('codigo'),
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'principio_activo' => $request->input('principio_activo'),
            'pvp1' => $request->input('pvp1'),
            'precio_costo_unitario' => $request->input('precio_costo_unitario'),
            'stock' => $request->input('stock'),
            'stock_min' => $request->input('stock_min'),
            'fecha_vencimiento' => $request->input('fecha_vencimiento'),
            'imagen' => $rutaImagen, // Aquí usamos la ruta si se subió imagen
            'categoria_id' => $categoria?->id,
            'laboratorio_id' => $laboratorio?->id,
            'presentacion_id' => $presentacion?->id,
        ]);

        return Redirect::route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        $laboratorios = Laboratorio::all();
        $presentaciones = Presentacion::all();

        return view('producto.edit', compact('producto', 'categorias', 'laboratorios', 'presentaciones'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update($request->validated());

        return Redirect::route('productos.index')
            ->with('success', 'Producto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Producto::find($id)->delete();

        return Redirect::route('productos.index')
            ->with('success', 'Producto deleted successfully');
    }



    /**
     * detalles 
     */
    public function especificaciones($id): View
    {
        $producto = Producto::with(['categoria', 'laboratorio', 'presentacion'])->findOrFail($id);

        return view('producto.especificaciones', compact('producto'));
    }
    public function importarExcel(Request $request)
    {
       $request->validate([
        'archivo_excel' => 'required|file|mimes:xls,xlsx'
        ]);

      // Verifica si el archivo está presente
        if (!$request->hasFile('archivo_excel')) {
        return back()->withErrors(['archivo_excel' => 'Debe seleccionar un archivo.']);
        }

       Excel::import(new ProductosImport, $request->file('archivo_excel'));

    return redirect()->route('productos.index')->with('success', 'Productos importados correctamente.');
    }
}
