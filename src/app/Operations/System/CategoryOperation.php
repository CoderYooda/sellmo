<?php

namespace App\Operations\System;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Psr\Log\LoggerInterface;

class CategoryOperation
{
    protected CategoryRepository $categoryRepository;
    protected LoggerInterface $logger;

    public function __construct(
        CategoryRepository $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    /**
     * @param int $companyId
     * @param int $parentId
     * @param string $name
     * @param string $type
     * @return Category
     */
    public function create(
        int $companyId,
        int $parentId,
        string $name,
        string $type,
    ): Category {
        $parentCategory = $this->categoryRepository->find($parentId);

        $category = new Category();
        $category->name = $name;
        $category->type = $type;
        $category->company()->associate($companyId);
        $category->slug = toSlug($name);
        $category->save();

        $parentCategory->appendNode($category);

        return $category;
    }

    /**
     * @param int $categoryId
     * @param int $parentId
     * @param string $name
     * @param string|null $type
     * @return Category
     */
    public function update(
        int $categoryId,
        int $parentId,
        string $name,
        ?string $type = null
    ): Category {
        $parentCategory = $this->categoryRepository->find($parentId);
        $category = $this->categoryRepository->find($categoryId);

        $category->name = $name;
        $category->type = $type ?? $category->type;
        $category->slug = toSlug($name);
        $category->save();

        $parentCategory->appendNode($category);

        $this->logger->debug('[CATEGORY] updated', [
            'category' => $category->toArray(),
        ]);

        return $category;
    }

    /**
     * @param Collection $category
     * @param int $move_to
     * @return bool
     */
    public function move(
        Collection $category,
        int $move_to,
    ): bool {

        $category->each(function ($c) use ($move_to){
            $c->parent_id = $move_to;
            $c->save();
        });

        $this->logger->debug('[CATEGORY] moved', [
            'categoryId' => $category,
        ]);

        return true;
    }

    /**
     * @param int $categoryId
     * @param bool $recursive
     * @param ?int $move_to
     * @return bool
     */
    public function delete(
        int $categoryId,
        bool $recursive,
        int $move_to = null,
    ): bool {
        $category = $this->categoryRepository->find($categoryId);

        if($recursive){
            $category->descendants()->delete();
            $category->delete();
            $this->logger->debug('[CATEGORY] deleted recursive', [
                'categoryId' => $categoryId,
            ]);

            return true;
        }

        if(isset($move_to)){
            if($this->move($category->children()->get(), $move_to)){
                $category->delete();
                $this->logger->debug('[CATEGORY] deleted with migration', [
                    'categoryId' => $categoryId,
                ]);
            } else {
                $this->logger->debug('[CATEGORY] deleted with migration error', [
                    'categoryId' => $categoryId,
                ]);

                return false;
            }

            return true;
        }

        return false;
    }
}
