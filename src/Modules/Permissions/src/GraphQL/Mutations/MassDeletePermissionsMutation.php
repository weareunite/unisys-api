<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Permissions\PermissionRepository;

class MassDeletePermissionsMutation extends BaseMassDeleteMutation
{
    protected $attributes = [
        'name' => 'massDeletePermissions',
    ];

    public function repositoryClass()
    : string
    {
        return PermissionRepository::class;
    }

    protected function beforeDelete(Model $model, $root, $args)
    {
        // todo: before delete Permissions
    }
}
