<?php

namespace App\Repositories\Pipeline;

use App\Models\Company;
use App\Models\TaskTracker\Pipeline;

class PipelineRepository implements PipelineRepositoryInterface
{
    public function find(int $id): ?Pipeline
    {
        /** @var Pipeline $pipeline */
        $pipeline = Pipeline::query()
            ->where('id', $id)
            ->first();

        return $pipeline;
    }

    /**
     * @param string $name
     * @param Company $company
     * @return Pipeline
     */
    public function store(
        string $name,
        Company $company
    ): Pipeline {
        $pipeline = new Pipeline();
        $pipeline->name = $name;
        $pipeline->company()->associate($company);
        $pipeline->save();

        return $pipeline;
    }

    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @return Pipeline
     */
    public function update(
        Pipeline $pipeline,
        string $name
    ): Pipeline {
        $pipeline->name = $name;
        $pipeline->save();

        return $pipeline;
    }

    /**
     * @param Pipeline $pipeline
     * @return bool
     */
    public function delete(
        Pipeline $pipeline
    ): bool {
        return $pipeline->delete();
    }
}
