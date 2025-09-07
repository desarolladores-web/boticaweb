<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoImportController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CheckoutController;

use App\Models\Venta;






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




Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/contactanos', function () {
    return view('contactanos.contactanos');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('productos', ProductoController::class);
Route::get('/buscar-productos', [ProductoController::class, 'buscar'])->name('productos.buscar');

Route::get('/productos/especificaciones/{id}', [ProductoController::class, 'especificaciones'])->name('productos.especificaciones');


// Filtro de productos (sin cambios)
Route::get('/producto-filtro', [ProductoController::class, 'vistaConFiltro'])->name('productos.filtro');



Route::post('/agregar-carrito/{id}', [CartController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CartController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/eliminar/{id}', [CartController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar/{id}', [CartController::class, 'actualizar'])->name('carrito.actualizar');



Route::get('/ver-carrito', [CartController::class, 'verCarrito'])->name('carrito.ver');

// Perfil del usuario (restringido a usuarios autenticados)
// RUTAS PARA CUALQUIER USUARIO AUTENTICADO (admin o no admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/account/edit', [ProfileController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account/image/{user}', [ProfileController::class, 'eliminarImagen'])->name('account.image.delete');
    // Ruta para editar la contraseña
    Route::get('/account/password/edit', [ProfileController::class, 'editPassword'])->name('account.password.edit');

    // Ruta para actualizar la contraseña
    Route::put('/account/password/update', [ProfileController::class, 'updatePassword'])->name('account.password.update');
// Página de cuenta (perfil, contraseña, pedidos, etc.)
Route::get('/account/{section?}', [ProfileController::class, 'edit'])
    ->name('account')
    ->middleware('auth');


});

// RUTAS EXCLUSIVAS PARA ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/account/edit', [ProfileController::class, 'edit'])->name('admin.account.edit');
    Route::get('/empleados/create', [App\Http\Controllers\EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [App\Http\Controllers\EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{id}/edit', [App\Http\Controllers\EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'update'])->name('empleados.update');


    Route::resource('productos', ProductoController::class);
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/clientes', [UserController::class, 'clientes'])->name('usuarios.clientes');
    Route::resource('productos', ProductoController::class);

    Route::get('/admin/productos-agotados', [AdminController::class, 'productosAgotados'])
        ->name('admin.productos.agotados');

    Route::put('/admin/productos/update-stock', [AdminController::class, 'updateStock'])
    ->name('admin.productos.updateStock');



    Route::get('/admin/ventas/pendientes', [VentaController::class, 'pendientes'])->name('admin.ventas.pendientes');
    Route::get('/admin/ventas/entregadas', [VentaController::class, 'ventasEntregadas'])->name('admin.ventas.entregadas');
    Route::put('/admin/ventas/{id}/entregar', [VentaController::class, 'marcarComoEntregada'])->name('admin.ventas.marcarEntregada');
    Route::get('/ventas-pendientes-count', function () {
        $count = Venta::whereHas('estadoVenta', function ($q) {
            $q->where('estado', 'venta pendiente'); // usando la columna real
        })->count();

        return response()->json(['count' => $count]);
    });
});

//INFORMACION 
Route::get('/quienes-somos', [InformacionController::class, 'quienesSomos'])->name('quienes.somos');
Route::get('/consejos', [InformacionController::class, 'consejos'])->name('consejos');

Route::post('productos/importar', [ProductoImportController::class, 'importarExcel'])->name('productos.importar');





// Mostrar formulario de checkout (GET)
Route::get('/checkout', [CheckoutController::class, 'mostrarCheckout'])->name('checkout.formulario');

// Guardar datos del cliente 
Route::post('/checkout/guardar-datos', [CheckoutController::class, 'guardarDatosYRedirigir'])->name('checkout.guardar-datos');



Route::get('/pago/exito', function () {
    return 'Pago exitoso';
})->name('pago.exito');

Route::get('/pago/fallo', function () {
    return 'Pago fallido';
})->name('pago.fallo');

Route::get('/pago/pendiente', function () {
    return 'Pago pendiente';
})->name('pago.pendiente');









Route::get('/carrito/sidebar/dinamico', function () {
    return view('components.cart-items');
})->name('carrito.sidebar.dinamico');
Route::get('/carrito/sidebar/ajax', [CartController::class, 'obtenerSidebarAjax'])->name('carrito.sidebar.ajax');
