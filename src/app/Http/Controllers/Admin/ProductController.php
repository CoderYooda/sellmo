<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\Source\CreateLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\DeleteLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\GetLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\UpdateLeadSourceRequest;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Models\Permission;
use App\Operations\Ecommerce\ProductOperation;
use App\Operations\System\CategoryOperation;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Ecommerce\ProductRepository;
use App\Repositories\Ecommerce\ProductRepositoryInterface;
use App\Repositories\Lead\LeadSourceRepository;
use App\Repositories\Lead\LeadSourceRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

class ProductController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected ProductRepositoryInterface $productRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected ProductOperation $productOperation;
    protected LoggerInterface $logger;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ProductOperation $productOperation,
        LoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productOperation = $productOperation;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . Permission::CAN_CREATE_PRODUCT,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . Permission::CAN_UPDATE_PRODUCT,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . Permission::CAN_DELETE_PRODUCT,
            ['only' => ['delete']]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $products = $this->productRepository->get();

        return response()->json([
            'products' => $products->toArray(),
        ]);
    }

    /**
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function create(
        CreateProductRequest $request
    ): JsonResponse {
        $category = $this->categoryRepository->find($request->getCategoryId());

        $product = $this->productOperation->create(
            $request->company(),
            $category,
            $request->getSku(),
            $request->getName(),
            $request->getType()
        );

        return response()->json([
            'product' => $product->toArray(),
        ]);
    }

    /**
     * @param UpdateLeadSourceRequest $request
     * @return JsonResponse
     */
    public function update(
        UpdateLeadSourceRequest $request
    ): JsonResponse {
//        $source = $this->leadSourceRepository->find($request->getLeadSourceId());
//
//        $source = $this->leadSourceRepository->update(
//            $source,
//            $request->getName()
//        );
//
        return response()->json([
//            'source' => $source->toArray(),
        ]);
    }

    /**
     * @param DeleteLeadSourceRequest $request
     * @return JsonResponse
     */
    public function delete(
        DeleteLeadSourceRequest $request
    ): JsonResponse {
//        $source = $this->leadSourceRepository->find($request->getLeadSourceId());
//
//        $isDeleted = $this->leadSourceRepository->delete(
//            $source
//        );
//
        return response()->json([
//            'source' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
