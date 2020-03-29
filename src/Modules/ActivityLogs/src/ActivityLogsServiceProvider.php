<?php

namespace Unite\UnisysApi\Modules\ActivityLogs;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\ActivityLogs\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class ActivityLogsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }

        if ($this->isGraphqlRequest()) {
            $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
            $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
        }
    }
}
