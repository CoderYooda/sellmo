<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getRootCategoryBySlug(string $slug): ?Category;
    public function getCategoriesTree(bool|int $rootCategoryId = false, ?Company $company = null, bool $force = false): Collection;
    public function find(int $id): ?Category;
    public function store(string $name, string $type, Company $company): Category;
    public function update(Category $category, ?string $name = null, ?string $type = null): Category;
    public function move(Category $category, int $move_to): Category;
}
