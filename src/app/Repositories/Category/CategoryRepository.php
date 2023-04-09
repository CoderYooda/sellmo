<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    /**
     * @param string $slug
     * @return ?Category
     */
    public function getRootCategoryBySlug(string $slug): ?Category
    {
        if(!in_array($slug, Category::RESERVED_SLUGS)){
            return null;
        }

        /** @var Category $category */
        $category = Category::query()
            ->where('type', Category::TYPE_SYSTEM)
            ->where('slug', $slug)
            ->first();

        return $category;
    }

    /**
     * @param int|false $rootCategoryId
     * @param int|null $companyId
     * @param bool $force
     * @return Collection
     */
    public function getCategoriesTree(bool|int $rootCategoryId = false, int $companyId = null, bool $force = false): Collection
    {
        return Category::query()
            ->where('type', Category::TYPE_SYSTEM)
            ->when(!$force, function ($q) use ($companyId){
                $q->orWhere('company_id', $companyId);
            })
            ->get()
            ->toTree($rootCategoryId);
    }

    /**
     * @param int $id
     * @return Category|null
     */
    public function find(int $id): ?Category
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('id', $id)
            ->first();

        return $category;
    }
}
