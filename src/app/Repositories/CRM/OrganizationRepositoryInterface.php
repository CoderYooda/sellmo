<?php

namespace App\Repositories\CRM;

use App\Models\Company;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface OrganizationRepositoryInterface
{
    /**
     * @param Company $company
     * @param string $name
     * @return Organization
     */
    public function store(Company $company, string $name): Organization;

    /**
     * @param Organization $lead
     * @param string $name
     * @return Organization
     */
    public function update(Organization $lead, string $name): Organization;

    /**
     * @param int $id
     * @return Organization|null
     */
    public function find(int $id): ?Organization;

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection;

    /**
     * @param Organization $lead
     * @return bool
     */
    public function delete(Organization $lead): bool;
}
