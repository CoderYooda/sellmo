<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryTreeRequest;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Operations\System\CategoryOperation;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class CategoryController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected CategoryRepositoryInterface $categoryRepository;
    protected CategoryOperation $categoryOperation;
    protected LoggerInterface $logger;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryOperation $categoryOperation,
        LoggerInterface $logger,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryOperation = $categoryOperation;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_CREATE_CATEGORY,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_UPDATE_CATEGORY,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_DELETE_CATEGORY,
            ['only' => ['delete']]);
    }

    /**
     * @param CategoryTreeRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(CategoryTreeRequest $request): JsonResponse
    {
        if(!$request->canAccessIfForce()){
            throw new AuthorizationException();
        }

        $categories = $this->categoryRepository->getCategoriesTree(
            $request->getRootCategoryId(),
            $request->user()->person->company,
            $request->isForce()
        );

        return response()->json([
            'categories' => $categories->toArray(),
        ]);
    }

    /**
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create(
        CreateCategoryRequest $request
    ): JsonResponse {
        $parentCategory = $this->categoryRepository->find($request->getParentId());

        $this->checkAccess($request->user(), $parentCategory);

        $category = $this->categoryOperation->create(
            $request->user()->person->company,
            $parentCategory,
            $request->getName(),
            Category::TYPE_PUBLIC
        );

        return response()->json([
            'category' => $category->toArray(),
        ]);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateCategoryRequest $request
    ): JsonResponse {
        $category = $this->categoryRepository->find($request->getCategoryId());
        $parentCategory = $this->categoryRepository->find($request->getParentId());

        $this->checkAccess($request->user(), $category);
        $this->checkAccess($request->user(), $parentCategory);

        $category = $this->categoryOperation->update(
            $category,
            $parentCategory,
            $request->getName()
        );

        return response()->json([
            'category' => $category->toArray(),
        ]);
    }

    /**
     * @param DeleteCategoryRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(
        DeleteCategoryRequest $request
    ): JsonResponse {
        $category = $this->categoryRepository->find($request->getCategoryId());
        $this->checkAccess($request->user(), $category);

        $isDeleted = $this->categoryOperation->delete(
            $category,
            $request->getRecursive(),
            $request->getMoveTo(),
        );

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
