<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User; 
use App\Models\Venta;// Cambiado de Cliente a User

class ProfileController extends Controller
{
    // Mostrar el formulario de edición del perfil
public function edit($section = 'profile')
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->back()->with('error', 'No se encontró el usuario autenticado.');
    }

    $pedidos = collect();

    if ($section === 'pedidos') {
        $cliente = $user->cliente;

        // DEBUG: Mostrar cliente
        // dd($cliente);

        if ($cliente) {
            $pedidos = Venta::with('detalleVentas.producto', 'estadoVenta')
                ->where('cliente_id', $cliente->id)
                ->orderByDesc('fecha')
                ->get();

            // DEBUG: Mostrar pedidos
            // dd($pedidos);
        }
    }

    return view('account.edit', compact('user', 'section', 'pedidos'));
}





    // Actualizar perfil del usuario
    public function update(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verificar si el usuario está autenticado
        if (!$user) {
            return redirect()->back()->with('error', 'No se encontró el usuario autenticado.');
        }

        // Validar datos
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'imagen' => 'nullable|file|mimetypes:image/*|max:20480',

        ]);

        // Actualizar datos
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Procesar imagen si se envió y es válida
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');

            if ($imagen->isValid()) {
                try {
                    // Leer la imagen y almacenarla
                    $contenido = file_get_contents($imagen->getPathname());

                    if ($contenido !== false) {
                        $user->imagen = $contenido;
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

        // Guardar los cambios del usuario
        $user->save();

        // Redirigir con éxito al perfil
        return redirect()->route('account.edit', ['section' => 'profile'])->with('success', 'Perfil actualizado correctamente.');
    }

    // Eliminar imagen del usuario
    public function eliminarImagen(User $user) // Cambiado de Cliente a User
    {
        // Verificar si el usuario tiene una imagen
        if ($user->imagen) {
            // Eliminar la imagen del usuario
            $user->imagen = null;
            $user->save();

            return response()->json(['success' => 'Imagen eliminada correctamente.']);
        }

        // Si no tiene imagen, devolver error
        return response()->json(['error' => 'No se encontró una imagen para eliminar.'], 404);
    }

    // Mostrar el formulario de edición de la contraseña
    public function editPassword()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        
        // Establecer que la sección es 'password'
        $section = 'password';  

        // Pasar 'user' y 'section' a la vista
        return view('account.edit', compact('user', 'section'));
    }

    // Método para actualizar la contraseña
    public function updatePassword(Request $request)
    {
        // Validar la entrada del formulario de contraseña
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user(); // Obtener el usuario autenticado

        // Verificar la contraseña actual
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        // Actualizar la contraseña
        $user->password = \Hash::make($request->new_password);
        $user->save();

        // Redirigir con la sección de perfil y los datos del usuario
        return redirect()->route('account.edit', ['section' => 'profile'])->with('success', 'Contraseña actualizada correctamente');
    }
}
