<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\CreateLeadRequest;
use App\Http\Requests\Admin\Lead\Type\GetLeadRequest;
use App\Operations\CRM\LeadOperation;
use App\Operations\CRM\PersonOperation;
use App\Repositories\CRM\OrganizationRepositoryInterface;
use App\Repositories\CRM\PersonRepositoryInterface;
use App\Repositories\Lead\LeadRepositoryInterface;
use App\Repositories\Lead\LeadSourceRepositoryInterface;
use App\Repositories\Lead\LeadTypeRepositoryInterface;
use App\Repositories\Pipeline\PipelineRepositoryInterface;
use App\Repositories\Pipeline\PipelineStageRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Psr\Log\LoggerInterface;

class LeadController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected LeadRepositoryInterface $leadRepository;
    protected LeadSourceRepositoryInterface $leadSourceRepository;
    protected PersonRepositoryInterface $personRepository;
    protected OrganizationRepositoryInterface $organizationRepository;
    protected LeadTypeRepositoryInterface $leadTypeRepository;
    protected PipelineRepositoryInterface $pipelineRepository;
    protected PipelineStageRepositoryInterface $pipelineStageRepository;
    protected LeadOperation $leadOperation;
    protected PersonOperation $personOperation;
    protected LoggerInterface $logger;

    public function __construct(
        LeadRepositoryInterface $leadRepository,
        LeadSourceRepositoryInterface $leadSourceRepository,
        PersonRepositoryInterface $personRepository,
        OrganizationRepositoryInterface $organizationRepository,
        LeadTypeRepositoryInterface $leadTypeRepository,
        PipelineRepositoryInterface $pipelineRepository,
        PipelineStageRepositoryInterface $pipelineStageRepository,
        LeadOperation $leadOperation,
        PersonOperation $personOperation,
        LoggerInterface $logger,
    ) {
        $this->leadRepository = $leadRepository;
        $this->leadSourceRepository = $leadSourceRepository;
        $this->personRepository = $personRepository;
        $this->organizationRepository = $organizationRepository;
        $this->leadTypeRepository = $leadTypeRepository;
        $this->pipelineRepository = $pipelineRepository;
        $this->pipelineStageRepository = $pipelineStageRepository;
        $this->leadOperation = $leadOperation;
        $this->personOperation = $personOperation;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . Permission::CAN_CREATE_LEAD,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . Permission::CAN_UPDATE_LEAD,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . Permission::CAN_DELETE_LEAD,
            ['only' => ['delete']]);
    }

    /**
     * @param GetLeadRequest $request
     * @return JsonResponse
     */
    public function get(GetLeadRequest $request): JsonResponse
    {
        $pipeline = $this->pipelineRepository->find($request->getPipelineId());
        $leads = $this->leadOperation->getByPipeline(
            $pipeline
        );

        return response()->json([
            'leads' => $leads->toArray(),
        ]);
    }

    /**
     * @param CreateLeadRequest $request
     * @return JsonResponse
     */
    public function create(
        CreateLeadRequest $request
    ): JsonResponse {
        $leadSource = $this->leadSourceRepository->find($request->getLeadSourceId());
        $creator = $request->person();
        $manager = $this->personRepository->find($request->getManagerId());

        $organization = $request->getOrganizationId() ?
            $this->organizationRepository->find($request->getOrganizationId()) :
            $this->organizationRepository->store($request->company(), $request->getOrganizationName());

        $person = $this->personOperation->findOrCreate(
            $request->company(),
            $request->getPersonId(),
            $request->getPersonFullName(),
            $organization
        );

        $leadType = $this->leadTypeRepository->find($request->getLeadTypeId());
        $pipelineStage = $this->pipelineStageRepository->find($request->getPipelineStageId());
        $lead = $this->leadOperation->create(
            $request->company(),
            $leadSource,
            $creator,
            $manager,
            $person,
            $organization,
            $leadType,
            $pipelineStage,
            $request->getTitle(),
            $request->getDescription(),
            $request->getAmount(),
            $request->getLostReason() ?? null
        );

        return response()->json([
            'lead' => $lead->toArray(),
        ]);
    }
}
