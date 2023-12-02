<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\UserController;
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
Route::post('/tambah_keranjang', [PublicController::class,'tambah_keranjang'])->name('public.tambah_keranjang');
Route::post('/tambah_favorit', [PublicController::class,'tambah_favorit'])->name('public.tambah_favorit');
Route::post('/single_checkout', [PublicController::class,'single_checkout'])->name('public.single_checkout');

Route::get('/login', [AuthController::class,'login'])->name('auth.login');
Route::post('/login', [AuthController::class,'login'])->name('auth.login');
Route::get('/register', [AuthController::class,'register'])->name('auth.register');
Route::post('/register', [AuthController::class,'register_post'])->name('auth.register');
Route::get('/logout', [AuthController::class,'logout'])->name('auth.logout');

Route::get('/user', [UserController::class,'index'])->name('user.index');

//api provinsi
Route::get('/api/provinsi',[RajaOngkirController::class,'provinsi'])->name('api.provinsi');
Route::get('/api/kota/{id}',[RajaOngkirController::class,'kota'])->name('api.kota');
Route::get('/api/ongkir/{produk_id}/{jenis}/{kurir}',[RajaOngkirController::class,'ongkir'])->name('api.ongkir');
