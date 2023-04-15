<?php

namespace App\Repositories\Lead;

use App\Models\Company;
use App\Models\Lead\LeadType;
use Illuminate\Support\Collection;

class LeadTypeRepository implements LeadTypeRepositoryInterface
{
    /**
     * @param int $id
     * @return LeadType|null
     */
    public function find(int $id): ?LeadType
    {
        /** @var LeadType $leadType */
        $leadType = LeadType::query()
            ->where('id', $id)
            ->first();

        return $leadType;
    }

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection
    {
        /** @var LeadType $leadType */
        return LeadType::query()
            ->where('company_id', $company->id)
            ->get();
    }

    /**
     * @param Company $company
     * @param string $name
     * @return LeadType
     */
    public function store(
        Company $company,
        string $name,
    ): LeadType {
        $leadType = new LeadType();
        $leadType->name = $name;
        $leadType->company()->associate($company);
        $leadType->save();

        return $leadType;
    }

    /**
     * @param LeadType $leadType
     * @param string $name
     * @return LeadType
     */
    public function update(
        LeadType $leadType,
        string $name,
    ): LeadType {
        $leadType->name = $name;
        $leadType->save();

        return $leadType;
    }

    /**
     * @param LeadType $leadType
     * @return bool
     */
    public function delete(
        LeadType $leadType
    ): bool {
        return $leadType->delete();
    }
}
