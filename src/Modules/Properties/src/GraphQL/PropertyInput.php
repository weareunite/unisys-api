<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PropertyInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'PropertyInput',
        'description' => 'A property input',
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