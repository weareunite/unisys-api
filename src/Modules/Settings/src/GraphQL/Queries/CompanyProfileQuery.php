<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Queries;

use GraphQL;
use Rebing\GraphQL\Support\Query;

class CompanyProfileQuery extends Query
{
    protected $attributes = [
        'name' => 'companyProfile',
    ];

    public function type()
    {
        return GraphQL::type('Contact');
    }

    public function resolve($root, $args)
    {
        return companyProfile();
    }
}
