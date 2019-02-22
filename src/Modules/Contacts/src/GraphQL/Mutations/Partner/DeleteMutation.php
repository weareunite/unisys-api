<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\Partner;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Contacts\PartnerRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deletePartner',
    ];

    public function repositoryClass()
    : string
    {
        return PartnerRepository::class;
    }
}
