<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }
}
