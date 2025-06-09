<?php

use App\Http\Controllers\AdopsiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PenjualanPetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PKHController;
use App\Http\Controllers\TransaksiAdopsiController;
use App\Http\Controllers\TransaksiPenjualanPetController;
use App\Http\Controllers\TransaksiPKHController;
use App\Http\Controllers\UserManajementController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::post('/postregister', [AuthController::class, 'postregister'])->name('postregister');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// End Auth

// Admin
Route::middleware(['auth', 'level:admin'])->prefix('admin')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('/pets', PetController::class);
    Route::resource('/adopt', AdopsiController::class);
    Route::resource('/vendor', VendorController::class);
    Route::resource('/kebutuhan-hewan', PKHController::class);
    Route::resource('/penjualan-hewan', PenjualanPetController::class);
    Route::resource('/transaksi-adopsi', TransaksiAdopsiController::class);
    Route::resource('/transaksi-penjualan', TransaksiPenjualanPetController::class);
    Route::resource('/transaksi-pkh', TransaksiPKHController::class);
    Route::resource('/users', UserManajementController::class);
});
// End Admin

// Vendor
Route::middleware(['auth', 'level:vendor'])->prefix('vendor')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'vendordashboard'])->name('vendordashboard');
});
// End Vendor

// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('beranda');
Route::get('/adopt', [FrontendController::class, 'adopt'])->name('adopt');
Route::get('/pet-shop', [FrontendController::class, 'petshop'])->name('pet-shop');
Route::get('/other', [FrontendController::class, 'other'])->name('other');
Route::get('/my/cart', [FrontendController::class, 'cart'])->name('cart');
Route::post('/cart/add', [FrontendController::class, 'addToCart'])->middleware('auth');
Route::put('/cart/{id}', [FrontendController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [FrontendController::class, 'destroy'])->name('cart.remove');
Route::get('/product/{id}', [FrontendController::class, 'productDetail'])->name('product.detail');
Route::get('/pet/{id}', [FrontendController::class, 'petDetail'])->name('pet.detail');
Route::get('/article/{slug}', [FrontendController::class, 'artikeldetail'])->name('artikeldetail');
