<?php

use App\Http\Controllers\Admin;
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

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/admin{any}', function () {
    return view('admin.index');
})->where('any', '.*');

Route::group([
    'prefix'    => '',
], function () {
    Route::post('/register', [Admin\AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('auth.login');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/whoami', [Admin\AuthController::class, 'whoami'])->name('auth.whoami');

    });
});
