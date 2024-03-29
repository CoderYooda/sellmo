<?php

namespace App\Operations\Ecommerce;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Company;
use App\Models\Organization;
use App\Models\Person;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CRM\PersonRepository;
use App\Repositories\Ecommerce\ProductRepositoryInterface;

class ProductOperation
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Company $company
     * @param Category $category
     * @param string $sku
     * @param string $name
     * @param string $type
     * @param int $price
     * @param string|null $slug
     * @param int|null $specialPrice
     * @return Product
     */
    public function create(
        Company $company,
        Category $category,
        string $sku,
        string $name,
        string $type,
        int $price,
        ?string $slug = null,
        ?int $specialPrice = null,
    ): Product {
        return $this->productRepository->store(
            $company,
            $category,
            $sku,
            $name,
            $type,
            $price,
            $this->getSlug($name, $slug),
            $specialPrice
        );
    }

    /**
     * @param string $name
     * @param string|null $slug
     * @return string
     */
    protected function getSlug(string $name, ?string $slug = null ): string
    {
        return $slug ?: toSlug($name);
    }
}
