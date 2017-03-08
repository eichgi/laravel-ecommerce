<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'MainController@home');

Route::get('/carrito', 'ShoppingCartsController@index');

Route::get('/payments/store', 'PaymentsController@store');

Auth::routes();

Route::resource('products', 'ProductsController');

Route::resource('in_shopping_carts', 'InShoppingCartsController', [
    'only' => ['store', 'destroy']
]);

Route::resource('compras', 'ShoppingCartsController', [
    'only' => ['show']
]);

Route::resource('orders', 'OrdersController', [
    'show' => ['index', 'update']
]);

/**
 * Redirecciones generadas automaticamente el utilizar el método resource:
 *
 * GET /products => index
 * POST /products => store
 * GET /products/create => Formulario para crear
 *
 * GET /products/:id => Mostrar un producto con ID
 * GET /products/:id/edit => Mostrar datos que se van a editar
 * PUT/PATCH /products/:id => Recibe datos para actualizar dicho registro
 * DELETE /products/:id => Elimina el registro con el id especificado
 *
 */

Route::get('/home', 'HomeController@index');
