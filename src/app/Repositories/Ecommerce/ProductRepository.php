<?php

namespace App\Repositories\Ecommerce;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @return Collection|null
     */
    public function get(): ?Collection
    {
        /** @var ?Collection $products */
        $products = Product::query()
            ->get();

        return $products;
    }

    /**
     * @param int $id
     * @return Category|null
     */
    public function find(int $id): ?Product
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('id', $id)
            ->firstOrFail();

        return $category;
    }

    /**
     * @param Company $company
     * @param Category $category
     * @param string $sku
     * @param string $name
     * @param string $type
     * @return Product
     */
    public function store(
     Company $company,
     Category $category,
     string $sku,
     string $name,
     string $type
    ): Product {
        $product = new Product();

        $product->sku = $sku;
        $product->name = $name;
        $product->type = $type;
        $product->category()->associate($category);
        $product->company()->associate($company);
        $product->save();

        return $product;
    }

    /**
     * @param Category $category
     * @param ?string $name
     * @param ?string $type
     * @return Product
     */
    public function update(
        Category $category,
        ?string $name = null,
        ?string $type = null
    ): Product {
        return new Product();
    }
}
