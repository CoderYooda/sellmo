<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Email;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadSource;
use App\Models\Lead\LeadType;
use App\Models\Organization;
use App\Models\Person;
use App\Models\Phone;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
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

            $persons = collect();
            $persons->push($this->createPersonForCompany($company, 1, Appointment::DIRECTOR));
            $persons->push($this->createPersonForCompany($company, 2, Appointment::MANAGER));
            $persons->push($this->createPersonForCompany($company, 3, Appointment::EMPLOYEE));
            $persons->push($this->createPersonForCompany($company, 4, Appointment::CLIENT));

            $leadTypes = $this->createLeadTypes($company, 2);
            $leadSources = $this->createLeadSources($company, 3);

            $this->createPipelines($company, 4)->each(function ($pipeline) use (
                $company,
                $persons,
                $leadTypes,
                $leadSources,
            ){
                $stagesDataProvider = [
                    ['Новый',0],
                    ['Был звонок',1],
                    ['КП отправлено',2],
                    ['Провал',3],
                ];
                foreach ($stagesDataProvider as $data){
                    $stage = $this->createPipelineStage($company, $pipeline, ...$data);
                    $this->createLeads(
                        $company,
                        $pipeline,
                        $stage,
                        $persons->random()->first(),
                        $persons->random()->first(),
                        $leadSources,
                        $leadTypes,
                        10
                    );
                }
            });
        });
    }

    /**
     * @param Company $company
     * @param int $count
     * @param string $appointmentName
     * @return Collection
     */
    protected function createPersonForCompany(Company $company, int $count, string $appointmentName): Collection
    {
        $appointment = Appointment::firstOrCreate([
            'name' => $appointmentName,
            'company_id' => $company->id,
        ]);

        return Person::factory($count)->create([
            'company_id' => $company->id,
        ])->each(function($person) use ($appointment, $company){

            $person->phones()->sync($this->createPhones(rand(1,4)));
            $person->emails()->sync($this->createEmails(rand(1,4)));
            $person->addresses()->sync($this->createAddresses(rand(1,4)));
            $person->organization()->associate($this->createOrganization($company));
            $person->save();

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

    /**
     * @return Organization
     */
    protected function createOrganization(Company $company): Organization
    {
        return Organization::factory()->create([
            'company_id' => $company->id,
        ]);
    }

    /**
     * @param Company $company
     * @param int $count
     * @return Collection
     */
    protected function createLeadTypes(Company $company, int $count = 1): Collection
    {
        return LeadType::factory($count)->create([
            'company_id' => $company->id
        ]);
    }

    /**
     * @param Company $company
     * @param int $count
     * @return Collection
     */
    protected function createLeadSources(Company $company, int $count = 1): Collection
    {
        return LeadSource::factory($count)->create([
            'company_id' => $company->id
        ]);
    }

    /**
     * @param Company $company
     * @param int $count
     * @return Collection
     */
    protected function createPipelines(Company $company, int $count = 1): Collection
    {
        return Pipeline::factory($count)->create([
            'company_id' => $company->id
        ]);
    }

    /**
     * @param Company $company
     * @param Pipeline $pipeline
     * @param string $name
     * @param ?string $slug
     * @param int $order
     * @return PipelineStage
     */
    protected function createPipelineStage(
        Company $company,
        Pipeline $pipeline,
        string $name,
        int $order,
        ?string $slug = null,
    ): PipelineStage {
        return PipelineStage::factory()->create([
            'name' => $name,
            'slug' => $slug ?? translit($name),
            'order' => $order,
            'company_id' => $company->id,
            'pipeline_id' => $pipeline->id,
        ]);
    }

    /**
     * @param Company $company
     * @param Pipeline $pipeline
     * @param PipelineStage $pipelineStage
     * @param Person $creator
     * @param Collection $leadSources
     * @param Collection $leadTypes
     * @param int $count
     * @return Collection
     */
    protected function createLeads(
        Company $company,
        Pipeline $pipeline,
        PipelineStage $pipelineStage,
        Person $creator,
        Person $person,
        Collection $leadSources,
        Collection $leadTypes,
        int $count = 1
    ): Collection {
        return Lead::factory($count)->create([
            'company_id' => $company->id,
            'pipeline_id' => $pipeline->id,
            'pipeline_stage_id' => $pipelineStage->id,
            'lead_type_id' => $leadTypes->random()->first()->id,
            'lead_source_id' => $leadSources->random()->first()->id,
            'creator_id' => $creator->id,
            'person_id' => $person->id,
        ]);
    }
}
