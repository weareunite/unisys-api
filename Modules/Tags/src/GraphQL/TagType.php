<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Tags\Tag;

class TagType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Tag',
        'description' => 'A tag',
        'model'       => Tag::class,
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    : array
    {
        return [
            'id'                => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of tag',
            ],
            'type'              => [
                'type'        => Type::string(),
                'description' => 'The type of tag',
            ],
            'name'              => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of tag',
            ],
            'created_at'        => [
                'type'        => Type::string(),
                'description' => 'The created_at of tag',
            ],
        ];
    }
}

