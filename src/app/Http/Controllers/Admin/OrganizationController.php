<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\Admin\Organization\CreateOrganizationRequest;
use App\Http\Requests\Admin\Organization\DeleteOrganizationRequest;
use App\Http\Requests\Admin\Organization\GetOrganizationRequest;
use App\Http\Requests\Admin\Organization\UpdateOrganizationRequest;
use App\Models\Category;
use App\Repositories\CRM\OrganizationRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class OrganizationController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected OrganizationRepositoryInterface $organizationRepository;
    protected LoggerInterface $logger;

    public function __construct(
        OrganizationRepositoryInterface $organizationRepository,
        LoggerInterface $logger,
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_CREATE_ORGANIZATION,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_UPDATE_ORGANIZATION,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_DELETE_ORGANIZATION,
            ['only' => ['delete']]);
    }

    /**
     * @param GetOrganizationRequest $request
     * @return JsonResponse
     */
    public function list(GetOrganizationRequest $request): JsonResponse
    {
        $organizations = $this->organizationRepository->get(
            $request->company()
        );

        return response()->json([
            'organizations' => $organizations->toArray(),
        ]);
    }

    /**
     * @param CreateOrganizationRequest $request
     * @return JsonResponse
     */
    public function create(
        CreateOrganizationRequest $request
    ): JsonResponse {
        $organization = $this->organizationRepository->store($request->company(), $request->getName());

        return response()->json([
            'organization' => $organization->toArray(),
        ]);
    }

    /**
     * @param UpdateOrganizationRequest $request
     * @return JsonResponse
     */
    public function update(
        UpdateOrganizationRequest $request
    ): JsonResponse {
        $organization = $this->organizationRepository->find($request->getOrganizationId());
        $organization = $this->organizationRepository->update($organization, $request->getName());

        return response()->json([
            'organization' => $organization->toArray(),
        ]);
    }

    /**
     * @param DeleteOrganizationRequest $request
     * @return JsonResponse
     */
    public function delete(
        DeleteOrganizationRequest $request
    ): JsonResponse {
        $organization = $this->organizationRepository->find($request->getOrganizationId());
        $isDeleted = $this->organizationRepository->delete($organization);

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
