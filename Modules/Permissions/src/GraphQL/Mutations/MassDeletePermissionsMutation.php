<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Spatie\Permission\Models\Permission;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;

class MassDeletePermissionsMutation extends BaseMassDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Permission::class;
    }
}
