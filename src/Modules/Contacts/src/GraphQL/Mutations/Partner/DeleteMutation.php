<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\Partner;

use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Partner::class;
    }
}
