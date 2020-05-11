<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\Partner;

use Unite\UnisysApi\Modules\Contacts\GraphQL\Inputs\PartnerInput;
use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;

class CreateMutation extends BaseCreateMutation
{
    protected function modelClass()
    : string
    {
        return Partner::class;
    }

    protected function inputClass()
    : string
    {
        return PartnerInput::class;
    }
}
