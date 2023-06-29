<?php

use Illuminate\Support\Facades\DB;
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

Route::get('/health', function () {

    return [
        'db' => DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME),
        'redis' => \Illuminate\Support\Facades\Redis::connection()->ping(),
    ];
});
