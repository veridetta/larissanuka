<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MidtransController;
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
Route::post('/product', [PublicController::class,'product_cari'])->name('public.product');
Route::get('/product_detail/{id}', [PublicController::class,'product_detail'])->name('public.product_detail');
Route::post('/tambah_keranjang', [PublicController::class,'tambah_keranjang'])->name('public.tambah_keranjang');
Route::post('/tambah_favorit', [PublicController::class,'tambah_favorit'])->name('public.tambah_favorit');
Route::post('/single_checkout', [PublicController::class,'single_checkout'])->name('public.single_checkout');
Route::get('/checkout', [PublicController::class,'checkout'])->name('public.checkout');

Route::get('/login', [AuthController::class,'login'])->name('auth.login');
Route::post('/login', [AuthController::class,'login'])->name('auth.login');
Route::get('/register', [AuthController::class,'register'])->name('auth.register');
Route::post('/register', [AuthController::class,'register_post'])->name('auth.register');
Route::get('/logout', [AuthController::class,'logout'])->name('auth.logout');

Route::get('/user', [UserController::class,'index'])->name('user.index');
Route::get('/user/profile', [UserController::class,'profile'])->name('user.profile');
Route::post('/user/profile', [UserController::class,'profile_post'])->name('user.profile');
Route::get('/user/favorit', [UserController::class,'favorit'])->name('user.favorit');
Route::post('/user/favorit', [UserController::class,'favorit_cari'])->name('user.favorit');
Route::post('/user/rate', [UserController::class,'rate'])->name('user.rate');
Route::get('/user/cart', [UserController::class,'cart'])->name('user.cart');
Route::delete('/user/cart/{id}', [UserController::class,'cart_delete'])->name('user.cart_delete');
Route::put('/user/cart/{id}', [UserController::class,'cart_update'])->name('user.cart_update');
Route::get('/user/keranjang', [UserController::class,'keranjang'])->name('user.keranjang');
Route::get('/user/checkout', [PublicController::class,'checkout'])->name('user.checkout');
Route::get('/user/transaction', [UserController::class,'transaction'])->name('user.transaction');
Route::get('/user/transaction/{id}/review', [UserController::class,'review'])->name('user.review');
Route::post('/rate', [UserController::class,'review_post'])->name('user.review');

//api provinsi
Route::get('/api/provinsi',[RajaOngkirController::class,'provinsi'])->name('api.provinsi');
Route::get('/api/kota/{id}',[RajaOngkirController::class,'kota'])->name('api.kota');
Route::get('/api/ongkir/{produk_id}/{jenis}/{kurir}',[RajaOngkirController::class,'ongkir'])->name('api.ongkir');

//midtrans
Route::post('buat-pesanan', [MidtransController::class, 'buat_pesanan'])->name('buat-pesanan');
//1
Route::get('buat-pembayaran/{id}', [MidtransController::class, 'select_pay'])->name('buat-pembayaran');
//2
Route::get('post-pembayaran/{id}/{type}', [MidtransController::class, 'post_pay'])->name('post-pembayaran');
//3;
Route::get('update/{id}/{status}', [MidtransController::class, 'update'])->name('update-payment');
//4
Route::get('/midtrans/notification', [MidtransController::class, 'handleNotification']);
