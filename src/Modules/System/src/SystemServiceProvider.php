<?php

namespace Unite\UnisysApi\Modules\System;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;
use Unite\UnisysApi\Modules\System\Console\Commands\Install;

class SystemServiceProvider extends ServiceProvider
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

            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateSystemSettingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_system_settings_table.php.stub' => database_path("/migrations/{$timestamp}_create_system_settings_table.php"),
                ], 'migrations');
            }
        }

        if ($this->isGraphqlRequest()) {
            $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
            $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadSystemSettings();
    }

    protected function loadSystemSettings()
    {
        SystemSettings::load($this->app);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
