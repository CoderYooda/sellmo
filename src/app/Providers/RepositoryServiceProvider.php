<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\CRM\OrganizationRepository;
use App\Repositories\CRM\OrganizationRepositoryInterface;
use App\Repositories\CRM\PersonRepository;
use App\Repositories\CRM\PersonRepositoryInterface;
use App\Repositories\Lead\LeadRepository;
use App\Repositories\Lead\LeadRepositoryInterface;
use App\Repositories\Lead\LeadTypeRepository;
use App\Repositories\Pipeline\PipelineRepository;
use App\Repositories\Pipeline\PipelineRepositoryInterface;
use App\Repositories\Lead\LeadSourceRepository;
use App\Repositories\Lead\LeadSourceRepositoryInterface;
use App\Repositories\Lead\LeadTypeRepositoryInterface;
use App\Repositories\Pipeline\PipelineStageRepository;
use App\Repositories\Pipeline\PipelineStageRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PipelineRepositoryInterface::class, PipelineRepository::class);
        $this->app->bind(PipelineStageRepositoryInterface::class, PipelineStageRepository::class);
        $this->app->bind(LeadSourceRepositoryInterface::class, LeadSourceRepository::class);
        $this->app->bind(LeadTypeRepositoryInterface::class, LeadTypeRepository::class);
        $this->app->bind(LeadRepositoryInterface::class, LeadRepository::class);
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
    }
}

