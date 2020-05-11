<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class RoleInput extends Input
{
    public function fields()
    : array
    {
        return [
            'name'       => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'guard_name' => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'permissions_ids' => [
                'type'  => Type::listOf(Type::int()),
                'rules' => [
                    'array'
                ],
            ],
        ];
    }
}