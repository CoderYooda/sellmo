<?php

namespace App\Operations\CRM;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Organization;
use App\Models\Person;
use App\Models\User;
use App\Repositories\CRM\PersonRepository;

class PersonOperation
{
    protected PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @param User $user
     * @param Company $company
     * @param Appointment $appointment
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     * @return Person
     */
    public function create(
        User $user,
        Company $company,
        Appointment $appointment,
        string $firstName,
        string $lastName,
        string $middleName
    ): Person {
        $person = new Person();

        $person->first_name = $firstName;
        $person->last_name = $lastName;
        $person->middle_name = $middleName;
        $person->user()->associate($user);
        $person->company()->associate($company);
        $person->appointment()->associate($appointment);
        $person->save();

        return $person;
    }

    public function findOrCreate(
        Company $company,
        ?int $personId = null,
        ?string $fullName  = null,
        ?Organization $organization = null
    ): Person {
        $fullNameParsed = $this->parseFullName($fullName);

        $person = $personId ?
            $this->personRepository->find($personId) :
            $this->personRepository->store(
                $company,
                $fullNameParsed['first_name'],
                $fullNameParsed['last_name'],
                $fullNameParsed['middle_name'],
            );
        $person->organization()->associate($organization);

        return $person;
    }

    public function parseFullName(string $fullName): array
    {
        $exploded = explode(' ', $fullName);
        if(count($exploded) === 1){
            return [
                'last_name' => null,
                'first_name' => $exploded[0] ?? null,
                'middle_name' => null,
            ];
        }

        return [
            'last_name' => $exploded[0] ?? null,
            'first_name' => $exploded[1] ?? null,
            'middle_name' => $exploded[2] ?? null,
        ];
    }
}
