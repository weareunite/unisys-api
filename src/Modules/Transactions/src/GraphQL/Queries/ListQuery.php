<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Transactions\GraphQL\TransactionType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'transactions',
    ];

    protected function typeClass()
    : string
    {
        return TransactionType::class;
    }
}
