<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\Modules\Help\Help;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;

class MassDeleteMutation extends BaseMassDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Help::class;
    }
}
