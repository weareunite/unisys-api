<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Modules\Transactions\Contracts\HasTransactions;
use Unite\UnisysApi\Modules\Transactions\Events\MadeTransaction;
use Unite\UnisysApi\Modules\Transactions\Http\Requests\Transaction\StoreRequest;
use Unite\UnisysApi\Modules\Transactions\Http\Resources\TransactionResource;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 */
trait HandleTransaction
{
    /**
     * Add Transaction
     *
     * Add transaction to given model find by model primary id
     *
     * @param int $id
     * @param StoreRequest $request
     *
     * @return TransactionResource
     */
    public function addTransaction(int $id, StoreRequest $request)
    {
        /** @var HasTransactions $object */
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $transaction = $object->addTransaction( $request->all() );

        event(new MadeTransaction($transaction));

        \Cache::tags('response')->flush();

        return new TransactionResource($transaction);
    }

    /**
     * Get latest Transactions
     *
     * Get all transactions order by created desc for given model find by model primary id
     *
     * @param int $id
     *
     * @return AnonymousResourceCollection|TransactionResource[]
     */
    public function allTransactions(int $id)
    {
        /** @var HasTransactions $object */
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $transactions = $object->getLatestTransactions();

        return TransactionResource::collection($transactions);
    }
}
