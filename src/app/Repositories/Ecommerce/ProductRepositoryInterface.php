<?php

namespace App\Repositories\Ecommerce;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function get(): ?Collection;
    public function find(int $id): ?Product;
    public function store(
        Company $company,
        Category $category,
        string $sku,
        string $name,
        string $type,
        int $price,
        string $slug,
        ?int $specialPrice = null
    ): Product;
    public function update(Category $category, ?string $name = null, ?string $type = null): Product;
}
