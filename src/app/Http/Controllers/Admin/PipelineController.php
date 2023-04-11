<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pipeline\CreatePipelineRequest;
use App\Operations\CRM\PipelineOperation;
use Illuminate\Http\JsonResponse;

class PipelineController extends Controller
{
    protected PipelineOperation $pipelineOperation;

    public function __construct(
        PipelineOperation $pipelineOperation
    ) {
        $this->pipelineOperation = $pipelineOperation;
    }

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
}
