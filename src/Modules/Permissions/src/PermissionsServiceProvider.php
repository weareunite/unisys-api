<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Permissions\Commands\PermissionsSync;
use Unite\UnisysApi\Modules\Permissions\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;
use Illuminate\Routing\Router;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;

class PermissionsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot(Router $router)
    {
        $this->commands([
            Install::class,
            PermissionsSync::class
        ]);

        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
