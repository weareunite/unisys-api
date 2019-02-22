<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Contacts\ContactRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteContact',
    ];

    public function repositoryClass()
    : string
    {
        return ContactRepository::class;
    }
}
