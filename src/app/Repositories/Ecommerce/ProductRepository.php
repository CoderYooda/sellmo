<?php

namespace App\Repositories\Ecommerce;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function gridQueryBuilder(): Builder
    {
        return Product::query()
            ->select(
                'products.id',
                'products.name',
                'products.type',
                'products.sku',
                'products.price',
                'products.special_price',
            );
    }


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
     * @param int $price
     * @param string $slug
     * @param int|null $specialPrice
     * @return Product
     */
    public function store(
     Company $company,
     Category $category,
     string $sku,
     string $name,
     string $type,
     int $price,
     string $slug,
     ?int $specialPrice = null
    ): Product {
        $product = new Product();

        $product->sku = $sku;
        $product->name = $name;
        $product->type = $type;
        $product->price = $price;
        $product->slug = $slug;
        $product->special_price = $specialPrice;
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
