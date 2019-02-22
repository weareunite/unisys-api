<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\GraphQL\Media\MediaType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'media',
    ];

    protected function typeClass()
    : string
    {
        return MediaType::class;
    }
}
