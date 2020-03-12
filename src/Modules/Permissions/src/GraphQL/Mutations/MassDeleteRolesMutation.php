<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Permissions\Role;

class MassDeleteRolesMutation extends BaseMassDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Role::class;
    }
}
