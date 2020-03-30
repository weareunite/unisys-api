<?php

namespace Unite\UnisysApi;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInitializeEnv;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInstall;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Console\Commands\MakeModule;
use Unite\UnisysApi\Http\Middleware\HttpsProtocol;

class UnisysApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(HttpKernel $kernel)
    {
        $this->setRoutePatterns();

        $this->loadRoutes();

        $this->pushHttpsMiddleware($kernel);

        if ($this->app->runningInConsole()) {
            $this->loadCommands();

            $this->loadSchedules();

            $this->publishes([
                __DIR__ . '/../config/query-filter.php' => config_path('query-filter.php'),
            ], 'config');

            $this->mergeConfigFrom(__DIR__ . '/../config/query-filter.php', 'query-filter');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDisk();

        $this->registerModules();

        if ($this->app->environment() === 'local') {
            $this->registerIdeHelper();
        }
    }

    protected function registerDisk()
    {
        Config::set("filesystems.disks.unisys-api-modules", [
            'driver'     => 'local',
            'root'       => base_path('vendor/weareunite/unisys-api/src/Modules'),
            'visibility' => 'private',
        ]);
//        $this->app['config']->set("filesystems.disks.unisys-api-modules", [
//            'driver'     => 'local',
//            'root'       => base_path('vendor/weareunite/unisys-api/src/Modules'),
//            'visibility' => 'private',
//        ]);
    }

    protected function registerIdeHelper()
    {
        $this->app->register(IdeHelperServiceProvider::class);
    }

    protected function loadCommands()
    {
        $this->commands([
            UnisysApiInitializeEnv::class,
            UnisysApiInstall::class,
            MakeModule::class,
        ]);
    }

    protected function registerModules()
    {
        $directories = Storage::disk('unisys-api-modules')->directories();

        foreach ($directories as $directory) {
            $this->loadServiceProviderForModule($directory);
        }
    }

    private function loadServiceProviderForModule(string $moduleName)
    {
        foreach ([ $moduleName, Str::singular($moduleName) ] as $name) {
            $class = 'Unite\UnisysApi\Modules\\' . $moduleName . '\\' . $name . 'ServiceProvider';

            if (class_exists($class)) {
                $this->app->register($class);
                continue;
            }
        }
    }

    protected function loadSchedules()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('activitylog:clean')->daily();
            $schedule->command('auth:clear-resets')->daily();

//            $schedule->command('backup:clean')->daily()->at('01:00');
//            $schedule->command('backup:run')->daily()->at('02:00');
        });
    }

    protected function setRoutePatterns()
    {
        Route::pattern('id', '^\d+$');
        Route::pattern('model', '^\d+$');
    }

    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    protected function pushHttpsMiddleware(HttpKernel $kernel)
    {
        $kernel->pushMiddleware(HttpsProtocol::class);
    }
}
