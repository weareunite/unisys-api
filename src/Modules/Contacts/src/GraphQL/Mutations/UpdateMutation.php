<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Modules\Contacts\ContactRepository;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateContact',
    ];

    public function repositoryClass()
    : string
    {
        return ContactRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Contact');
    }

    public function args()
    {
        return array_merge(parent::args(), UpdateArguments::arguments());
    }
}
