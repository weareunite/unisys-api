<?php

namespace Unite\UnisysApi\Modules\Properties;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Properties\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class PropertiesServiceProvider extends ServiceProvider
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

            if (! class_exists('CreatePropertiesTables')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes([
                    __DIR__ . '/../database/migrations/create_properties_tables.php.stub' => database_path("migrations/{$timestamp}_create_properties_tables.php"),
                ], 'migrations');
            }
        }

        $this->loadGraphQLFrom(__DIR__ . '/GraphQL/types.php', __DIR__ . '/GraphQL/schemas.php');
    }
}
