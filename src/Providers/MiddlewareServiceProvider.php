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
     * @param Router $router
     * @param Kernel $kernel
     * @return void
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('client', CheckClientCredentials::class);
        $router->aliasMiddleware('authorize', Authorize::class);

        $kernel->pushMiddleware(HttpsProtocol::class);
        $kernel->pushMiddleware(HandleCors::class);
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
