<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL;

use GraphQL\Type\Definition\Type;
use Illuminate\Notifications\DatabaseNotification;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NotificationType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Notification',
        'description' => 'A notification',
        'model'       => DatabaseNotification::class,

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
            'id'         => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the notification',
            ],
            'type'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The type of notification',
            ],
            'data'       => [
                'type'        => Type::string(),
                'description' => 'The data of notification',
            ],
            'read_at'    => [
                'type'        => Type::string(),
                'description' => 'The read_at of notification',
            ],
            'created_at' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The created_at of notification',
            ],
        ];
    }
}