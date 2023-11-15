<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/phpinfo', function () {
    return phpinfo();
});
Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);
Route::post('products/{id}/like', [\App\Http\Controllers\ProductController::class, 'like']);
