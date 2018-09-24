<?php

namespace Unite\UnisysApi\Http\Middleware;

use Cache;
use Closure;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $tag = null)
    {
        $key = md5($request->fullUrl());

        $tags = ['response', $tag];

        if (Cache::tags($tags)->has($key)) {
            return Cache::tags($tags)->get($key);
        }

        $response = $next($request);

        Cache::tags($tags)->put($key, $response, 60 * 24);

        return $response;
    }
}
