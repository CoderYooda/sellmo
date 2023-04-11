<?php

namespace App\Repositories\Pipeline;

use App\Models\Category;
use App\Models\Company;
use App\Models\TaskTracker\Pipeline;
use Illuminate\Support\Collection;

interface PipelineRepositoryInterface
{
    /**
     * @param string $name
     * @param Company $company
     * @return Pipeline
     */
    public function store(string $name, Company $company): Pipeline;
}
