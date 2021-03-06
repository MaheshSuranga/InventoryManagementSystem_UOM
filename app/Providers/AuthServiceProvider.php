<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Inventory;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerInventoryPolicies();
        //
    }

    public function registerInventoryPolicies(){
        Gate::define('create-inventory', function($user){
            return $user->hasAccess(['create-inventory']);
        });

        Gate::define('update-inventory', function($user){
            return $user->hasAccess(['update-inventory']);
        });

        Gate::define('delete-inventory', function($user){
            return $user->hasAccess(['delete-inventory']);
        });

        Gate::define('issue-inventory', function($user){
            $user->hasAccess(['issue-inventory']);
        });

        Gate::define('register-user', function($user){
            return $user->hasAccess(['register-user']);
        });

        Gate::define('update-lecturer', function($user){
            return $user->hasAccess(['update-lecturer']);
        });

        Gate::define('delete-lecturer', function($user){
            return $user->hasAccess(['delete-lecturer']);
        });

        Gate::define('update-supervisor', function($user){
            return $user->hasAccess(['update-supervisor']);
        });

        Gate::define('delete-supervisor', function($user){
            return $user->hasAccess(['delete-supervisor']);
        });

        Gate::define('update-to', function($user){
            return $user->hasAccess(['update-to']);
        });

        Gate::define('delete-to', function($user){
            return $user->hasAccess(['delete-to']);
        });

        Gate::define('login-system', function($user){
            return $user->hasAccess(['login-system']);
        });
    }
}
