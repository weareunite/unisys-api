<?php

namespace Unite\UnisysApi\Modules\ActivityLogs;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\ActivityLogs\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class ActivityLogsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
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
