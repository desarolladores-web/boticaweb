<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TipoDocumento;
use App\Models\Cliente;
use App\Models\Rol;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirección después del registro.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
{
    $tiposDocumento = \App\Models\TipoDocumento::all();
    return view('auth.register', compact('tiposDocumento'));
}


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'tipo_documento_id' => ['required', 'integer', 'exists:tipo_documentos,id'],
            'DNI' => ['required', 'string', 'max:15'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clientes,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $cliente = Cliente::create([
            'nombre' => $data['name'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'DNI' => $data['DNI'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'email' => $data['email'],
        ]);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol_id' => 2,
            'cliente_id' => $cliente->id,
            'tipo_documento_id' => $data['tipo_documento_id'],
            'estado' => true,
            'fecha_ingreso' => now(),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect($this->redirectTo); 
    }
}
