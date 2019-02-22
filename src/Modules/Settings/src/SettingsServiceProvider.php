<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Settings\Console\Commands\Install;
use Unite\UnisysApi\Modules\Settings\Console\Commands\SetCompanyProfile;
use Unite\UnisysApi\Modules\Settings\Services\SettingService;
use Unite\UnisysApi\Providers\LoadGraphQL;

class SettingsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
            SetCompanyProfile::class,
        ]);

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateSettingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_settings_table.php.stub' => database_path("/migrations/{$timestamp}_create_settings_table.php"),
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
        $this->app->singleton('companyProfile', function ($app) {
            return $app['cache']->remember('companyProfile', 60*12, function () {
                return app(SettingService::class)->companyProfile();
            });
        });
    }
}
