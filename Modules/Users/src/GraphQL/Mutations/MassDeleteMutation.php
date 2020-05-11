<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;

class MassDeleteMutation extends BaseMassDeleteMutation
{
    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }
}
