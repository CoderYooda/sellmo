<?php

namespace App\Repositories\Lead;

use App\Models\Company;
use App\Models\Lead\LeadSource;
use Illuminate\Support\Collection;

class LeadSourceRepository implements LeadSourceRepositoryInterface
{
    /**
     * @param int $id
     * @return LeadSource|null
     */
    public function find(int $id): ?LeadSource
    {
        /** @var LeadSource $leadSource */
        $leadSource = LeadSource::query()
            ->where('id', $id)
            ->first();

        return $leadSource;
    }

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection
    {
        /** @var LeadSource $leadSource */
        return LeadSource::query()
            ->where('company_id', $company->id)
            ->get();
    }

    /**
     * @param Company $company
     * @param string $name
     * @return LeadSource
     */
    public function store(
        Company $company,
        string $name,
    ): LeadSource {
        $leadSource = new LeadSource();
        $leadSource->name = $name;
        $leadSource->company()->associate($company);
        $leadSource->save();

        return $leadSource;
    }

    /**
     * @param LeadSource $leadSource
     * @param string $name
     * @return LeadSource
     */
    public function update(
        LeadSource $leadSource,
        string $name,
    ): LeadSource {
        $leadSource->name = $name;
        $leadSource->save();

        return $leadSource;
    }

    /**
     * @param LeadSource $leadSource
     * @return bool
     */
    public function delete(
        LeadSource $leadSource
    ): bool {
        return $leadSource->delete();
    }
}
