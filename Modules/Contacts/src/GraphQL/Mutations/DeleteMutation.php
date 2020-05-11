<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Contact::class;
    }
}
