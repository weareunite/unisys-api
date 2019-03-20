<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as Mutation;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;

class UpdateRoleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateRole',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id'              => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:roles,id',
                ],
            ],
            'name'            => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'permissions_ids' => [
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
        $model = $this->repository->find($args['id']);

        $model->update($args);

        $model->permissions()->sync($args['permissions_ids']);

        return true;
    }
}
