<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\GraphQL\Settings\SettingType;

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
}
