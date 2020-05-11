<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Help\Help;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Help::class;
    }
}
