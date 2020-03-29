<?php

namespace Unite\UnisysApi\Modules\Users;

use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Laravel\Passport\Http\Middleware\CheckForAnyScope;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Laravel\Passport\Passport;
use Unite\UnisysApi\Modules\Users\Console\Commands\ImportUsers;
use Unite\UnisysApi\Modules\Users\Console\Commands\Install;
use Unite\UnisysApi\Modules\Users\Console\Commands\SetFirstUser;
use Unite\UnisysApi\Modules\Users\Policies\NotificationPolicy;
use Unite\UnisysApi\Modules\Users\Policies\UserPolicy;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class UsersServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot(Router $router)
    {
        $this->registerGates();

        $this->registerPassport();

        $this->setPassportRouteMiddleware($router);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->setCommands();

            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateUsersTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_users_table.php.stub' => database_path("/migrations/{$timestamp}_create_users_table.php"),
                ], 'migrations');
            }

            if (!class_exists('CreatePasswordResetsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_password_resets_table.php.stub' => database_path("/migrations/{$timestamp}_create_password_resets_table.php"),
                ], 'migrations');
            }
        }

        if ($this->isGraphqlRequest()) {
            $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
            $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    protected function setCommands()
    {
        $this->commands([
            Install::class,
            ImportUsers::class,
            SetFirstUser::class,
        ]);
    }

    protected function registerPassport()
    {
        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }

    protected function setPassportRouteMiddleware(Router $router)
    {
        $router->aliasMiddleware('client', CheckClientCredentials::class);
        $router->aliasMiddleware('scopes', CheckScopes::class);
        $router->aliasMiddleware('scope', CheckForAnyScope::class);
    }

    protected function registerGates()
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(DatabaseNotification::class, NotificationPolicy::class);

        Gate::define('hasPermission', function (User $user, string $permissionName) {
            if ($user->isAdmin()) {
                return true;
            }

            return $user->hasPermissionTo($permissionName);
        });
    }
}
