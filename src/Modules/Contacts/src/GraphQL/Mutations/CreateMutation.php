<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use Unite\UnisysApi\Modules\Contacts\GraphQL\Inputs\ContactInput;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class CreateMutation extends BaseCreateMutation
{
    protected function modelClass()
    : string
    {
        return Contact::class;
    }

    protected function inputClass()
    : string
    {
        return ContactInput::class;
    }
}
