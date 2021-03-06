<?php

use App\Http\Controllers\AndroidController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\FoodOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

// LOG IN
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'viewLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'submitLogin']);
});

Route::middleware('haruslogin')->group(function () {
    // PERMISSION DENIED
    Route::get('/denied', [AppController::class, 'permissionDenied'])->name('permissiondenied');

    // HOME PAGE
    Route::get('/', [LoginController::class, 'redirectLogin'])->name('home');

    // LOG OUT
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});


// ADMIN
Route::middleware(['haruslogin', 'admin'])->group(function () {
    // ROUTING ADMIN
    Route::get('dashboard', [AppController::class, 'dashboard'])->name('admin.home');
    Route::get('history', [AppController::class, 'history'])->name('admin.history');

    Route::get('setting', [AppController::class, 'settingView'])->name('admin.setting.view');
    Route::post('setting', [AppController::class, 'settingSubmit'])->name('admin.setting.submit');

    // ROUTING MENU
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'list'])->name('menu.list');
        Route::get('/list/json', [MenuController::class, 'getListJson']);

        Route::get('/add', [MenuController::class, 'viewAdd'])->name('menu.add.form');
        Route::post('/add', [MenuController::class, 'submitAdd'])->name('menu.add.submit');

        Route::prefix('{id}')->group(function () {
            Route::get('/edit', [MenuController::class, 'viewEdit'])->name('menu.edit.form');
            Route::post('/edit', [MenuController::class, 'submitEdit'])->name('menu.edit.submit');

            Route::post('/delete', [MenuController::class, 'delete'])->name('menu.delete');
            Route::post('/restore', [MenuController::class, 'restore'])->name('menu.restore');
        });
    });
});



// KOKI
Route::middleware(['haruslogin', 'koki'])->group(function () {
    // ROUTING FOOD ORDER / PESANAN MAKANAN
    Route::prefix('food-order')->group(function () {
        Route::prefix('{status}')->group(function(){
            Route::get('/', [FoodOrderController::class, 'list'])->name('foodorder.list');
            Route::get('/list/json/rekapmenu', [FoodOrderController::class, 'getRekapanMenuPesananJson']);
            Route::get('/list/json/pesanan', [FoodOrderController::class, 'getDataPesananJson']);
        });


        Route::prefix('{id}')->group(function () {
            Route::post('/done', [FoodOrderController::class, 'foodPrepared'])->name('foodorder.foodPrepared');
        });

    });

    //semua pesanan di order ini sudah selesai disiapkan semua
    Route::post('/customer-order/{id}/done-all', [FoodOrderController::class, 'foodPreparedAll'])
        ->name('foodorder.foodPreparedAll');
});



// KASIR
Route::middleware(['haruslogin', 'kasir'])->group(function () {
    // ROUTING CUSTOMER ORDER / PESANAN PELANGGAN
    Route::prefix('customer-order')->group(function () {
        Route::prefix('/{status}')->group(function(){
            Route::get('/', [CustomerOrderController::class, 'list'])->name('custorder.list');
            Route::get('/list/json', [CustomerOrderController::class, 'getListJson']);
        });

        Route::prefix('{id}')->group(function () {
            Route::get('/detail', [CustomerOrderController::class, 'detail'])
                ->name('custorder.detail');
            Route::post('/confirm-payment', [CustomerOrderController::class, 'confirmPayment'])
                ->name('custorder.confirmpayment');
        });
    });
});

Route::prefix('android')->group(function(){
    Route::get('/coba', [AndroidController::class, 'coba']);
});




