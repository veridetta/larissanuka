<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [PublicController::class,'index'])->name('public.index');
Route::get('/product', [PublicController::class,'product'])->name('public.product');
Route::post('/product', [PublicController::class,'product'])->name('public.product');
Route::get('/product_detail/{id}', [PublicController::class,'product_detail'])->name('public.product_detail');
