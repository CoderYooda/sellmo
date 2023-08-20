<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

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
    Route::resource('categories', Admin\CategoryController::class);
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
        Route::post('/stages/delete', [Admin\PipelineStageController::class, 'delete'])
            ->name('admin.pipeline.stage.delete');
    });

    Route::group([
        'prefix'    => 'organization',
    ], function () {
        Route::post('/', [Admin\OrganizationController::class, 'list'])
            ->name('admin.organization.list');
        Route::post('/create', [Admin\OrganizationController::class, 'create'])
            ->name('admin.organization.create');
        Route::post('/update', [Admin\OrganizationController::class, 'update'])
            ->name('admin.organization.update');
        Route::post('/delete', [Admin\OrganizationController::class, 'delete'])
            ->name('admin.organization.delete');
    });

    Route::group([
        'prefix'    => 'person',
    ], function () {
        Route::post('/', [Admin\PersonController::class, 'list'])
            ->name('admin.organization.list');
        Route::post('/create', [Admin\PersonController::class, 'create'])
            ->name('admin.organization.create');
        Route::post('/update', [Admin\PersonController::class, 'update'])
            ->name('admin.organization.update');
        Route::post('/delete', [Admin\PersonController::class, 'delete'])
            ->name('admin.organization.delete');
    });

    Route::resource('products', Admin\ProductController::class);
//    Route::group([
//        'prefix'    => 'product',
//    ], function () {
//        Route::post('/', [Admin\ProductController::class, 'list'])
//            ->name('admin.product.list');
//        Route::post('/create', [Admin\ProductController::class, 'create'])
//            ->name('admin.product.create');
//    });

    Route::group([
        'prefix'    => 'lead',
    ], function () {
        Route::group([
            'prefix'    => 'type',
        ], function () {
            Route::post('/', [Admin\LeadTypeController::class, 'list'])
                ->name('admin.lead.type.list');
            Route::post('/create', [Admin\LeadTypeController::class, 'create'])
                ->name('admin.lead.type.create');
            Route::post('/update', [Admin\LeadTypeController::class, 'update'])
                ->name('admin.lead.type.update');
            Route::post('/delete', [Admin\LeadTypeController::class, 'delete'])
                ->name('admin.lead.type.delete');
        });
        Route::group([
            'prefix'    => 'source',
        ], function () {
            Route::post('/', [Admin\LeadSourceController::class, 'list'])
                ->name('admin.lead.source.list');
            Route::post('/create', [Admin\LeadSourceController::class, 'create'])
                ->name('admin.lead.source.create');
            Route::post('/update', [Admin\LeadSourceController::class, 'update'])
                ->name('admin.lead.source.update');
            Route::post('/delete', [Admin\LeadSourceController::class, 'delete'])
                ->name('admin.lead.source.delete');
        });
        Route::post('/create', [Admin\LeadController::class, 'create'])
            ->name('admin.lead.create');
    });
});

