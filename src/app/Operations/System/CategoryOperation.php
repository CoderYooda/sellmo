<?php

namespace App\Operations\System;

use App\Models\Category;
use App\Models\Company;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Psr\Log\LoggerInterface;

class CategoryOperation
{
    protected CategoryRepositoryInterface $categoryRepository;
    protected LoggerInterface $logger;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    /**
     * @param Company $company
     * @param Category $parentCategory
     * @param string $name
     * @param string $type
     * @return Category
     */
    public function create(
        Company $company,
        Category $parentCategory,
        string $name,
        string $type,
    ): Category {
        $category = $this->categoryRepository->store($name, $type, $company);
        $parentCategory->appendNode($category);

        $this->logger->debug('[CATEGORY] created', [
            'category' => $category->toArray(),
        ]);

        return $category;
    }

    /**
     * @param Category $category
     * @param Category $parentCategory
     * @param ?string $name
     * @param string|null $type
     * @return Category
     */
    public function update(
        Category $category,
        Category $parentCategory,
        ?string $name,
        ?string $type = null
    ): Category {
        $categoryUpdated = $this->categoryRepository->update($category, $name, $type);

        $parentCategory->appendNode($categoryUpdated);

        $this->logger->debug('[CATEGORY] updated', [
            'category' => $categoryUpdated->toArray(),
        ]);

        return $categoryUpdated;
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
        $category->each(function ($category) use ($move_to){
            $this->categoryRepository->move($category, $move_to);
        });

        $this->logger->debug('[CATEGORY] moved', [
            'categoryId' => $category,
        ]);

        return true;
    }

    /**
     * @param Category $category
     * @param bool $recursive
     * @param ?int $move_to
     * @return bool
     */
    public function delete(
        Category $category,
        bool $recursive,
        int $move_to = null,
    ): bool {
        if($recursive){
            $category->delete();
            $this->logger->debug('[CATEGORY] deleted recursive', [
                'category' => $category,
            ]);

            return true;
        }

        if(isset($move_to)){
            if($this->move($category->children()->get(), $move_to)){
                $category->delete();
                $this->logger->debug('[CATEGORY] deleted with migration', [
                    'category' => $category,
                ]);
            } else {
                $this->logger->debug('[CATEGORY] deleted with migration error', [
                    'category' => $category,
                ]);

                return false;
            }

            return true;
        }

        return false;
    }
}
