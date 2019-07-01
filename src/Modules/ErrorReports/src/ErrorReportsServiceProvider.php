<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\ErrorReports\Console\Commands\Install;

class ErrorReportsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateErrorReportsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_error_reports_table.php.stub' => database_path("/migrations/{$timestamp}_create_error_reports_table.php"),
                ], 'migrations');
            }
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
