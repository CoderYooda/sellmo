<?php

namespace App\Repositories\Lead;

use App\Models\Company;
use App\Models\Lead\LeadSource;
use Illuminate\Support\Collection;

interface LeadSourceRepositoryInterface
{
    /**
     * @param Company $company
     * @param string $name
     * @return LeadSource
     */
    public function store(Company $company, string $name): LeadSource;

    /**
     * @param LeadSource $leadSource
     * @param string $name
     * @return LeadSource
     */
    public function update(LeadSource $leadSource, string $name): LeadSource;

    /**
     * @param int $id
     * @return LeadSource|null
     */
    public function find(int $id): ?LeadSource;

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection;

    /**
     * @param LeadSource $leadSource
     * @return bool
     */
    public function delete(LeadSource $leadSource): bool;
}
