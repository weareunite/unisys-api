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

        $directories = Storage::disk('unisys-api-modules')->directories();

        foreach ($directories as $directory) {
            $this->loadServiceProvider($directory);
        }
    }

    protected function loadServiceProvider(string $moduleName)
    {
        foreach ([$moduleName, str_singular($moduleName)] as $baseName) {
            $class = 'Unite\UnisysApi\Modules\\' . $moduleName . '\\'. $baseName .'ServiceProvider';

            if(class_exists($class)) {
                $this->app->register($class);
                continue;
            }
        }
    }
}
