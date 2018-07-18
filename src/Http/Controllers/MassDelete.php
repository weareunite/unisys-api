<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\Transactions\Events\MadeTransaction;
use Unite\Transactions\Http\Requests\Transaction\StoreRequest;
use Unite\Transactions\Http\Resources\TransactionResource;
use Unite\Transactions\Traits\HasTransactionsInterface;
use Unite\UnisysApi\Http\Requests\MassDeleteRequest;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 */
trait MassDelete
{
    /**
     * Mass Delete
     *
     * Mass delete many models byt ids
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(MassDeleteRequest $request)
    {
        $data = $request->only('ids');

        $this->repository->massDelete($data['ids']);

        return $this->successJsonResponse();
    }
}
