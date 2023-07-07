<?php

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


require __DIR__ . '/auth.php';

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/', fn(Request $request) => $request->user())->name('get');

        Route::apiResource('orders', \App\Http\Controllers\V1\OrderController::class)->only('index', 'show');
    });
});
