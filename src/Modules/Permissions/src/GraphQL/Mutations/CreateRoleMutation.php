<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Spatie\Permission\Contracts\Role;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;
use GraphQL;

class CreateRoleMutation extends BaseCreateMutation
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
        return GraphQL::type('Role');
    }

    public function args()
    {
        return [
            'name'            => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'guard_name'      => [
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

    protected function afterUpdate(Model $model, $root, $args)
    {
        /** @var Role $model */
        $model->permissions()->sync($args['permissions_ids'] ?? []);
    }
}
