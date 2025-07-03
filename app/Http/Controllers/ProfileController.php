<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;

class ProfileController extends Controller
{
    // Mostrar el formulario de edición del perfil
    public function edit()
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente) {
            return redirect()->back()->with('error', 'No se encontró el cliente relacionado al usuario.');
        }

        return view('account.edit', compact('cliente'));
    }

    // Actualizar perfil del cliente
    public function update(Request $request)
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente) {
            return redirect()->back()->with('error', 'No se encontró el cliente relacionado.');
        }

        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:clientes,email,' . $cliente->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar datos
        $cliente->nombre = $request->input('nombre');
        $cliente->email = $request->input('email');

        // Procesar imagen si se envió y es válida
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');

            if ($imagen->isValid()) {
                try {
                    $contenido = file_get_contents($imagen->getPathname());

                    if ($contenido !== false) {
                        $cliente->imagen = $contenido;
                    } else {
                        Log::error('[ProfileController] No se pudo leer el contenido binario de la imagen.');
                        return redirect()->back()->with('error', 'La imagen no se pudo leer.');
                    }
                } catch (\Exception $e) {
                    Log::error('[ProfileController] Excepción al procesar imagen: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Error inesperado al subir la imagen.');
                }
            } else {
                return redirect()->back()->with('error', 'La imagen subida no es válida.');
            }
        }

        $cliente->save();

        return redirect()->route('account.edit')->with('success', 'Perfil actualizado correctamente.');
    }

    // Eliminar imagen del cliente
    public function eliminarImagen(Cliente $cliente)
    {
        // Verificar si el cliente tiene una imagen
        if ($cliente->imagen) {
            // Eliminar la imagen del sistema de archivos
            $cliente->imagen = null;
$cliente->save();

            // Eliminar la imagen en la base de datos
           

            return response()->json(['success' => 'Imagen eliminada correctamente.']);
        }

        return response()->json(['error' => 'No se encontró una imagen para eliminar.'], 404);
    }

}
