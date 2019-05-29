<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::patterns([
            'id'    => '^\d+$',
            'model' => '^\d+$',
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        parent::boot();
    }
}
