<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\Modules\Users\User;

class RolesQuery extends Query
{
    protected $attributes = [
        'name' => 'roles',
    ];

    public function type()
    {
        return GraphQL::pagination(GraphQL::type(RoleType::class));
    }

    public function args()
    {
        return [
            'filter' => [
                'type' => GraphQL::type('QueryFilterInput')
            ]
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::where('id', $args['id'])->get();
        } else if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        } else {
            return User::all();
        }
    }
}
