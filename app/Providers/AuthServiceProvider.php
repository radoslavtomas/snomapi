<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\ContactPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

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

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return Request::root() . '/reset-password/' . $token . '?email=' . $user->email;
        });
    }
}
