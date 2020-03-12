<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Users\User;

class MassDeleteMutation extends BaseMassDeleteMutation
{
    protected function modelClass()
    : string
    {
        return User::class;
    }
}
