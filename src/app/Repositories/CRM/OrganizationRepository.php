<?php

namespace App\Repositories\CRM;

use App\Models\Company;
use App\Models\Organization;
use App\Models\TaskTracker\Pipeline;
use Illuminate\Support\Collection;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    /**
     * @param int $id
     * @return Organization|null
     */
    public function find(int $id): ?Organization
    {
        /** @var Organization $lead */
        $lead = Organization::query()
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
        return Organization::query()
            ->where('pipeline_id', $pipeline->id)
            ->get();
    }

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection
    {
        /** @var Organization $lead */
        return Organization::query()
            ->where('company_id', $company->id)
            ->get();
    }

    /**
     * @param Company $company
     * @param string $name
     * @return Organization
     */
    public function store(
        Company $company,
        string $name,
    ): Organization {
        $organization = new Organization();
        $organization->name = $name;
        $organization->company()->associate($company);
        $organization->save();

        return $organization;
    }

    /**
     * @param Organization $organization
     * @param string $name
     * @return Organization
     */
    public function update(
        Organization $organization,
        string $name,
    ): Organization {
        $organization->name = $name;
        $organization->save();

        return $organization;
    }

    /**
     * @param Organization $organization
     * @return bool
     */
    public function delete(
        Organization $organization
    ): bool {
        return $organization->delete();
    }
}
