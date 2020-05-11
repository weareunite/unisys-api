<?php

namespace Unite\UnisysApi\Modules\Company;

use Illuminate\Contracts\Cache\Repository as Cache;

class CompanyService
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function create(array $data)
    {
        /** @var Company $company */
        $company = Company::create($data);

        if (isset($data['contact_profile']) && $data['contact_profile']) {
            $company->attachOrUpdateContactProfile($data['contact_profile']);
        }

        $this->cache->forget(Company::CACHE_NAME);
        $this->cache->put(Company::CACHE_NAME, $company, null);

        return $company;
    }

    public function update(Company $company, array $data)
    {
        $company->update($data);

        if (isset($data['contact_profile']) && $data['contact_profile']) {
            $company->attachOrUpdateContactProfile($data['contact_profile']);
        }

        $this->cache->forget(Company::CACHE_NAME);
        $this->cache->put(Company::CACHE_NAME, $company, null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getProfile()
    {
        $cacheName = Company::CACHE_NAME;

        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $company = Company::query()->with([ 'contact_profile' ])->first();

        $this->cache->put($cacheName, $company, null);

        return $company;
    }
}
