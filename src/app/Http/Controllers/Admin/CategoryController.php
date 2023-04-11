<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Operations\Category\CategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryTreeRequest;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use App\Operations\System\CategoryOperation;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class CategoryController extends Controller
{
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
    public function tree(CategoryTreeRequest $request): JsonResponse
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
        $this->checkAccess($request->user(), $request->getParentId());

        $category = $this->categoryOperation->create(
            $request->user()->person->company,
            $request->getParentId(),
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
        $this->checkAccess($request->user(), $request->getCategoryId());

        $category = $this->categoryOperation->update(
            $request->getCategoryId(),
            $request->getParentId(),
            $request->getName()
        );

        return response()->json([
            'category' => $category->toArray(),
        ]);
    }

    /**
     * @param DeleteCategoryRequest $request
     * @return JsonResponse
     * @throws AuthorizationException|CategoryNotFoundException
     */
    public function delete(
        DeleteCategoryRequest $request
    ): JsonResponse {
        $this->checkAccess($request->user(), $request->getCategoryId());

        $isDeleted = $this->categoryOperation->delete(
            $request->getCategoryId(),
            $request->getRecursive(),
            $request->getMoveTo(),
        );

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    protected function checkAccess(
        User $user,
        int $categoryId
    ): void {
        $cannotUse = $user->cannot('useCategory', [
            'category' => Category::find($categoryId)
        ]);

        if($cannotUse){
            $this->logger->alert('[CATEGORY] trying to access protected category', [
                'user_id' => $user->id,
                'category_id' => $categoryId
            ]);
            throw new AuthorizationException();
        }
    }
}
