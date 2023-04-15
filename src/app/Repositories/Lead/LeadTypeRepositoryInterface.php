<?php

namespace App\Repositories\Lead;

use App\Models\Company;
use App\Models\Lead\LeadType;
use Illuminate\Support\Collection;

interface LeadTypeRepositoryInterface
{
    /**
     * @param Company $company
     * @param string $name
     * @return LeadType
     */
    public function store(Company $company, string $name): LeadType;

    /**
     * @param LeadType $leadType
     * @param string $name
     * @return LeadType
     */
    public function update(LeadType $leadType, string $name): LeadType;

    /**
     * @param int $id
     * @return LeadType|null
     */
    public function find(int $id): ?LeadType;

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection;

    /**
     * @param LeadType $leadType
     * @return bool
     */
    public function delete(LeadType $leadType): bool;
}
