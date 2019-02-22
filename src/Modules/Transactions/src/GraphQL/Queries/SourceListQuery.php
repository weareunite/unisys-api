<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Transactions\GraphQL\SourceType;

class SourceListQuery extends Query
{
    protected $attributes = [
        'name' => 'sources',
    ];

    protected function typeClass()
    : string
    {
        return SourceType::class;
    }
}
