<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoDocumento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;

class EmpleadoController extends Controller
{
    public function create()
    {
        $tiposDocumento = TipoDocumento::all();
        $clientes = Cliente::all();
        $roles = Rol::whereIn('id', [1, 3])->get(); // Solo roles ADMIN y EMPLEADO

        return view('empleados.create', compact('tiposDocumento', 'clientes', 'roles'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'tipo_documento_id' => 'nullable|exists:tipo_documentos,id',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'DNI' => 'required|string|max:20|unique:clientes,DNI',
        'direccion' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
    ]);

    // 1. Crear el cliente primero
    $cliente = Cliente::create([
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'DNI' => $request->DNI,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
    ]);

    // 2. Crear el usuario (empleado) usando el cliente_id generado
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol_id' => 3, // Rol empleado
        'estado' => true,
        'cliente_id' => $cliente->id,
        'tipo_documento_id' => $request->tipo_documento_id,
    ]);

    return redirect()->route('empleados.create')->with('success', 'Empleado creado correctamente.');
}
}
