<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('dashboard');
});
*/
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/users', 'user_index')->middleware('can:users');
    Route::view('/stock', 'stock_index')->middleware('can:stock');
    Route::view('/accounting', 'accounting_index')->middleware('can:accounting');
    Route::view('/online_store', 'store_index')->middleware('can:online_store');

    Route::controller(UserController::class)->group(function () {
        Route::post('users/getUsers', 'getUsers');    
    });
});

require __DIR__.'/auth.php';
