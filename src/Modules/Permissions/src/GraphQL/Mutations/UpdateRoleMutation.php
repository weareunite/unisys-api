<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Spatie\Permission\Contracts\Role;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;

class UpdateRoleMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateRole',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
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
                'type'  => Type::listOf(Type::int()),
                'rules' => [
                    'array'
                ],
            ],
        ]);
    }

    protected function afterUpdate(Model $model, $root, $args)
    {
        /** @var Role $model */
        $model->permissions()->sync($args['permissions_ids'] ?? []);
    }
}
