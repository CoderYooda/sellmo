<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pipeline\CreatePipelineStageRequest;
use App\Http\Requests\Admin\Pipeline\DeletePipelineStageRequest;
use App\Http\Requests\Admin\Pipeline\UpdatePipelineStageRequest;
use App\Operations\CRM\PipelineOperation;
use App\Repositories\Pipeline\PipelineRepository;
use App\Repositories\Pipeline\PipelineStageRepository;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class PipelineStageController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected PipelineOperation $pipelineOperation;
    protected PipelineStageRepository $pipelineStageRepository;
    protected PipelineRepository $pipelineRepository;

    public function __construct(
        PipelineOperation $pipelineOperation,
        PipelineStageRepository $pipelineStageRepository,
        PipelineRepository $pipelineRepository
    ) {
        $this->pipelineOperation = $pipelineOperation;
        $this->pipelineStageRepository = $pipelineStageRepository;
        $this->pipelineRepository = $pipelineRepository;
    }

    /**
     * @param CreatePipelineStageRequest $request
     * @return JsonResponse
     */
    public function create(
        CreatePipelineStageRequest $request
    ): JsonResponse {
        $pipeline = $this->pipelineRepository->find($request->getPipelineId());

        $pipeline = $this->pipelineOperation->createStage(
            $pipeline,
            $request->getName(),
            $request->getOrder(),
        );

        return response()->json([
            'pipeline' => $pipeline->toArray(),
        ]);
    }

    /**
     * @param UpdatePipelineStageRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdatePipelineStageRequest $request
    ): JsonResponse {
        $pipelineStage = $this->pipelineStageRepository->find($request->getPipelineStageId());
        $this->checkAccess($request->user(), $pipelineStage);

        $pipelineStage = $this->pipelineOperation->updateStage(
            $pipelineStage,
            $request->getName(),
            $request->getOrder(),
        );

        return response()->json([
            'pipeline' => $pipelineStage->toArray(),
        ]);
    }

    /**
     * @param DeletePipelineStageRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(
        DeletePipelineStageRequest $request
    ): JsonResponse {
        $pipelineStage = $this->pipelineStageRepository->find($request->getPipelineStageId());
        $this->checkAccess($request->user(), $pipelineStage);
        $isDeleted = $this->pipelineOperation->deleteStage($pipelineStage);

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
