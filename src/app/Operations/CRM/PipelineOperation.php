<?php

namespace App\Operations\CRM;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Person;
use App\Models\TaskTracker\Pipeline;
use App\Models\User;
use App\Repositories\Pipeline\PipelineRepositoryInterface;

class PipelineOperation
{
    protected PipelineRepositoryInterface $pipelineRepository;

    public function __construct(
        PipelineRepositoryInterface $pipelineRepository
    ) {
        $this->pipelineRepository = $pipelineRepository;
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
}
