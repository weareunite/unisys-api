<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Users\User;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'User',
        'description' => 'A user',
        'model'       => User::class,
    ];

    public function fields()
    {
        return [
            'id'                   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'name'                 => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'surname'              => [
                'type'        => Type::string(),
                'description' => 'The surname of user',
            ],
            'email'                => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The email of user',
            ],
            'username'             => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The username of user',
            ],
            'roles'                => [
                'type'        => Type::listOf(GraphQL::type('Role')),
                'description' => 'The roles assigned to user',
            ],
            'frontend_permissions' => [
                'type'        => Type::listOf(GraphQL::type('Permission')),
                'description' => 'The all permissions',
                'selectable'  => false,
            ],
        ];
    }

    protected function resolveFrontendPermissionsField($root, $args)
    {
        /** @var User $root */
        return $root->getFrontendPermissions();
    }
}

