<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Modules\Contacts\ContactRepository;
use Unite\UnisysApi\Modules\Contacts\GraphQL\Inputs\ContactInput;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;

class UpdateMutation extends BaseUpdateMutation
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
