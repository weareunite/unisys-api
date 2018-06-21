<?php

namespace Unite\UnisysApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;

class PermissionsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check route names and update permissions in database';

    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->routes) == 0) {
            return $this->error("Application doesn't have any routes.");
        }

        $routes = $this->getRoutes();
        $global = \Unite\UnisysApi\Models\Permission::getGlobalPermissions();

        $permissions = $routes->merge($global);

        Permission::all()->each(function (Permission $permission) use($permissions) {
            if(!$permissions->contains($permission->name)) {
                $permission->delete();
            }
        });

        $permissions->each(function ($name) {
            try {
                Permission::findByName($name);
            } catch (PermissionDoesNotExist $e) {
                Permission::create(['name' => $name]);
            }
        });

        $this->info('Permissions was synced');
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getRoutes()
    {
        return collect($this->routes)
            ->map(function ($route) {
                return $this->getRouteInformation($route);
            })
            ->reject(function ($item) {
                return is_null($item);
            })
            ->sortBy('name')
            ->pluck('name');
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return $this->filterRoute([
            'name'   => $route->getName(),
            'isAuthorized' => $this->isAuthorized($route),
        ]);
    }

    /**
     * Get before filters.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    protected function isAuthorized($route)
    {
        if(collect($route->gatherMiddleware())->contains('authorize')) {
            return true;
        }

        return false;
    }

    /**
     * Filter the route by not empty name.
     *
     * @param  array  $route
     * @return array|null
     */
    protected function filterRoute(array $route)
    {
        if(!$route['isAuthorized']) {
            return null;
        }

        if (Str::contains($route['name'], '')) {
            return null;
        }

        return $route;
    }
}
