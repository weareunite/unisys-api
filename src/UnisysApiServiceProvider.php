<?php

namespace Unite\UnisysApi;

use Route;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInitializeEnv;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInstall;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Console\Commands\MakeModule;
use Unite\UnisysApi\Providers\GraphQLServiceProvider;
use Unite\UnisysApi\Providers\ModulesServiceProvider;
use Unite\UnisysApi\Providers\RouteServiceProvider;
use Unite\UnisysApi\Providers\ScheduleServiceProvider;
use Unite\UnisysApi\Providers\MiddlewareServiceProvider;
use Unite\UnisysApi\Console\Commands\Update;

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
            Update::class,
            MakeModule::class,
        ]);

        if ($this->app->runningInConsole()) {

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

        $this->app->config["filesystems.disks.unisys-api-modules"] = [
            'driver' => 'local',
            'root'   => base_path('vendor/weareunite/unisys-api/src/Modules'),
            'visibility' => 'private',
        ];

        if ($this->app->environment() === 'local') {
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);
        }
    }
}
