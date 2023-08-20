<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Develop;

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/devtools/seed', [Develop\SeedController::class, 'index']);
Route::post('/devtools/seed/products', [Develop\SeedController::class, 'products'])
    ->name('dev.seed.products');


