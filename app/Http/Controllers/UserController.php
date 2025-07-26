<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    $users = User::with(['tipoDocumento', 'rol', 'cliente'])->get(); // eager load relaciones
    return view('users.index', compact('users'));
}
}
