<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Transactions\Events\MadeTransaction;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;
use Unite\UnisysApi\Modules\Transactions\TransactionRepository;

class CancelMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'cancelTransaction',
    ];

    public function repositoryClass()
    : string
    {
        return TransactionRepository::class;
    }

    public function args()
    {
        return parent::args();
    }

    public function resolve($root, $args)
    {
        /** @var Transaction $object */
        $object = $this->repository->find($args['id']);

        /** @var Transaction $newTransaction */
        $newTransaction = $object->replicate();

        $newTransaction->amount = -1 * abs($object->amount);
        $newTransaction->save();

        event(new MadeTransaction($newTransaction));

        return true;
    }
}
