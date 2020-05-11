<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Help\Help;

class HelpType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Help',
        'description' => 'A Help',
        'model'       => Help::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the help',
            ],
            'key'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The key of help',
            ],
            'name' => [
                'type'        => Type::string(),
                'description' => 'The name of help',
            ],
            'body' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The body of help',
            ],
        ];
    }
}

