<?php

namespace Unite\UnisysApi\Modules\Users\Providers;

use Unite\UnisysApi\Modules\Users\Policies\NotificationPolicy;
use Unite\UnisysApi\Modules\Users\Policies\UserPolicy;
use Unite\UnisysApi\Modules\Users\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        DatabaseNotification::class => NotificationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('hasPermission', function (User $user, string $permissionName) {
            if($user->isAdmin()) {
                return true;
            }

            return $user->hasPermissionTo($permissionName);
        });

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
