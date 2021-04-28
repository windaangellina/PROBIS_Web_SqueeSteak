<?php

use App\Http\Controllers\AndroidController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/android')->group(function(){
    Route::post('/ubahMeja', [AndroidController::class, 'ubahNoMeja']);
    Route::post('/getMenu', [AndroidController::class, 'getMenu']);
    Route::post('/makeHeader', [AndroidController::class, 'makeHeader']);
    Route::post('/addItem', [AndroidController::class, 'addItem']);
});

