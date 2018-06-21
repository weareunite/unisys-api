<?php

namespace Unite\UnisysApi\Services;

use Closure;
use Illuminate\Cache\Repository as Cache;

class CacheService extends AbstractService
{
    protected $page;
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;

        $this->resolveCurrentPage();
    }

    protected function resolveCurrentPage(string $pageName = 'page')
    {
        $page = request()->has($pageName)
            ? request()->get($pageName)
            : 1;

        $this->setPage($page);
    }

    public function setPage($page)
    {
        $this->page = (int) $page;
    }

    public function makeKey($name)
    {
        return md5($name . $this->page);
    }

    public function remember(string $key, Closure $callback, array $tags = [])
    {
        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $value = $callback();

        $this->cache->put($key, $value, now()->addHours(6));

        return $value;
    }

    public function forgotByKey(string $key)
    {
        $this->cache->forget($this->makeKey($key));
    }

    public function flushByTags(array $tags)
    {
        $this->cache->tags($tags)->flush();
    }
}