<?php
use App\Categoria;
use App\Producto;
use App\Images;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//para hacer pruebas
Route::get('/pruebas', function () {

    $producto = App\Producto::with('imagenes','categoria')->orderBy('id','DESC')->get();
    return $producto;


});


//mostrar resultados
Route::get('/resultados', function () {
    $imagen=App\Imagen::orderBy('id','DESC')->get();
    return $imagen;
});


Route::get('/', function () {
    return view('tienda.index');
});






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
    return view('plantilla.admin');
})->name('admin');

Route::resource('admin/categoria','Admin\AdminCategoriaController')->names('admin.categoria_c');
Route::resource('admin/producto','Admin\AdminProductoController')->names('admin.producto_c');

Route::get('cancelar/{ruta}', function($ruta){
    return redirect()->route($ruta)->with('cancelar','¡Cancelado correntamente!');
})->name('cancelar');
