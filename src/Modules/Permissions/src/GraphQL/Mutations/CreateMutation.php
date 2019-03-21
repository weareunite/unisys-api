<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createPermission',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Permission');
    }

    public function args()
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
        ];
    }
}
