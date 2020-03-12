<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\Partner;

use Unite\UnisysApi\Modules\Contacts\GraphQL\Inputs\PartnerInput;
use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;

class UpdateMutation extends BaseUpdateMutation
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
