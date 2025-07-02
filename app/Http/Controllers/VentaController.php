<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VentaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ventas = Venta::paginate();

        return view('venta.index', compact('ventas'))
            ->with('i', ($request->input('page', 1) - 1) * $ventas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $venta = new Venta();

        return view('venta.create', compact('venta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VentaRequest $request): RedirectResponse
    {
        // Crear cliente si no existe
    $cliente = Cliente::create([
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'email' => $request->email,
        'DNI' => $request->dni,
    ]);

    // Crear venta
    $venta = Venta::create([
        'cliente_id' => $cliente->id,
        'fecha' => $request->fecha,
        'tipo_comprobante' => $request->tipo_comprobante,
        'igv' => $request->igv,
        'subtotal' => $request->subtotal,
        'total' => $request->total,
        'metodo_pago_id' => $request->metodo_pago_id,
        'estado_venta_id' => $request->estado_venta_id,
    ]);

    // Agregar detalle_venta
    foreach (session('carrito', []) as $item) {
        DetalleVenta::create([
            'venta_id' => $venta->id,
            'producto_id' => $item['id'],
            'cantidad' => $item['cantidad'],
            'precio_venta' => $item['precio'],  
            'descuento' => 0,
            'id_sucursal' => 1, // ajustar si es necesario
            'id_usuario' => null // dejar nulo si no hay sesión
        ]);
    }

        Venta::create($request->validated());

        session()->forget('carrito');
        return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $venta = Venta::find($id);

        return view('venta.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $venta = Venta::find($id);

        return view('venta.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VentaRequest $request, Venta $venta): RedirectResponse
    {
        $venta->update($request->validated());

        return Redirect::route('ventas.index')
            ->with('success', 'Venta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Venta::find($id)->delete();

        return Redirect::route('ventas.index')
            ->with('success', 'Venta deleted successfully');
    }
}
