<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Categories\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class CategoriesServiceProvider extends ServiceProvider
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

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
