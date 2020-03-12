<?php

namespace Unite\UnisysApi\Modules\GraphQL;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\GraphQL\Console\Commands\Install;

class GraphQLServiceProvider extends ServiceProvider
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

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }
}
