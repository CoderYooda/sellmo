<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Email;
use App\Models\Person;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

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
            $company->phones()->sync($this->createPhones(2));
            $company->emails()->sync($this->createEmails(rand(1,4)));
            $company->addresses()->sync($this->createAddresses(rand(1,4)));

            $this->createPersonForCompany($company, 1, Appointment::DIRECTOR);
            $this->createPersonForCompany($company, 2, Appointment::MANAGER);
            $this->createPersonForCompany($company, 3, Appointment::EMPLOYEE);
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

            $person->phones()->sync($this->createPhones(rand(1,4)));
            $person->emails()->sync($this->createEmails(rand(1,4)));
            $person->addresses()->sync($this->createAddresses(rand(1,4)));

            if(in_array($appointment->name, [Appointment::DIRECTOR, Appointment::MANAGER])){
                $user = User::factory()->create();

                /** @var User $user */
                $person->user()->associate($user);
                $person->save();
            }

            $company->persons()->attach(
                $person->id,
                ['appointment_id' => $appointment->id]
            );
        });
    }

    /**
     * @param int $count
     * @return Collection
     */
    protected function createPhones(int $count = 1): Collection
    {
        return Phone::factory($count)->create()->pluck('id');
    }

    /**
     * @param int $count
     * @return Collection
     */
    protected function createEmails(int $count = 1): Collection
    {
        return Email::factory($count)->create()->pluck('id');
    }

    /**
     * @param int $count
     * @return Collection
     */
    protected function createAddresses(int $count = 1): Collection
    {
        return Address::factory($count)->create()->pluck('id');
    }
}
