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

class LeadRepository implements LeadRepositoryInterface
{
    /**
     * @param int $id
     * @return Lead|null
     */
    public function find(int $id): ?Lead
    {
        /** @var Lead $lead */
        $lead = Lead::query()
            ->where('id', $id)
            ->first();

        return $lead;
    }

    /**
     * @param Pipeline $pipeline
     * @return Collection|null
     */
    public function getByPipeline(Pipeline $pipeline): ?Collection
    {
        return Lead::query()
            ->where('pipeline_id', $pipeline->id)
            ->get();
    }

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection
    {
        /** @var Lead $lead */
        return Lead::query()
            ->where('company_id', $company->id)
            ->get();
    }

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
        ?CarbonInterface $closed_at = null,
    ): Lead {
        $lead = new Lead();
        $lead->title = $title;
        $lead->description = $description;
        $lead->lead_value = $leadValue;
        $lead->status = $status;
        $lead->lost_reason = $lost_reason;
        $lead->closed_at = $closed_at;
        $lead->leadSource()->associate($leadSource);
        $lead->creator()->associate($creator);
        $lead->manager()->associate($manager);
        $lead->person()->associate($person);
        $lead->organization()->associate($organization);
        $lead->leadType()->associate($leadType);
        $lead->pipeline()->associate($pipeline);
        $lead->pipelineStage()->associate($pipelineStage);
        $lead->company()->associate($company);
        $lead->save();

        return $lead;
    }

    /**
     * @param Lead $lead
     * @param string $name
     * @return Lead
     */
    public function update(
        Lead $lead,
        string $name,
    ): Lead {
        $lead->name = $name;
        $lead->save();

        return $lead;
    }

    /**
     * @param Lead $lead
     * @return bool
     */
    public function delete(
        Lead $lead
    ): bool {
        return $lead->delete();
    }
}
