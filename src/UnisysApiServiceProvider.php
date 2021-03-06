<?php

namespace Unite\UnisysApi;

use Route;
use Unite\UnisysApi\Commands\PermissionsSync;
use Unite\UnisysApi\Commands\SetCompanyProfile;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInitializeEnv;
use Unite\UnisysApi\Console\Commands\Install\UnisysApiInstall;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Console\Commands\Update;
use Unite\UnisysApi\Console\Commands\Users\ImportUsers;
use Unite\UnisysApi\Providers\AuthServiceProvider;
use Unite\UnisysApi\Providers\RouteServiceProvider;
use Unite\UnisysApi\Providers\ScheduleServiceProvider;
use Unite\UnisysApi\Providers\MiddlewareServiceProvider;
use Unite\UnisysApi\Services\SettingService;

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
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(ScheduleServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);

        $this->commands([
            UnisysApiInitializeEnv::class,
            UnisysApiInstall::class,
            ImportUsers::class,
            PermissionsSync::class,
            SetCompanyProfile::class,
            Update::class,
        ]);

        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateUsersTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_users_table.php.stub' => database_path("/migrations/{$timestamp}_create_users_table.php"),
                ], 'migrations');
            }

            if (!class_exists('CreatePasswordResetsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_password_resets_table.php.stub' => database_path("/migrations/{$timestamp}_create_password_resets_table.php"),
                ], 'migrations');
            }

            if (!class_exists('CreateInstalledModulesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_installed_modules_table.php.stub' => database_path("/migrations/{$timestamp}_create_installed_modules_table.php"),
                ], 'migrations');
            }

            if (!class_exists('CreateSettingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_settings_table.php.stub' => database_path("/migrations/{$timestamp}_create_settings_table.php"),
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

        $this->app->singleton(
            \Illuminate\Foundation\Auth\User::class,
            \Unite\UnisysApi\Models\User::class
        );

        if ($this->app->environment() === 'local') {
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);
        }

        $this->app->singleton('companyProfile', function ($app) {
            return $app['cache']->remember('companyProfile', 60*12, function () {
                return app(SettingService::class)->companyProfile();
            });
        });

        app()->config["filesystems.disks.uploads"] = [
            'driver' => 'local',
            'root'   => public_path('uploads'),
            'visibility' => 'public',
        ];

        app()->config["filesystems.disks.protectedUploads"] = [
            'driver' => 'local',
            'root'   => storage_path('app/uploads'),
            'visibility' => 'private',
        ];
    }
}
