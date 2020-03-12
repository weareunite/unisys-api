<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL;

use Unite\UnisysApi\Modules\Contacts\Models\Partner;

class PartnerType extends ContactType
{
    protected $attributes = [
        'name'        => 'Partner',
        'description' => 'A Partner',
        'model'       => Partner::class,
    ];
}

