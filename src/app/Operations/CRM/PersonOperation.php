<?php

namespace App\Operations\CRM;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;

class PersonOperation
{
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
}
