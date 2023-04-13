<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
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
     * @param ?Company $company
     * @param bool $force
     * @return Collection
     */
    public function getCategoriesTree(
        bool|int $rootCategoryId = false,
        ?Company $company = null,
        bool $force = false
    ): Collection {
        return Category::query()
            ->where('type', Category::TYPE_SYSTEM)
            ->when(!$force, function ($q) use ($company){
                $q->orWhere('company_id', $company->id);
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
            ->firstOrFail();

        return $category;
    }

    /**
     * @param string $name
     * @param string $type
     * @param Company $company
     * @return Category
     */
    public function store(
        string $name,
        string $type,
        Company $company
    ): Category {
        $category = new Category();
        $category->name = $name;
        $category->type = $type;
        $category->company()->associate($company);
        $category->slug = toSlug($name);
        $category->save();

        return $category;
    }

    /**
     * @param Category $category
     * @param ?string $name
     * @param ?string $type
     * @return Category
     */
    public function update(
        Category $category,
        ?string $name = null,
        ?string $type = null
    ): Category {
        if(!$name && ! $type){
            return $category;
        }

        $category->name = $name ?? $category->name;
        $category->type = $type ?? Category::TYPE_PUBLIC;
        $category->slug = $name ? toSlug($name) : $category->slug;
        $category->save();

        return $category;
    }

    /**
     * @param Category $category
     * @param int $move_to
     * @return Category
     */
    public function move(Category $category, int $move_to): Category
    {
        $category->parent_id = $move_to;
        $category->save();

        return $category;
    }
}
