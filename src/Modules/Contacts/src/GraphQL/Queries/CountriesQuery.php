<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Queries;

use Unite\UnisysApi\Modules\Contacts\GraphQL\CountryType;
use Unite\UnisysApi\GraphQL\BuilderQuery as Query;

class CountriesQuery extends Query
{
    protected $attributes = [
        'name' => 'countries',
    ];

    protected function typeClass()
    : string
    {
        return CountryType::class;
    }
}
