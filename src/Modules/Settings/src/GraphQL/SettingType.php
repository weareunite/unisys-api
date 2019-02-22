<?php

namespace Unite\UnisysApi\GraphQL\Settings;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Settings\Setting;

class SettingType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Setting',
        'description' => 'A setting',
        'model'       => Setting::class,
    ];

    public function fields()
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
            'type'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The type of the setting',
            ],
        ];
    }
}

