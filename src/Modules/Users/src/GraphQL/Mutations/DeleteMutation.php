<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Users\User;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return User::class;
    }
}
