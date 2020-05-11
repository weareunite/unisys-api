<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Queries;

use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;

class ContactsQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Contact::class;
    }
}
