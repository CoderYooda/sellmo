<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\Source\CreateLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\DeleteLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\GetLeadSourceRequest;
use App\Http\Requests\Admin\Lead\Source\UpdateLeadSourceRequest;
use App\Operations\System\CategoryOperation;
use App\Repositories\Lead\LeadSourceRepository;
use App\Repositories\Lead\LeadSourceRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class LeadSourceController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected LeadSourceRepositoryInterface $leadSourceRepository;
    protected CategoryOperation $categoryOperation;
    protected LoggerInterface $logger;

    public function __construct(
        LeadSourceRepository $leadSourceRepository,
        LoggerInterface $logger,
    ) {
        $this->leadSourceRepository = $leadSourceRepository;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_CREATE_LEAD_SOURCE,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_UPDATE_LEAD_SOURCE,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_DELETE_LEAD_SOURCE,
            ['only' => ['delete']]);
    }

    /**
     * @param GetLeadSourceRequest $request
     * @return JsonResponse
     */
    public function list(GetLeadSourceRequest $request): JsonResponse
    {
        $sources = $this->leadSourceRepository->get($request->company());

        return response()->json([
            'sources' => $sources->toArray(),
        ]);
    }

    /**
     * @param CreateLeadSourceRequest $request
     * @return JsonResponse
     */
    public function create(
        CreateLeadSourceRequest $request
    ): JsonResponse {
        $source = $this->leadSourceRepository->store(
            $request->company(),
            $request->getName()
        );

        return response()->json([
            'source' => $source->toArray(),
        ]);
    }

    /**
     * @param UpdateLeadSourceRequest $request
     * @return JsonResponse
     */
    public function update(
        UpdateLeadSourceRequest $request
    ): JsonResponse {
        $source = $this->leadSourceRepository->find($request->getLeadSourceId());

        $source = $this->leadSourceRepository->update(
            $source,
            $request->getName()
        );

        return response()->json([
            'source' => $source->toArray(),
        ]);
    }

    /**
     * @param DeleteLeadSourceRequest $request
     * @return JsonResponse
     */
    public function delete(
        DeleteLeadSourceRequest $request
    ): JsonResponse {
        $source = $this->leadSourceRepository->find($request->getLeadSourceId());

        $isDeleted = $this->leadSourceRepository->delete(
            $source
        );

        return response()->json([
            'source' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
