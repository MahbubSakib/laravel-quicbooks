<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin/product/', 'middleware' => ['auth']], function(){
    Route::get('list', [App\Http\Controllers\ProductController::class, 'index'])->name('productList');
    Route::get('all', [App\Http\Controllers\ProductController::class, 'show']);
    // Route::post('store', [App\Http\Controllers\ProductController::class, 'store']);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/oauth/connect', [App\Http\Controllers\OAuthController::class, 'redirect']);
Route::get('/oauth/callback', [App\Http\Controllers\OAuthController::class, 'callback']);
Route::get('/oauth/refresh', [App\Http\Controllers\OAuthController::class, 'refresh']);


Route::get('/oauth/invoice', [App\Http\Controllers\InvoiseController::class, 'makeAPICall']);
Route::get('/oauth/invoice/create', [App\Http\Controllers\InvoiseController::class, 'create']);
Route::post('/oauth/invoice/store', [App\Http\Controllers\InvoiseController::class, 'store'])->name('store');
// Route::get('/oauth/invoice/delete', [App\Http\Controllers\InvoiseController::class, 'destroy']);
Route::get('/oauth/invoice/index', [App\Http\Controllers\InvoiseController::class, 'index'])->name('index');
Route::get('/oauth/edit/{id}', [App\Http\Controllers\InvoiseController::class, 'edit'])->name('invoice');
Route::post('/oauth/update/{id}', [App\Http\Controllers\InvoiseController::class, 'update'])->name('update');
Route::get('/oauth/delete/{id}', [App\Http\Controllers\InvoiseController::class, 'destroy'])->name('delete');


