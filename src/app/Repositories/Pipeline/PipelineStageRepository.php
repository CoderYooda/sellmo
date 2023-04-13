<?php

namespace App\Repositories\Pipeline;

use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;

class PipelineStageRepository implements PipelineStageRepositoryInterface
{
    public function find(int $id): ?PipelineStage
    {
        /** @var PipelineStage $pipelineStage */
        $pipelineStage = PipelineStage::query()
            ->where('id', $id)
            ->first();

        return $pipelineStage;
    }

    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @param int|null $order
     * @return PipelineStage
     */
    public function store(
        Pipeline $pipeline,
        string $name,
        ?int $order
    ): PipelineStage {
        $pipelineStage = new PipelineStage();
        $pipelineStage->name = $name;
        $pipelineStage->slug = toSlug($name);
        $pipelineStage->order = $order ?? 0;
        $pipelineStage->company()->associate($pipeline->company->id);
        $pipelineStage->pipeline()->associate($pipeline);
        $pipelineStage->save();

        return $pipelineStage;
    }

    /**
     * @param PipelineStage $pipelineStage
     * @param string $name
     * @param int|null $order
     * @return PipelineStage
     */
    public function update(
        PipelineStage $pipelineStage,
        string $name,
        ?int $order = null
    ): PipelineStage {
        $pipelineStage->name = $name;
        $pipelineStage->order = $order ?? $pipelineStage->order;
        $pipelineStage->save();

        return $pipelineStage;
    }

    /**
     * @param PipelineStage $pipelineStage
     * @return bool
     */
    public function delete(
        PipelineStage $pipelineStage
    ): bool {
        return $pipelineStage->delete();
    }
}
