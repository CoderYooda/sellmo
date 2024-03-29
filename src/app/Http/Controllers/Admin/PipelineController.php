<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pipeline\CreatePipelineRequest;
use App\Http\Requests\Admin\Pipeline\DeletePipelineRequest;
use App\Http\Requests\Admin\Pipeline\UpdatePipelineRequest;
use App\Operations\CRM\PipelineOperation;
use App\Repositories\Pipeline\PipelineRepository;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class PipelineController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected PipelineOperation $pipelineOperation;
    protected PipelineRepository $pipelineRepository;

    public function __construct(
        PipelineOperation $pipelineOperation,
        PipelineRepository $pipelineRepository
    ) {
        $this->pipelineOperation = $pipelineOperation;
        $this->pipelineRepository = $pipelineRepository;
    }

    /**
     * @param CreatePipelineRequest $request
     * @return JsonResponse
     */
    public function create(
        CreatePipelineRequest $request
    ): JsonResponse {
        $pipeline = $this->pipelineOperation->create(
            $request->company(),
            $request->getName()
        );

        return response()->json([
            'pipeline' => $pipeline->toArray(),
        ]);
    }

    /**
     * @param UpdatePipelineRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdatePipelineRequest $request
    ): JsonResponse {
        $pipeline = $this->pipelineRepository->find($request->getPipelineId());
        $this->checkAccess($request->user(), $pipeline);

        $pipeline = $this->pipelineOperation->update(
            $pipeline,
            $request->getName(),
        );

        return response()->json([
            'pipeline' => $pipeline->toArray(),
        ]);
    }

    /**
     * @param DeletePipelineRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(
        DeletePipelineRequest $request
    ): JsonResponse {
        $pipeline = $this->pipelineRepository->find($request->getPipelineId());
        $this->checkAccess($request->user(), $pipeline);
        $isDeleted = $this->pipelineOperation->delete($pipeline);

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
