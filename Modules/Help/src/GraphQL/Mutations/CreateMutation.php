<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Help\GraphQL\Inputs\HelpInput;
use Unite\UnisysApi\Modules\Help\Help;

class CreateMutation extends BaseCreateMutation
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
