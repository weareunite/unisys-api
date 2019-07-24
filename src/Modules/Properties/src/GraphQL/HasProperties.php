<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;

trait HasProperties
{
    public function propertiesField()
    : array
    {
        return [
            'properties' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Property'))),
                'description' => 'The properties',
            ],
        ];
    }

}