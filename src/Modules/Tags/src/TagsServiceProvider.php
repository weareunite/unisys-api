<?php

namespace Unite\UnisysApi\Modules\Tags;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Tags\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class TagsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
        ]);

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateTagTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_tag_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_tag_tables.php'),
                ], 'migrations');
            }
        }

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
