<?php

namespace Unite\UnisysApi\Repositories;

use Unite\UnisysApi\Models\Setting;

class SettingRepository extends Repository
{
    protected $modelClass = Setting::class;

    public function getSettingByKey(string $key, array $attributes = ['*'])
    {
        return $this->getQueryBuilder()
            ->where('key', '=', $key)
            ->first($attributes);
    }

    public function getAllSettings()
    {
        return $this->getQueryBuilder()
            ->where('key', '<>', Setting::COMPANY_PROFILE_KEY)
            ->get();
    }
}