<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Services\Company\HasCompanyInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole(Role::ROLE_ADMIN) ? true : null;
        });

        Gate::define('useCompanyModel', function (User $user, HasCompanyInterface $model) {

            if($model instanceof Category){
                if($model->isSystem()){
                    return true;
                }
            }

            if(!$model->company){
                return false;
            }

            return $user->person->company->id === $model->company->id;
        });
    }
}
