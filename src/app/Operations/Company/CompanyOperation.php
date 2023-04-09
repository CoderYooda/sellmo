<?php

namespace App\Operations\Company;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Operations\CRM\PersonOperation;

class CompanyOperation
{
    protected PersonOperation $personOperation;

    public function __construct(PersonOperation $personOperation)
    {
        $this->personOperation = $personOperation;
    }

    /**
     * @param string $companyName
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function create(
        string $companyName,
        string $firstName,
        string $lastName,
        string $middleName,
        string $name,
        string $email,
        string $password,
    ): User {
        $company = $this->createBaseCompany($companyName);
        $appointment = $this->createAppointment($company, Appointment::DIRECTOR);
        $user = $this->createUser($name, $email, $password);
        $this->personOperation->create($user, $company, $appointment, $firstName, $lastName, $middleName);
        $this->giveBasePermissions($user);
        return $user;
    }

    /**
     * @param $name
     * @return Company
     */
    protected function createBaseCompany($name): Company
    {
        $company = new Company();
        $company->name = $name;
        $company->save();

        return $company;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    protected function createUser(string $name, string $email, string $password): User
    {
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    /**
     * @param Company $company
     * @param string $name
     * @return Appointment
     */
    protected function createAppointment(Company $company, string $name): Appointment
    {
        $appointment = new Appointment();
        $appointment->name = $name;
        $appointment->company()->associate($company);
        $appointment->save();

        return $appointment;
    }

    protected function giveBasePermissions(User $user): void
    {
        $user->assignRole(Role::CRM_USER);

        $user->givePermissionTo(Permission::DEFAULT_DIRECTOR_PERMISSIONS);
    }
}
