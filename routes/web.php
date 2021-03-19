<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\FoodOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Route;

// TESTING TEMPLATE LAYOUT
Route::get('/test/layouts', function () {
    return view('layouts.layout-master');
});
Route::get('/test/template', function () {
    return view('layouts.template-asli');
});
Route::get('/hash', function(){
    // $staffs = Pegawai::all();

    // foreach ($staffs as $key => $staff) {
    //     $staff->password = \password_hash($staff->password, PASSWORD_DEFAULT);
    //     $staff->save();
    // }
    // echo 'sukses hash';
    dd(url()->current());
});


// HOME PAGE
Route::get('/', [LoginController::class, 'redirectLogin'])->name('home');

// LOG IN
Route::get('/login', [LoginController::class, 'viewLogin'])->name('login');
Route::post('/login', [LoginController::class, 'submitLogin']);

// LOG OUT
Route::get('/logout', [LoginController::class, 'logout']);


// ROUTING MENU
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'list'])->name('menu.list');

    Route::get('/edit', [MenuController::class, 'viewEdit']);
    Route::post('/edit', [MenuController::class, 'submitEdit']);

    Route::post('/delete', [MenuController::class, 'delete']);
    Route::post('/restore', [MenuController::class, 'delete']);
});


// ROUTING FOOD ORDER / PESANAN MAKANAN
Route::prefix('food-order')->group(function () {
    Route::get('/{status}', [FoodOrderController::class, 'list'])->name('foodorder.list');
});


// ROUTING CUSTOMER ORDER / PESANAN PELANGGAN
Route::prefix('customer-order')->group(function () {
    Route::get('/{status}', [CustomerOrderController::class, 'list'])->name('custorder.list');
});


// ROUTING ADMIN
Route::get('dashboard', [AppController::class, 'dashboard'])->name('admin.home');
Route::get('setting', [AppController::class, 'setting'])->name('admin.setting');
Route::get('history', [AppController::class, 'history'])->name('admin.history');
