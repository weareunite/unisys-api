<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Permissions\Commands\PermissionsSync;
use Unite\UnisysApi\Modules\Permissions\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class PermissionsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
            PermissionsSync::class
        ]);

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
