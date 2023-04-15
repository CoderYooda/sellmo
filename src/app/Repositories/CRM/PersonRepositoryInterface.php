<?php

namespace App\Repositories\CRM;

use App\Models\Company;
use App\Models\Person;
use Illuminate\Support\Collection;

interface PersonRepositoryInterface
{
    /**
     * @param Company $company
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     * @return Person
     */
    public function store(
        Company $company,
        string $firstName,
        string $lastName,
        string $middleName,
    ): Person;

    /**
     * @param Person $lead
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     * @return Person
     */
    public function update(
        Person $lead,
        string $firstName,
        string $lastName,
        string $middleName,
    ): Person;

    /**
     * @param int $id
     * @return Person|null
     */
    public function find(int $id): ?Person;

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection;

    /**
     * @param Person $lead
     * @return bool
     */
    public function delete(Person $lead): bool;
}
