<?php

namespace App\Repositories\Pipeline;

use App\Models\Company;
use App\Models\TaskTracker\Pipeline;

interface PipelineRepositoryInterface
{
    /**
     * @param string $name
     * @param Company $company
     * @return Pipeline
     */
    public function store(string $name, Company $company): Pipeline;

    /**
     * @param Pipeline $pipeline
     * @param string $name
     * @return Pipeline
     */
    public function update(Pipeline $pipeline, string $name): Pipeline;

    /**
     * @param int $id
     * @return Pipeline|null
     */
    public function find(int $id): ?Pipeline;

    /**
     * @param Pipeline $pipeline
     * @return bool
     */
    public function delete(Pipeline $pipeline): bool;
}
