<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Transactions\TransactionRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteTransaction',
    ];

    public function repositoryClass()
    : string
    {
        return TransactionRepository::class;
    }
}
