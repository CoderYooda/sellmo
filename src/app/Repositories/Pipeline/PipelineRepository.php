<?php

namespace App\Repositories\Pipeline;

use App\Models\Company;
use App\Models\TaskTracker\Pipeline;

class PipelineRepository implements PipelineRepositoryInterface
{
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
}
