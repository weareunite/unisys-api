<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs\PermissionInput;
use Unite\UnisysApi\Modules\Permissions\Permission;

class UpdateMutation extends BaseUpdateMutation
{
    protected function modelClass()
    : string
    {
        return Permission::class;
    }

    protected function inputClass()
    : string
    {
        return PermissionInput::class;
    }
}
