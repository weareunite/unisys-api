<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\GraphQL\Settings\SettingType;
use Unite\UnisysApi\Modules\Settings\Setting;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'settings',
    ];

    protected function typeClass()
    : string
    {
        return SettingType::class;
    }

    public function customScope(&$query, $args)
    {
        return $query->where('key', '<>', Setting::COMPANY_PROFILE_KEY);
    }
}
