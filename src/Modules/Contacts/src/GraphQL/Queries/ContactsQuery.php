<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Contacts\GraphQL\ContactType;

class ContactsQuery extends Query
{
    protected $attributes = [
        'name' => 'contacts',
    ];

    protected function typeClass()
    : string
    {
        return ContactType::class;
    }
}
