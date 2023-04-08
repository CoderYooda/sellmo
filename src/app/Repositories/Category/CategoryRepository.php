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
            ->when(!$force, function ($q) use ($companyId){
                $q->where('company_id', $companyId)
                    ->orWhere('type', Category::TYPE_SYSTEM);
            })
            ->get()
            ->toTree($rootCategoryId);
    }
}
