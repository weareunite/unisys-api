<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Categories\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class CategoriesServiceProvider extends ServiceProvider
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

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
