<?php

namespace App\Operations\CRM;

use App\Models\Company;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
use App\Repositories\Pipeline\PipelineRepositoryInterface;
use App\Repositories\Pipeline\PipelineStageRepositoryInterface;

class PipelineOperation
{
    protected PipelineRepositoryInterface $pipelineRepository;
    protected PipelineStageRepositoryInterface $pipelineStageRepository;

    public function __construct(
        PipelineRepositoryInterface $pipelineRepository,
        PipelineStageRepositoryInterface $pipelineStageRepository,
    ) {
        $this->pipelineRepository = $pipelineRepository;
        $this->pipelineStageRepository = $pipelineStageRepository;
    }

    /**
     * @param Company $company
     * @param string $name
     * @return Pipeline
     */
    public function create(
        Company $company,
        string $name,
    ): Pipeline {
        return $this->pipelineRepository->store($name, $company);
    }

    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @return Pipeline
     */
    public function update(
        Pipeline $pipeline,
        string $name,
    ): Pipeline {
        return $this->pipelineRepository->update($pipeline, $name);
    }

    /**
     * @param Pipeline $pipeline
     * @return bool
     */
    public function delete(
        Pipeline $pipeline
    ): bool {
        return $this->pipelineRepository->delete($pipeline);
    }

    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @param int|null $order
     * @return PipelineStage
     */
    public function createStage(
        Pipeline $pipeline,
        string $name,
        ?int $order = null
    ): PipelineStage {
        return $this->pipelineStageRepository->store(
            $pipeline,
            $name,
            $order
        );
    }

    /**
     * @param PipelineStage $pipeline
     * @param string $name
     * @param int|null $order
     * @return PipelineStage
     */
    public function updateStage(
        PipelineStage $pipeline,
        string $name,
        ?int $order = null
    ): PipelineStage {
        return $this->pipelineStageRepository->update(
            $pipeline,
            $name,
            $order
        );
    }

    /**
     * @param PipelineStage $pipelineStage
     * @return bool
     */
    public function deleteStage(
        PipelineStage $pipelineStage
    ): bool {
        return $this->pipelineStageRepository->delete($pipelineStage);
    }
}
