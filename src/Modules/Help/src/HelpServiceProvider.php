<?php

namespace Unite\UnisysApi\Modules\Help;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Help\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class HelpServiceProvider extends ServiceProvider
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

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateHelpTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_help_table.php.stub' => database_path("/migrations/{$timestamp}_create_help_table.php"),
                ], 'migrations');
            }
        }

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
