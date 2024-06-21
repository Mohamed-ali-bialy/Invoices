<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invoice', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice');
Route::get('/productsManagement', [App\Http\Controllers\ProductController::class, 'management'])->name('productsManagemnet');


Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('manufacturers', App\Http\Controllers\ManufacturerController::class);
Route::resource('carts', App\Http\Controllers\CartController::class);
Route::resource('cartItems', App\Http\Controllers\CartItemController::class);

Route::post('/addToCart', [App\Http\Controllers\CartItemController::class, 'addToCart'])->name('addToCart');
Route::delete('/cart-items/{id}', [App\Http\Controllers\CartItemController::class, 'destroy'])->name('cart.delete');
Route::delete('/clearCart', [App\Http\Controllers\CartItemController::class, 'clearCart'])->name('cart.clear');


Route::get('produts/export/', [App\Http\Controllers\ProductController::class, 'export']);
Route::post('/import/products', [App\Http\Controllers\ProductController::class, 'import'])->name('import.products');
