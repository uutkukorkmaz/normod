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

Route::get('/health', function () {

    return [
        'db' => DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME),
        'redis' => \Illuminate\Support\Facades\Redis::connection()->ping(),
    ];
});
