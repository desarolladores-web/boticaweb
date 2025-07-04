<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;

class ProfileController extends Controller
{
    // Mostrar el formulario de edición del perfil
    public function edit($section = 'profile')
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente) {
            return redirect()->back()->with('error', 'No se encontró el cliente relacionado al usuario.');
        }

        // Pasar la variable 'section' y 'cliente' a la vista para mostrar el formulario adecuado (perfil o contraseña)
        return view('account.edit', compact('cliente', 'section'));
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
                    // Leer la imagen y almacenarla
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

        // Guardar los cambios del cliente
        $cliente->save();

        // Redirigir con éxito al perfil
        return redirect()->route('account.edit', ['section' => 'profile'])->with('success', 'Perfil actualizado correctamente.');
    }

    // Eliminar imagen del cliente
    public function eliminarImagen(Cliente $cliente)
    {
        // Verificar si el cliente tiene una imagen
        if ($cliente->imagen) {
            // Eliminar la imagen del cliente
            $cliente->imagen = null;
            $cliente->save();

            return response()->json(['success' => 'Imagen eliminada correctamente.']);
        }

        // Si no tiene imagen, devolver error
        return response()->json(['error' => 'No se encontró una imagen para eliminar.'], 404);
    }

    // Mostrar el formulario de edición de la contraseña
    public function editPassword()
    {
        $cliente = auth()->user()->cliente; // Obtener el cliente autenticado
        
        // Establecer que la sección es 'password'
        $section = 'password';  

        // Pasar 'cliente' y 'section' a la vista
        return view('account.edit', compact('cliente', 'section'));
    }

    // Método para actualizar la contraseña
    public function updatePassword(Request $request)
    {
        // Validar la entrada del formulario de contraseña
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        // Verificar la contraseña actual
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        // Actualizar la contraseña
        $user->password = \Hash::make($request->new_password);
        $user->save();

        // Redirigir con la sección de perfil y los datos del cliente
        return redirect()->route('account.edit', ['section' => 'profile'])->with('success', 'Contraseña actualizada correctamente');
    }
}
