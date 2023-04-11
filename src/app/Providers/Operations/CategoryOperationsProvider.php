<?php

declare(strict_types=1);

namespace App\Providers\Operations;

use App\Operations\System\CategoryOperation;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class CategoryOperationsProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(CategoryOperation::class, function () {
            return new CategoryOperation(
                resolve(CategoryRepositoryInterface::class),
                resolve(LoggerInterface::class),
            );
        });
    }
}
