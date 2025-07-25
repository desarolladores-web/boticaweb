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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;





class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request): View
{
    $query = Producto::query();

    // Filtro por nombre (buscador)
    if ($request->filled('buscar')) {
        $query->where('nombre', 'like', '%' . $request->buscar . '%');
    }

    // Filtro por categoría
    if ($request->filled('categoria_id')) {
        $query->where('categoria_id', $request->categoria_id);
    }

    $productos = $query->paginate(10)->appends($request->query());
    $categorias = Categoria::all();

    return view('producto.index', compact('productos', 'categorias'))
        ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
}

    public function buscar(Request $request): View
{
    $keyword = $request->input('keyword');

    $productos = Producto::query()
        ->when($keyword, function ($query, $keyword) {
            $query->where('nombre', 'like', "%{$keyword}%")
                  ->orWhere('descripcion', 'like', "%{$keyword}%");
        })
        ->paginate(12);

    return view('welcome', [
        'productos' => $productos,
        'i' => ($request->input('page', 1) - 1) * $productos->perPage()
        
    ]);
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
    // 1. Buscar o crear la categoría
    $categoria = null;
    if ($request->filled('categoria_nombre')) {
        $categoria = Categoria::firstOrCreate(
            ['nombre' => $request->input('categoria_nombre')],
            ['descripcion' => null]
        );
    }

    // 2. Buscar o crear el laboratorio
    $laboratorio = null;
    if ($request->filled('laboratorio_nombre')) {
        $laboratorio = Laboratorio::firstOrCreate(
            ['nombre_laboratorio' => $request->input('laboratorio_nombre')]
        );
    }

    // 3. Buscar o crear la presentación
    $presentacion = null;
    if ($request->filled('presentacion_tipo')) {
        $presentacion = Presentacion::firstOrCreate(
            ['tipo_presentacion' => $request->input('presentacion_tipo')]
        );
    }

    // 4. Leer imagen como binario (no se guarda en disco)
   $contenidoImagen = null;
if ($request->hasFile('imagen')) {
    $imagen = $request->file('imagen');

    if ($imagen->isValid()) {
        try {
            // Validar que el archivo sea una imagen
            $mimeType = $imagen->getMimeType();
            if (!str_starts_with($mimeType, 'image/')) {
                return back()->withErrors(['imagen' => 'El archivo debe ser una imagen válida.']);
            }

            // Leer imagen en binario
            $contenido = file_get_contents($imagen->getPathname());

            if ($contenido !== false) {
                $contenidoImagen = $contenido;
            } else {
                \Log::error('[ProductoController] No se pudo leer el contenido binario de la imagen.');
                return back()->withErrors(['imagen' => 'La imagen no se pudo leer.']);
            }
        } catch (\Exception $e) {
            \Log::error('[ProductoController] Excepción al procesar imagen: ' . $e->getMessage());
            return back()->withErrors(['imagen' => 'Error inesperado al subir la imagen.']);
        }
    } else {
        return back()->withErrors(['imagen' => 'La imagen subida no es válida.']);
    }
}

    // 5. Insertar producto con imagen binaria
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
        'imagen' => $contenidoImagen, // 👈 Aquí va como binario
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
    $datos = $request->validated();

    if ($request->hasFile('imagen')) {
        $archivo = $request->file('imagen');

        if ($archivo->isValid()) {
            $datos['imagen'] = file_get_contents($archivo); // sin usar getRealPath()
        } else {
            return back()->with('error', 'La imagen no es válida.');
        }
    } else {
        unset($datos['imagen']); // no actualizar si no se envió imagen
    }

    $producto->update($datos);

    return Redirect::route('productos.index')
        ->with('success', 'Producto actualizado correctamente.');
}


    public function vistaConFiltro(Request $request)
{
    $categoriaId = $request->input('categoria');
    $precioMin = $request->input('precio_min');
    $precioMax = $request->input('precio_max');

    $productos = Producto::query()
        ->when($categoriaId, function ($query) use ($categoriaId) {
            return $query->where('categoria_id', $categoriaId);
        })
        ->when($precioMin !== null && $precioMax !== null, function ($query) use ($precioMin, $precioMax) {
            return $query->whereBetween('pvp1', [$precioMin, $precioMax]);
        })
        ->get();

    $categorias = Categoria::all();

    return view('producto.filtro', compact('productos', 'categorias'));
}



    /**
     * detalles 
     */
    public function especificaciones($id): View
    {
        $producto = Producto::with(['categoria', 'laboratorio', 'presentacion'])->findOrFail($id);

        return view('producto.especificaciones', compact('producto'));
    }





}
