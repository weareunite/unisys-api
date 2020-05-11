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

        $this->loadGraphQLFrom(__DIR__ . '/GraphQL/types.php', __DIR__ . '/GraphQL/schemas.php');
    }
}
