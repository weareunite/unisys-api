<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $directories = Storage::disk('unisys-api')->directories('src/Modules');

        foreach ($directories as $directory) {
            $this->app->register('Unite\UnisysApi\Modules\\' . $directory . '\src\\'. $directory .'ServiceProvider');
        }
    }
}
