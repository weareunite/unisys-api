<?php

namespace Unite\UnisysApi\Modules\Tags;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Tags\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class TagsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);

            if (! class_exists('CreateTagTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_tag_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_tag_tables.php'),
                ], 'migrations');
            }
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }
}
