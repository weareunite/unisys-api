<?php

namespace Unite\UnisysApi\Modules\Users;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Users\Console\Commands\ImportUsers;
use Unite\UnisysApi\Modules\Users\Console\Commands\Install;
use Unite\UnisysApi\Modules\Users\Http\Middleware\Authenticate;
use Unite\UnisysApi\Modules\Users\Providers\AuthServiceProvider;
use Unite\UnisysApi\Providers\LoadGraphQL;
use Unite\UnisysApi\Modules\Users\Services\InstanceService;
use Illuminate\Routing\Router;

class UserServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot(Router $router)
    {
        $this->app->register(AuthServiceProvider::class);

        $router->aliasMiddleware('auth', Authenticate::class);

        $this->commands([
            Install::class,
            ImportUsers::class,
        ]);

        $this->app->singleton(InstanceService::class, InstanceService::class);

        $this->app->singleton('instanceId', function () {
            return app(InstanceService::class)->getInstanceId();
        });

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateInstancesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_instances_table.php.stub' => database_path("/migrations/{$timestamp}_create_instances_table.php"),
                ], 'migrations');
            }

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

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            \Illuminate\Foundation\Auth\User::class,
            \Unite\UnisysApi\Modules\Users\User::class
        );
    }
}
