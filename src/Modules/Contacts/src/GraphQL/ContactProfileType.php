<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL;

class ContactProfileType extends ContactType
{
    protected $attributes = [
        'name'        => 'ContactProfile',
        'description' => 'A ContactProfile',
    ];
}