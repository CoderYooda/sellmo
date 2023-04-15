<?php

namespace App\Operations\CRM;

use App\Models\Company;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadSource;
use App\Models\Lead\LeadType;
use App\Models\Organization;
use App\Models\Person;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
use App\Repositories\Lead\LeadRepositoryInterface;
use Carbon\CarbonInterface;

class LeadOperation
{
    protected LeadRepositoryInterface $LeadRepository;

    public function __construct(
        LeadRepositoryInterface $LeadRepository
    ) {
        $this->LeadRepository = $LeadRepository;
    }

    public function getByPipeline(
        Pipeline $pipeline
    )
    {
        return $this->LeadRepository->getByPipeline($pipeline);
    }

    /**
     * @param Company $company
     * @param LeadSource $leadSource
     * @param Person $creator
     * @param Person $manager
     * @param Person $person
     * @param Organization $organization
     * @param LeadType $leadType
     * @param PipelineStage $pipelineStage
     * @param string $title
     * @param string $description
     * @param int $leadValue
     * @param string|null $lost_reason
     * @param CarbonInterface|null $closed_at
     * @return Lead
     */
    public function create(
        Company $company,
        LeadSource $leadSource,
        Person $creator,
        Person $manager,
        Person $person,
        Organization $organization,
        LeadType $leadType,
        PipelineStage $pipelineStage,
        string $title,
        string $description,
        int $leadValue,
        ?string $lost_reason = null,
        ?CarbonInterface $closed_at = null,
    ): Lead {
        $pipeline = $pipelineStage->pipeline;
        return $this->LeadRepository->store(
            $company,
            $leadSource,
            $creator,
            $manager,
            $person,
            $organization,
            $leadType,
            $pipeline,
            $pipelineStage,
            $title,
            $description,
            $leadValue,
            Lead::STATUS_INIT,
            $lost_reason,
            $closed_at
        );
    }

    /**
     * @param Lead $Lead
     * @param string $name
     * @return Lead
     */
    public function update(
        Lead $Lead,
        string $name,
    ): Lead {
        return $this->LeadRepository->update($Lead, $name);
    }

    /**
     * @param Lead $Lead
     * @return bool
     */
    public function delete(
        Lead $Lead
    ): bool {
        return $this->LeadRepository->delete($Lead);
    }
}
