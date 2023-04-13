<?php

namespace App\Repositories\Pipeline;

use App\Models\Company;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;

interface PipelineStageRepositoryInterface
{
    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @param int $order
     * @return PipelineStage
     */
    public function store(Pipeline $pipeline, string $name, int $order): PipelineStage;

    /**
     * @param PipelineStage $pipelineStage
     * @param string $name
     * @param ?int $order
     * @return PipelineStage
     */
    public function update(PipelineStage $pipelineStage, string $name, int $order = null): PipelineStage;

    /**
     * @param int $id
     * @return PipelineStage|null
     */
    public function find(int $id): ?PipelineStage;

    /**
     * @param PipelineStage $pipelineStage
     * @return bool
     */
    public function delete(PipelineStage $pipelineStage): bool;
}
