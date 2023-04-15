<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\Type\CreateLeadTypeRequest;
use App\Http\Requests\Admin\Lead\Type\DeleteLeadTypeRequest;
use App\Http\Requests\Admin\Lead\Type\GetLeadTypeRequest;
use App\Http\Requests\Admin\Lead\Type\UpdateLeadTypeRequest;
use App\Operations\System\CategoryOperation;
use App\Repositories\Lead\LeadTypeRepository;
use App\Repositories\Lead\LeadTypeRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class LeadTypeController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected LeadTypeRepositoryInterface $leadTypeRepository;
    protected CategoryOperation $categoryOperation;
    protected LoggerInterface $logger;

    public function __construct(
        LeadTypeRepository $leadTypeRepository,
        LoggerInterface $logger,
    ) {
        $this->leadTypeRepository = $leadTypeRepository;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_CREATE_LEAD_TYPE,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_UPDATE_LEAD_TYPE,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_DELETE_LEAD_TYPE,
            ['only' => ['delete']]);
    }

    /**
     * @param GetLeadTypeRequest $request
     * @return JsonResponse
     */
    public function list(GetLeadTypeRequest $request): JsonResponse
    {
        $sources = $this->leadTypeRepository->get($request->company());

        return response()->json([
            'sources' => $sources->toArray(),
        ]);
    }

    /**
     * @param CreateLeadTypeRequest $request
     * @return JsonResponse
     */
    public function create(
        CreateLeadTypeRequest $request
    ): JsonResponse {
        $source = $this->leadTypeRepository->store(
            $request->company(),
            $request->getName()
        );

        return response()->json([
            'source' => $source->toArray(),
        ]);
    }

    /**
     * @param UpdateLeadTypeRequest $request
     * @return JsonResponse
     */
    public function update(
        UpdateLeadTypeRequest $request
    ): JsonResponse {
        $source = $this->leadTypeRepository->find($request->getLeadTypeId());

        $source = $this->leadTypeRepository->update(
            $source,
            $request->getName()
        );

        return response()->json([
            'source' => $source->toArray(),
        ]);
    }

    /**
     * @param DeleteLeadTypeRequest $request
     * @return JsonResponse
     */
    public function delete(
        DeleteLeadTypeRequest $request
    ): JsonResponse {
        $source = $this->leadTypeRepository->find($request->getLeadTypeId());

        $isDeleted = $this->leadTypeRepository->delete(
            $source
        );

        return response()->json([
            'source' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
