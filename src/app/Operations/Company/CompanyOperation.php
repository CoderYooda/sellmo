<?php

namespace App\Operations\Company;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Operations\CRM\PersonOperation;
use App\Repositories\User\UserRepository;

class CompanyOperation
{
    protected PersonOperation $personOperation;
    protected UserRepository $userRepository;

    public function __construct(
        PersonOperation $personOperation,
        UserRepository $userRepository
    ) {
        $this->personOperation = $personOperation;
        $this->userRepository = $userRepository;
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

        $user = $this->userRepository->store($name, $email, $password);
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
