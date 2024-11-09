<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy; 
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
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-dashboard', function (User $user) {
            return $user->isAdmin() || $user->isUser();
        });

        Gate::define('manage-profile', function (User $user) {
            return $user->isAdmin() || $user->isUser();
        });
    }
}
