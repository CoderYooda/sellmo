<?php

namespace App\Repositories\Category;

use App\Models\Category;

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
}
