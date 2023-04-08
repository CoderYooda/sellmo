<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryTreeRequest;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryTreeRequest $request
     * @return JsonResponse
     */
    public function categoriesTree(CategoryTreeRequest $request): JsonResponse
    {
        $categories = $this->categoryRepository->getCategoriesTree(
            $request->getRootCategoryId(),
            $request->getCompanyId(),
            $request->isForce()
        );

        return response()->json([
            'categories' => $categories->toArray(),
        ]);
    }
}
