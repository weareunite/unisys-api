<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Modules\Permissions\Permission;

class SynchronizeMutation extends Mutation
{
    protected $attributes = [
        'name' => 'synchronizePermissions',
    ];

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'names'  => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'string',
                ],
            ],
            'secret' => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'string',
                    'regex:/nYtF8FrYNGERrffd/',
                ],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $permissionNames = collect($args['names']);

        Permission::where('guard_name', '=', 'frontend')->get()->each(function (Permission $permission) use ($permissionNames) {
            if (!$permissionNames->contains($permission->name)) {
                $permission->delete();
            }
        });

        $permissionNames->each(function ($name) {
            Permission::findOrCreate($name, 'frontend');
        });

        return true;
    }
}
