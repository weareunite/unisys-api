<?php

namespace Unite\UnisysApi\Providers;

use Barryvdh\Cors\HandleCors;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Unite\UnisysApi\Http\Middleware\Authorize;
use Unite\UnisysApi\Http\Middleware\HttpsProtocol;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Kernel $kernel
     * @param Router $router
     * @return void
     */
    public function boot(Kernel $kernel, Router $router)
    {
        $kernel->pushMiddleware(HttpsProtocol::class);
        $kernel->pushMiddleware(HandleCors::class);

        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('client', CheckClientCredentials::class);
        $router->aliasMiddleware('authorize', Authorize::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
