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
Route::group([
    'middleware' => ['company', 'auth:sanctum']
], function () {
    Route::group([
        'prefix'    => 'categories',
    ], function () {
        Route::post('/', [Admin\CategoryController::class, 'tree'])
            ->name('admin.categories');
        Route::post('/create', [Admin\CategoryController::class, 'create'])
            ->name('admin.categories.create');
        Route::post('/update', [Admin\CategoryController::class, 'update'])
            ->name('admin.categories.update');
        Route::post('/delete', [Admin\CategoryController::class, 'delete'])
            ->name('admin.categories.delete');
    });

    Route::group([
        'prefix'    => 'pipeline',
    ], function () {
        Route::post('/create', [Admin\PipelineController::class, 'create'])
            ->name('admin.pipeline.create');
        Route::post('/update', [Admin\PipelineController::class, 'update'])
            ->name('admin.pipeline.update');
        Route::post('/delete', [Admin\PipelineController::class, 'delete'])
            ->name('admin.pipeline.delete');

        Route::post('/stages/create', [Admin\PipelineStageController::class, 'create'])
            ->name('admin.pipeline.stage.create');
        Route::post('/stages/update', [Admin\PipelineStageController::class, 'update'])
            ->name('admin.pipeline.stage.update');
    });
});

