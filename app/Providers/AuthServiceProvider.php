<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\ContactPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        Contact::class => ContactPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-users', function(User $user) {
            return $user->is_admin = true;
        });
    }
}
