<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\ItemsController::class, 'index']);
Route::get('/{id}', [App\Http\Controllers\ItemsController::class, 'edit']);
Route::post('/', [App\Http\Controllers\ItemsController::class, 'store']);
Route::put('/', [App\Http\Controllers\ItemsController::class, 'update']);
Route::delete('/', [App\Http\Controllers\ItemsController::class, 'destroy']);
