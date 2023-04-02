<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Database\Seeder;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Company::factory(1)->create([
            'name' => 'Тестовая компания',
        ])->each(function ($company){
            $this->createPersonForCompany($company, 1, Appointment::DIRECTOR);
            $this->createPersonForCompany($company, 10, Appointment::MANAGER);
            $this->createPersonForCompany($company, 100, Appointment::EMPLOYEE);
        });
    }

    /**
     * @param Company $company
     * @param int $count
     * @param string $appointmentName
     * @return void
     */
    protected function createPersonForCompany(Company $company, int $count, string $appointmentName): void
    {
        $appointment = Appointment::firstOrCreate([
            'name' => $appointmentName,
            'company_id' => $company->id,
        ]);

        Person::factory($count)->create([
            'company_id' => $company->id,
        ])->each(function($person) use ($appointment, $company){
            $company->persons()->attach(
                $person->id,
                ['appointment_id' => $appointment->id]
            );
        });
    }
}
