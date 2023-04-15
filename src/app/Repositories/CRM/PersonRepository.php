<?php

namespace App\Repositories\CRM;

use App\Models\Company;
use App\Models\Person;
use App\Models\TaskTracker\Pipeline;
use Illuminate\Support\Collection;

class PersonRepository implements PersonRepositoryInterface
{
    /**
     * @param int $id
     * @return Person|null
     */
    public function find(int $id): ?Person
    {
        /** @var Person $lead */
        $lead = Person::query()
            ->where('id', $id)
            ->first();

        return $lead;
    }

    /**
     * @param Company $company
     * @return Collection|null
     */
    public function get(Company $company): ?Collection
    {
        /** @var Person $lead */
        return Person::query()
            ->where('company_id', $company->id)
            ->get();
    }

    /**
     * @param Company $company
     * @param string $lastName
     * @param ?string $firstName
     * @param ?string $middleName
     * @return Person
     */
    public function store(
        Company $company,
        string $firstName,
        ?string $lastName= null,
        ?string $middleName = null,
    ): Person {
        $lead = new Person();
        $lead->first_name = $firstName;
        $lead->last_name = $lastName;
        $lead->middle_name = $middleName;
        $lead->company()->associate($company);
        $lead->save();

        return $lead;
    }

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
    ): Person {
        $lead->first_name = $firstName;
        $lead->last_name = $lastName;
        $lead->middle_name = $middleName;
        $lead->save();

        return $lead;
    }

    /**
     * @param Person $lead
     * @return bool
     */
    public function delete(
        Person $lead
    ): bool {
        return $lead->delete();
    }
}
