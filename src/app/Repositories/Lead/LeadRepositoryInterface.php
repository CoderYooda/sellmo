<?php

namespace App\Repositories\Lead;

use App\Models\Company;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadSource;
use App\Models\Lead\LeadType;
use App\Models\Organization;
use App\Models\Person;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

interface LeadRepositoryInterface
{
    /**
     * @param Pipeline $pipeline
     * @return Collection|null
     */
    public function getByPipeline(Pipeline $pipeline): ?Collection;

    /**
     * @param Company $company
     * @param LeadSource $leadSource
     * @param Person $creator
     * @param Person $manager
     * @param Person $person
     * @param Organization $organization
     * @param LeadType $leadType
     * @param Pipeline $pipeline
     * @param PipelineStage $pipelineStage
     * @param string $title
     * @param string $description
     * @param int $leadValue
     * @param string $status
     * @param string|null $lost_reason
     * @param CarbonInterface|null $closed_at
     * @return Lead
     */
    public function store(
        Company $company,
        LeadSource $leadSource,
        Person $creator,
        Person $manager,
        Person $person,
        Organization $organization,
        LeadType $leadType,
        Pipeline $pipeline,
        PipelineStage $pipelineStage,
        string $title,
        string $description,
        int $leadValue,
        string $status,
        ?string $lost_reason = null,
        CarbonInterface $closed_at = null,
    ): Lead;

    /**
     * @param Lead $lead
     * @param string $name
     * @return Lead
     */
    public function update(Lead $lead, string $name): Lead;

    /**
     * @param int $id
     * @return Lead|null
     */
    public function find(int $id): ?Lead;

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection;

    /**
     * @param Lead $lead
     * @return bool
     */
    public function delete(Lead $lead): bool;
}
