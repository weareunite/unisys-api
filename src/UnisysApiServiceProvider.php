<?php

namespace Unite\UnisysApi;

use Unite\UnisysApi\Commands\PermissionsSync;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInitializeEnv;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInstall;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Console\Commands\Users\ImportUsers;
use Unite\UnisysApi\Providers\AuthServiceProvider;
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
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(ScheduleServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);

        $this->commands([
            UnisysApiInitializeEnv::class,
            UnisysApiInstall::class,
            ImportUsers::class,
            PermissionsSync::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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

        $this->app->singleton(
            \Illuminate\Foundation\Auth\User::class,
            \Unite\UnisysApi\Models\User::class
        );

        if ($this->app->environment() === 'local') {
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);
        }


        app()->config["filesystems.disks.uploads"] = [
            'driver' => 'local',
            'root'   => public_path('uploads'),
        ];

        app()->config["filesystems.disks.protectedUploads"] = [
            'driver' => 'local',
            'root'   => storage_path('app/uploads'),
        ];
    }
}
