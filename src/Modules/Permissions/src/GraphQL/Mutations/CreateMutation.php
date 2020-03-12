<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs\PermissionInput;
use Unite\UnisysApi\Modules\Permissions\Permission;

class CreateMutation extends BaseCreateMutation
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
