<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Queries;

use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;

class CountriesQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Country::class;
    }
}
