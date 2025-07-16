<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login (fallback).
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Redirecciona según el rol después del login.
     */
    protected function authenticated(Request $request, $user)
    {
        
        return redirect()->route('home'); // Cliente o empleado
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
