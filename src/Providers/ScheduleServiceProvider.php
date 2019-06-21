<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('activitylog:clean')->daily();
            $schedule->command('auth:clear-resets')->daily();

//            $schedule->command('backup:clean')->daily()->at('01:00');
//            $schedule->command('backup:run')->daily()->at('02:00');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
