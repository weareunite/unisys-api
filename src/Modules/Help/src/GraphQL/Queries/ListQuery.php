<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Help\GraphQL\HelpType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'helps',
    ];

    protected function typeClass()
    : string
    {
        return HelpType::class;
    }
}
