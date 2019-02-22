<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class ContactRepository extends Repository
{
    protected $modelClass = Contact::class;
}