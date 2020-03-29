<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Permissions\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }

        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if ($this->isGraphqlRequest()) {
            $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
            $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
        }
    }
}
