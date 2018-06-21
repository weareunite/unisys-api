<?php

namespace Unite\UnisysApi\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class Authorize
{
    use HandlesAuthorization;

    protected $permissionKey;

    /** @var  \Illuminate\Http\Request */
    protected $request;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;

        $this->setPermissionKey();

        if(Gate::denies('hasPermission', $this->permissionKey)) {
            $this->deny();
        }

        return $next($request);
    }

    protected function setPermissionKey()
    {
        $action = $this->request->route()->getAction();
        if(!isset($action['as'])) {
            $action['controller'];

            $class = $this->controllerClassName();

            $method = $this->request->route()->getActionMethod();

            $key = $class . '.' . $method;
        } else {
            $key = $action['as'];
        }

        $this->permissionKey = $key;
    }

    protected function controllerClassName() {

        list ($class) = array_slice(array_reverse(explode('\\', Arr::first(explode('@', $this->request->route()->getActionName())))), 0, 2);

        $class = lcfirst(str_replace('Controller', '', $class));

        return $class;
    }
}
