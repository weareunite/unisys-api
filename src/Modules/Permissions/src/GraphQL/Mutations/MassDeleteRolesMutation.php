<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;

class MassDeleteRolesMutation extends BaseMassDeleteMutation
{
    protected $attributes = [
        'name' => 'massDeleteRoles',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }

    protected function beforeDelete(Model $model, $root, $args)
    {
        // todo: before delete Role
    }
}
