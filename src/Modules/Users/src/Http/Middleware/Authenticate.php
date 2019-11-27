<?php

namespace Unite\UnisysApi\Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Contracts\Auth\Factory as Auth;
use Unite\UnisysApi\Modules\Users\Services\InstanceService;

class Authenticate extends BaseAuthenticate
{
    protected $instanceService;

    public function __construct(Auth $auth, InstanceService $instanceService)
    {
        parent::__construct($auth);

        $this->instanceService = $instanceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        if(!instanceId()) {
            $this->instanceService->setUser($this->auth->user());
            $this->instanceService->selectInstanceId();
        }

        return $next($request);
    }
}
