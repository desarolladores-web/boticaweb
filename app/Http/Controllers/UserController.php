<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
   
    $users = User::with(['tipoDocumento', 'rol', 'cliente'])
             ->whereIn('rol_id', [1, 3]) // 1 = admin, 3 = empleado
             ->get();
// eager load relaciones
    return view('users.index', compact('users'));
}
public function clientes()
{
    $users = User::with(['tipoDocumento', 'rol', 'cliente'])
                 ->where('rol_id', 2)
                 ->get();
    return view('users.clientes', compact('users'));
}
}
