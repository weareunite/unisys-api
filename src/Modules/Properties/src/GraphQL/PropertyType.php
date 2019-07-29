<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Properties\Property;

class PropertyType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Property',
        'description' => 'A property',
        'model'       => Property::class,
    ];

    public function fields()
    {
        return [
            'key'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The key of property',
            ],
            'value' => [
                'type'        => Type::string(),
                'description' => 'The value of property',
            ],
        ];
    }
}
