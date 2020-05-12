<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SettingType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Setting',
        'description' => 'A setting',
    ];

    public function fields()
    : array
    {
        return [
            'key'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The key of the setting',
            ],
            'value' => [
                'type'        => Type::string(),
                'description' => 'The value of the setting',
            ],
        ];
    }
}

