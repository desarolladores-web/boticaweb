<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;


/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/contactanos', function () {
    return view('contactanos.contactanos');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('productos', ProductoController::class);

Route::get('/productos/especificaciones/{id}', [ProductoController::class, 'especificaciones'])->name('productos.especificaciones');

Route::post('/agregar-carrito/{id}', [CartController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CartController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/eliminar/{id}', [CartController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar/{id}', [CartController::class, 'actualizar'])->name('carrito.actualizar');

Route::resource('ventas', VentaController::class);

Route::get('/ver-carrito', [CartController::class, 'verCarrito'])->name('carrito.ver');

// Perfil del usuario (restringido a usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
   });
   
    Route::get('/account/edit', [ProfileController::class, 'edit'])->name('account.edit'); // Cambié 'cliente' por 'user'
    Route::put('/account/update', [ProfileController::class, 'update'])->name('account.update'); // Cambié 'cliente' por 'user'
    Route::delete('/account/image/{user}', [ProfileController::class, 'eliminarImagen'])->name('account.image.delete');

    
    // Ruta para editar la contraseña
    Route::get('/account/password/edit', [ProfileController::class, 'editPassword'])->name('account.password.edit');

    // Ruta para actualizar la contraseña
    Route::put('/account/password/update', [ProfileController::class, 'updatePassword'])->name('account.password.update');
    

});
