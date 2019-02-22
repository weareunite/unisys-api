<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as Mutation;
use Unite\UnisysApi\GraphQL\Permissions\RoleType;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;

class CreateRoleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createRole',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }

    public function type()
    {
        return RoleType::class;
    }

    public function args()
    {
        return [
            'name'           => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'permission_ids' => [
                'type'  => Type::string(),
                'rules' => [
                    'integer',
                    'exists:permissions,id',
                ],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return $this->repository->create($args);
    }
}
