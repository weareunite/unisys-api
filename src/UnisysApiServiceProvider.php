<?php

namespace Unite\UnisysApi;

use Route;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInitializeEnv;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInstall;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Providers\GraphQLServiceProvider;
use Unite\UnisysApi\Providers\ModulesServiceProvider;
use Unite\UnisysApi\Providers\RouteServiceProvider;
use Unite\UnisysApi\Providers\ScheduleServiceProvider;
use Unite\UnisysApi\Providers\MiddlewareServiceProvider;

class UnisysApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::patterns([
            'id'    => '^\d+$',
            'model' => '^\d+$',
        ]);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ScheduleServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(ModulesServiceProvider::class);
        $this->app->register(GraphQLServiceProvider::class);

        $this->commands([
            UnisysApiInitializeEnv::class,
            UnisysApiInstall::class,
        ]);

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateInstalledModulesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_installed_modules_table.php.stub' => database_path("/migrations/{$timestamp}_create_installed_modules_table.php"),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__ . '/../config/query-filter.php' => config_path('query-filter.php'),
            ], 'config');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Unite\UnisysApi\Exceptions\Handler::class
        );

        if ($this->app->environment() === 'local') {
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);
        }
    }
}
