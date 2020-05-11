<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Permissions\Role;

class DeleteRoleMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Role::class;
    }
}
