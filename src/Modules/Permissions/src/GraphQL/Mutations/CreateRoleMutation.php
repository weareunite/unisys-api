<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Spatie\Permission\Contracts\Role;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;

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
                'type'  => Type::listOf(Type::int()),
                'rules' => [
                    'array'
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
