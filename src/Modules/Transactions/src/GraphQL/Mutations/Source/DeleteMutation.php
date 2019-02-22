<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations\Source;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Transactions\SourceRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteSource',
    ];

    public function repositoryClass()
    : string
    {
        return SourceRepository::class;
    }
}
