<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Help\GraphQL\Inputs\HelpInput;
use Unite\UnisysApi\Modules\Help\Help;

class UpdateMutation extends BaseUpdateMutation
{
    protected function modelClass()
    : string
    {
        return Help::class;
    }

    protected function inputClass()
    : string
    {
        return HelpInput::class;
    }
}
