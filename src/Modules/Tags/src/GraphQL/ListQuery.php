<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'tags',
    ];

    protected function typeClass()
    : string
    {
        return TagType::class;
    }
}
