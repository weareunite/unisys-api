<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Settings\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class SettingsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->isGraphqlRequest()) {
            $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
            $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }
    }
}
