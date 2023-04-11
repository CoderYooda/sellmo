<?php

namespace App\Operations\System;

use App\Exceptions\Operations\Category\CategoryNotFoundException;
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
     * @param int $parentId
     * @param string $name
     * @param string $type
     * @return Category
     */
    public function create(
        Company $company,
        int $parentId,
        string $name,
        string $type,
    ): Category {
        $parentCategory = $this->categoryRepository->find($parentId);
        $category = $this->categoryRepository->store($name, $type, $company);
        $parentCategory->appendNode($category);

        $this->logger->debug('[CATEGORY] created', [
            'category' => $category->toArray(),
        ]);

        return $category;
    }

    /**
     * @param int $categoryId
     * @param int $parentId
     * @param ?string $name
     * @param string|null $type
     * @return Category
     */
    public function update(
        int $categoryId,
        int $parentId,
        ?string $name,
        ?string $type = null
    ): Category {
        $parentCategory = $this->categoryRepository->find($parentId);
        $category = $this->categoryRepository->find($categoryId);
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
     * @param int $categoryId
     * @param bool $recursive
     * @param ?int $move_to
     * @return bool
     * @throws CategoryNotFoundException
     */
    public function delete(
        int $categoryId,
        bool $recursive,
        int $move_to = null,
    ): bool {
        $category = $this->categoryRepository->find($categoryId);
        if(!$category){
            throw new CategoryNotFoundException();
        }
        if($recursive){
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
